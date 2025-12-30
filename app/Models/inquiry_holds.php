<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inquiry_holds extends Model
{
    protected $table = 'inquiry_holds';

    protected $fillable = ['consult_id', 'reason', 'revisit_date'];
}
