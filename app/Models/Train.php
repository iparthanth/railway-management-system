<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'type',
        'available_classes',
        'running_days',
        'is_active',
    ];

    protected $casts = [
        'available_classes' => 'array',
        'running_days' => 'array',
        'is_active' => 'boolean',
    ];

    public function routes()
    {
        return $this->hasMany(Route::class)->orderBy('sequence');
    }

    public function trainClasses()
    {
        return $this->hasMany(TrainClass::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function runsOnDay($day)
    {
        return in_array(strtolower($day), $this->running_days ?? []);
    }

    public function getRouteStations()
    {
        return $this->routes()->with('station')->get();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
