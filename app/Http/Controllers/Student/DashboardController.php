<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\studentapplication;
use App\Models\studentapplicationdetail;
use App\Models\studentdocument;
use App\Models\students;
use App\Services\StudentDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
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

        $documents = $documentService->getDocuments($student);

        return view('student.dashboard.documents.index', compact(
            'student',
            'documents'
        ));

    }



    public function viewDocument($documentId)
    {
        $document = studentdocument::findOrFail($documentId);

        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }

        return response()->file(
            Storage::disk('public')->path($document->file_path)
        );
    }

    public function deleteDocument($id)
    {
        $document = studentdocument::findOrFail($id);

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document deleted successfully.'
        ]);
    }

    public function editDocument(Request $request, $documentId)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $document = studentdocument::findOrFail($documentId);

        $oldPath = $document->file_path;

        // Purane path se filename nikaal lo
        $filename = basename($oldPath);

        // Same folder
        $directory = dirname($oldPath);

        // Purani file delete karo
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        // New file ko purane filename ke saath save karo
        $newPath = $request->file('file')->storeAs(
            $directory,
            $filename,
            'public'
        );

        // DB path same rahega
        $document->update([
            'file_path' => $newPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document updated successfully.',
        ]);
    }

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'document_type' => 'required|string',
            'files' => 'required',
            'files.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $student = students::findOrFail($request->student_id);

        // Existing document ka folder le lo
        $existingDocument = studentdocument::where('student_id', $student->id)
            ->where('document_type', $request->document_type)
            ->first();

        if ($existingDocument) {
            $directory = dirname($existingDocument->file_path);
        } else {
            // Agar is type ki koi file pehle nahi hai
            $directory = 'documents/' .
                strtolower(str_replace(' ', '', $student->first_name)) . '_' .
                strtolower(str_replace(' ', '', $student->last_name)) . '_' .
                strtolower(str_replace(' ', '', $student->intake)) . '_documents';
        }

        // Existing files ka count
        $existingCount = studentdocument::where('student_id', $student->id)
            ->where('document_type', $request->document_type)
            ->count();

        foreach ($request->file('files') as $index => $file) {

            $number = $existingCount + $index + 1;

            $extension = $file->getClientOriginalExtension();

            $filename = $request->document_type . '_' . $number . '.' . $extension;

            $path = $file->storeAs(
                $directory,
                $filename,
                'public'
            );

            studentdocument::create([
                'student_id' => $student->id,
                'document_type' => $request->document_type,
                'file_path' => $path,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Documents uploaded successfully.',
        ]);
    }

    public function getApplications()
    {
        $student = auth()->user()->student;

        $applications = studentapplicationdetail::where('student_id', $student->id)
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
