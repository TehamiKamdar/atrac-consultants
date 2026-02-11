<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\sim_codes;
use App\Models\students;
use App\Models\university;
use App\Models\departments;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\studenteducation;
use Illuminate\Support\Facades\DB;
use App\Models\studentenglishtests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function index()
    {
        $activeCountries = country::where('status', 'active')->orderBy('name', 'ASC')->get();
        $sim_codes = sim_codes::all();
        return view('pages.register', compact('activeCountries', 'sim_codes'));
    }

    public function getCountryPrograms($country_id)
    {
        $programs = DB::table('country_programs')
            ->join('program_levels', 'program_levels.id', '=', 'country_programs.program_level_id')
            ->where('country_programs.country_id', $country_id)
            ->select('program_levels.id', 'program_levels.name')
            ->get();

        return response()->json($programs);
    }

    public function departments(Request $request)
    {
        $request->validate([
            'country_id' => 'required|integer',
            'program_level_id' => 'required|integer',
        ]);

        $departments = departments::whereHas('program', function ($q) use ($request) {
            $q->where('program_level_id', $request->program_level_id)
                ->whereHas('university', function ($q2) use ($request) {
                    $q2->where('country_id', $request->country_id);
                });
        })
            ->select('id', 'name')
            ->distinct()
            ->orderBy('name')
            ->get()->unique('name')->values();

        return response()->json($departments);
    }

    public function universities(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string',
            'country_id' => 'required|integer',
            'program_level_id' => 'required|integer',
        ]);

        // Find all department IDs with this name for selected country + program level
        $departmentIds = departments::where('name', $request->department_name)
            ->whereHas('program', function ($q) use ($request) {
                $q->where('program_level_id', $request->program_level_id)
                    ->whereHas('university', function ($q2) use ($request) {
                        $q2->where('country_id', $request->country_id);
                    });
            })
            ->pluck('id');

        // Fetch universities for all those department IDs
        $universities = university::whereHas('programs', function ($q) use ($departmentIds) {
            $q->whereHas('departments', function ($q2) use ($departmentIds) {
                $q2->whereIn('id', $departmentIds);
            });
        })
            ->where('country_id', $request->country_id)
            ->select('id', 'name')
            ->distinct()
            ->orderBy('name')
            ->get();

        return response()->json($universities);
    }

    public function checkEmail(Request $request){
        $email = $request->email;

        $exists = Students::where('email', $email)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function checkCNIC(Request $request){
        $cnic = $request->cnic;

        $exists = Students::where('cnic', $cnic)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function checkPassport(Request $request){
        $passport = $request->passport;

        $exists = Students::where('passport_number', $passport)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function checkPhone(Request $request)
    {
        $exists = Students::where('phone', $request->phone_prefix.$request->phone_number)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->validate([
                'step1' => 'required|array',
                'step2' => 'required|array',
                'step3' => 'sometimes|array',
                'step4' => 'sometimes|array',
                'english_test_list' => 'required|array',
                'english_tests' => 'sometimes|array',
            ]);

            // 1. Save student
            $student = students::create([
                'first_name' => $data['step1']['firstName'],
                'last_name' => $data['step1']['lastName'],
                'father_name' => $data['step1']['fatherName'],
                'mother_name' => $data['step1']['motherName'],
                'city' => $data['step1']['city'],
                'dob' => $data['step1']['dob'],
                'cnic' => $data['step1']['cnic'],
                'passport_number' => $data['step1']['passport'],
                'passport_valid_from' => $data['step1']['passportValidFrom'],
                'passport_valid_thru' => $data['step1']['passportValidThru'],
                'phone' => $data['step1']['phonePrefix'] . $data['step1']['phoneNumber'],
                'email' => $data['step1']['email'],
                'address' => $data['step1']['address'],
                'postal_code' => $data['step1']['postalCode'],
                'qualification' => $data['step1']['qualification'],
                'percentage' => $data['step1']['percentage'],
                'intake' => $data['step1']['intake'],
                'country_id' => $data['step1']['country'],
                'program_level_id' => $data['step1']['applying'],
                'english_test' => json_encode($data['english_test_list']),
                'english_proficiency' => $data['step1']['proficiency'],
            ]);

            // 2. Save academics
            foreach ($data['step2'] as $level => $academic) {
                studenteducation::create([
                    'student_id' => $student->id,
                    'level' => $level,
                    'institute' => $academic['institute'] ?? null,
                    'board' => $academic['board'] ?? null,
                    'subject' => $academic['subject'] ?? null,
                    'passing_year' => !empty($academic['passing_year'])
                        ? substr($academic['passing_year'], 0, 4)
                        : null,
                    'obtained_marks' => $academic['obtained_marks'] ?? null,
                    'total_marks' => $academic['total_marks'] ?? null,
                    'grade_or_cgpa' => $academic['grade_or_cgpa'] ?? null,
                ]);
            }

            // 3. Save English tests
            if (!empty($data['english_tests'])) {
                foreach ($data['english_tests'] as $test => $values) {

                    $hasData = collect($values)->filter(fn($v) => $v !== null && $v !== '')->isNotEmpty();
                    if (!$hasData)
                        continue;

                    studentenglishtests::create([
                        'student_id' => $student->id,
                        'test_name' => strtoupper($test),
                        'listening' => $values['listening'] ?? 0,
                        'reading' => $values['reading'] ?? 0,
                        'speaking' => $values['speaking'] ?? 0,
                        'writing' => $values['writing'] ?? 0,
                        'score' => $values['overall'] ?? 0,
                        'test_date' => !empty($values['passing_year'])
                            ? substr($values['passing_year'], 0, 4)
                            : null,
                    ]);
                }
            }

            // 4. Documents
            $studentFolder = 'documents/' . $student->email . '_documents';

            if (!Storage::disk('public')->exists($studentFolder)) {
                Storage::disk('public')->makeDirectory($studentFolder);
            }

            $documentFields = [
                'cnic-front',
                'cnic-back',
                'passport',
                'photograph',
                'cv-resume',
                'experience-letter',
                'proficiency-letter',
                'motivation-letter',
                'matric-front',
                'matric-back',
                'intermediate-front',
                'intermediate-back',
                'bachelors-transcript',
                'bachelors-degree',
                'masters-transcript',
                'masters-degree',
                'ielts',
                'toefl',
                'pte',
            ];

            foreach ($documentFields as $field) {
                if ($request->hasFile("step3.$field")) {

                    $file = $request->file("step3.$field");
                    $fileName = $field . '_' . time() . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs($studentFolder, $fileName, 'public');

                    \App\Models\studentdocument::create([
                        'student_id' => $student->id,
                        'document_type' => $field,
                        'file_path' => $path,
                    ]);
                }
            }

            // 5. Department applications
            if (!empty($data['step4'])) {
                foreach ($data['step4'] as $app) {
                    \App\Models\studentapplication::create([
                        'student_id' => $student->id,
                        'country_id' => $student->country_id,
                        'university_id' => $app['university_id'] ?? null,
                        'program_level_id' => $student->program_level_id,
                        'department_id' => $app['department_id'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'id' => $student->id,
                'message' => 'Student Registered'
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
