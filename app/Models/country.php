<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = ['country_name', 'slug'];

    public function programLevels()
    {
        return $this->belongsToMany(program_level::class, 'country_programs', 'country_id', 'program_level_id');
    }
}
