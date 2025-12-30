<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'name', 'code', 'credits'];

    public function department()
    {
        return $this->belongsTo(departments::class, 'department_id');
    }
}
