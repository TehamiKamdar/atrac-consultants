<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class programs extends Model
{
    use HasFactory;

    protected $fillable = ['university_id', 'name', 'duration', 'description'];

    public function university() {
        return $this->belongsTo(universities::class);
    }

    public function level() {
        return $this->belongsTo(program_levels::class, 'program_level_id');
    }

    public function departments() {
        return $this->hasMany(departments::class);
    }
}

