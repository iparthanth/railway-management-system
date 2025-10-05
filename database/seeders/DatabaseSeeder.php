<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StationSeeder::class,
            TrainSeeder::class,
            CoachSeeder::class,
            RouteSeeder::class,
            SeatSeeder::class,
            BookingSeeder::class,
            BookingSeatSeeder::class,
        ]);
    }
}
