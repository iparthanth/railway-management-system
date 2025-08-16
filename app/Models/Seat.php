<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'seat_number',
        'row_number',
        'position',
        'is_window',
        'is_available'
    ];

    protected $casts = [
        'is_window' => 'boolean',
        'is_available' => 'boolean'
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_seats');
    }
}
