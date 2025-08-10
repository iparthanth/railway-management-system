<?php

namespace Database\Seeders;

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
                'train_number' => '143',
                'name' => 'Turna Nishitha',
                'type' => 'EXPRESS',
                'total_seats' => 200,
                'is_active' => true,
            ],
            [
                'train_number' => '164',
                'name' => 'Chittagong Express',
                'type' => 'EXPRESS',
                'total_seats' => 180,
                'is_active' => true,
            ],
            [
                'train_number' => '142',
                'name' => 'Suborono Express',
                'type' => 'EXPRESS',
                'total_seats' => 190,
                'is_active' => true,
            ],
            [
                'train_number' => '701',
                'name' => 'Parabat Express',
                'type' => 'EXPRESS',
                'total_seats' => 170,
                'is_active' => true,
            ],
            [
                'train_number' => '721',
                'name' => 'Kalni Express',
                'type' => 'EXPRESS',
                'total_seats' => 160,
                'is_active' => true,
            ],
            [
                'train_number' => '771',
                'name' => 'Surma Mail',
                'type' => 'MAIL',
                'total_seats' => 150,
                'is_active' => true,
            ],
        ];

        foreach ($trains as $train) {
            Train::create($train);
        }
    }
}