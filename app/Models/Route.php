<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id',
        'departure_station_id',
        'arrival_station_id',
        'departure_time',
        'arrival_time',
        'distance_km',
        'duration_minutes',
        'is_active',
    ];

    protected $casts = [
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
        'distance_km' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function departureStation()
    {
        return $this->belongsTo(Station::class, 'departure_station_id');
    }

    public function arrivalStation()
    {
        return $this->belongsTo(Station::class, 'arrival_station_id');
    }
}
