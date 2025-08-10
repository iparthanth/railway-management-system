<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Train;
use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'train_id' => Train::factory(),
            'route_id' => Route::factory(),
            'booking_reference' => 'BR' . now()->format('ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'passenger_name' => $this->faker->name(),
            'passenger_email' => $this->faker->email(),
            'passenger_phone' => $this->faker->phoneNumber(),
            'passenger_nid' => $this->faker->optional()->numerify('##########'),
            'travel_date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'seat_class' => $this->faker->randomElement(['AC_B', 'AC_S', 'SNIGDHA', 'F_BERTH', 'F_SEAT', 'S_CHAIR']),
            'total_amount' => $this->faker->numberBetween(500, 2000),
            'payment_status' => $this->faker->randomElement(['PENDING', 'PAID', 'FAILED']),
            'booking_status' => $this->faker->randomElement(['CONFIRMED', 'CANCELLED']),
            'special_requests' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the booking is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => 'PAID',
            'booking_status' => 'CONFIRMED',
        ]);
    }

    /**
     * Indicate that the booking is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'booking_status' => 'CANCELLED',
        ]);
    }
}