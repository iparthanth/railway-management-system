<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Create a Stripe Checkout Session for the booking and redirect.
     */
    public function create($bookingId)
    {
        $booking = Booking::with(['train', 'route'])->findOrFail((int)$bookingId);

        // Ensure Stripe keys are configured
        $secret = env('STRIPE_SECRET');
        if (!$secret) {
            return back()->withErrors(['payment' => 'Stripe credentials are not configured. Set STRIPE_SECRET and STRIPE_KEY in .env']);
        }

        // Build line item (amount in smallest currency unit)
        $currency = env('STRIPE_CURRENCY', 'usd');
        $amount = (int) round(((float) $booking->total_amount) * 100);
        $productName = 'Train Booking ' . ($booking->booking_reference ?? ('#' . $booking->id));

        try {
            $client = new \Stripe\StripeClient($secret);
            $session = $client->checkout->sessions->create([
                'mode' => 'payment',
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => [
                            'name' => $productName,
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'booking_id' => (string)$booking->id,
                    'booking_reference' => (string)($booking->booking_reference ?? ''),
                ],
                'success_url' => route('payment.success', ['booking' => $booking->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', ['booking' => $booking->id]),
            ]);

            // Keep session id on the booking (optional)
            $booking->payment_status = 'pending';
            $booking->save();

            return redirect()->away($session->url, 303);
        } catch (\Throwable $e) {
            Log::error('Stripe session create failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['payment' => 'Unable to start payment: ' . $e->getMessage()]);
        }
    }

    /**
     * Called when Stripe redirects back on success.
     * We verify the session and mark booking as paid if already succeeded.
     */
    public function success($bookingId, Request $request)
    {
        $booking = Booking::findOrFail((int)$bookingId);
        $sessionId = $request->query('session_id');
        $secret = env('STRIPE_SECRET');
        if (!$secret || !$sessionId) {
            return view('payment.success', ['booking' => $booking, 'paid' => false, 'message' => 'Missing Stripe configuration or session.']);
        }

        try {
            $client = new \Stripe\StripeClient($secret);
            $session = $client->checkout->sessions->retrieve($sessionId, ['expand' => ['payment_intent']]);

            $paid = ($session->payment_status === 'paid') || ($session->status === 'complete');
            if ($paid) {
                $booking->booking_status = 'confirmed';
                $booking->payment_status = 'paid';
                $booking->save();
            }

            return view('payment.success', [
                'booking' => $booking,
                'paid' => $paid,
                'message' => $paid ? 'Payment successful.' : 'Payment processing... If already paid, you will receive confirmation shortly.'
            ]);
        } catch (\Throwable $e) {
            Log::error('Stripe success check failed', ['error' => $e->getMessage()]);
            return view('payment.success', ['booking' => $booking, 'paid' => false, 'message' => 'Could not verify payment.']);
        }
    }

    /**
     * Called when user cancels from Stripe checkout.
     */
    public function cancel($bookingId)
    {
        $booking = Booking::findOrFail((int)$bookingId);
        return view('payment.cancel', ['booking' => $booking]);
    }

    /**
     * (Optional) Webhook to handle asynchronous events from Stripe
     */
    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        if (!$endpointSecret) {
            // If no secret configured, accept without verification (NOT recommended for production)
            $event = json_decode($payload);
        } else {
            try {
                $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
            } catch (\UnexpectedValueException $e) {
                return response('Invalid payload', 400);
            } catch (\Stripe\Exception\SignatureVerificationException $e) {
                return response('Invalid signature', 400);
            }
        }

        // Handle event types
        $type = is_object($event) ? ($event->type ?? '') : ($event['type'] ?? '');
        if ($type === 'checkout.session.completed') {
            $session = is_object($event) ? $event->data->object : $event['data']['object'];
            $bookingId = $session->metadata->booking_id ?? null;
            if ($bookingId) {
                $booking = Booking::find($bookingId);
                if ($booking) {
                    $booking->booking_status = 'confirmed';
                    $booking->payment_status = 'paid';
                    $booking->save();
                }
            }
        }

        return response('Webhook handled', 200);
    }
}
