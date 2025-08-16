<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
    
        DB::table('seats')->insert([
            ['coach_id' => 1, 'seat_number' => 'A1', 'row_number' => 1, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A2', 'row_number' => 1, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A3', 'row_number' => 2, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A4', 'row_number' => 2, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A5', 'row_number' => 3, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A6', 'row_number' => 3, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A7', 'row_number' => 4, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A8', 'row_number' => 4, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A9', 'row_number' => 5, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 1, 'seat_number' => 'A10', 'row_number' => 5, 'position' => 'aisle', 'is_available' => true],
        ]);

        
        DB::table('seats')->insert([
            ['coach_id' => 2, 'seat_number' => 'B1', 'row_number' => 1, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B2', 'row_number' => 1, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B3', 'row_number' => 2, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B4', 'row_number' => 2, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B5', 'row_number' => 3, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B6', 'row_number' => 3, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B7', 'row_number' => 4, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B8', 'row_number' => 4, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B9', 'row_number' => 5, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 2, 'seat_number' => 'B10', 'row_number' => 5, 'position' => 'aisle', 'is_available' => true],
        ]);

        
        DB::table('seats')->insert([
            ['coach_id' => 3, 'seat_number' => 'C1', 'row_number' => 1, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C2', 'row_number' => 1, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C3', 'row_number' => 2, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C4', 'row_number' => 2, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C5', 'row_number' => 3, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C6', 'row_number' => 3, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C7', 'row_number' => 4, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C8', 'row_number' => 4, 'position' => 'aisle', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C9', 'row_number' => 5, 'position' => 'window', 'is_available' => true],
            ['coach_id' => 3, 'seat_number' => 'C10', 'row_number' => 5, 'position' => 'aisle', 'is_available' => true],
        ]);
    }
}
