<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StationFactory extends Factory
{
    public function definition(): array
    {
        $stations = [
            ['name' => 'Dhaka', 'code' => 'DHK', 'city' => 'Dhaka'],
            ['name' => 'Chittagong', 'code' => 'CTG', 'city' => 'Chittagong'],
            ['name' => 'Sylhet', 'code' => 'SYL', 'city' => 'Sylhet'],
            ['name' => 'Rajshahi', 'code' => 'RAJ', 'city' => 'Rajshahi'],
            ['name' => 'Khulna', 'code' => 'KHL', 'city' => 'Khulna'],
            ['name' => 'Barisal', 'code' => 'BAR', 'city' => 'Barisal'],
            ['name' => 'Tangail', 'code' => 'TAN', 'city' => 'Tangail'],
        ];

        $station = $this->faker->randomElement($stations);

        return [
            'name' => $station['name'],
            'code' => $station['code'],
            'city' => $station['city'],
            'state' => 'Bangladesh',
            'is_active' => true,
        ];
    }
}
