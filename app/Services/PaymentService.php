<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class PaymentService
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.secret'));
    }

    public function initiatePayment(Payment $payment)
    {
        try {
            // Create a payment intent with Stripe
            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $payment->amount * 100, // Stripe uses cents
                'currency' => 'bdt',
                'payment_method_types' => ['card'],
                'metadata' => [
                    'payment_id' => $payment->id,
                    'booking_id' => $payment->booking_id,
                ],
            ]);

            $payment->update([
                'status' => 'processing',
                'transaction_id' => $paymentIntent->id,
            ]);

            return view('payment.stripe', [
                'payment' => $payment,
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe payment initiation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function handleCallback(Request $request)
    {
        try {
            $intent = $this->stripe->paymentIntents->retrieve($request->payment_intent);
            
            if ($intent->status === 'succeeded') {
                $payment = Payment::where('transaction_id', $intent->id)->firstOrFail();
                $payment->update([
                    'status' => 'completed',
                    'gateway_response' => json_encode($intent->toArray())
                ]);

                return [
                    'success' => true,
                    'data' => [
                        'transaction_id' => $intent->id,
                        'amount' => $intent->amount / 100,
                        'status' => 'completed'
                    ]
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment failed',
                'data' => $intent->toArray()
            ];
        } catch (\Exception $e) {
            Log::error('Stripe payment callback failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment processing error',
                'data' => $e->getMessage()
            ];
        }
    }
}
