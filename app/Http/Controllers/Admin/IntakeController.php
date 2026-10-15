<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intake;
use Illuminate\Http\Request;

class IntakeController extends Controller
{
    public function index(){
        $intakes = Intake::all();
        return view('admin.intakes.index', compact('intakes'));
    }

    public function status(Request $request){
        $intake = Intake::findOrFail($request->id);
        $intake->is_active = $request->status;
        $intake->save();

        return response()->json([
            'success' => true,
            'message' => 'Intake Status Updated'
        ]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'is_active' => 'required|string',
        ]);

        Intake::create($data);

        return response()->json([
            'success' => true,
            'message' => 'New Intake Added'
        ]);
    }
}
