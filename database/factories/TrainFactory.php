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
            'Express', 'Mail', 'Intercity', 'Local', 'Special'
        ];
        
        $cities = [
            'Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Barisal', 'Tangail'
        ];
        
        $departureTime = fake()->time('H:i');
        $arrivalTime = fake()->time('H:i');
        
        return [
            'name' => fake()->randomElement($cities) . ' ' . fake()->randomElement($trainNames),
            'train_number' => 'TR-' . fake()->unique()->numberBetween(100, 999),
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,
            'duration' => fake()->randomElement(['2h 30m', '4h 00m', '6h 30m', '8h 00m', '8h 30m']),
            'total_seats' => 16,
            'is_active' => fake()->boolean(90), // 90% active
        ];
    }
}