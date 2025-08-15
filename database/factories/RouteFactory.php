<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Station;

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
        return [
            'from_station_id' => Station::factory(),
            'to_station_id' => Station::factory(),
            'distance_km' => fake()->numberBetween(50, 400),
            'base_fare' => fake()->numberBetween(300, 1500),
            'is_active' => fake()->boolean(95), // 95% active
        ];
    }
}