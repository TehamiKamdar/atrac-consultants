<?php

namespace App\Http\Controllers;

use App\Models\country;
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

        return view('pages.register', compact('activeCountries'));
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
        return departments::select('departments.id', 'departments.name')
            ->join('programs', 'programs.id', '=', 'departments.program_id')
            ->join('universities', 'universities.id', '=', 'programs.university_id')
            ->where('universities.country_id', $request->country_id)
            ->where('programs.program_level_id', $request->program_level_id)
            ->distinct()
            ->get();
    }

    public function universities(Request $request)
    {
        return university::select('universities.id', 'universities.name')
            ->join('programs', 'programs.university_id', '=', 'universities.id')
            ->join('departments', 'departments.program_id', '=', 'programs.id')
            ->where('departments.id', $request->department_id)
            ->where('programs.program_level_id', $request->program_level_id)
            ->where('universities.country_id', $request->country_id)
            ->distinct()
            ->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'step1' => 'required|array',
            'step2' => 'required|array',
            'step3' => 'sometimes|array',
            'step4' => 'required|array',
            'english_test_list' => 'required|array',
        ]);

            // Saving Students is Students Table

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
                'phone' => $data['step1']['phonePrefix'].$data['step1']['phoneNumber'],
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

            // saving student's academics (educational) records.
            foreach ($data['step2'] as $level => $academic) {
                studenteducation::create([
                    'student_id' => $student->id,        // Foreign key
                    'level' => $level,                   // matric / intermediate / bachelors
                    'institute' => $academic['institute'] ?? null,
                    'board' => $academic['board'] ?? null,
                    'subject' => $academic['subject'] ?? null,
                    'passing_year' => !empty($academic['passing_year']) ? substr($academic['passing_year'],0,4) : null,
                    'obtained_marks' => $academic['obtained_marks'] ?? null,
                    'total_marks' => $academic['total_marks'] ?? null,
                    'grade_or_cgpa' => $academic['grade_or_cgpa'] ?? null,
                ]);
            }

            // saving students english test records
            $tests = ['IELTS', 'TOEFL', 'PTE'];

            foreach ($tests as $test) {

                // Extract values
                $listening = $data['step2']["listening$test"] ?? null;
                $reading = $data['step2']["reading$test"] ?? null;
                $speaking = $data['step2']["speaking$test"] ?? null;
                $writing = $data['step2']["writing$test"] ?? null;
                $score = $data['step2']["overall$test"] ?? null;
                $test_date = $data['step2']["passingYear$test"] ?? null;

                // Skip if all fields are empty strings or null
                if (
                    empty($listening) &&
                    empty($reading) &&
                    empty($speaking) &&
                    empty($writing) &&
                    empty($score) &&
                    empty($test_date)
                ) {
                    continue; // skip this test
                }

                studentenglishtests::create([
                    'student_id' => $student->id,
                    'test_name' => $test,
                    'listening' => $listening ?: null,
                    'reading' => $reading ?: null,
                    'speaking' => $speaking ?: null,
                    'writing' => $writing ?: null,
                    'score' => $score ?: null,
                    'test_date' => !empty($test_date) ? substr($test_date,0,4) : null,
                ]);
            }

            // saving student's documents
            $studentFolder = 'documents/'.Str::slug($student->first_name.'_'.$student->last_name).'_documents';

            // Make folder if not exists
            if (! Storage::exists($studentFolder)) {
                Storage::makeDirectory($studentFolder, 0755, true);
            }

            // List of input files you expect
            $documentFields = [
                'cnic_front',
                'cnic_back',
                'matric_front',
                'matric_back',
                'intermediate_front',
                'intermediate_back',
                'bachelors_front',
                'bachelors_back',
                'masters_front',
                'masters_back',
                'ielts',
                'toefl',
                'pte',
                'motivation_letter',
                'proficiency_letter',
            ];

            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    // Clean file name: lowercase, underscores
                    $extension = $file->getClientOriginalExtension();
                    $fileName = strtolower($field).'_'.time().'.'.$extension;

                    // Store in public/documents/FirstName_LastName_documents/
                    $path = $file->storeAs($studentFolder, $fileName, 'public');

                    // Save record in DB
                    \App\Models\StudentDocument::create([
                        'student_id' => $student->id,
                        'type' => $field,
                        'file_path' => $path,
                    ]);
                }
            }

            // saving student's program applications
            foreach ($data['step4'] as $app) {
                \App\Models\studentapplication::create([
                    'student_id' => $student->id,
                    'country_id' => $student->country_id ?? null,
                    'university_id' => $app['university_id'] ?? null,
                    'program_level_id' => $student->program_level_id ?? null,
                    'department_id' => $app['department_id'] ?? null,
                ]);
            }


        return response()->json([
            "sucess" => true,
            "message" => "Student Registered"
        ]);
    }
}
