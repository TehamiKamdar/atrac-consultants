<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostFaq;
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
        $keywords = explode(' ', $details->title);
        $relatedPosts = Post::where('id', '!=', $details->id)
                        ->where(function($q) use ($keywords){
                            foreach($keywords as $word){
                                $q->orWhere('title', 'LIKE', '%'.$word.'%');
                            }
                        })->take(4)->get();



        return view('web.blog_details', compact('details', 'relatedPosts'));
    }
    public function question(Request $request){
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'name' => 'required|string|min:1',
            'email' => 'required|email|min:1',
            'question' => 'required|string|min:1',
        ]);

        $bannedWords = config('bannedwords');
        if(containsBannedWords($validated, $bannedWords)){
            return response()->json([
                'success' => false,
                'message' => "Your question contains inappropriate words"
            ], 422);
        }

        PostFaq::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Question Submitted'
        ]);
    }
}
