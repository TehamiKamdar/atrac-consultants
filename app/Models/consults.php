<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class consults extends Model
{
    protected $table = 'consults';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'qualification',
        'country_id',
        'field',
        'percentage',
        'office_location',
        'status',
        'date',
        'time',
        'reason'
    ];
}
