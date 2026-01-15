<?php

namespace App\Http\Controllers;

use App\Models\country;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){
        $activeCountries = country::where('status', 'active')->orderBy('name', 'ASC')->get();
        return view('pages.register', compact('activeCountries'));
    }
}
