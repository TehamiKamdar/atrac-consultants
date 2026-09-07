<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentapplication extends Model
{
    use HasFactory;

    protected $table = "student_applications";

    protected $fillable = ['student_id', 'country_id', 'university_id', 'program_level_id', 'course_name', 'department_id'];

    public function student(){
        return $this->belongsTo(students::class);
    }

    public function university(){
        return $this->belongsTo(university::class);
    }

    public function country(){
        return $this->belongsTo(country::class);
    }

    public function program_level(){
        return $this->belongsTo(program_level::class);
    }

    public function department(){
        return $this->belongsTo(departments::class);
    }
}
