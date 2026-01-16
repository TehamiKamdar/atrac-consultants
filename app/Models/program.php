<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class program extends Model
{
    use HasFactory;
    protected $table = "programs";

    protected $fillable = ['university_id', 'program_level_id'];

    public function university() {
        return $this->belongsTo(university::class, 'university_id');
    }

    public function level() {
        return $this->belongsTo(program_level::class, 'program_level_id');
    }

    public function departments() {
        return $this->hasMany(related: departments::class);
    }
}

