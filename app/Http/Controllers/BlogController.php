<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Post::where('is_published', '1')->get();
        return view('web.blog', compact('blogs'));
    }
    public function show($slug)
    {
        $details = Post::where('slug', $slug)->first();
        return view('web.blog_details', compact('details'));
    }
}
