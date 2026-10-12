<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\studentapplication;
use App\Models\studentdocument;
use App\Models\students;
use App\Services\StudentDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    protected StudentDocumentService $studentDocumentService;

    public function __construct(
        StudentDocumentService $studentDocumentService
    ) {
        $this->studentDocumentService = $studentDocumentService;
    }

    public function index()
    {
        $user = auth()->user();
        $student = $user->student;
        return view('student.dashboard.index', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return response()->json([
                'message' => 'Student profile not found.'
            ], 404);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'father_name' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'dob' => 'nullable|date',
            'cnic' => 'nullable|string|max:30|unique:students,cnic,' . $student->id,
            'passport' => 'nullable|string|max:50',
            'passport_valid_from' => 'nullable|date',
            'passport_valid_thru' => 'nullable|date',
        ]);

        $student->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'father_name' => $validated['father_name'] ?? null,
            'mother_name' => $validated['mother_name'] ?? null,
            'city' => $validated['city'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'dob' => $validated['dob'] ?? null,
            'cnic' => $validated['cnic'] ?? null,
            'passport_number' => $validated['passport'] ?? null,
            'passport_valid_from' => $validated['passport_valid_from'] ?? null,
            'passport_valid_thru' => $validated['passport_valid_thru'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
        ]);
    }

    public function getDocuments(StudentDocumentService $documentService)
    {
        $student = auth()->user()->student;

        $documents = $this->studentDocumentService->getDocuments($student);

        return view('student.dashboard.documents.index', compact(
            'student',
            'documents'
        ));

    }

    public function viewDocument($documentId)
    {
        return $this->studentDocumentService->viewDocument($documentId);
    }

    public function deleteDocument($id)
    {
        return $this->studentDocumentService->deleteDocument($id);
    }

    public function editDocument(Request $request, $documentId)
    {
        return $this->studentDocumentService->editDocument($request, $documentId);
    }

    public function addDocument(Request $request, $studentId)
    {
        return $this->studentDocumentService->addDocument($request, $studentId);
    }

    public function uploadDocument(Request $request)
    {
        return $this->studentDocumentService->uploadDocument($request);
    }

    public function getApplications()
    {
        $student = auth()->user()->student;

        $applications = studentapplication::with('details')
            ->where('student_id', $student->id)
            ->whereHas('details')
            ->latest()
            ->get();

        return view(
            'student.dashboard.applications.index',
            compact('student', 'applications')
        );
    }

    public function getSettings()
    {
        $student = auth()->user()->student;

        return view('student.dashboard.settings.index', compact('student'));
    }

    public function updatePassword(Request $request)
    {

        $request->validate([
            'current' => 'required|string',

            'new1' => [
                'required',
                'string',
                'min:8',
                'max:64',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
            ],

            'new2' => 'required|string|same:new1',

        ], [
            'new1.required' => 'New password is required.',
            'new1.min' => 'New password must be at least 8 characters.',
            'new1.max' => 'New password cannot exceed 64 characters.',

            'new1.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',

            'new2.required' => 'Please confirm your new password.',
            'new2.same' => 'New password and confirm password do not match.',
        ]);

        $user = auth()->user();

        if (!\Hash::check($request->current, $user->password)) {
            return back()->withErrors(['current' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new1);
        $user->must_change_password = 0;
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
