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
        'total_coaches',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function coaches()
    {
        return $this->hasMany(Coach::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function seats()
    {
        return $this->hasManyThrough(Seat::class, Coach::class);
    }
}
