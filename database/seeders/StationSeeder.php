<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['name' => 'Dhaka', 'code' => 'DKA'],
            ['name' => 'Chittagong', 'code' => 'CTG'],
            ['name' => 'Sylhet', 'code' => 'SYL'],
            ['name' => 'Rajshahi', 'code' => 'RAJ'],
            ['name' => 'Khulna', 'code' => 'KHL'],
            ['name' => 'Barisal', 'code' => 'BAR'],
            ['name' => 'Tangail', 'code' => 'TAN'],
        ];

        foreach ($stations as $station) {
            Station::create($station);
        }
    }
}