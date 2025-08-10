<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Train>
 */
class TrainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $trainNames = [
            'Suborno Express', 'Turna Nishitha', 'Chittagong Express', 'Parabat Express',
            'Rangpur Express', 'Silk City Express', 'Kalni Express', 'Mohanagar Godhuli',
            'Sundarban Express', 'Padma Express', 'Jamuna Express', 'Meghna Express'
        ];

        return [
            'train_number' => $this->faker->unique()->numberBetween(100, 999),
            'name' => $this->faker->randomElement($trainNames),
            'type' => $this->faker->randomElement(['EXPRESS', 'INTERCITY', 'LOCAL', 'MAIL']),
            'total_seats' => $this->faker->numberBetween(200, 800),
            'is_active' => $this->faker->boolean(90),
        ];
    }

    /**
     * Indicate that the train is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
