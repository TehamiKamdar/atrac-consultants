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

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $student = $user->student;

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
        ]);

        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.'
        ]);
    }
}
