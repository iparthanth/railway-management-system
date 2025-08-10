<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;
use App\Models\Train;
use App\Models\Station;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get stations
        $dhaka = Station::where('code', 'DHK')->first();
        $chittagong = Station::where('code', 'CTG')->first();
        $sylhet = Station::where('code', 'SYL')->first();
        $rajshahi = Station::where('code', 'RAJ')->first();
        $khulna = Station::where('code', 'KHL')->first();
        $barisal = Station::where('code', 'BAR')->first();

        // Get trains
        $turnaNishitha = Train::where('train_number', '143')->first();
        $chittagongExpress = Train::where('train_number', '164')->first();
        $suboronoExpress = Train::where('train_number', '142')->first();
        $parabatExpress = Train::where('train_number', '701')->first();
        $kalniExpress = Train::where('train_number', '721')->first();
        $surmaMail = Train::where('train_number', '771')->first();

        $routes = [
            // Dhaka to Chittagong routes
            [
                'train_id' => $turnaNishitha->id,
                'departure_station_id' => $dhaka->id,
                'arrival_station_id' => $chittagong->id,
                'departure_time' => '23:30:00',
                'arrival_time' => '06:40:00',
                'distance_km' => 264,
                'duration_minutes' => 430,
                'is_active' => true,
            ],
            [
                'train_id' => $chittagongExpress->id,
                'departure_station_id' => $dhaka->id,
                'arrival_station_id' => $chittagong->id,
                'departure_time' => '14:50:00',
                'arrival_time' => '22:00:00',
                'distance_km' => 264,
                'duration_minutes' => 430,
                'is_active' => true,
            ],
            [
                'train_id' => $suboronoExpress->id,
                'departure_station_id' => $dhaka->id,
                'arrival_station_id' => $chittagong->id,
                'departure_time' => '07:15:00',
                'arrival_time' => '14:40:00',
                'distance_km' => 264,
                'duration_minutes' => 445,
                'is_active' => true,
            ],
            
            // Dhaka to Sylhet routes
            [
                'train_id' => $parabatExpress->id,
                'departure_station_id' => $dhaka->id,
                'arrival_station_id' => $sylhet->id,
                'departure_time' => '06:40:00',
                'arrival_time' => '14:30:00',
                'distance_km' => 308,
                'duration_minutes' => 470,
                'is_active' => true,
            ],
            [
                'train_id' => $kalniExpress->id,
                'departure_station_id' => $dhaka->id,
                'arrival_station_id' => $sylhet->id,
                'departure_time' => '21:30:00',
                'arrival_time' => '06:15:00',
                'distance_km' => 308,
                'duration_minutes' => 525,
                'is_active' => true,
            ],
            [
                'train_id' => $surmaMail->id,
                'departure_station_id' => $dhaka->id,
                'arrival_station_id' => $sylhet->id,
                'departure_time' => '22:30:00',
                'arrival_time' => '08:00:00',
                'distance_km' => 308,
                'duration_minutes' => 570,
                'is_active' => true,
            ],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}