<?php

namespace App\Http\Controllers;

use App\Models\students;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function downloadDocuments($folder)
    {

        $folderPath = storage_path("app/public/documents/{$folder}");

        if (! file_exists($folderPath)) {
            abort(404, 'File Not Found');
        }

        $zipFileName = "{$folder}.zip";
        $tempDir = storage_path('app/public/temp');
        $tempPath = $tempDir.'/'.$zipFileName;

        // Create temp folder if not exists
        if (! file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        } else {
        }

        $zip = new ZipArchive;
        if ($zip->open($tempPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {

            $files = scandir($folderPath);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $filePath = $folderPath.'/'.$file;
                $zip->addFile($filePath, $file);
                Log::info("Added file to ZIP: {$filePath}");
            }

            $zip->close();
        } else {
            abort(500, 'Cannot create ZIP file');
        }


        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $student = students::findOrFail($id);

            // --- Delete storage folder ---
            $folderName = $student->email . '_documents';
            if (Storage::disk('public')->exists($folderName)) {
                Storage::disk('public')->deleteDirectory($folderName);
            }

            // --- Delete related tables ---
            DB::table('student_application_details')->where('student_id', $id)->delete();
            DB::table('student_applications')->where('student_id', $id)->delete();
            DB::table('student_educations')->where('student_id', $id)->delete();
            DB::table('student_documents')->where('student_id', $id)->delete();
            DB::table('student_english_tests')->where('student_id', $id)->delete();

            // --- Delete student ---
            $student->delete();

            DB::commit();

            return response()->json([
                'message' => 'Student, related records & documents deleted successfully'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Student delete failed', [
                'student_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Deletion failed'
            ], 500);
        }
    }
}
