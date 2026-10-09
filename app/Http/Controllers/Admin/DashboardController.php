<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\consults;
use App\Models\PageVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = PageVisit::query();
        // if ($request->filled('from')) {
        //     $query->whereDate('visited_at', '>=', $request->from);
        // }
        // if ($request->filled('to')) {
        //     $query->whereDate('visited_at', '<=', $request->to);
        // }

        $totalViews = (clone $query)->count();
        $uniqueVisitors = (clone $query)->distinct('visitor_id')->count('visitor_id');

        // Traffic sources ke hisaab se counts
        $sources = PageVisit::selectRaw('source, COUNT(*) as total')
            ->groupBy('source')
            ->orderByDesc('total')
            ->get();

        // Device types ke hisaab se counts
        $devices = PageVisit::selectRaw('device_type, COUNT(*) as total')
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->get();

        // Countries ke hisaab se counts
        $countries = PageVisit::selectRaw(
            'country, country_code, COUNT(*) as total'
        )
            ->groupBy('country', 'country_code')
            ->orderByDesc('total')
            ->get();


        return view('admin.index', compact(
            'totalViews',
            'uniqueVisitors',
            'sources',
            'devices',
            'countries'
        ));
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
