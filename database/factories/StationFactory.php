<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Station>
 */
class StationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = ['Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Barisal', 'Tangail', 'Comilla', 'Mymensingh', 'Rangpur'];
        
        return [
            'name' => fake()->unique()->randomElement($cities),
            'code' => fake()->unique()->regexify('[A-Z]{3}'),
            'is_active' => fake()->boolean(90),
        ];
    }
}