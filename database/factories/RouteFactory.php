<?php

namespace Database\Factories;

use App\Models\Station;
use App\Models\Train;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    public function definition(): array
    {
        $departureTime = $this->faker->time('H:i');
        $arrivalTime = $this->faker->time('H:i');
        $durationMinutes = $this->faker->numberBetween(120, 720);
        
        return [
            'train_id' => Train::factory(),
            'from_station_id' => Station::factory(),
            'to_station_id' => Station::factory(),
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,
            'duration_minutes' => $durationMinutes,
            'distance_km' => $this->faker->numberBetween(50, 500),
            'base_price' => $this->faker->numberBetween(200, 2000),
            'is_active' => true,
        ];
    }
}
