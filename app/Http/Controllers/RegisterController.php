<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\university;
use App\Models\departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index(){
        $activeCountries = country::where('status', 'active')->orderBy('name', 'ASC')->get();
        return view('pages.register', compact('activeCountries'));
    }

    public function getCountryPrograms($country_id){
        $programs = DB::table('country_programs')
            ->join('program_levels', 'program_levels.id', '=', 'country_programs.program_level_id')
            ->where('country_programs.country_id', $country_id)
            ->select('program_levels.id', 'program_levels.name')
            ->get();

        return response()->json($programs);
    }

    public function departments(Request $request){
        return departments::select('departments.id', 'departments.name')
            ->join('programs', 'programs.id', '=', 'departments.program_id')
            ->join('universities', 'universities.id', '=', 'programs.university_id')
            ->where('universities.country_id', $request->country_id)
            ->where('programs.program_level_id', $request->program_level_id)
            ->distinct()
            ->get();
    }

    public function universities(Request $request){
        return university::select('universities.id', 'universities.name')
            ->join('programs', 'programs.university_id', '=', 'universities.id')
            ->join('departments', 'departments.program_id', '=', 'programs.id')
            ->where('departments.id', $request->department_id)
            ->where('programs.program_level_id', $request->program_level_id)
            ->where('universities.country_id', $request->country_id)
            ->distinct()
            ->get();
    }
}
