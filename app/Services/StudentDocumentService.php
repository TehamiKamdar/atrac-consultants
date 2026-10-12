<?php

namespace App\Services;

use App\Models\studentdocument;
use App\Models\students;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class StudentDocumentService
{
    public function getDocuments($student): Collection
    {
        $uploadedDocuments = studentdocument::where('student_id', $student->id)->get();

        /*
        |--------------------------------------------------------------------------
        | Common Documents
        |--------------------------------------------------------------------------
        */

        $requiredDocuments = [
            'cnic' => 'CNIC',
            'passport' => 'Passport',
            'photograph' => 'Photograph',
            'cv-resume' => 'CV / Resume',
            'proficiency-letter' => 'Proficiency Letter',
            'motivation-letter' => 'Motivation Letter',
            'ielts-certificate' => 'IELTS Certificate',
            'toefl-certificate' => 'TOEFL Certificate',
            'pte-certificate' => 'PTE Certificate',
            'recommendation-letters' => 'Recommendation Letters',
            'experience-letters' => 'Experience Letters',
            'other-certificates' => 'Additional Document',
        ];

        /*
        |--------------------------------------------------------------------------
        | Academic Documents
        |--------------------------------------------------------------------------
        */

        $academicDocuments = [
            'matric' => [
                'matric-marksheet' => 'Matric Marksheet',
                'matric-certificate' => 'Matric Certificate',
            ],

            'intermediate' => [
                'intermediate-marksheet' => 'Intermediate Marksheet',
                'intermediate-certificate' => 'Intermediate Certificate',
            ],

            'bachelors' => [
                'bachelors-transcript' => 'Bachelors Transcript',
                'bachelors-degree' => 'Bachelors Degree',
            ],

            'masters' => [
                'masters-transcript' => 'Masters Transcript',
                'masters-degree' => 'Masters Degree',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Qualification
        |--------------------------------------------------------------------------
        */

        $qualification = strtolower(
            trim($student->qualification ?? '')
        );

        /*
        |--------------------------------------------------------------------------
        | Add Academic Documents According To Qualification
        |--------------------------------------------------------------------------
        */

        // Matric is common for every qualification
        $requiredDocuments = array_merge(
            $requiredDocuments,
            $academicDocuments['matric']
        );

        if ($qualification === 'intermediate') {

            $requiredDocuments = array_merge(
                $requiredDocuments,
                $academicDocuments['intermediate']
            );

        } elseif ($qualification === 'bachelors') {

            $requiredDocuments = array_merge(
                $requiredDocuments,
                $academicDocuments['intermediate'],
                $academicDocuments['bachelors']
            );

        } elseif ($qualification === 'masters') {

            $requiredDocuments = array_merge(
                $requiredDocuments,
                $academicDocuments['intermediate'],
                $academicDocuments['bachelors'],
                $academicDocuments['masters']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Build Documents Collection
        |--------------------------------------------------------------------------
        */

        $documents = collect();

        foreach ($requiredDocuments as $type => $name) {

            $files = $uploadedDocuments->where('document_type', $type);

            if ($files->count() > 0) {

                /*
                |--------------------------------------------------------------------------
                | Every DB record gets its own row
                |--------------------------------------------------------------------------
                */

                foreach ($files as $file) {

                    $documents->push([
                        'type' => $type,
                        'name' => $name,
                        'uploaded' => true,
                        'file' => $file,
                    ]);
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | No file uploaded = Pending
                |--------------------------------------------------------------------------
                */

                $documents->push([
                    'type' => $type,
                    'name' => $name,
                    'uploaded' => false,
                    'file' => null,
                ]);
            }
        }

        return $documents;
    }

    /* ===============================
        VIEW DOCUMENT
    =============================== */

    public function viewDocument($documentId)
    {
        $document = studentdocument::findOrFail($documentId);

        if (
            !Storage::disk('public')->exists($document->file_path)
        ) {
            abort(404);
        }

        return response()->file(
            Storage::disk('public')->path($document->file_path)
        );
    }


    /* ===============================
        DELETE DOCUMENT
    =============================== */

    public function deleteDocument($id)
    {
        $document = studentdocument::findOrFail($id);

        if (
            $document->file_path &&
            Storage::disk('public')->exists($document->file_path)
        ) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document deleted successfully.',
        ]);
    }


    /* ===============================
        EDIT DOCUMENT
    =============================== */

    public function editDocument(Request $request, $documentId)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $document = studentdocument::findOrFail($documentId);

        $oldPath = $document->file_path;
        $directory = dirname($oldPath);

        // Uploaded file ka original name
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();

        // Agar same folder mein filename already exist karta hai
        $existingPath = $directory . '/' . $filename;

        if (
            $existingPath !== $oldPath &&
            Storage::disk('public')->exists($existingPath)
        ) {
            $name = pathinfo($filename, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $filename = $name . '_' . time() . '.' . $extension;
        }

        // New file save karo
        $newPath = $file->storeAs(
            $directory,
            $filename,
            'public'
        );

        // New file save hone ke baad purani file delete karo
        if (
            $oldPath &&
            $oldPath !== $newPath &&
            Storage::disk('public')->exists($oldPath)
        ) {
            Storage::disk('public')->delete($oldPath);
        }

        $document->update([
            'file_path' => $newPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document updated successfully.',
        ]);
    }


    /* ===============================
    ADD DOCUMENT
=============================== */

    public function addDocument(Request $request, $studentId)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'document_type' => 'required|string|max:255',
        ]);

        $student = students::findOrFail($studentId);

        $file = $request->file('file');

        // Original filename
        $filename = $file->getClientOriginalName();

        // Student folder
        $folderName = strtolower(
            str_replace(
                ' ',
                '',
                $student->first_name . '_' . $student->last_name . '_' . $student->intake
            )
        );

        $directory = "documents/{$folderName}_documents";

        // Duplicate filename se bachao
        $path = "{$directory}/{$filename}";

        if (Storage::disk('public')->exists($path)) {
            $name = pathinfo($filename, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $filename = $name . '_' . time() . '.' . $extension;
        }

        $filePath = $file->storeAs(
            $directory,
            $filename,
            'public'
        );

        $document = studentdocument::create([
            'student_id' => $student->id,
            'document_type' => $request->input('document_type'),
            'file_path' => $filePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document uploaded successfully.',
            'document' => $document,
        ]);
    }


    /* ===============================
    UPLOAD MULTIPLE DOCUMENTS
=============================== */

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'document_type' => 'required|string',
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $student = students::findOrFail($request->student_id);

        // Existing document ka folder
        $existingDocument = studentdocument::where(
            'student_id',
            $student->id
        )
            ->where('document_type', $request->document_type)
            ->first();

        if ($existingDocument) {
            $directory = dirname($existingDocument->file_path);
        } else {
            $folderName = strtolower(
                str_replace(' ', '', $student->first_name) . '_' .
                str_replace(' ', '', $student->last_name) . '_' .
                str_replace(' ', '', $student->intake)
            );

            $directory = "documents/{$folderName}_documents";
        }

        foreach ($request->file('files') as $file) {

            // Uploaded file ka original filename
            $filename = $file->getClientOriginalName();

            $path = "{$directory}/{$filename}";

            // Duplicate filename se bachao
            if (Storage::disk('public')->exists($path)) {
                $name = pathinfo($filename, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();

                $filename = $name . '_' . uniqid() . '.' . $extension;
            }

            $filePath = $file->storeAs(
                $directory,
                $filename,
                'public'
            );

            studentdocument::create([
                'student_id' => $student->id,
                'document_type' => $request->document_type,
                'file_path' => $filePath,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Documents uploaded successfully.',
        ]);
    }
}