<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seat;
use App\Models\Train;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trains = Train::all();
        $today = now()->toDateString();
        
        // Generate seats for next 30 days
        $dates = [];
        for ($i = 0; $i < 30; $i++) {
            $dates[] = now()->addDays($i)->toDateString();
        }

        foreach ($trains as $train) {
            foreach ($dates as $date) {
                // Generate standard seat layout: A1-A4, B1-B4, C1-C4, D1-D4 (16 seats total)
                $seatLayout = Seat::generateSeatLayout();
                
                foreach ($seatLayout as $seatNumber) {
                    // Randomly book some seats to simulate real scenario
                    $status = (mt_rand(1, 100) <= 20) ? 'booked' : 'available'; // 20% booked
                    
                    Seat::create([
                        'train_id' => $train->id,
                        'seat_number' => $seatNumber,
                        'journey_date' => $date,
                        'status' => $status,
                    ]);
                }
            }
        }
    }
}
