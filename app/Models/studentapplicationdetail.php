<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentapplicationdetail extends Model
{
    use HasFactory;

    protected $table = 'student_application_details';

    protected $fillable = [
        'student_id',
        'university_id',
        'campus',
        'uni_user_id',
        'uni_user_password',
        'uni_url',
        'status',
    ];

    protected $casts = [
        'uni_user_password' => 'encrypted', // Laravel 10+ encryption
    ];

    public function student()
    {
        return $this->belongsTo(students::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
