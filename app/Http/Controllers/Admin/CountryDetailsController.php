<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\country;
use Illuminate\Http\Request;
use App\Models\countrydetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CountryDetailsController extends Controller
{
    public function index()
    {


        $details = country::leftJoin('countrydetails', 'countries.id', '=', 'countrydetails.country_id')
            ->where('status', 'active')
            ->select(
                'countrydetails.*',
                'countries.id AS country_id',
                'countries.*'
            )
            ->get();

        // return $details;
        return view('admin.details.index', compact('details'));
    }

    public function edit($id)
    {


        $detail = country::where('countries.id', '=', $id)
            ->leftJoin('countrydetails', 'countries.id', '=', 'countrydetails.country_id')
            ->select(
                'countries.*',
                'countrydetails.*',
                'countries.name AS name',
                'countries.id as country_id'
            )
            ->first();

        if ($detail) {
            $detail->admission_requirements = !empty($detail->admission_requirements)
                ? json_decode($detail->admission_requirements, true)
                : [];

            $detail->visa_requirements = !empty($detail->visa_requirements)
                ? json_decode($detail->visa_requirements, true)
                : [];
        }

        return view('admin.details.edit', compact('detail'));
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
                'country_description' => 'nullable|string',
                'cost_of_living' => 'nullable|string',
                'climate' => 'nullable|string',
                'language' => 'nullable|string',
                'scholarships' => 'nullable|string',
                'workOpp' => 'nullable|string',
                'admission_requirements'   => 'nullable|array',
                'admission_requirements.*' => 'nullable|string|max:255',
                'visa_requirements'        => 'nullable|array',
                'visa_requirements.*'      => 'nullable|string|max:255',
            ]);

            countrydetails::updateOrCreate(
                ['country_id' => $request->_id],
                $validated
            );

            return response()->json(['success' => 'Details Updated!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
