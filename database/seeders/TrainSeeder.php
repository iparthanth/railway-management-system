<?php

namespace Database\Seeders;

use App\Models\Train;
use App\Models\TrainClass;
use Illuminate\Database\Seeder;

class TrainSeeder extends Seeder
{
    public function run()
    {
        $trains = [
            [
                'name' => 'CHATTALA EXPRESS',
                'number' => '801',
                'type' => 'express',
                'available_classes' => ['SNIGDHA', 'AC_S', 'S_CHAIR'],
                'running_days' => ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
                'classes' => [
                    ['class_name' => 'SNIGDHA', 'base_fare' => 855, 'total_seats' => 72],
                    ['class_name' => 'AC_S', 'base_fare' => 922, 'total_seats' => 48],
                    ['class_name' => 'S_CHAIR', 'base_fare' => 405, 'total_seats' => 96],
                ]
            ],
            [
                'name' => 'MOHANAGAR EXPRESS',
                'number' => '721',
                'type' => 'express',
                'available_classes' => ['S_CHAIR', 'AC_S', 'SNIGDHA'],
                'running_days' => ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
                'classes' => [
                    ['class_name' => 'S_CHAIR', 'base_fare' => 405, 'total_seats' => 96],
                    ['class_name' => 'AC_S', 'base_fare' => 922, 'total_seats' => 48],
                    ['class_name' => 'SNIGDHA', 'base_fare' => 777, 'total_seats' => 72],
                ]
            ],
            [
                'name' => 'MOHANAGAR GODHULI',
                'number' => '703',
                'type' => 'express',
                'available_classes' => ['SNIGDHA', 'S_CHAIR', 'F_SEAT', 'AC_S'],
                'running_days' => ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
                'classes' => [
                    ['class_name' => 'SNIGDHA', 'base_fare' => 777, 'total_seats' => 72],
                    ['class_name' => 'S_CHAIR', 'base_fare' => 405, 'total_seats' => 96],
                    ['class_name' => 'F_SEAT', 'base_fare' => 321, 'total_seats' => 120],
                    ['class_name' => 'AC_S', 'base_fare' => 922, 'total_seats' => 48],
                ]
            ],
            [
                'name' => 'SUBORNO EXPRESS',
                'number' => '701',
                'type' => 'express',
                'available_classes' => ['S_CHAIR', 'SNIGDHA', 'AC_S'],
                'running_days' => ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
                'classes' => [
                    ['class_name' => 'S_CHAIR', 'base_fare' => 450, 'total_seats' => 96],
                    ['class_name' => 'SNIGDHA', 'base_fare' => 855, 'total_seats' => 72],
                    ['class_name' => 'AC_S', 'base_fare' => 1025, 'total_seats' => 48],
                ]
            ],
            [
                'name' => 'SONAR BANGLA EXPRESS',
                'number' => '787',
                'type' => 'express',
                'available_classes' => ['AC_S', 'F_SEAT', 'S_CHAIR', 'SNIGDHA'],
                'running_days' => ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
                'classes' => [
                    ['class_name' => 'AC_S', 'base_fare' => 1025, 'total_seats' => 48],
                    ['class_name' => 'F_SEAT', 'base_fare' => 321, 'total_seats' => 120],
                    ['class_name' => 'S_CHAIR', 'base_fare' => 450, 'total_seats' => 96],
                    ['class_name' => 'SNIGDHA', 'base_fare' => 855, 'total_seats' => 72],
                ]
            ],
            [
                'name' => 'PARJOTAK EXPRESS',
                'number' => '815',
                'type' => 'express',
                'available_classes' => ['SNIGDHA', 'S_CHAIR', 'AC_B'],
                'running_days' => ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
                'classes' => [
                    ['class_name' => 'SNIGDHA', 'base_fare' => 855, 'total_seats' => 72],
                    ['class_name' => 'S_CHAIR', 'base_fare' => 450, 'total_seats' => 96],
                    ['class_name' => 'AC_B', 'base_fare' => 1590, 'total_seats' => 32],
                ]
            ],
            [
                'name' => 'TURNA',
                'number' => '741',
                'type' => 'express',
                'available_classes' => ['S_CHAIR', 'F_BERTH', 'AC_B', 'SNIGDHA'],
                'running_days' => ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
                'classes' => [
                    ['class_name' => 'S_CHAIR', 'base_fare' => 405, 'total_seats' => 96],
                    ['class_name' => 'F_BERTH', 'base_fare' => 982, 'total_seats' => 64],
                    ['class_name' => 'AC_B', 'base_fare' => 1448, 'total_seats' => 32],
                    ['class_name' => 'SNIGDHA', 'base_fare' => 777, 'total_seats' => 72],
                ]
            ],
            [
                'name' => 'RANGPUR EXPRESS',
                'number' => '771',
                'type' => 'express',
                'available_classes' => ['S_CHAIR', 'SNIGDHA', 'F_SEAT', 'AC_S'],
                'running_days' => ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
                'classes' => [
                    ['class_name' => 'S_CHAIR', 'base_fare' => 450, 'total_seats' => 96],
                    ['class_name' => 'SNIGDHA', 'base_fare' => 855, 'total_seats' => 72],
                    ['class_name' => 'F_SEAT', 'base_fare' => 321, 'total_seats' => 120],
                    ['class_name' => 'AC_S', 'base_fare' => 1025, 'total_seats' => 48],
                ]
            ],
        ];

        foreach ($trains as $trainData) {
            $classes = $trainData['classes'];
            unset($trainData['classes']);
            
            $train = Train::create($trainData);
            
            foreach ($classes as $classData) {
                TrainClass::create([
                    'train_id' => $train->id,
                    'class_name' => $classData['class_name'],
                    'base_fare' => $classData['base_fare'],
                    'total_seats' => $classData['total_seats'],
                ]);
            }
        }
    }
}
