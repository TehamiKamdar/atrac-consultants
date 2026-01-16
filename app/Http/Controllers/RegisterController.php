<?php

namespace App\Http\Controllers;

use App\Models\country;
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
}
