<?php
namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        $stations = [
            ['name' => 'Dhaka', 'code' => 'DHK', 'city' => 'Dhaka', 'state' => 'Bangladesh'],
            ['name' => 'Chittagong', 'code' => 'CTG', 'city' => 'Chittagong', 'state' => 'Bangladesh'],
            ['name' => 'Sylhet', 'code' => 'SYL', 'city' => 'Sylhet', 'state' => 'Bangladesh'],
            ['name' => 'Rajshahi', 'code' => 'RAJ', 'city' => 'Rajshahi', 'state' => 'Bangladesh'],
            ['name' => 'Khulna', 'code' => 'KHL', 'city' => 'Khulna', 'state' => 'Bangladesh'],
            ['name' => 'Barisal', 'code' => 'BAR', 'city' => 'Barisal', 'state' => 'Bangladesh'],
            ['name' => 'Tangail', 'code' => 'TAN', 'city' => 'Tangail', 'state' => 'Bangladesh'],
        ];

        foreach ($stations as $station) {
            // Use updateOrCreate to avoid duplicate entries
            Station::updateOrCreate(
                ['code' => $station['code']], // Search by unique code
                $station // Data to insert/update
            );
        }
    }
}