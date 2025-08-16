<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'train_id',
        'route_id',
        'coach_id',
        'journey_date',
        'passenger_name',
        'passenger_email',
        'passenger_phone',
        'passenger_count',
        'total_amount',
        'booking_status',
        'payment_status'
    ];

    protected $casts = [
        'journey_date' => 'date',
        'total_amount' => 'decimal:2'
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'booking_seats');
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }
}
