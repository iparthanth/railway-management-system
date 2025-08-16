<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id',
        'from_station_id',
        'to_station_id',
        'departure_time',
        'arrival_time',
        'duration_minutes',
        'distance_km',
        'base_price',
        'is_active'
    ];

    protected $casts = [
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
        'is_active' => 'boolean',
        'base_price' => 'decimal:2'
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function fromStation()
    {
        return $this->belongsTo(Station::class, 'from_station_id');
    }

    public function toStation()
    {
        return $this->belongsTo(Station::class, 'to_station_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
