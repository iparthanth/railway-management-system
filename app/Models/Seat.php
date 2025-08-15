<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id',
        'seat_number',
        'journey_date',
        'status',
    ];

    protected $casts = [
        'journey_date' => 'date',
    ];

    // Relationships
    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeBooked($query)
    {
        return $query->where('status', 'booked');
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('journey_date', $date);
    }

    public function scopeForTrain($query, $trainId)
    {
        return $query->where('train_id', $trainId);
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function isBooked()
    {
        return $this->status === 'booked';
    }

    public function book()
    {
        $this->update(['status' => 'booked']);
    }

    public function release()
    {
        $this->update(['status' => 'available']);
    }

    // Generate standard seat layout (A1-A4, B1-B4, C1-C4, D1-D4)
    public static function generateSeatLayout()
    {
        $seats = [];
        $rows = ['A', 'B', 'C', 'D'];
        
        foreach ($rows as $row) {
            for ($col = 1; $col <= 4; $col++) {
                $seats[] = $row . $col;
            }
        }
        
        return $seats;
    }
}
