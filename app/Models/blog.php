<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blog extends Model
{
    use HasFactory;
    protected $table = "blogs";
    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'keywords',
        'status',
        'published_at',
        'views',
    ];

    /**
     * Categories relation
     */
    public function categories()
    {
        return $this->belongsToMany(category::class, 'blog_category');
    }
}
