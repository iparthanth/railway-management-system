<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_method',
        'transaction_id',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'amount',
        'currency',
        'payment_status',
        'payment_date',
        'gateway_response',
        'failure_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'gateway_response' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('payment_status', 'completed');
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeStripePayments($query)
    {
        return $query->where('payment_method', 'stripe');
    }

    public function scopeCardPayments($query)
    {
        return $query->where('payment_method', 'stripe');
    }

    public function isStripePayment()
    {
        return $this->payment_method === 'stripe';
    }

    public function getFormattedAmountAttribute()
    {
        $currency = strtoupper($this->currency ?? 'USD');
        $symbol = $this->getCurrencySymbol($currency);
        return $symbol . number_format($this->amount, 2);
    }

    public function getCurrencySymbol($currency)
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'JPY' => '¥',
            'CHF' => 'CHF ',
            'SEK' => 'kr ',
            'NOK' => 'kr ',
            'DKK' => 'kr ',
        ];

        return $symbols[$currency] ?? $currency . ' ';
    }

    public function getSupportedCurrencies()
    {
        return config('services.stripe.supported_currencies', []);
    }
}
