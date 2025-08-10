<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'train_id',
        'route_id',
        'booking_reference',
        'passenger_name',
        'passenger_email',
        'passenger_phone',
        'passenger_nid',
        'travel_date',
        'seat_class',
        'total_amount',
        'payment_status',
        'booking_status',
        'special_requests',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    
    // Generate unique booking reference
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            $booking->booking_reference = self::generateBookingReference();
        });
    }

    private static function generateBookingReference()
    {
        $prefix = 'BR';
        $timestamp = now()->format('ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return $prefix . $timestamp . $random;
    }
}
