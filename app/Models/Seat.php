<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id',
        'class_name',
        'coach_name',
        'seat_number',
        'full_seat_number',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function seatLocks()
    {
        return $this->hasMany(SeatLock::class);
    }

    public function isLockedForDate($date, $excludeSession = null)
    {
        $query = $this->seatLocks()
            ->where('journey_date', $date)
            ->where('locked_until', '>', now());
            
        if ($excludeSession) {
            $query->where('session_id', '!=', $excludeSession);
        }
        
        return $query->exists();
    }

    public function isBookedForDate($date)
    {
        return Booking::whereJsonContains('selected_seats', $this->id)
            ->where('journey_date', $date)
            ->whereIn('status', ['confirmed', 'pending'])
            ->exists();
    }

    public function isAvailableForDate($date, $excludeSession = null)
    {
        return $this->is_available && 
               !$this->isLockedForDate($date, $excludeSession) && 
               !$this->isBookedForDate($date);
    }
}
