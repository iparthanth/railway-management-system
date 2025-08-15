<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Train;
use App\Models\Route;

class TrainRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->assignRoutesToTrains();
    }

    private function assignRoutesToTrains()
    {
        $routes = Route::with(['fromStation', 'toStation'])->get();
        $trains = Train::all();

        // Route assignments based on train numbers
        $routeAssignments = [
            'TR-001' => ['Dhaka' => 'Chittagong'], // Chittagong Express
            'TR-002' => ['Dhaka' => 'Chittagong'], // Chittagong Mail
            'TR-003' => ['Chittagong' => 'Dhaka'], // Dhaka Express
            'TR-004' => ['Dhaka' => 'Sylhet'],     // Sylhet Express
            'TR-005' => ['Dhaka' => 'Rajshahi'],   // Rajshahi Express
            'TR-006' => ['Dhaka' => 'Khulna'],     // Khulna Express
            'TR-007' => ['Dhaka' => 'Barisal'],    // Barisal Express
            'TR-008' => ['Dhaka' => 'Tangail'],    // Tangail Express
            'TR-009' => ['Sylhet' => 'Dhaka'],     // Sylhet Mail
            'TR-010' => ['Rajshahi' => 'Dhaka'],   // Rajshahi Mail
            'TR-011' => ['Dhaka' => 'Chittagong'], // Intercity Express
        ];

        foreach ($trains as $train) {
            if (isset($routeAssignments[$train->train_number])) {
                $assignment = $routeAssignments[$train->train_number];
                $fromStation = key($assignment);
                $toStation = $assignment[$fromStation];

                $route = $routes->first(function ($route) use ($fromStation, $toStation) {
                    return $route->fromStation->name === $fromStation && 
                           $route->toStation->name === $toStation;
                });

                if ($route) {
                    $train->routes()->attach($route->id);
                    $this->command->info("✅ Assigned {$train->name} ({$train->train_number}) to route {$fromStation} → {$toStation}");
                } else {
                    $this->command->warn("⚠️  Route not found for {$train->name}: {$fromStation} → {$toStation}");
                }
            }
        }
    }
}