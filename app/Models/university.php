<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class university extends Model
{
    use HasFactory;

    protected $table = "universities";

    protected $fillable = ['country_id', 'name', 'description', 'location', 'website','slug', 'meta_title', 'meta_description', 'meta_keywords', 'country', 'state', 'city', 'image'];

    public function country()
    {
        return $this->belongsTo(country::class);
    }

    public function programs()
    {
        return $this->hasMany(program::class);
    }
}
