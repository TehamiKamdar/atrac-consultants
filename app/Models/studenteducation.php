<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class studenteducation extends Model
{
    use HasFactory;

    protected $table = 'student_educations';

    protected $fillable = ['student_id','level','institute','board','subject','passing_year','obtained_marks','total_marks','grade_or_cgpa'];

    public function student(){
        return $this->belongsTo(students::class);
    }
}
