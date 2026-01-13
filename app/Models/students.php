<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = ['first_name','last_name','father_name','mother_name','dob','gender','email','phone','city','address','postal_code','cnic','passport_number','passport_valid_from','passport_valid_thru','applying_for','account_created','status'];
}
