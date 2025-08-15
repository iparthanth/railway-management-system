<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'train_number',
        'departure_time',
        'arrival_time',
        'duration',
        'total_seats',
        'is_active',
    ];

    protected $casts = [
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function routes()
    {
        return $this->belongsToMany(Route::class, 'train_routes');
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
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

    public function scopeByRoute($query, $fromStation, $toStation)
    {
        return $query->whereHas('routes', function($q) use ($fromStation, $toStation) {
            $q->byStations($fromStation, $toStation);
        });
    }

    // Helper methods
    public function getFormattedDepartureTimeAttribute()
    {
        return $this->departure_time->format('H:i');
    }

    public function getFormattedArrivalTimeAttribute()
    {
        return $this->arrival_time->format('H:i');
    }

    public function getAvailableSeats($date)
    {
        return $this->seats()
            ->where('journey_date', $date)
            ->where('status', 'available')
            ->count();
    }

    public function getSeatMap($date)
    {
        return $this->seats()
            ->where('journey_date', $date)
            ->orderBy('seat_number')
            ->get()
            ->keyBy('seat_number');
    }

    public function getRouteForStations($fromStation, $toStation)
    {
        return $this->routes()->byStations($fromStation, $toStation)->first();
    }
}