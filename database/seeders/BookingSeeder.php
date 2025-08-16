<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bookings')->insert([
            [
                'route_id' => 1,
                'train_id' => 1,
                'coach_id' => 1,
                'passenger_name' => 'Ahmed Hassan',
                'passenger_phone' => '01712345678',
                'passenger_email' => 'ahmed@example.com',
                'journey_date' => '2024-02-15',
                'passenger_count' => 2,
                'total_amount' => 1000.00,
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
                'booking_reference' => 'BK001',
            ],
            [
                'route_id' => 2,
                'train_id' => 2,
                'coach_id' => 3,
                'passenger_name' => 'Fatima Rahman',
                'passenger_phone' => '01823456789',
                'passenger_email' => 'fatima@example.com',
                'journey_date' => '2024-02-16',
                'passenger_count' => 1,
                'total_amount' => 800.00,
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
                'booking_reference' => 'BK002',
            ],
            [
                'route_id' => 3,
                'train_id' => 3,
                'coach_id' => 5,
                'passenger_name' => 'Mohammad Ali',
                'passenger_phone' => '01934567890',
                'passenger_email' => 'ali@example.com',
                'journey_date' => '2024-02-17',
                'passenger_count' => 3,
                'total_amount' => 1500.00,
                'booking_status' => 'pending',
                'payment_status' => 'pending',
                'booking_reference' => 'BK003',
            ],
            [
                'route_id' => 1,
                'train_id' => 1,
                'coach_id' => 2,
                'passenger_name' => 'Rashida Begum',
                'passenger_phone' => '01645678901',
                'passenger_email' => 'rashida@example.com',
                'journey_date' => '2024-02-18',
                'passenger_count' => 1,
                'total_amount' => 500.00,
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
                'booking_reference' => 'BK004',
            ],
        ]);
    }
}
