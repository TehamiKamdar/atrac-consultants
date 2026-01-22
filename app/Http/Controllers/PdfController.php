<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function downloadDemoPdf()
    {
        $pdf = Pdf::loadView('pages.profile')
            ->setPaper('A4', 'portrait');

        return $pdf->download('student-profile.pdf');
    }
    public function viewPdf()
    {
        return view('pages.profile');
    }
}
