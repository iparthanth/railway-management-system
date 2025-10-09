<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Station;
use App\Models\Train;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        // Resolve station IDs by stable codes from StationSeeder
        $stationByCode = Station::pluck('id', 'code')->all();

        // Resolve train IDs by stable numbers from TrainSeeder
        $trainByNumber = Train::pluck('id', 'number')->all();

        // Fixed values for all routes (explicit manual dataset)
        $duration = 240; // minutes
        $distance = 300.00; // km
        $price = 500.00; // base price

        // Explicitly enumerated routes: two per From→To pair (84 entries)
        // Time slots are fixed; arrival time derived manually (no generation logic)
        $routes = [
            // DHK → ...
            ['train_number' => '701', 'from_code' => 'DHK', 'to_code' => 'CTG', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'DHK', 'to_code' => 'CTG', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'DHK', 'to_code' => 'SYL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'DHK', 'to_code' => 'SYL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'DHK', 'to_code' => 'RAJ', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'DHK', 'to_code' => 'RAJ', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '701', 'from_code' => 'DHK', 'to_code' => 'KHL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'DHK', 'to_code' => 'KHL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'DHK', 'to_code' => 'BAR', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'DHK', 'to_code' => 'BAR', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'DHK', 'to_code' => 'TAN', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'DHK', 'to_code' => 'TAN', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            // CTG → ...
            ['train_number' => '701', 'from_code' => 'CTG', 'to_code' => 'DHK', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'CTG', 'to_code' => 'DHK', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'CTG', 'to_code' => 'SYL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'CTG', 'to_code' => 'SYL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'CTG', 'to_code' => 'RAJ', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'CTG', 'to_code' => 'RAJ', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '701', 'from_code' => 'CTG', 'to_code' => 'KHL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'CTG', 'to_code' => 'KHL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'CTG', 'to_code' => 'BAR', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'CTG', 'to_code' => 'BAR', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'CTG', 'to_code' => 'TAN', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'CTG', 'to_code' => 'TAN', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            // SYL → ...
            ['train_number' => '701', 'from_code' => 'SYL', 'to_code' => 'DHK', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'SYL', 'to_code' => 'DHK', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'SYL', 'to_code' => 'CTG', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'SYL', 'to_code' => 'CTG', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'SYL', 'to_code' => 'RAJ', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'SYL', 'to_code' => 'RAJ', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '701', 'from_code' => 'SYL', 'to_code' => 'KHL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'SYL', 'to_code' => 'KHL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'SYL', 'to_code' => 'BAR', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'SYL', 'to_code' => 'BAR', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'SYL', 'to_code' => 'TAN', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'SYL', 'to_code' => 'TAN', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            // RAJ → ...
            ['train_number' => '701', 'from_code' => 'RAJ', 'to_code' => 'DHK', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'RAJ', 'to_code' => 'DHK', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'RAJ', 'to_code' => 'CTG', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'RAJ', 'to_code' => 'CTG', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'RAJ', 'to_code' => 'SYL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'RAJ', 'to_code' => 'SYL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '701', 'from_code' => 'RAJ', 'to_code' => 'KHL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'RAJ', 'to_code' => 'KHL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'RAJ', 'to_code' => 'BAR', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'RAJ', 'to_code' => 'BAR', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'RAJ', 'to_code' => 'TAN', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'RAJ', 'to_code' => 'TAN', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            // KHL → ...
            ['train_number' => '701', 'from_code' => 'KHL', 'to_code' => 'DHK', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'KHL', 'to_code' => 'DHK', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'KHL', 'to_code' => 'CTG', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'KHL', 'to_code' => 'CTG', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'KHL', 'to_code' => 'SYL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'KHL', 'to_code' => 'SYL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '701', 'from_code' => 'KHL', 'to_code' => 'RAJ', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'KHL', 'to_code' => 'RAJ', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'KHL', 'to_code' => 'BAR', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'KHL', 'to_code' => 'BAR', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'KHL', 'to_code' => 'TAN', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'KHL', 'to_code' => 'TAN', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            // BAR → ...
            ['train_number' => '701', 'from_code' => 'BAR', 'to_code' => 'DHK', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'BAR', 'to_code' => 'DHK', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'BAR', 'to_code' => 'CTG', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'BAR', 'to_code' => 'CTG', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'BAR', 'to_code' => 'SYL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'BAR', 'to_code' => 'SYL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '701', 'from_code' => 'BAR', 'to_code' => 'RAJ', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'BAR', 'to_code' => 'RAJ', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'BAR', 'to_code' => 'KHL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'BAR', 'to_code' => 'KHL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'BAR', 'to_code' => 'TAN', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'BAR', 'to_code' => 'TAN', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            // TAN → ...
            ['train_number' => '701', 'from_code' => 'TAN', 'to_code' => 'DHK', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'TAN', 'to_code' => 'DHK', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'TAN', 'to_code' => 'CTG', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'TAN', 'to_code' => 'CTG', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'TAN', 'to_code' => 'SYL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'TAN', 'to_code' => 'SYL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '701', 'from_code' => 'TAN', 'to_code' => 'RAJ', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '759', 'from_code' => 'TAN', 'to_code' => 'RAJ', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '720', 'from_code' => 'TAN', 'to_code' => 'KHL', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '142', 'from_code' => 'TAN', 'to_code' => 'KHL', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],

            ['train_number' => '320', 'from_code' => 'TAN', 'to_code' => 'BAR', 'departure_time' => '07:30:00', 'arrival_time' => '11:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
            ['train_number' => '246', 'from_code' => 'TAN', 'to_code' => 'BAR', 'departure_time' => '15:30:00', 'arrival_time' => '19:30:00', 'duration_minutes' => $duration, 'distance_km' => $distance, 'base_price' => $price, 'is_active' => true],
        ];

        foreach ($routes as $r) {
            // Map codes/numbers to IDs
            $trainId = $trainByNumber[$r['train_number']] ?? null;
            $fromId  = $stationByCode[$r['from_code']] ?? null;
            $toId    = $stationByCode[$r['to_code']] ?? null;

            if (!$trainId || !$fromId || !$toId) {
                // Skip invalid rows if seeder data changes
                continue;
            }

            DB::table('routes')->updateOrInsert(
                [
                    'train_id'        => $trainId,
                    'from_station_id' => $fromId,
                    'to_station_id'   => $toId,
                    'departure_time'  => $r['departure_time'],
                ],
                [
                    'arrival_time'     => $r['arrival_time'],
                    'duration_minutes' => $r['duration_minutes'],
                    'distance_km'      => $r['distance_km'],
                    'base_price'       => $r['base_price'],
                    'is_active'        => $r['is_active'] ?? true,
                    'updated_at'       => now(),
                    'created_at'       => now(),
                ]
            );
        }
    }
}