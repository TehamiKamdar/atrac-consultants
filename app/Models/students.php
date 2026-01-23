<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class students extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = ['first_name','last_name','father_name','mother_name','dob','email','phone','city','address','postal_code','cnic','english_test','english_proficiency','passport_number','passport_valid_from','passport_valid_thru','account_created','status','country_id','program_level_id','intake','qualification','percentage','secondary_email','secondary_password'];

    public function educations(){
        return $this->hasMany(studenteducation::class);
    }

    public function documents(){
        return $this->hasMany(studentdocument::class);
    }

    public function applications(){
        return $this->hasMany(studentapplication::class);
    }

    public function english_tests(){
        return $this->hasMany(studentenglishtests::class);
    }
}
