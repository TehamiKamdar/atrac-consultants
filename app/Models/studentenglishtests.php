<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentenglishtests extends Model
{
    use HasFactory;

    protected $table = "student_english_tests";

    protected $fillable = ['student_id','test_name','listening','reading','speaking','writing','score','test_date'];

    public function student(){
        return $this->belongsTo(students::class);
    }
}
