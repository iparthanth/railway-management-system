<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Train;
use App\Models\Route;
use App\Models\User;

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
        $selectedSeats = fake()->randomElements(['A1', 'A2', 'A3', 'A4', 'B1', 'B2', 'B3', 'B4'], fake()->numberBetween(1, 4));
        
        return [
            'pnr' => 'PNR' . fake()->unique()->numberBetween(1000000, 9999999),
            'passenger_name' => fake()->name(),
            'passenger_email' => fake()->email(),
            'passenger_phone' => fake()->phoneNumber(),
            'train_id' => Train::factory(),
            'route_id' => Route::factory(),
            'journey_date' => fake()->dateTimeBetween('now', '+30 days'),
            'selected_seats' => $selectedSeats,
            'total_fare' => fake()->numberBetween(500, 2000),
            'payment_method' => fake()->randomElement(['stripe', 'cash']),
            'payment_status' => fake()->randomElement(['pending', 'succeeded', 'failed']),
            'booking_status' => fake()->randomElement(['confirmed', 'cancelled']),
            'user_id' => fake()->boolean(70) ? User::factory() : null, // 70% have user accounts
        ];
    }
}
