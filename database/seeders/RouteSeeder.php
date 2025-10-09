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
        // Goal: For every From -> To pair, seed TWO active express routes
        // so search never shows "No Trains Found" due to missing routes.

        $stations = Station::orderBy('id')->get(['id', 'name']);
        if ($stations->count() < 2) {
            // Not enough stations to build routes
            return;
        }

        // Prefer express trains; if fewer than 2, fall back to all trains
        $expressIds = Train::where('type', 'express')->pluck('id')->all();
        if (count($expressIds) < 2) {
            $expressIds = Train::pluck('id')->all();
        }
        if (count($expressIds) < 2) {
            // Still not enough trains to create two options per pair
            return;
        }

        // Use two time slots for consistency; rotate trains for variety
        $timeSlots = ['07:30:00', '15:30:00'];

        $pairIndex = 0;
        foreach ($stations as $from) {
            foreach ($stations as $to) {
                if ($from->id === $to->id) continue;

                // Simple distance/duration/base price model based on station id delta
                $delta = abs($from->id - $to->id);
                $distanceKm = 120 + ($delta * 30);                 // 120km .. ~300km
                $durationMin = 150 + ($delta * 25);                // 2.5h .. ~5h
                $basePrice  = 350 + ($delta * 30);                 // 350 .. ~530

                // Generate two routes for this pair with different trains and times
                for ($i = 0; $i < 2; $i++) {
                    $trainId = $expressIds[($pairIndex + $i) % count($expressIds)];
                    $depTime = $timeSlots[$i % count($timeSlots)];

                    DB::table('routes')->updateOrInsert(
                        [
                            'train_id' => $trainId,
                            'from_station_id' => $from->id,
                            'to_station_id' => $to->id,
                            'departure_time' => $depTime,
                        ],
                        [
                            'arrival_time' => date('H:i:s', strtotime($depTime) + ($durationMin * 60)),
                            'distance_km' => $distanceKm,
                            'duration_minutes' => $durationMin,
                            'base_price' => $basePrice,
                            'is_active' => true,
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );
                }

                $pairIndex++;
            }
        }
    }
}