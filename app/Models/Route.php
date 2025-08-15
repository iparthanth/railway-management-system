<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_station_id',
        'to_station_id',
        'distance_km',
        'base_fare',
        'is_active',
    ];

    protected $casts = [
        'base_fare' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function fromStation()
    {
        return $this->belongsTo(Station::class, 'from_station_id');
    }

    public function toStation()
    {
        return $this->belongsTo(Station::class, 'to_station_id');
    }

    public function trains()
    {
        return $this->belongsToMany(Train::class, 'train_routes');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByStations($query, $fromStationName, $toStationName)
    {
        return $query->whereHas('fromStation', function($q) use ($fromStationName) {
            $q->where('name', $fromStationName);
        })->whereHas('toStation', function($q) use ($toStationName) {
            $q->where('name', $toStationName);
        });
    }

    // Helper methods
    public function getRouteNameAttribute()
    {
        return $this->fromStation->name . ' → ' . $this->toStation->name;
    }

    public function getDistanceTextAttribute()
    {
        return $this->distance_km . ' km';
    }

    public static function findByStations($fromStation, $toStation)
    {
        return static::byStations($fromStation, $toStation)->first();
    }
}