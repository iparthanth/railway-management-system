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
        $bangladeshStations = [
            ['code' => 'DHK', 'name' => 'Dhaka', 'city' => 'Dhaka', 'lat' => 23.8103, 'lng' => 90.4125],
            ['code' => 'CTG', 'name' => 'Chittagong', 'city' => 'Chittagong', 'lat' => 22.3569, 'lng' => 91.7832],
            ['code' => 'SYL', 'name' => 'Sylhet', 'city' => 'Sylhet', 'lat' => 24.8949, 'lng' => 91.8687],
            ['code' => 'RAJ', 'name' => 'Rajshahi', 'city' => 'Rajshahi', 'lat' => 24.3745, 'lng' => 88.6042],
            ['code' => 'KHL', 'name' => 'Khulna', 'city' => 'Khulna', 'lat' => 22.8456, 'lng' => 89.5403],
            ['code' => 'BSL', 'name' => 'Barisal', 'city' => 'Barisal', 'lat' => 22.7010, 'lng' => 90.3535],
        ];

        $station = $this->faker->randomElement($bangladeshStations);

        return [
            'code' => $station['code'],
            'name' => $station['name'] . ' Railway Station',
            'city' => $station['city'],
            'state' => 'Bangladesh',
            'latitude' => $station['lat'],
            'longitude' => $station['lng'],
            'is_active' => $this->faker->boolean(95),
        ];
    }

    /**
     * Indicate that the station is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
