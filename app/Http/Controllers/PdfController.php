<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\departments;
use App\Models\program_level;
use App\Models\studentapplication;
use App\Models\studenteducation;
use App\Models\studentenglishtests;
use App\Models\students;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PdfController extends Controller
{
    public function downloadPdf($id)
    {
        $student = students::findOrFail($id);
        $countryIds = $student->country_id ?? [];

        $country = country::whereIn('id', $countryIds)
            ->pluck('name')
            ->implode(', ');
        $program_level = program_level::where('id', $student->program_level_id)->value('name');
        $education_details = studenteducation::where('student_id', $id)->get();
        $english_test_details = studentenglishtests::where('student_id', $id)->get();
        $application_details = studentapplication::with([
            'university:id,name',
            'student:id,intake',
        ])
            ->where('student_id', $id)
            ->get()
            ->map(function ($application) {

                // Course names
                $courses = $application->course_name;

                if (is_string($courses)) {
                    $decodedCourses = json_decode($courses, true);

                    $courses = is_array($decodedCourses)
                        ? $decodedCourses
                        : [$courses];
                }

                if (!is_array($courses)) {
                    $courses = [];
                }


                // Department IDs
                $departmentIds = $application->department_id;

                if (is_string($departmentIds)) {
                    $decodedDepartments = json_decode($departmentIds, true);

                    $departmentIds = is_array($decodedDepartments)
                        ? $decodedDepartments
                        : [$departmentIds];
                }

                if (!is_array($departmentIds)) {
                    $departmentIds = [];
                }


                // Get all departments
                $departmentNames = departments::whereIn('id', $departmentIds)
                    ->pluck('name', 'id');


                // Match course with department by index
                $courseDetails = collect($courses)
                    ->map(function ($course, $index) use ($departmentIds, $departmentNames) {

                    $departmentId = $departmentIds[$index] ?? null;

                    return [
                        'course' => $course,
                        'department' => $departmentNames[$departmentId] ?? '',
                    ];
                })
                    ->values()
                    ->toArray();


                return [
                    'intake' => $application->student->intake ?? '',

                    'university' => $application->university->name ?? '',

                    'courses' => $courseDetails,
                ];
            });

        // Load PDF with same variables as view
        $pdf = Pdf::loadView('pages.generate', compact(
            'student',
            'country',
            'program_level',
            'education_details',
            'english_test_details',
            'application_details'
        ))
            ->setPaper('A4', 'portrait');

        $filename = preg_replace('/[^A-Za-z0-9\-]/', '', $student->first_name . '-' . $student->last_name) . '-student-profile.pdf';
        return $pdf->download(strtolower($filename));

    }

    public function viewPdf($id)
    {
        $student = students::findOrFail($id);

        $country = country::where('id', $student->country_id)->value('name');

        $activeCountries = country::where('status', 'active')->pluck('name', 'id');

        $program_levels = program_level::all();

        $education_details = studenteducation::where('student_id', $id)->get();

        $english_test_details = studentenglishtests::where('student_id', $id)->get();

        $application_details = studentapplication::with([
            'university:id,name',
            'student:id,intake',
        ])
            ->where('student_id', $id)
            ->get()
            ->map(function ($application) {

                // Course names
                $courses = $application->course_name;

                if (is_string($courses)) {
                    $decodedCourses = json_decode($courses, true);

                    $courses = is_array($decodedCourses)
                        ? $decodedCourses
                        : [$courses];
                }

                if (!is_array($courses)) {
                    $courses = [];
                }


                // Department IDs
                $departmentIds = $application->department_id;

                if (is_string($departmentIds)) {
                    $decodedDepartments = json_decode($departmentIds, true);

                    $departmentIds = is_array($decodedDepartments)
                        ? $decodedDepartments
                        : [$departmentIds];
                }

                if (!is_array($departmentIds)) {
                    $departmentIds = [];
                }


                // Get all departments
                $departmentNames = departments::whereIn('id', $departmentIds)
                    ->pluck('name', 'id');


                // Match course with department by index
                $courseDetails = collect($courses)
                    ->map(function ($course, $index) use ($departmentIds, $departmentNames) {

                    $departmentId = $departmentIds[$index] ?? null;

                    return [
                        'course' => $course,
                        'department' => $departmentNames[$departmentId] ?? '',
                    ];
                })
                    ->values()
                    ->toArray();


                return [
                    'intake' => $application->student->intake ?? '',

                    'university' => $application->university->name ?? '',

                    'courses' => $courseDetails,
                ];
            });
        return view('pages.profile', compact('student', 'country', 'activeCountries', 'program_levels', 'education_details', 'english_test_details', 'application_details'));
    }

    public function update(Request $request)
    {
        // Authenticated user ka student record
        $student = students::findOrFail($request->id);

        abort_if(!$student, 403, 'Student profile not found.');

        /*
        |--------------------------------------------------------------------------
        | 1. Validate request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            // Personal information
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'father_name' => ['required', 'string', 'max:150'],
            'mother_name' => ['required', 'string', 'max:150'],
            'dob' => ['required', 'date'],
            'city' => ['required', 'string', 'max:100'],
            'cnic' => ['required', 'string', 'max:30'],
            'passport_number' => ['required', 'string', 'max:50'],
            'passport_valid_from' => ['required', 'date'],
            'passport_valid_thru' => [
                'required',
                'date',
                'after_or_equal:passport_valid_from',
            ],

            // Contact information
            'address' => ['nullable', 'string', 'max:1000'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],

            // Academic summary
            'qualification' => ['nullable', 'string', 'max:150'],
            'percentage' => ['nullable', 'numeric', 'min:0'],
            'countries' => ['nullable', 'array'],
            'countries.*' => ['required', 'integer'],
            'program_level_id' => ['nullable', 'integer'],
            'intake' => ['nullable', 'string', 'max:50'],
            'english_test' => ['nullable', 'array'],
            'english_test.*' => [
                'required',
                Rule::in(['IELTS', 'PTE', 'TOEFL', 'None']),
            ],

            // Education rows
            'education' => ['nullable', 'array'],
            'education.*.id' => ['nullable', 'integer'],
            'education.*.level' => [
                'required',
            ],
            'education.*.institute' => ['required', 'string', 'max:255'],
            'education.*.board' => ['required', 'string', 'max:255'],
            'education.*.subject' => ['required', 'string', 'max:255'],
            'education.*.passing_year' => [
                'required',
                'integer',
                'min:1900',
            ],
            'education.*.obtained_marks' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'education.*.total_marks' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'education.*.grade_or_cgpa' => [
                'nullable',
                'string',
            ],

            // English test rows
            'english_tests' => ['nullable', 'array'],
            'english_tests.*.id' => ['nullable', 'integer'],
            'english_tests.*.test_name' => [
                'required',
                Rule::in(['IELTS', 'PTE', 'TOEFL']),
            ],
            'english_tests.*.listening' => [
                'nullable',
                'string',
            ],
            'english_tests.*.reading' => [
                'nullable',
                'string',
                'max:30',
            ],
            'english_tests.*.speaking' => [
                'nullable',
                'string',
            ],
            'english_tests.*.writing' => [
                'nullable',
                'string',
            ],
            'english_tests.*.score' => [
                'nullable',
                'string',
            ],
            'english_tests.*.test_date' => [
                'nullable',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. Update all tables in one transaction
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($student, $validated) {

            /*
            | Students table
            */

            $student->forceFill([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'father_name' => $validated['father_name'] ?? null,
                'mother_name' => $validated['mother_name'] ?? null,
                'dob' => $validated['dob'] ?? null,
                'city' => $validated['city'] ?? null,
                'cnic' => $validated['cnic'] ?? null,
                'passport_number' => $validated['passport_number'] ?? null,
                'passport_valid_from' => $validated['passport_valid_from'] ?? null,
                'passport_valid_thru' => $validated['passport_valid_thru'] ?? null,

                'address' => $validated['address'] ?? null,
                'postal_code' => $validated['postal_code'] ?? null,
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,

                'qualification' => $validated['qualification'] ?? null,
                'percentage' => $validated['percentage'] ?? null,

                // Database mein JSON string store ho rahi hai
                'country_id' => $validated['countries'] ?? [],

                'program_level_id' => $validated['program_level_id'] ?? null,
                'intake' => $validated['intake'] ?? null,

                'english_test' => json_encode(
                    $validated['english_test'] ?? []
                ),
            ])->save();

            /*
            | Student educations table
            */

            foreach ($validated['education'] ?? [] as $row) {

                $educationData = [
                    'level' => $row['level'],
                    'institute' => $row['institute'],
                    'board' => $row['board'],
                    'subject' => $row['subject'],
                    'passing_year' => $row['passing_year'],
                    'obtained_marks' => $row['obtained_marks'] ?? null,
                    'total_marks' => $row['total_marks'] ?? null,
                    'grade_or_cgpa' => $row['grade_or_cgpa'] ?? null,
                ];

                if (!empty($row['id'])) {

                    // Sirf isi student ka existing record update hoga
                    $updated = DB::table('student_educations')
                        ->where('id', $row['id'])
                        ->where('student_id', $student->id)
                        ->update($educationData);

                    abort_if(
                        !$updated &&
                        !DB::table('student_educations')
                            ->where('id', $row['id'])
                            ->where('student_id', $student->id)
                            ->exists(),
                        403,
                        'Invalid education record.'
                    );

                } else {

                    // New education record
                    $educationData['student_id'] = $student->id;
                    $educationData['created_at'] = now();
                    $educationData['updated_at'] = now();

                    DB::table('student_educations')
                        ->insert($educationData);
                }
            }

            /*
            | Student English tests table
            */

            foreach ($validated['english_tests'] ?? [] as $row) {

                $testData = [
                    'test_name' => $row['test_name'],
                    'listening' => $row['listening'] ?? null,
                    'reading' => $row['reading'] ?? null,
                    'speaking' => $row['speaking'] ?? null,
                    'writing' => $row['writing'] ?? null,
                    'score' => $row['score'] ?? null,
                    'test_date' => $row['test_date'] ?? null,
                ];

                if (!empty($row['id'])) {

                    // Sirf isi student ka existing test update hoga
                    $updated = DB::table('student_english_tests')
                        ->where('id', $row['id'])
                        ->where('student_id', $student->id)
                        ->update($testData);

                    abort_if(
                        !$updated &&
                        !DB::table('student_english_tests')
                            ->where('id', $row['id'])
                            ->where('student_id', $student->id)
                            ->exists(),
                        403,
                        'Invalid English test record.'
                    );

                } else {

                    // New English test record
                    $testData['student_id'] = $student->id;
                    $testData['created_at'] = now();
                    $testData['updated_at'] = now();

                    DB::table('student_english_tests')
                        ->insert($testData);
                }
            }
        });

        return back()->with(
            'success',
            'Student profile updated successfully.'
        );
    }
}
