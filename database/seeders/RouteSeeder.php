<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure key express routes exist and provide two express options per pair
        $routes = [
            // Dhaka (1) → Chittagong (2)
            [
                'train_id' => 1, // Suborno Express
                'from_station_id' => 1,
                'to_station_id' => 2,
                'departure_time' => '07:30:00',
                'arrival_time' => '13:00:00',
                'distance_km' => 264,
                'duration_minutes' => 330,
                'base_price' => 500,
                'is_active' => true,
            ],
            [
                'train_id' => 5, // Karnaphuli Express (second express option on the same pair)
                'from_station_id' => 1,
                'to_station_id' => 2,
                'departure_time' => '15:00:00',
                'arrival_time' => '20:30:00',
                'distance_km' => 264,
                'duration_minutes' => 330,
                'base_price' => 520,
                'is_active' => true,
            ],

            // Dhaka (1) → Sylhet (3)
            [
                'train_id' => 2, // Padma Express
                'from_station_id' => 1,
                'to_station_id' => 3,
                'departure_time' => '08:00:00',
                'arrival_time' => '12:15:00',
                'distance_km' => 198,
                'duration_minutes' => 255,
                'base_price' => 400,
                'is_active' => true,
            ],
            [
                'train_id' => 6, // Surma Express (second express option on the same pair)
                'from_station_id' => 1,
                'to_station_id' => 3,
                'departure_time' => '16:30:00',
                'arrival_time' => '21:00:00',
                'distance_km' => 198,
                'duration_minutes' => 270,
                'base_price' => 420,
                'is_active' => true,
            ],

            // Dhaka (1) → Rajshahi (4)
            [
                'train_id' => 3, // Meghna Express
                'from_station_id' => 1,
                'to_station_id' => 4,
                'departure_time' => '09:00:00',
                'arrival_time' => '14:00:00',
                'distance_km' => 256,
                'duration_minutes' => 300,
                'base_price' => 450,
                'is_active' => true,
            ],
            [
                'train_id' => 4, // Jamuna Express (second express option on the same pair)
                'from_station_id' => 1,
                'to_station_id' => 4,
                'departure_time' => '18:30:00',
                'arrival_time' => '23:20:00',
                'distance_km' => 256,
                'duration_minutes' => 290,
                'base_price' => 460,
                'is_active' => true,
            ],
        ];

        foreach ($routes as $r) {
            // Avoid duplicates if seeder runs multiple times
            DB::table('routes')->updateOrInsert(
                [
                    'train_id' => $r['train_id'],
                    'from_station_id' => $r['from_station_id'],
                    'to_station_id' => $r['to_station_id'],
                    'departure_time' => $r['departure_time'],
                ],
                [
                    'arrival_time' => $r['arrival_time'],
                    'distance_km' => $r['distance_km'],
                    'duration_minutes' => $r['duration_minutes'],
                    'base_price' => $r['base_price'],
                    'is_active' => $r['is_active'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}