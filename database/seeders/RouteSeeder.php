<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('routes')->insert([
            [
                'train_id' => 1,
                'from_station_id' => 1,
                'to_station_id' => 2,
                'departure_time' => '07:30:00',
                'arrival_time' => '13:00:00',
                'distance_km' => 264,
                'duration_minutes' => 330,
                'base_price' => 500,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'train_id' => 2,
                'from_station_id' => 1,
                'to_station_id' => 3,
                'departure_time' => '08:00:00',
                'arrival_time' => '12:15:00',
                'distance_km' => 198,
                'duration_minutes' => 255,
                'base_price' => 400,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'train_id' => 3,
                'from_station_id' => 1,
                'to_station_id' => 4,
                'departure_time' => '09:00:00',
                'arrival_time' => '14:00:00',
                'distance_km' => 256,
                'duration_minutes' => 300,
                'base_price' => 450,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
