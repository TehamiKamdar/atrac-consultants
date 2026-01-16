<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country_programs extends Model
{
    use HasFactory;
    protected $table = 'country_programs';

    protected $fillable = [
        'country_id',
        'program_level_id'
    ];

    public function country()
    {
        return $this->belongsTo(country::class);
    }

    public function programLevel()
    {
        return $this->belongsTo(program_levels::class);
    }
}
