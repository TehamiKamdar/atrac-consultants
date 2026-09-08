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

class PdfController extends Controller
{
    public function downloadPdf($id)
    {
        $student = students::findOrFail($id);
        $country = country::where('id', $student->country_id)->value('name');
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
        $pdf = Pdf::loadView('pages.profile', compact(
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
        return view('pages.profile', compact('student', 'country', 'program_level', 'education_details', 'english_test_details', 'application_details'));
    }
}
