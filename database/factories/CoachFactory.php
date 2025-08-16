<?php

namespace Database\Factories;

use App\Models\Train;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoachFactory extends Factory
{
    public function definition(): array
    {
        return [
            'train_id' => Train::factory(),
            'coach_number' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'coach_type' => $this->faker->randomElement(['economy', 'business', 'first_class', 'sleeper']),
            'total_seats' => $this->faker->numberBetween(40, 80),
            'price_multiplier' => $this->faker->randomFloat(2, 1.0, 2.5),
        ];
    }
}
