<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainStatus extends Model
{
    use HasFactory;

    protected $table = 'trainstatus';

    protected $fillable = [
        'train_id',
        'date',
        'current_station',
        'status',
        'last_updated',
    ];

    protected $casts = [
        'date' => 'date',
        'last_updated' => 'datetime',
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function scopeDelayed($query)
    {
        return $query->where('delay_minutes', '>', 0);
    }

    public function scopeOnTime($query)
    {
        return $query->where('delay_minutes', '<=', 0);
    }

    public function getStatusColorAttribute()
    {
        return match($this->current_status) {
            'on_time' => 'green',
            'delayed' => 'orange',
            'cancelled' => 'red',
            'departed' => 'blue',
            default => 'gray'
        };
    }
}
