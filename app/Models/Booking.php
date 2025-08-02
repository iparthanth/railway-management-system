<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'pnr',
        'user_id',
        'train_id',
        'from_station_id',
        'to_station_id',
        'journey_date',
        'class_name',
        'selected_seats',
        'passengers',
        'contact_mobile',
        'contact_email',
        'ticket_fare',
        'vat',
        'service_charge',
        'total_amount',
        'status',
        'boarding_station',
        'booking_expires_at',
    ];

    protected $casts = [
        'journey_date' => 'date',
        'selected_seats' => 'array',
        'passengers' => 'array',
        'ticket_fare' => 'decimal:2',
        'vat' => 'decimal:2',
        'service_charge' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'booking_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function fromStation()
    {
        return $this->belongsTo(Station::class, 'from_station_id');
    }

    public function toStation()
    {
        return $this->belongsTo(Station::class, 'to_station_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getSelectedSeatsDetails()
    {
        if (!$this->selected_seats) return collect();
        
        return Seat::whereIn('id', $this->selected_seats)->get();
    }

    public static function generatePNR()
    {
        do {
            $pnr = 'BD' . str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (self::where('pnr', $pnr)->exists());

        return $pnr;
    }

    public function isExpired()
    {
        return $this->booking_expires_at && $this->booking_expires_at < now();
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }
}
