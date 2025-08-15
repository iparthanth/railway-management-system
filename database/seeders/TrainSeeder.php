<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Train;

class TrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trains = [
            [
                'name' => 'Chittagong Express',
                'train_number' => 'TR-001',
                'departure_time' => '06:00',
                'arrival_time' => '14:30',
                'duration' => '8h 30m',
                'total_seats' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Chittagong Mail',
                'train_number' => 'TR-002',
                'departure_time' => '22:00',
                'arrival_time' => '06:30',
                'duration' => '8h 30m',
                'total_seats' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Dhaka Express',
                'train_number' => 'TR-003',
                'departure_time' => '07:00',
                'arrival_time' => '15:30',
                'duration' => '8h 30m',
                'total_seats' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Sylhet Express',
                'train_number' => 'TR-004',
                'departure_time' => '08:00',
                'arrival_time' => '16:00',
                'duration' => '8h 00m',
                'total_seats' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Rajshahi Express',
                'train_number' => 'TR-005',
                'departure_time' => '09:00',
                'arrival_time' => '17:30',
                'duration' => '8h 30m',
                'total_seats' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Khulna Express',
                'train_number' => 'TR-006',
                'departure_time' => '10:00',
                'arrival_time' => '18:00',
                'duration' => '8h 00m',
                'total_seats' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Barisal Express',
                'train_number' => 'TR-007',
                'departure_time' => '11:00',
                'arrival_time' => '19:30',
                'duration' => '8h 30m',
                'total_seats' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Tangail Express',
                'train_number' => 'TR-008',
                'departure_time' => '12:00',
                'arrival_time' => '14:30',
                'duration' => '2h 30m',
                'total_seats' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Sylhet Mail',
                'train_number' => 'TR-009',
                'departure_time' => '20:00',
                'arrival_time' => '04:00',
                'duration' => '8h 00m',
                'total_seats' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Rajshahi Mail',
                'train_number' => 'TR-010',
                'departure_time' => '21:00',
                'arrival_time' => '05:30',
                'duration' => '8h 30m',
                'total_seats' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Intercity Express',
                'train_number' => 'TR-011',
                'departure_time' => '15:00',
                'arrival_time' => '23:30',
                'duration' => '8h 30m',
                'total_seats' => 16,
                'is_active' => true,
            ],
        ];

        foreach ($trains as $train) {
            Train::create($train);
        }
    }
}