<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Route;
use App\Models\Station;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get stations by name for easier reference
        $stations = Station::pluck('id', 'name')->toArray();

        $routes = [
            [
                'from_station_id' => $stations['Dhaka'],
                'to_station_id' => $stations['Chittagong'],
                'distance_km' => 264,
                'base_fare' => 1200.00,
                'is_active' => true,
            ],
            [
                'from_station_id' => $stations['Chittagong'],
                'to_station_id' => $stations['Dhaka'],
                'distance_km' => 264,
                'base_fare' => 1200.00,
                'is_active' => true,
            ],
            [
                'from_station_id' => $stations['Dhaka'],
                'to_station_id' => $stations['Sylhet'],
                'distance_km' => 245,
                'base_fare' => 1000.00,
                'is_active' => true,
            ],
            [
                'from_station_id' => $stations['Sylhet'],
                'to_station_id' => $stations['Dhaka'],
                'distance_km' => 245,
                'base_fare' => 1000.00,
                'is_active' => true,
            ],
            [
                'from_station_id' => $stations['Dhaka'],
                'to_station_id' => $stations['Rajshahi'],
                'distance_km' => 256,
                'base_fare' => 950.00,
                'is_active' => true,
            ],
            [
                'from_station_id' => $stations['Rajshahi'],
                'to_station_id' => $stations['Dhaka'],
                'distance_km' => 256,
                'base_fare' => 950.00,
                'is_active' => true,
            ],
            [
                'from_station_id' => $stations['Dhaka'],
                'to_station_id' => $stations['Khulna'],
                'distance_km' => 228,
                'base_fare' => 900.00,
                'is_active' => true,
            ],
            [
                'from_station_id' => $stations['Dhaka'],
                'to_station_id' => $stations['Barisal'],
                'distance_km' => 240,
                'base_fare' => 920.00,
                'is_active' => true,
            ],
            [
                'from_station_id' => $stations['Dhaka'],
                'to_station_id' => $stations['Tangail'],
                'distance_km' => 98,
                'base_fare' => 400.00,
                'is_active' => true,
            ],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}