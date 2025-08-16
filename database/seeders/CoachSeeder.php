<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoachSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('coaches')->insert([
            ['train_id' => 1, 'coach_number' => 'C1', 'coach_type' => 'business', 'total_seats' => 24, 'price_multiplier' => 2.5],
            ['train_id' => 1, 'coach_number' => 'C2', 'coach_type' => 'first_class', 'total_seats' => 52, 'price_multiplier' => 1.5],
            ['train_id' => 2, 'coach_number' => 'C1', 'coach_type' => 'business', 'total_seats' => 60, 'price_multiplier' => 1.2],
            ['train_id' => 2, 'coach_number' => 'C2', 'coach_type' => 'economy', 'total_seats' => 80, 'price_multiplier' => 1.0],
            ['train_id' => 3, 'coach_number' => 'C1', 'coach_type' => 'business', 'total_seats' => 48, 'price_multiplier' => 2.0],
            ['train_id' => 3, 'coach_number' => 'C2', 'coach_type' => 'first_class', 'total_seats' => 32, 'price_multiplier' => 1.8],
            ['train_id' => 4, 'coach_number' => 'C1', 'coach_type' => 'business', 'total_seats' => 60, 'price_multiplier' => 1.2],
            ['train_id' => 5, 'coach_number' => 'C1', 'coach_type' => 'economy', 'total_seats' => 80, 'price_multiplier' => 1.0],
        ]);
    }
}
