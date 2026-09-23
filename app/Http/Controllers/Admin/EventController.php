<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index(){
        return Event::where('user_id', auth()->id())->get();
    }
    public function calendar(){
        return view('admin.events.index');
    }
}
