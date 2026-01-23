<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use ZipArchive;

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
}
