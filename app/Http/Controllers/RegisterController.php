<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\course;
use App\Models\sim_codes;
use App\Models\students;
use App\Models\university;
use App\Models\departments;
use App\Models\program;
use App\Models\program_level;
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
        $program_levels = program_level::all();
        $sim_codes = sim_codes::all();
        return view('pages.register', compact('activeCountries', 'sim_codes', 'program_levels'));
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

    public function countries(Request $request)
    {
        $request->validate([
            'country_ids' => 'required|array',
            'country_ids.*' => 'integer',
        ]);

        $countries = country::whereIn('id', $request->country_ids)
            ->select('id', 'name')
            ->get();

        return response()->json($countries);
    }

    public function departments(Request $request)
    {
        $request->validate([
            'university_name' => 'required|string',
            'program_level_id' => 'required|integer',
        ]);

        $university = university::where('name', $request->university_name)->first();

        if (!$university) {
            return response()->json([]);
        }

        $departments = DB::table('programs as p')
            ->join('departments as d', 'd.program_id', '=', 'p.id')
            ->where('p.university_id', $university->id)
            ->where('p.program_level_id', $request->program_level_id)
            ->select(
                'd.id',
                'd.name'
            )
            ->get();

        return response()->json($departments);
    }

    public function universities(Request $request)
    {
        $request->validate([
            'country_name' => 'required|string',
        ]);

        $country = country::where('name', $request->country_name)->first();

        if (!$country) {
            return response()->json([]);
        }

        $universities = university::where('country_id', $country->id)
            ->get();

        return response()->json($universities);
    }

    public function searchPrograms(Request $request)
    {
        $request->validate([
            'country_ids' => 'required|array',
            'country_ids.*' => 'required|integer',
            'program_level_id' => 'required|integer',
            'search' => 'required|string|min:2|max:255',
        ]);

        $search = trim($request->search);

        $programs = program::with([
            'level:id,name',
            'university:id,name,country_id',
            'university.country:id,name',

            'departments' => function ($query) use ($search) {

                $query->select('id', 'program_id', 'name')
                    ->with([
                        'courses' => function ($query) use ($search) {

                            $query->select(
                                'id',
                                'department_id',
                                'name',
                            )
                                ->where('name', 'LIKE', "%{$search}%");
                        }
                    ])
                    ->whereHas('courses', function ($query) use ($search) {

                        $query->where('name', 'LIKE', "%{$search}%");

                    });
            }
        ])

            ->where('program_level_id', $request->program_level_id)

            // Multiple country filter
            ->whereHas('university', function ($query) use ($request) {

                $query->whereIn('country_id', $request->country_ids);

            })

            // Search ONLY course name OR university name
            ->where(function ($query) use ($search) {

                // University search
                $query->whereHas('university', function ($q) use ($search) {

                    $q->where('name', 'LIKE', "%{$search}%");

                })

                    // Course search
                    ->orWhereHas('departments.courses', function ($q) use ($search) {

                    $q->where('name', 'LIKE', "%{$search}%");

                });
            })

            ->select(
                'id',
                'university_id',
                'program_level_id'
            )

            ->limit(20)
            ->get();

        return response()->json($programs);
    }

    public function checkEmail(Request $request)
    {
        $email = $request->email;

        $exists = Students::where('email', $email)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function checkCNIC(Request $request)
    {
        $cnic = $request->cnic;

        $exists = Students::where('cnic', $cnic)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function checkPassport(Request $request)
    {
        $passport = $request->passport;

        $exists = Students::where('passport_number', $passport)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function checkPhone(Request $request)
    {
        $exists = Students::where('phone', $request->phone_prefix . $request->phone_number)->exists();

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
            $countryIds = explode(',', $data['step1']['country']);
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
                'phone' => $data['step1']['phoneNumber'],
                'email' => $data['step1']['email'],
                'address' => $data['step1']['address'],
                'postal_code' => $data['step1']['postalCode'],
                'qualification' => $data['step1']['qualification'],
                'percentage' => $data['step1']['percentage'],
                'intake' => $data['step1']['intake'],
                'country_id' => json_encode($countryIds),
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
            $studentFolder = 'documents/' . strtolower(str_replace(' ', '', $student->first_name)) . '_' . strtolower(str_replace(' ', '', $student->last_name)) . '_' . '_' . strtolower(str_replace(' ', '', $student->intake)) . '_documents';

            if (!Storage::disk('public')->exists($studentFolder)) {
                Storage::disk('public')->makeDirectory($studentFolder);
            }


            /*
            |--------------------------------------------------------------------------
            | Single File Documents
            |--------------------------------------------------------------------------
            */

            $documentFields = [
                'cnic',
                'passport',
                'photograph',
                'cv-resume',
                'proficiency-letter',
                'motivation-letter',
                'matric-marksheet',
                'matric-certificate',
                'intermediate-marksheet',
                'intermediate-certificate',
                'bachelors-transcript',
                'bachelors-degree',
                'masters-transcript',
                'masters-degree',
                'ielts-certificate',
                'toefl-certificate',
                'pte-certificate'
            ];

            foreach ($documentFields as $field) {

                if (!$request->hasFile("step3.$field")) {
                    continue;
                }

                $file = $request->file("step3.$field");

                $fileName = $field . '.' . $file->getClientOriginalExtension();

                $path = $file->storeAs(
                    $studentFolder,
                    $fileName,
                    'public'
                );

                \App\Models\studentdocument::create([
                    'student_id' => $student->id,
                    'document_type' => $field,
                    'file_path' => $path,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Multiple File Documents
            |--------------------------------------------------------------------------
            */

            $multipleDocumentFields = [
                'recommendation-letters',
                'experience-letters',
            ];

            foreach ($multipleDocumentFields as $field) {

                if (!$request->hasFile("step3.$field")) {
                    continue;
                }

                $files = $request->file("step3.$field");

                foreach ($files as $index => $file) {

                    $fileName = $field . '_' . ($index + 1) . '.' . $file->getClientOriginalExtension();

                    $path = $file->storeAs(
                        $studentFolder,
                        $fileName,
                        'public'
                    );

                    \App\Models\studentdocument::create([
                        'student_id' => $student->id,
                        'document_type' => $field,
                        'file_path' => $path,
                    ]);
                }
            }

            // 5. Department applications
            if (!empty($data['step4'])) {

                $applications = collect($data['step4'])
                    ->groupBy('university_id');

                foreach ($applications as $universityId => $apps) {

                    $firstApp = $apps->first();

                    $courseNames = $apps
                        ->pluck('course')
                        ->filter()
                        ->values()
                        ->toArray();

                    $departmentIds = $apps
                        ->pluck('department_id')
                        ->filter()
                        ->values()
                        ->toArray();

                    \App\Models\studentapplication::create([
                        'student_id' => $student->id,
                        'country_id' => $firstApp['country_id'],
                        'university_id' => $universityId,
                        'program_level_id' => $firstApp['program_level_id'],
                        'course_name' => $courseNames,
                        'department_id' => $departmentIds,
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

    public function storeNewUniversityDepartmentCourse(Request $request)
    {
        $request->validate([
            'university_name' => 'required|string',
            'department_name' => 'required|string',
            'course_name' => 'required|string',
            'country_name' => 'required|string',
            'program_level_id' => 'required|integer',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Find Country
            |--------------------------------------------------------------------------
            */

            $country = country::where('name', $request->country_name)->first();

            /*
            |--------------------------------------------------------------------------
            | Find University
            |--------------------------------------------------------------------------
            */

            $university = university::where('name', $request->university_name)
                ->where('country_id', $country->id)
                ->first();


            /*
            |--------------------------------------------------------------------------
            | If University doesn't exist, create University
            |--------------------------------------------------------------------------
            */

            if (!$university) {

                $university = university::create([
                    'name' => $request->university_name,
                    'slug' => Str::slug($request->university_name),
                    'country_id' => $country->id,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Find Program for this University + Program Level
            |--------------------------------------------------------------------------
            */

            $program = program::where('university_id', $university->id)
                ->where('program_level_id', $request->program_level_id)
                ->first();


            /*
            |--------------------------------------------------------------------------
            | If Program doesn't exist, create it
            |--------------------------------------------------------------------------
            */

            if (!$program) {

                $program = program::create([
                    'university_id' => $university->id,
                    'program_level_id' => $request->program_level_id,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Find Department
            |--------------------------------------------------------------------------
            */

            $department = departments::where('program_id', $program->id)
                ->where('name', $request->department_name)
                ->first();


            /*
            |--------------------------------------------------------------------------
            | If Department doesn't exist, create it
            |--------------------------------------------------------------------------
            */

            if (!$department) {

                $department = departments::create([
                    'program_id' => $program->id,
                    'name' => $request->department_name,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Course
            |--------------------------------------------------------------------------
            */

            $course = course::where('department_id', $department->id)
                ->where('name', $request->course_name)
                ->first();


            if (!$course) {

                $course = course::create([
                    'department_id' => $department->id,
                    'name' => $request->course_name,
                ]);
            }


            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data Saved',
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
