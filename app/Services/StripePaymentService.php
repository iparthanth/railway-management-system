<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\CardException;
use Stripe\Exception\ApiErrorException;

class StripePaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a payment intent for booking
     */
    public function createPaymentIntent(Booking $booking, array $options = [])
    {
        try {
            $currency = $options['currency'] ?? config('services.stripe.default_currency', 'usd');
            $amount = $this->convertToStripeAmount($booking->total_amount, $currency);

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method_types' => ['card'],
                'metadata' => [
                    'booking_id' => $booking->id,
                    'passenger_name' => $booking->passenger_name,
                    'passenger_email' => $booking->passenger_email,
                    'train_name' => $booking->trainSchedule->train_name ?? 'Unknown',
                    'journey_date' => $booking->journey_date->format('Y-m-d'),
                    'route' => ($booking->trainSchedule->from_station ?? '') . ' to ' . ($booking->trainSchedule->to_station ?? ''),
                ],
                'description' => "Railway ticket: {$booking->passenger_name} - " . ($booking->trainSchedule->train_name ?? 'Train'),
                'receipt_email' => $booking->passenger_email,
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            // Create payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'payment_method' => 'stripe',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'amount' => $booking->total_amount,
                'currency' => $currency,
                'payment_status' => 'pending',
                'gateway_response' => [
                    'payment_intent_id' => $paymentIntent->id,
                    'client_secret' => $paymentIntent->client_secret,
                    'status' => $paymentIntent->status,
                    'amount' => $paymentIntent->amount,
                    'currency' => $paymentIntent->currency,
                    'payment_method_types' => $paymentIntent->payment_method_types,
                    'created_at' => now()->toISOString(),
                ],
            ]);

            return [
                'success' => true,
                'payment_intent' => $paymentIntent,
                'payment' => $payment,
                'client_secret' => $paymentIntent->client_secret,
            ];

        } catch (CardException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'type' => 'card_error',
            ];
        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'type' => 'api_error',
            ];
        }
    }

    /**
     * Confirm payment and update records
     */
    public function confirmPayment($paymentIntentId)
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            
            $payment = Payment::where('stripe_payment_intent_id', $paymentIntentId)->first();
            
            if (!$payment) {
                return [
                    'success' => false,
                    'error' => 'Payment record not found',
                ];
            }

            if ($paymentIntent->status === 'succeeded') {
                $payment->update([
                    'payment_status' => 'completed',
                    'payment_date' => now(),
                    'stripe_charge_id' => $paymentIntent->charges->data[0]->id ?? null,
                    'gateway_response' => [
                        'payment_intent_id' => $paymentIntent->id,
                        'charge_id' => $paymentIntent->charges->data[0]->id ?? null,
                        'status' => $paymentIntent->status,
                        'amount_received' => $paymentIntent->amount_received,
                    ],
                ]);

                // Update booking status
                $payment->booking->update([
                    'booking_status' => 'confirmed',
                    'payment_status' => 'paid',
                ]);

                return [
                    'success' => true,
                    'payment' => $payment,
                    'booking' => $payment->booking,
                ];
            } else {
                $payment->update([
                    'payment_status' => 'failed',
                    'failure_reason' => $paymentIntent->last_payment_error->message ?? 'Unknown error',
                    'gateway_response' => [
                        'payment_intent_id' => $paymentIntent->id,
                        'status' => $paymentIntent->status,
                        'error' => $paymentIntent->last_payment_error ?? null,
                    ],
                ]);

                return [
                    'success' => false,
                    'error' => $paymentIntent->last_payment_error->message ?? 'Payment failed',
                ];
            }

        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'type' => 'api_error',
            ];
        }
    }

    /**
     * Refund a payment
     */
    public function refundPayment(Payment $payment, $amount = null)
    {
        try {
            if (!$payment->stripe_charge_id) {
                return [
                    'success' => false,
                    'error' => 'No charge ID found for refund',
                ];
            }

            $refund = \Stripe\Refund::create([
                'charge' => $payment->stripe_charge_id,
                'amount' => $amount ? $this->convertToStripeAmount($amount, $payment->currency) : null,
                'metadata' => [
                    'booking_id' => $payment->booking_id,
                    'original_payment_id' => $payment->id,
                ],
            ]);

            $payment->update([
                'payment_status' => $amount ? 'partially_refunded' : 'refunded',
                'gateway_response' => array_merge($payment->gateway_response ?? [], [
                    'refund_id' => $refund->id,
                    'refund_status' => $refund->status,
                    'refund_amount' => $refund->amount,
                ]),
            ]);

            return [
                'success' => true,
                'refund' => $refund,
                'payment' => $payment,
            ];

        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'type' => 'api_error',
            ];
        }
    }

    /**
     * Convert amount to Stripe format (cents)
     */
    private function convertToStripeAmount($amount, $currency)
    {
        // Currencies that don't use decimal places
        $zeroDecimalCurrencies = ['bif', 'clp', 'djf', 'gnf', 'jpy', 'kmf', 'krw', 'mga', 'pyg', 'rwf', 'ugx', 'vnd', 'vuv', 'xaf', 'xof', 'xpf'];
        
        if (in_array(strtolower($currency), $zeroDecimalCurrencies)) {
            return (int) $amount;
        }
        
        return (int) ($amount * 100);
    }

    /**
     * Convert amount from Stripe format
     */
    private function convertFromStripeAmount($amount, $currency)
    {
        $zeroDecimalCurrencies = ['bif', 'clp', 'djf', 'gnf', 'jpy', 'kmf', 'krw', 'mga', 'pyg', 'rwf', 'ugx', 'vnd', 'vuv', 'xaf', 'xof', 'xpf'];

        if (in_array(strtolower($currency), $zeroDecimalCurrencies)) {
            return $amount;
        }

        return $amount / 100;
    }

    /**
     * Get supported currencies
     */
    public function getSupportedCurrencies()
    {
        return config('services.stripe.supported_currencies', []);
    }

    /**
     * Validate currency
     */
    public function isCurrencySupported($currency)
    {
        $supportedCurrencies = array_keys($this->getSupportedCurrencies());
        return in_array(strtolower($currency), $supportedCurrencies);
    }

    /**
     * Get currency display name
     */
    public function getCurrencyName($currency)
    {
        $currencies = $this->getSupportedCurrencies();
        return $currencies[strtolower($currency)] ?? strtoupper($currency);
    }
}
