<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StationSeeder::class,
            RouteSeeder::class,
            TrainSeeder::class,
            TrainRouteSeeder::class, // Assign trains to routes after both exist
            SeatSeeder::class,
            // Optional seeders for testing
            // SampleBookingsSeeder::class,
        ]);

        $this->command->info('🚂 Railway Management System database seeded successfully!');
        $this->command->info('📊 You can now:');
        $this->command->info('   - Search for trains between stations');
        $this->command->info('   - Book tickets with seat selection');
        $this->command->info('   - Process payments via Stripe');
        $this->command->info('   - Manage seat availability');
        $this->command->newLine();
        $this->command->info('🔑 Default credentials will be created by UserSeeder');
        $this->command->info('✅ All deprecated models and seeders have been removed');
        $this->command->info('✅ TrainController now uses proper database models');
    }
}
