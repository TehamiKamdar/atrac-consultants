<?php

namespace App\Services;

use App\Models\studentdocument;
use Illuminate\Support\Collection;

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
}