<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostFaq extends Model
{
    use HasFactory;
    protected $table = 'post_faqs';
    protected $fillable = [
        'post_id',
        'name',
        'email',
        'question',
        'answer'
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
