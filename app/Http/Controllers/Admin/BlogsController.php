<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\blog;
use App\Models\category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Post::all();
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'blog_content' => 'required|string',
            'featured_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'keywords' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
        ]);

        $post = new Post();

        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->excerpt = $request->excerpt;
        $post->content = $request->blog_content;
        $post->user_id = auth()->id(); // Assuming the user is authenticated and you want to associate the post with the logged-in user

        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->keywords;

        $post->is_published = $request->status === 'published' ? 1 : 0;

        if ($post->is_published) {
            $post->published_at = now();
        }

        if ($request->hasFile('featured_image')) {
            $post->featured_image = $request->file('featured_image')->store('posts', 'public');
        }

        $post->save();

        return redirect()
            ->back()
            ->with('success', 'Post created successfully.');
    }

    public function publish($id)
    {
        $blog = Post::findOrFail($id);
        $blog->is_published = 1;
        $blog->published_at = now();
        $blog->save();

        return redirect()->back()->with('success', 'Blog published successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.blogs.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:1000',
            'blog_content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'keywords' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
        ]);

        $post->title = $request->input('title');
        $post->slug = Str::slug($request->input('title'));
        $post->excerpt = $request->input('excerpt');
        $post->content = $request->input('blog_content');
        $post->meta_keywords = $request->input('keywords');
        $post->meta_title = $request->input('meta_title');
        $post->meta_description = $request->input('meta_description');

        $post->is_published = $request->input('status') === 'published';

        if ($post->is_published && !$post->published_at) {
            $post->published_at = now();
        }

        if ($request->hasFile('featured_image')) {
            $post->featured_image = $request
                ->file('featured_image')
                ->store('posts', 'public');
        }

        $post->save();

        return redirect()
            ->route('admin-blogs-index')
            ->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
