<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class universities extends Model
{
    use HasFactory;

    protected $fillable = ['country_id', 'name', 'description', 'location', 'website','slug', 'meta_title', 'meta_description', 'meta_keywords', 'country', 'state', 'city', 'image'];

    public function country()
    {
        return $this->belongsTo(country::class, 'country_id');
    }

    public function programs()
    {
        return $this->hasMany(programs::class, 'university_id');
    }
}
