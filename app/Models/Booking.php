<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'pnr',
        'passenger_name',
        'passenger_email',
        'passenger_phone',
        'train_id',
        'route_id',
        'journey_date',
        'selected_seats',
        'total_fare',
        'payment_method',
        'transaction_id',
        'stripe_payment_intent_id',
        'payment_status',
        'user_id',
        'booking_status'
    ];

    protected $casts = [
        'journey_date' => 'date',
        'selected_seats' => 'array',
        'total_fare' => 'decimal:2',
    ];

    protected $attributes = [
        'payment_status' => 'pending',
        'payment_method' => 'stripe',
        'booking_status' => 'confirmed'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function train(): BelongsTo
    {
        return $this->belongsTo(Train::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // Accessors & Mutators
    public function getContactEmailAttribute()
    {
        return $this->passenger_email ?? $this->user?->email;
    }

    public function getContactPhoneAttribute()
    {
        return $this->passenger_phone ?? $this->user?->mobile;
    }

    public function getRouteNameAttribute()
    {
        return $this->route->route_name ?? 'N/A';
    }

    public function getSeatCountAttribute()
    {
        return count($this->selected_seats ?? []);
    }

    public function getSeatListAttribute()
    {
        return implode(', ', $this->selected_seats ?? []);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('booking_status', $status);
    }

    public function scopeByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('journey_date', $date);
    }

    public function scopeByPnr($query, $pnr)
    {
        return $query->where('pnr', $pnr);
    }

    // Methods
    public function isGuest()
    {
        return is_null($this->user_id);
    }

    public function canCancel()
    {
        return $this->booking_status === 'confirmed' && 
               $this->payment_status === 'succeeded' &&
               $this->journey_date->isAfter(now()->addHours(2));
    }

    public function cancel()
    {
        if ($this->canCancel()) {
            $this->update(['booking_status' => 'cancelled']);
            
            // Release seats
            Seat::where('train_id', $this->train_id)
                ->where('journey_date', $this->journey_date)
                ->whereIn('seat_number', $this->selected_seats)
                ->update(['status' => 'available']);
                
            return true;
        }
        return false;
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            // Generate PNR if not provided
            if (empty($booking->pnr)) {
                $booking->pnr = static::generatePnr();
            }
        });

        static::created(function ($booking) {
            // Book the selected seats
            Seat::where('train_id', $booking->train_id)
                ->where('journey_date', $booking->journey_date)
                ->whereIn('seat_number', $booking->selected_seats)
                ->update(['status' => 'booked']);
        });
    }

    // Generate unique PNR
    public static function generatePnr()
    {
        do {
            $pnr = 'PNR' . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
        } while (static::where('pnr', $pnr)->exists());
        
        return $pnr;
    }
}
