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
            'step4' => 'sometimes|array',
            'english_test_list' => 'required|array',
            'english_tests' => 'sometimes|array',
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

            if (!empty($data['english_tests']) && is_array($data['english_tests'])) {

                foreach ($data['english_tests'] as $test => $values) {

                    // skip completely empty test
                    $hasData = collect($values)->filter(function($v) {
                        return $v !== null && $v !== '';
                    })->isNotEmpty();

                    if (! $hasData) continue;

                    studentenglishtests::create([
                        'student_id' => $student->id,
                        'test_name'  => strtoupper($test), // IELTS / TOEFL / PTE
                        'listening'  => $values['listening'] ?? 0,
                        'reading'    => $values['reading'] ?? 0,
                        'speaking'   => $values['speaking'] ?? 0,
                        'writing'    => $values['writing'] ?? 0,
                        'score'      => $values['overall'] ?? 0,
                        'test_date'  => !empty($values['passing_year'])
                            ? substr($values['passing_year'], 0, 4)
                            : null,
                    ]);
                }
            }

            // saving student's documents
            $studentFolder = 'documents/'.Str::slug($student->first_name.'_'.$student->last_name).'_documents';

            // Make folder if not exists
            if (! Storage::exists($studentFolder)) {
                Storage::makeDirectory($studentFolder, 0755, true);
            }

            // List of input files you expect
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
                'motivation-letter',
                'proficiency-letter',
            ];

            foreach ($documentFields as $field) {
                if ($request->hasFile("step3.$field")) {

                    $file = $request->file("step3.$field");

                    $extension = $file->getClientOriginalExtension();
                    $fileName = strtolower($field).'_'.time().'.'.$extension;

                    $path = $file->storeAs($studentFolder, $fileName, 'public');

                    \App\Models\StudentDocument::create([
                        'student_id' => $student->id,
                        'document_type' => $field,
                        'file_path' => $path,
                    ]);
                }
            }

            // saving student's department applications
            if (!empty($data['step4']) && is_array($data['step4'])) {
                foreach ($data['step4'] as $app) {
                    \App\Models\studentapplication::create([
                        'student_id' => $student->id,
                        'country_id' => $student->country_id ?? null,
                        'university_id' => $app['university_id'] ?? null,
                        'program_level_id' => $student->program_level_id ?? null,
                        'department_id' => $app['department_id'] ?? null,
                    ]);
                }
            }

        return response()->json([
            "id" => $student->id,
            "success" => true,
            "message" => "Student Registered"
        ]);
    }
}
