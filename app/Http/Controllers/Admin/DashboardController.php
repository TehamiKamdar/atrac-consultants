<?php

namespace App\Http\Controllers\Admin;

use App\Models\consults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function getStates($country_id)
    {
        return response()->json(DB::table('states')->where('country_id', $country_id)->get());
    }

    public function getCities($state_id)
    {
        return response()->json(DB::table('cities')->where('state_id', $state_id)->get());
    }
}
