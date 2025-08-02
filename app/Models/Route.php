<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id',
        'station_id',
        'sequence',
        'arrival_time',
        'departure_time',
        'halt_duration',
        'distance_from_origin',
    ];

    protected $casts = [
        'arrival_time' => 'datetime:H:i',
        'departure_time' => 'datetime:H:i',
        'distance_from_origin' => 'decimal:2',
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
