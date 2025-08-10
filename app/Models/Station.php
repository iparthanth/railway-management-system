<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'city',
        'state',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'is_active' => 'boolean',
    ];

    public function departureRoutes()
    {
        return $this->hasMany(Route::class, 'departure_station_id');
    }

    public function arrivalRoutes()
    {
        return $this->hasMany(Route::class, 'arrival_station_id');
    }
}
