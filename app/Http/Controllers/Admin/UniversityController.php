<?php

namespace App\Http\Controllers\Admin;

use App\Models\country;
use App\Models\course;
use App\Models\departments;
use App\Models\program;
use App\Models\program_level;
use App\Models\university;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

    class UniversityController extends Controller
{
    public function index()
    {
        $list = country::where('status', '=', 'active')->get();

        return view('admin.university.index', compact('list'));
    }

    public function list($id)
    {
        $countryName = country::where('id', $id)->value('name');

        $universities = university::where('universities.country_id', '=', $id)
            ->select('universities.*')
            ->get();

        return view('admin.university.list', compact('id', 'universities', 'countryName'));
    }

    public function create($id)
    {
        // Get all programs for this country from pivot table
        $programIds = country::find($id)->programLevels()->pluck('program_level_id')->toArray();
        $programs = program_level::whereIn('id', $programIds)->get();

        return view('admin.university.create', compact('id', 'programs'));
    }

    public function store(Request $request)
    {
        try {
            // ✅ Safe validation (returns JSON if fails)
            $validator = Validator::make($request->all(), [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:universities,slug',
                'meta_title' => 'required|string|max:255',
                'meta_description' => 'required|string|max:500',
                'description' => 'required|string',
                // 'state' => 'required|string',
                'city' => 'required|string',
                'website' => 'required|url',
                'programs' => 'required|array',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            DB::transaction(function () use ($request) {
                $url = null; // ✅ initialize

                if ($request->hasFile('image')) {
                    $filename = time().'-'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
                    $request->file('image')->move(public_path('uploads/university'), $filename);
                    $url = url('uploads/university/'.$filename); // ✅ dynamic URL
                }

                // ✅ Insert University
                $university = university::create([
                    'country_id' => $request->country_id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'slug' => $request->slug,
                    'meta_title' => $request->meta_title,
                    'meta_description' => $request->meta_description,
                    'meta_keywords' => $request->meta_keywords ?? null,
                    // 'state_id' => $request->state,
                    'city' => $request->city,
                    'website' => $request->website,
                    'image' => $url,
                ]);

                // ✅ Programs insert
                foreach ($request->programs as $programData) {
                    // 🚨 SAFETY CHECK
                    if (empty($programData['program_level_id'])) {
                        continue; // skip broken row
                    }
                    $program = program::create([
                        'university_id' => $university->id,
                        'program_level_id' => $programData['program_level_id'],
                    ]);

                    foreach ($programData['departments'] as $deptData) {

                        if (empty($deptData['name'])) {
                            continue;
                        }
                        $department = departments::create([
                            'program_id' => $program->id,
                            'name' => $deptData['name'],
                        ]);

                        foreach ($deptData['courses'] ?? [] as $courseData) {

                            if (empty($courseData['name'])) {
                                continue;
                            }
                            course::create([
                                'department_id' => $department->id,
                                'name' => $courseData['name'],
                            ]);
                        }
                    }
                }
            });

            return response()->json([
                'status' => 'success',
                'message' => 'University Record Stored!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        $university = university::with([
            'programs.departments.courses',
        ])->findOrFail($id);

        // states & cities
        $states = DB::table('states')
            ->where('country_id', $university->country_id)
            ->get();

        $cities = DB::table('cities')
            ->where('state_id', $university->state_id)
            ->get();

        // ✅ program levels country-wise
        $programs = program_level::whereHas('countries', function ($q) use ($university) {
            $q->where('countries.id', $university->country_id);
        })->get();

        return view(
            'admin.university.edit',
            compact('university', 'programs', 'states', 'cities')
        );
    }

    public function update(Request $request, $id)
{
    try {
        DB::transaction(function () use ($request, $id) {

            // 1️⃣ Update University basic info
            $university = university::findOrFail($id);
            $university->update([
                'country_id' => $request->country_id,
                'name' => $request->name,
                'slug' => $request->slug,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'description' => $request->description,
                // 'state_id' => $request->state,
                'city' => $request->city,
                'website' => $request->website,
            ]);

            // 2️⃣ Track existing IDs
            $programIds = [];
            $departmentIds = [];
            $courseIds = [];

            // 3️⃣ Programs update/create
            if ($request->has('programs')) {
                foreach ($request->programs as $programData) {

                    if (empty($programData['program_level_id'])) continue;

                    // Check if program already exists (update) or create new
                    if (isset($programData['id'])) {
                        $program = program::find($programData['id']);
                        $program->update([
                            'program_level_id' => $programData['program_level_id'],
                        ]);
                    } else {
                        $program = program::create([
                            'university_id' => $university->id,
                            'program_level_id' => $programData['program_level_id'],
                        ]);
                    }
                    $programIds[] = $program->id;

                    // Departments
                    foreach ($programData['departments'] ?? [] as $deptData) {
                        if (empty($deptData['name'])) continue;

                        if (isset($deptData['id'])) {
                            $department = departments::find($deptData['id']);
                            $department->update([
                                'name' => $deptData['name'],
                            ]);
                        } else {
                            $department = departments::create([
                                'program_id' => $program->id,
                                'name' => $deptData['name'],
                            ]);
                        }
                        $departmentIds[] = $department->id;

                        // Courses
                        foreach ($deptData['courses'] ?? [] as $courseData) {
                            if (empty($courseData['name'])) continue;

                            if (isset($courseData['id'])) {
                                $course = course::find($courseData['id']);
                                $course->update([
                                    'name' => $courseData['name'],
                                ]);
                            } else {
                                $course = course::create([
                                    'department_id' => $department->id,
                                    'name' => $courseData['name'],
                                ]);
                            }
                            $courseIds[] = $course->id;
                        }
                    }
                }
            }

            // 4️⃣ Cleanup deleted records
            program::where('university_id', $university->id)
                ->whereNotIn('id', $programIds)
                ->delete();

            departments::whereIn('program_id', $programIds)
                ->whereNotIn('id', $departmentIds)
                ->delete();

            course::whereIn('department_id', $departmentIds)
                ->whereNotIn('id', $courseIds)
                ->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'University updated successfully!',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}

}
