<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'transaction_id',
        'payment_method',
        'amount',
        'status',
        'gateway_response',
        'gateway_transaction_id',
        'paid_at',
        'failure_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public static function generateTransactionId()
    {
        do {
            $transactionId = 'TXN' . time() . random_int(1000, 9999);
        } while (self::where('transaction_id', $transactionId)->exists());

        return $transactionId;
    }

    public function isSuccessful()
    {
        return $this->status === 'completed';
    }

    public function isFailed()
    {
        return in_array($this->status, ['failed', 'cancelled']);
    }
}
