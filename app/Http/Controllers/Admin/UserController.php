<?php

namespace App\Http\Controllers\Admin;

use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        $offices = Office::where('status', '1')->get();
        return view('admin.users.index', compact('users', 'offices'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'username' => 'required|string',
            'city' => 'required|string',
        ]);
    }
}
