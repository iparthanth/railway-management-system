<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Train extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_number',
        'name',
        'type',
        'total_seats',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
