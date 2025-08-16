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
        'city',
        'state',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function departureRoutes()
    {
        return $this->hasMany(Route::class, 'from_station_id');
    }

    public function arrivalRoutes()
    {
        return $this->hasMany(Route::class, 'to_station_id');
    }

    public function trains()
    {
        return $this->belongsToMany(Train::class, 'routes', 'from_station_id', 'train_id')
                    ->orWhere('routes.to_station_id', $this->id);
    }
}
