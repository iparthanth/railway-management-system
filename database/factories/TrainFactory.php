<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TrainFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Suborno Express', 'Padma Express', 'Meghna Express', 
                'Jamuna Express', 'Karnaphuli Express', 'Surma Express'
            ]),
            'number' => $this->faker->unique()->numberBetween(100, 999),
            'type' => $this->faker->randomElement(['express', 'local', 'intercity', 'mail']),
            'total_coaches' => $this->faker->numberBetween(8, 16),
            'is_active' => true,
        ];
    }
}
