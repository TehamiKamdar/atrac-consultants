<?php

namespace App\Http\Controllers;

use App\Models\contacts;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showContactForm(){
        return view('web.contact');
    }
    public function contact(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|min:3|max:150',
            'message' => 'required|string|min:5|max:1000',
        ]);

        contacts::create($validated);

        return redirect()->back()->with('success', 'Thanks for contacting us. We\'ll get back to you ASAP.');
    }
}
