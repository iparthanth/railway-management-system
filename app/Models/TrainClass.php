<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id',
        'class_name',
        'base_fare',
        'total_seats',
    ];

    protected $casts = [
        'base_fare' => 'decimal:2',
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function getAvailableSeats($date)
    {
        $bookedSeats = Booking::where('train_id', $this->train_id)
            ->where('class_name', $this->class_name)
            ->where('journey_date', $date)
            ->where('status', 'confirmed')
            ->count();

        return $this->total_seats - $bookedSeats;
    }
}
