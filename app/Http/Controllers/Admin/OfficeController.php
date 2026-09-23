<?php

namespace App\Http\Controllers\Admin;

use App\Models\country;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfficeController extends Controller
{
    public function index(){
        $offices = Office::all();
        $countries = country::all();
        return view('admin.offices.index', compact('offices', 'countries'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'phone' => 'required|string|min:1',
            'address' => 'required|string|min:1',
            'map_location' => 'required|string|min:1',
        ]);

        Office::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Office Location Added'
        ]);
    }

    public function status(Request $request){
        $office = Office::findOrFail($request->id);
        $office->status = $request->status;
        $office->save();

        return response()->json([
            'success' => true,
            'message' => 'Office Status Updated'
        ]);
    }

    public function destroy(Request $request){
        $id = $request->id;
        Office::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Office Location Deleted'
        ]);
    }

    public function edit(Request $request){
        $id = $request->id;
        $data = Office::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function update(Request $request){
        $data = $request->validate([
            'id' => 'required|exists:offices,id',
            'phone' => 'required|string|min:1',
            'address' => 'required|string|min:1',
            'map_location' => 'required|string|min:1',
        ]);

        $office = Office::findOrFail($data['id']);

        $office->update([
            'phone' => $data['phone'],
            'address' => $data['address'],
            'map_location' => $data['map_location'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Office Location Updated'
        ]);
    }
}
