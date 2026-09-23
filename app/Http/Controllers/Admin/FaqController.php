<?php

namespace App\Http\Controllers\Admin;

use App\Models\faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index(){
        $faqs = faq::all();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create(){
        return view('admin.faq.form');
    }

    public function store(Request $request){
        faq::create([
            "question" => $request->question,
            "answer" => $request->answer,
        ]);
        return response()->json([
            "success" => true,
            "message" => "Faq Added",
        ]);
    }

    public function destroy($id){
        faq::find($id)->delete();
        return response()->json([
            "success" => true,
            "message" => "Faq Deleted"
        ]);
    }
}
