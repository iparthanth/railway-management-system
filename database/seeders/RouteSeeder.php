<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Train;
use App\Models\Station;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    public function run()
    {
        // CHATTALA EXPRESS (801) - Chattogram to Dhaka
        $chattalaExpress = Train::where('number', '801')->first();
        $chattogramStation = Station::where('code', 'CTG')->first();
        $dhakaStation = Station::where('code', 'DHA')->first();
        
        if ($chattalaExpress && $chattogramStation && $dhakaStation) {
            Route::create([
                'train_id' => $chattalaExpress->id,
                'station_id' => $chattogramStation->id,
                'sequence' => 1,
                'arrival_time' => null,
                'departure_time' => '06:00',
                'halt_duration' => 0,
                'distance_from_origin' => 0,
            ]);
            
            Route::create([
                'train_id' => $chattalaExpress->id,
                'station_id' => $dhakaStation->id,
                'sequence' => 2,
                'arrival_time' => '12:45',
                'departure_time' => '12:45',
                'halt_duration' => 0,
                'distance_from_origin' => 264,
            ]);
        }

        // RANGPUR EXPRESS (771) - Dhaka to Rangpur with multiple stops
        $rangpurExpress = Train::where('number', '771')->first();
        $rangpurStation = Station::where('code', 'RAN')->first();
        
        if ($rangpurExpress && $dhakaStation && $rangpurStation) {
            $rangpurRoutes = [
                ['station_code' => 'DHA', 'sequence' => 1, 'arrival' => null, 'departure' => '09:10', 'halt' => 0, 'distance' => 0],
                ['station_code' => 'BHA', 'sequence' => 2, 'arrival' => '09:35', 'departure' => '09:36', 'halt' => 1, 'distance' => 23],
                ['station_code' => 'ISH', 'sequence' => 3, 'arrival' => '11:35', 'departure' => '11:45', 'halt' => 10, 'distance' => 155],
                ['station_code' => 'CHAT', 'sequence' => 4, 'arrival' => '12:31', 'departure' => '12:34', 'halt' => 3, 'distance' => 201],
                ['station_code' => 'NAT', 'sequence' => 5, 'arrival' => '01:43', 'departure' => '01:46', 'halt' => 3, 'distance' => 245],
                ['station_code' => 'RAN', 'sequence' => 6, 'arrival' => '07:00', 'departure' => '07:00', 'halt' => 0, 'distance' => 350],
            ];

            foreach ($rangpurRoutes as $routeData) {
                $station = Station::where('code', $routeData['station_code'])->first();
                if ($station) {
                    Route::create([
                        'train_id' => $rangpurExpress->id,
                        'station_id' => $station->id,
                        'sequence' => $routeData['sequence'],
                        'arrival_time' => $routeData['arrival'],
                        'departure_time' => $routeData['departure'],
                        'halt_duration' => $routeData['halt'],
                        'distance_from_origin' => $routeData['distance'],
                    ]);
                }
            }
        }

        // Add more routes for other trains as needed
        // This is a simplified version - in real implementation, you'd add all routes
    }
}
