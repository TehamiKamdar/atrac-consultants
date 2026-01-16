<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departments extends Model
{
    use HasFactory;

    protected $fillable = ['program_id', 'name', 'description'];

    public function program()
    {
        return $this->belongsTo(program::class, 'program_id');
    }

    public function courses()
    {
        return $this->hasMany(course::class, 'department_id');
    }
}
