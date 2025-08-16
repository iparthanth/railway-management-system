<?php

namespace Database\Factories;

use App\Models\Train;
use App\Models\Route;
use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_reference' => strtoupper($this->faker->bothify('??####')),
            'train_id' => Train::factory(),
            'route_id' => Route::factory(),
            'coach_id' => Coach::factory(),
            'journey_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'passenger_name' => $this->faker->name(),
            'passenger_email' => $this->faker->email(),
            'passenger_phone' => $this->faker->phoneNumber(),
            'passenger_count' => $this->faker->numberBetween(1, 4),
            'total_amount' => $this->faker->numberBetween(500, 5000),
            'booking_status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
