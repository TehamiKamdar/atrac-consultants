<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'state_id',
        'city_id',
        'phone',
        'address',
        'map_location',
        'status',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function country()
    {
        return $this->belongsTo(country::class);
    }

    public function state()
    {
        return $this->belongsTo(state::class);
    }

    public function city()
    {
        return $this->belongsTo(city::class);
    }
}
