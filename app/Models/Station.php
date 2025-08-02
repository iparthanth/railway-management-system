<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'division',
        'latitude',
        'longitude',
        'is_active',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function fromBookings()
    {
        return $this->hasMany(Booking::class, 'from_station_id');
    }

    public function toBookings()
    {
        return $this->hasMany(Booking::class, 'to_station_id');
    }
}
