<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Train;
use App\Models\Seat;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seatNumbers = Seat::generateSeatLayout();
        
        return [
            'train_id' => Train::factory(),
            'seat_number' => fake()->randomElement($seatNumbers),
            'journey_date' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'status' => fake()->randomElement(['available', 'booked']),
        ];
    }
}