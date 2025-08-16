<?php

namespace Database\Seeders;

use App\Models\Train;
use Illuminate\Database\Seeder;

class TrainSeeder extends Seeder
{
    public function run(): void
    {
        $trains = [
            ['name' => 'Suborno Express', 'number' => '701', 'type' => 'express', 'total_coaches' => 12],
            ['name' => 'Padma Express', 'number' => '759', 'type' => 'express', 'total_coaches' => 10],
            ['name' => 'Meghna Express', 'number' => '720', 'type' => 'express', 'total_coaches' => 14],
            ['name' => 'Jamuna Express', 'number' => '142', 'type' => 'intercity', 'total_coaches' => 8],
            ['name' => 'Karnaphuli Express', 'number' => '320', 'type' => 'express', 'total_coaches' => 11],
            ['name' => 'Surma Express', 'number' => '246', 'type' => 'mail', 'total_coaches' => 9],
        ];

        foreach ($trains as $train) {
            Train::create($train);
        }
    }
}
