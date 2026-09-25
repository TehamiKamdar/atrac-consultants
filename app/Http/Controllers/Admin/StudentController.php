<?php

namespace App\Http\Controllers\Admin;

use App\Models\country;
use App\Models\departments;
use App\Models\studentapplication;
use App\Models\studentapplicationdetail;
use App\Models\students;
use App\Models\university;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index()
    {
        $students = students::all();

        return view('admin.students.index', compact('students'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $students = students::query()->when($query, function ($q) use ($query) {
            $q->where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
        })->orderBy('first_name')->get();

        return view('admin.students.partials.table', compact('students'));
    }

    public function getStudentCountriesandProgramLevel($studentId)
    {
        $student = students::findOrFail($studentId);

        $countries = country::where('status', "active")
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'countries' => $countries,
            'selected' => $student->country_id ?? [],
            'applying' => $student->program_level_id,
        ]);
    }

    public function getStudentPrograms($studentId)
    {
        $applications = studentapplication::with([
            'country',
            'university',
            'programLevel',
        ])
            ->where('student_id', $studentId)
            ->get();

        // Sab applications ke department_id collect karke ek hi query mein names fetch karo
        $allDepartmentIds = $applications
            ->pluck('department_id')
            ->flatten()
            ->filter()
            ->unique()
            ->values();

        $departmentsMap = departments::whereIn('id', $allDepartmentIds)
            ->get(['id', 'name'])
            ->keyBy('id');

        $applications->transform(function ($app) use ($departmentsMap) {
            $ids = $app->department_id ?? [];

            $app->departments = collect($ids)
                ->map(fn($id) => $departmentsMap->get($id))
                ->filter()
                ->values();

            return $app;
        });

        return response()->json($applications);
    }

    public function storeApplications(Request $request)
    {
        $studentId = $request->student_id;

        // Update student countries
        $student = students::findOrFail($studentId);

        $student->country_id = $request->selectedCountries;
        $student->save();

        $selectedPrograms = $request->selectedPrograms;

        $groupedPrograms = collect($selectedPrograms)->groupBy('university_id');

        foreach ($groupedPrograms as $universityId => $programs) {

            $firstProgram = $programs->first();

            studentapplication::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'university_id' => $universityId,
                ],
                [
                    'country_id' => $firstProgram['country_id'],
                    'program_level_id' => $firstProgram['program_level_id'],

                    'course_name' => $programs
                        ->pluck('course')
                        ->values()
                        ->toArray(),

                    'department_id' => $programs
                        ->pluck('department_id')
                        ->values()
                        ->toArray(),
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Applications saved successfully.'
        ]);
    }

    public function getUniversityByStudent($id)
    {
        $university_ids = studentapplication::where('student_id', $id)
            ->whereNotNull('university_id')
            ->pluck('university_id')
            ->unique();

        if ($university_ids->isEmpty()) {
            return response()->json([]);
        }

        $universities = university::whereIn('id', $university_ids)
            ->select('id', 'name', 'country_id')
            ->with('country:id,name')
            ->orderBy('name')
            ->get();

        return response()->json($universities);
    }

    public function getUniversityprograms($studentId, $universityId)
    {
        $application = studentapplication::where('student_id', $studentId)
            ->where('university_id', $universityId)
            ->first();

        if (!$application) {
            return response()->json([]);
        }

        return response()->json([
            'programs' => $application->course_name ?? [],
        ]);
    }

    public function getApplications($id)
    {
        try {

            $applications = studentapplicationdetail::where('student_id', $id)
                ->with([
                    'university:id,name,country_id',
                    'university.country:id,name',
                    'application:id,course_name'
                ])
                ->get()
                ->map(function ($app) {

                    return [
                        'id' => $app->id,

                        'university_name' => $app->university
                            ? $app->university->name . ' - ' . ($app->university->country->name ?? '')
                            : '',

                        'course_names' => $app->application
                            ? ($app->application->course_name ?? [])
                            : [],

                        'uni_user_id' => $app->uni_user_id ?? '',
                        'uni_user_password' => $app->uni_user_password ?? '',
                        'uni_url' => $app->uni_url ?? '',
                        'status' => $app->status ?? '',
                    ];
                })
                ->values();

            return response()->json($applications, 200);

        } catch (\Throwable $e) {

            Log::error('Student applications fetch failed', [
                'student_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Unable to load applications',
            ], 500);
        }
    }

    public function getCredentials($studentId)
    {
        $student = students::select('secondary_email', 'secondary_password')
            ->where('id', $studentId)
            ->first();

        if (!$student) {
            return response()->json([], 404);
        }

        return response()->json([
            'secondary_email' => $student->secondary_email,
            'secondary_password' => $student->secondary_password, // reminder only
        ]);
    }

    public function gmailPassStore(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'gmail_id' => 'nullable|email',
            'gmail_password' => 'nullable|string',
        ]);
        students::where('id', $validated['student_id'])->update([
            'secondary_email' => $validated['gmail_id'],
            'secondary_password' => $validated['gmail_password'], // reminder only
        ]);
        return response()->json([
            'message' => 'Email and Password saved successfully',
        ], 201);
    }

    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'university_id' => 'required|exists:universities,id',
            'uni_user_id' => 'nullable|string|max:255',
            'uni_user_password' => 'nullable|string|max:255',
            'uni_url' => 'nullable|url',
            'status' => 'required',
        ]);

        DB::beginTransaction();

        try {

            // 2. Find student application
            $studentApplication = studentapplication::where(
                'student_id',
                $validated['student_id']
            )
                ->where(
                    'university_id',
                    $validated['university_id']
                )
                ->first();

            if (!$studentApplication) {
                DB::rollBack();

                return response()->json([
                    'message' => 'Student application for this university not found.',
                ], 404);
            }

            // 3. Prevent duplicate application details
            $exists = studentapplicationdetail::where(
                'student_application_id',
                $studentApplication->id
            )->exists();

            if ($exists) {
                DB::rollBack();

                return response()->json([
                    'message' => 'Application details for this university already exist.',
                ], 422);
            }

            // 4. Store application details
            studentapplicationdetail::create([
                'student_application_id' => $studentApplication->id,
                'student_id' => $validated['student_id'],
                'university_id' => $validated['university_id'],
                'uni_user_id' => $validated['uni_user_id'] ?? null,
                'uni_user_password' => $validated['uni_user_password'] ?? null,
                'uni_url' => $validated['uni_url'] ?? null,
                'status' => strtolower($validated['status']),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Application details saved successfully',
            ], 201);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Student Application Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $application = studentapplicationdetail::findOrFail($id);

        $application->status = $request->status;
        $application->save();

        return response()->json([
            'success' => true,
            'message' => 'Application status updated successfully.',
            'status' => $application->status,
        ]);
    }

    public function editApplication($id)
    {
        try {

            $applicationDetail = studentapplicationdetail::find($id);

            if (!$applicationDetail) {
                return response()->json([
                    'message' => 'Application not found.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $applicationDetail,
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateApplication(Request $request)
    {
        $request->validate([
            'uni_user_id' => 'nullable|string',
            'uni_user_password' => 'nullable|string',
            'uni_url' => 'nullable|string',
        ]);

        $applicationDetail = studentapplicationdetail::findOrFail($request->id);

        if (!$applicationDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Application not Found'
            ]);
        }

        $applicationDetail->uni_user_id = $request->uni_user_id;
        $applicationDetail->uni_user_password = $request->uni_user_password;
        $applicationDetail->uni_url = $request->uni_url;

        $applicationDetail->save();

        return response()->json([
            'success' => true,
            'message' => 'Application Details Updated'
        ]);

    }

    public function deleteApplication($id)
    {
        try {

            $applicationDetail = studentapplicationdetail::find($id);

            if (!$applicationDetail) {
                return response()->json([
                    'message' => 'Application not found.',
                ], 404);
            }

            $applicationDetail->delete();

            return response()->json([
                'message' => 'Application deleted successfully.',
            ], 200);

        } catch (\Throwable $e) {

            Log::error('Student application deletion failed', [
                'application_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Something went wrong while deleting application.',
            ], 500);
        }
    }
}
