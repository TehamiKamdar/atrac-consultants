<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\program_level;
use App\Models\studentapplication;
use App\Models\studenteducation;
use App\Models\studentenglishtests;
use App\Models\students;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function downloadPdf($id)
    {
        $student = students::findOrFail($id);
        $country = country::where('id', $student->country_id)->value('name');
        $program_level = program_level::where('id', $student->program_level_id)->value('name');
        $education_details = studenteducation::where('student_id', $id)->get();
        $english_test_details = studentenglishtests::where('student_id', $id)->get();
        $application_details = studentapplication::join('universities', 'student_applications.university_id', '=', 'universities.id')
            ->join('departments', 'student_applications.department_id', '=', 'departments.id')
            ->where('student_applications.student_id', $id)
            ->select('universities.name as university', 'departments.name as department')
            ->get();

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

        $filename = preg_replace('/[^A-Za-z0-9\-]/', '', $student->first_name.'-'.$student->last_name).'-student-profile.pdf';
        return $pdf->download($filename);

    }

    public function viewPdf($id)
    {
        $student = students::findOrFail($id);
        $country = country::where('id', $student->country_id)->value('name');
        $program_level = program_level::where('id', $student->program_level_id)->value('name');
        $education_details = studenteducation::where('student_id', $id)->get();
        $english_test_details = studentenglishtests::where('student_id', $id)->get();
        $application_details = studentapplication::join('universities', 'student_applications.university_id', '=', 'universities.id')
            ->join('departments', 'student_applications.department_id', '=', 'departments.id')
            ->where('student_applications.student_id', $id)
            ->select('universities.name as university', 'departments.name as department')
            ->get();
        return view('pages.profile', compact('student', 'country', 'program_level', 'education_details', 'english_test_details', 'application_details'));
    }
}
