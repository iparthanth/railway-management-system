<?php

namespace Database\Seeders;

use App\Models\BookingSeat;
use Illuminate\Database\Seeder;

class BookingSeatSeeder extends Seeder
{
    public function run(): void
    {
        $bookingSeats = [
            [
                'booking_id' => 1,
                'seat_id' => 1,
                'passenger_name' => 'Ahmed Hassan',
                'passenger_age' => 35,
                'passenger_gender' => 'male',
            ],
            [
                'booking_id' => 1,
                'seat_id' => 2,
                'passenger_name' => 'Fatima Hassan',
                'passenger_age' => 32,
                'passenger_gender' => 'female',
            ],
            [
                'booking_id' => 2,
                'seat_id' => 25,
                'passenger_name' => 'Fatima Rahman',
                'passenger_age' => 28,
                'passenger_gender' => 'female',
            ],
            [
                'booking_id' => 4,
                'seat_id' => 3,
                'passenger_name' => 'Rashida Begum',
                'passenger_age' => 45,
                'passenger_gender' => 'female',
            ],
        ];
        foreach ($bookingSeats as $bookingSeat) {
            BookingSeat::create($bookingSeat);
        }
    }
}