<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API routes for mobile app
Route::prefix('v1')->group(function () {
    // Station routes
    Route::get('/stations', [\App\Http\Controllers\Api\StationController::class, 'index']);
    Route::get('/stations/search', [\App\Http\Controllers\Api\StationController::class, 'search']);
    
    // Train routes
    Route::get('/trains', [\App\Http\Controllers\Api\TrainController::class, 'index']);
    Route::get('/trains/{train}', [\App\Http\Controllers\Api\TrainController::class, 'show']);
    Route::post('/trains/search', [\App\Http\Controllers\Api\TrainController::class, 'search']);
    
    // Ticket verification
    Route::post('/tickets/verify', [\App\Http\Controllers\Api\TicketController::class, 'verify']);
});
