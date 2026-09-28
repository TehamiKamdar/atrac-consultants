<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $user = auth()->user();
        $student = $user->student;
        return view('student.dashboard.index', compact('student'));
    }
}
