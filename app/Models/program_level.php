<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class program_level extends Model
{
    use HasFactory;
    protected $table = "program_levels";
    protected $fillable = ['name'];

    public function countries()
    {
        return $this->belongsToMany(
            country::class,
            'country_programs'
        );
    }

    public function programs()
    {
        return $this->hasMany(program::class);
    }
}
