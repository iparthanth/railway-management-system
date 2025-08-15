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
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function fromRoutes()
    {
        return $this->hasMany(Route::class, 'from_station_id');
    }

    public function toRoutes()
    {
        return $this->hasMany(Route::class, 'to_station_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public static function getActiveStations()
    {
        return static::active()->orderBy('name')->pluck('name', 'id');
    }

    public static function getStationNames()
    {
        return static::active()->orderBy('name')->pluck('name')->toArray();
    }
}