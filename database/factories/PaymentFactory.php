<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currencies = ['usd', 'eur', 'gbp', 'cad', 'aud', 'jpy'];
        $currency = fake()->randomElement($currencies);

        // Adjust amount based on currency (JPY doesn't use decimals)
        $amount = $currency === 'jpy'
            ? fake()->numberBetween(5000, 50000)
            : fake()->randomFloat(2, 50, 500);

        return [
            'booking_id' => \App\Models\Booking::factory(),
            'payment_method' => 'stripe',
            'transaction_id' => null,
            'stripe_payment_intent_id' => 'pi_' . fake()->unique()->regexify('[a-zA-Z0-9]{24}'),
            'stripe_charge_id' => 'ch_' . fake()->unique()->regexify('[a-zA-Z0-9]{24}'),
            'amount' => $amount,
            'currency' => $currency,
            'payment_status' => fake()->randomElement(['completed', 'pending', 'failed', 'refunded']),
            'payment_date' => fake()->dateTimeThisMonth(),
            'gateway_response' => [
                'payment_intent' => 'pi_' . fake()->regexify('[a-zA-Z0-9]{24}'),
                'status' => 'succeeded',
                'currency' => $currency,
                'payment_method_types' => ['card'],
                'receipt_url' => 'https://pay.stripe.com/receipts/' . fake()->regexify('[a-zA-Z0-9]{32}'),
            ],
            'failure_reason' => fake()->boolean(10) ? fake()->randomElement([
                'insufficient_funds',
                'card_declined',
                'expired_card',
                'incorrect_cvc',
                'processing_error'
            ]) : null,
        ];
    }
}
