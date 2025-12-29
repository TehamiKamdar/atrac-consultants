<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countrydetails extends Model
{
    protected $table = 'countrydetails';

    protected $fillable = [
        'meta_title',
        'meta_description',
        'image',
        'country_description',
        'cost_of_living',
        'climate',
        'admission_requirements',
        'language',
        'visa_requirements',
        'scholarships',
        'workOpp'
    ];

    protected $casts = [
        'admission_requirements' => 'array',
        'visa_requirements'      => 'array',
    ];
}
