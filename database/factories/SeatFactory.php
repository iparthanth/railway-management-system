<?php

namespace Database\Factories;

use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeatFactory extends Factory
{
    public function definition(): array
    {
        $positions = ['window', 'middle', 'aisle'];
        $position = $this->faker->randomElement($positions);
        
        return [
            'coach_id' => Coach::factory(),
            'seat_number' => $this->faker->bothify('?#'),
            'row_number' => $this->faker->numberBetween(1, 20),
            'position' => $position,
            'is_window' => $position === 'window',
            'is_available' => $this->faker->boolean(80),
        ];
    }
}
