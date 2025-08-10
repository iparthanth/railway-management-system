<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = [
            [
                'code' => 'DHK',
                'name' => 'Dhaka',
                'city' => 'Dhaka',
                'state' => 'Dhaka Division',
                'latitude' => 23.8103,
                'longitude' => 90.4125,
                'is_active' => true,
            ],
            [
                'code' => 'CTG',
                'name' => 'Chittagong',
                'city' => 'Chittagong',
                'state' => 'Chittagong Division',
                'latitude' => 22.3569,
                'longitude' => 91.7832,
                'is_active' => true,
            ],
            [
                'code' => 'SYL',
                'name' => 'Sylhet',
                'city' => 'Sylhet',
                'state' => 'Sylhet Division',
                'latitude' => 24.8949,
                'longitude' => 91.8687,
                'is_active' => true,
            ],
            [
                'code' => 'RAJ',
                'name' => 'Rajshahi',
                'city' => 'Rajshahi',
                'state' => 'Rajshahi Division',
                'latitude' => 24.3745,
                'longitude' => 88.6042,
                'is_active' => true,
            ],
            [
                'code' => 'KHL',
                'name' => 'Khulna',
                'city' => 'Khulna',
                'state' => 'Khulna Division',
                'latitude' => 22.8456,
                'longitude' => 89.5403,
                'is_active' => true,
            ],
            [
                'code' => 'BAR',
                'name' => 'Barisal',
                'city' => 'Barisal',
                'state' => 'Barisal Division',
                'latitude' => 22.7010,
                'longitude' => 90.3535,
                'is_active' => true,
            ],
        ];

        foreach ($stations as $station) {
            Station::create($station);
        }
    }
}