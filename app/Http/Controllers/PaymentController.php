<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Show payment page for booking
     */
    public function create($bookingId)
    {
        $booking = [
            'id' => $bookingId,
            'pnr' => 'PNR' . rand(1000000, 9999999),
            'passenger_name' => 'John Doe',
            'train_name' => 'Chittagong Express',
            'route' => 'Dhaka → Chittagong',
            'journey_date' => date('Y-m-d'),
            'seats' => ['A1', 'A2'],
            'total_fare' => 850,
            'payment_status' => 'pending'
        ];
        
        return view('payment.create', compact('booking'));
    }

    /**
     * Create Stripe payment intent
     */
    public function createStripeIntent(Request $request, $bookingId)
    {
        $request->validate([
            'currency' => 'required|in:usd,eur,gbp,cad,aud',
        ]);

        return response()->json([
            'success' => true,
            'client_secret' => 'pi_test_' . uniqid() . '_secret_test',
            'payment_id' => rand(1000, 9999),
            'currency' => $request->currency,
            'amount' => 850,
        ]);
    }

    /**
     * Confirm Stripe payment
     */
    public function confirmStripePayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment confirmed successfully',
            'booking' => [
                'id' => rand(1000, 9999),
                'status' => 'confirmed',
                'payment_status' => 'paid'
            ],
            'payment' => [
                'id' => rand(1000, 9999),
                'status' => 'completed',
                'amount' => 850
            ],
        ]);
    }

    /**
     * Get supported currencies
     */
    public function getSupportedCurrencies()
    {
        return response()->json([
            'success' => true,
            'currencies' => [
                'usd' => ['symbol' => '$', 'name' => 'US Dollar'],
                'eur' => ['symbol' => '€', 'name' => 'Euro'],
                'gbp' => ['symbol' => '£', 'name' => 'British Pound'],
                'cad' => ['symbol' => 'C$', 'name' => 'Canadian Dollar'],
                'aud' => ['symbol' => 'A$', 'name' => 'Australian Dollar']
            ],
            'default_currency' => 'usd',
        ]);
    }

    /**
     * Webhook handler for Stripe
     */
    public function stripeWebhook(Request $request)
    {
        return response('Webhook handled', 200);
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus($paymentId)
    {
        return response()->json([
            'success' => true,
            'payment' => [
                'id' => $paymentId,
                'status' => 'completed',
                'amount' => '$850.00',
                'currency' => 'USD',
                'method' => 'stripe',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            'booking' => [
                'id' => rand(1000, 9999),
                'status' => 'confirmed',
                'passenger_name' => 'John Doe',
            ],
        ]);
    }
}
