<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class studenteducation extends Model
{
    use HasFactory;

    protected $table = 'student_educations';

    protected $fillable = ['level','institute','board','passing_year','grade_or_cgpa'];

    public function student(){
        return $this->belongsTo(students::class);
    }
}
