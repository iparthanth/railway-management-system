<?php

namespace Database\Factories;

use App\Models\Train;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Route>
 */
class RouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departureTime = $this->faker->time('H:i');
        $duration = $this->faker->numberBetween(180, 720); // 3 to 12 hours in minutes
        $arrivalTime = date('H:i', strtotime($departureTime) + ($duration * 60));

        return [
            'train_id' => Train::factory(),
            'departure_station_id' => Station::factory(),
            'arrival_station_id' => Station::factory(),
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,
            'distance_km' => $this->faker->numberBetween(50, 500),
            'duration_minutes' => $duration,
            'is_active' => $this->faker->boolean(90),
        ];
    }

    /**
     * Indicate that the route is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
