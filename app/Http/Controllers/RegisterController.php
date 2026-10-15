<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\course;
use App\Models\departments;
use App\Models\Intake;
use App\Models\program_level;
use App\Models\program;
use App\Models\sim_codes;
use App\Models\studenteducation;
use App\Models\studentenglishtests;
use App\Models\students;
use App\Models\university;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        $activeCountries = country::where('status', 'active')->orderBy('name', 'ASC')->get();
        $program_levels = program_level::all();
        $intakes = Intake::where('is_active', 1)->get();
        return view('pages.register', compact('activeCountries', 'intakes', 'program_levels'));
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

    public function checkEmail(Request $request, $studentId = null)
    {
        $query = students::where('email', $request->email);

        if ($studentId) {
            $query->where('id', '!=', $studentId);
        }

        return response()->json([
            'exists' => $query->exists()
        ]);
    }

    public function checkCNIC(Request $request, $studentId = null)
    {
        $query = students::where('cnic', $request->cnic);

        if ($studentId) {
            $query->where('id', '!=', $studentId);
        }

        return response()->json([
            'exists' => $query->exists()
        ]);
    }

    public function checkPassport(Request $request, $studentId = null)
    {
        $query = students::where('passport_number', $request->passport);

        if ($studentId) {
            $query->where('id', '!=', $studentId);
        }

        return response()->json([
            'exists' => $query->exists()
        ]);
    }

    public function checkPhone(Request $request, $studentId = null)
    {
        $phone = $request->phone_number;

        $query = students::where('phone', $phone);

        if ($studentId) {
            $query->where('id', '!=', $studentId);
        }

        return response()->json([
            'exists' => $query->exists()
        ]);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->validate([
                'first_name' => 'nullable|string',
                'last_name' => 'nullable|string',
                'father_name' => 'nullable|string',
                'mother_name' => 'nullable|string',
                'city' => 'nullable|string',
                'dob' => 'nullable|string',
                'cnic' => 'nullable|string',
                'passport_number' => 'nullable|string',
                'passport_valid_from' => 'nullable|string',
                'passport_valid_thru' => 'nullable|string',
                'phone' => 'nullable|string',
                'email' => 'nullable|string',
                'address' => 'nullable|string',
                'postal_code' => 'nullable|string',
                'qualification' => 'nullable|string',
                'percentage' => 'nullable|string',
                'intake' => 'nullable|string',

                'countries' => 'nullable|array',
                'countries.*' => 'integer',
                
                'program_level' => 'nullable|string',

                'english_test' => 'nullable|array',
                'english_proficiency' => 'nullable|string',

                'education' => 'nullable|array',
                'education.*.level' => 'required|string|max:255',
                'education.*.institute' => 'required|string|max:255',
                'education.*.board' => 'required|string|max:255',
                'education.*.subject' => 'required|string|max:255',
                'education.*.passing_year' => 'required|integer|min:1900|max:' . (date('Y') + 10),
                'education.*.obtained_marks' => 'nullable|numeric',
                'education.*.total_marks' => 'nullable|numeric',
                'education.*.grade_or_cgpa' => 'nullable|string|max:100',

                'english_tests' => 'nullable|array',
                'english_tests.*.test_name' => 'required|string|max:100',
                'english_tests.*.listening' => 'nullable|numeric',
                'english_tests.*.reading' => 'nullable|numeric',
                'english_tests.*.speaking' => 'nullable|numeric',
                'english_tests.*.writing' => 'nullable|numeric',
                'english_tests.*.score' => 'nullable|numeric',
                'english_tests.*.test_date' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),

                'programs' => 'nullable|array',
                'programs.*.program_level_id' => 'required_with:programs|integer',
                'programs.*.country_id' => 'required_with:programs|integer',
                'programs.*.university_id' => 'required_with:programs|integer',
                'programs.*.department_id' => 'nullable|integer',
                'programs.*.course_id' => 'nullable|integer',
            ]);

            $countryIds = $data['countries'];

            if (!is_array($countryIds)) {
                $countryIds = [$countryIds];
            }

            // 2. Save student
            $student = students::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'father_name' => $data['father_name'],
                'mother_name' => $data['mother_name'],
                'city' => $data['city'],
                'dob' => $data['dob'],
                'cnic' => $data['cnic'],
                'passport_number' => $data['passport_number'],
                'passport_valid_from' => $data['passport_valid_from'],
                'passport_valid_thru' => $data['passport_valid_thru'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'address' => $data['address'],
                'postal_code' => $data['postal_code'],
                'qualification' => $data['qualification'],
                'percentage' => $data['percentage'],
                'intake' => $data['intake'],
                'country_id' => $countryIds,
                'program_level_id' => $data['program_level'],
                'english_test' => json_encode($data['english_test']),
                'english_proficiency' => $data['english_proficiency'],
            ]);

            // 2. Save academics
            foreach ($data['education'] ?? [] as $academic) {
                studenteducation::create([
                    'student_id' => $student->id,
                    'level' => $academic['level'],
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
            foreach ($data['english_tests'] ?? [] as $test) {
                $hasScores = collect([
                    $test['listening'] ?? null,
                    $test['reading'] ?? null,
                    $test['speaking'] ?? null,
                    $test['writing'] ?? null,
                    $test['score'] ?? null,
                    $test['test_date'] ?? null,
                ])->contains(fn($value) => $value !== null && $value !== '');

                if (!$hasScores) {
                    continue;
                }

                studentenglishtests::create([
                    'student_id' => $student->id,
                    'test_name' => strtoupper($test['test_name']),
                    'listening' => $test['listening'] ?? 0,
                    'reading' => $test['reading'] ?? 0,
                    'speaking' => $test['speaking'] ?? 0,
                    'writing' => $test['writing'] ?? 0,
                    'score' => $test['score'] ?? 0,
                    'test_date' => $test['test_date'] ?? null,
                ]);
            }

            // 4. Documents
            $studentFolder = 'documents/' . strtolower(str_replace(' ', '', $student->first_name)) . '_' . strtolower(str_replace(' ', '', $student->last_name)) . '_' . strtolower(str_replace(' ', '', $student->intake)) . '_documents';

            if (!Storage::disk('public')->exists($studentFolder)) {
                Storage::disk('public')->makeDirectory($studentFolder);
            }

            /*
            |--------------------------------------------------------------------------
            | Multiple File Documents
            |--------------------------------------------------------------------------
            */

            $multipleDocumentFields = [
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
                'pte-certificate',
                'recommendation-letters',
                'experience-letters',
                'other-certificates'
            ];

            foreach ($multipleDocumentFields as $field) {

                if (!$request->hasFile("step3.$field")) {
                    continue;
                }

                $files = $request->file("step3.$field");

                foreach ($files as $file) {

                    $fileName = $file->getClientOriginalName();

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
            $programs = collect($data['programs'] ?? []);

            // Same university ko different countries/program levels mein
            // accidentally combine hone se bachata hai.
            $applications = $programs->groupBy(function ($program) {
                return $program['country_id']
                    . '_'
                    . $program['university_id']
                    . '_'
                    . $program['program_level_id'];
            });

            foreach ($applications as $apps) {
                $firstApp = $apps->first();
                $courseIds = $apps
                    ->pluck('course_id')
                    ->filter()
                    ->unique()
                    ->values();

                $courseNames = course::whereIn('id', $courseIds)
                    ->pluck('name')
                    ->toArray();

                $departmentIds = $apps
                    ->pluck('department_id')
                    ->filter()
                    ->unique()
                    ->values()
                    ->toArray();

                \App\Models\studentapplication::create([
                    'student_id' => $student->id,
                    'country_id' => $firstApp['country_id'],
                    'university_id' => $firstApp['university_id'],
                    'program_level_id' => $firstApp['program_level_id'],
                    'course_name' => $courseNames,
                    'department_id' => $departmentIds,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'id' => $student->id,
                'message' => 'Profile Created'
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
