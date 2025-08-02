<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatLock extends Model
{
    use HasFactory;

    protected $fillable = [
        'seat_id',
        'user_id',
        'journey_date',
        'locked_until',
        'session_id',
    ];

    protected $casts = [
        'journey_date' => 'date',
        'locked_until' => 'datetime',
    ];

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {
        return $this->locked_until < now();
    }

    public static function lockSeats($seatIds, $userId, $journeyDate, $sessionId, $minutes = 15)
    {
        $lockedUntil = now()->addMinutes($minutes);
        
        foreach ($seatIds as $seatId) {
            self::updateOrCreate(
                [
                    'seat_id' => $seatId,
                    'journey_date' => $journeyDate,
                ],
                [
                    'user_id' => $userId,
                    'locked_until' => $lockedUntil,
                    'session_id' => $sessionId,
                ]
            );
        }
    }

    public static function releaseExpiredLocks()
    {
        self::where('locked_until', '<', now())->delete();
    }
}
