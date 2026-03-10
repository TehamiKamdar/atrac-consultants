<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'featured_image', 'thumbnail', 'image_alt', 'user_id', 'published_at', 'is_published','meta_title', 'meta_description', 'meta_keywords'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    // Relations
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function faqs(){
        return $this->hasMany(PostFaq::class);
    }

    // SEO ke liye helpful accessors (blade mein easy use)
    public function getMetaTitleAttribute($value)
    {
        return $value ?? $this->title;
    }

    public function getUrlAttribute()
    {
        return url('/blog/' . $this->slug);   // ya route('blog.show', $this)
    }
}
