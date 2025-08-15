<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainSearchController;
use App\Http\Controllers\SeatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API routes (no authentication required)
Route::prefix('trains')->group(function () {
    Route::get('/search', [TrainSearchController::class, 'quickSearch']);
    Route::get('/stations', [TrainSearchController::class, 'getStations']);
    Route::get('/popular-routes', [TrainSearchController::class, 'getPopularRoutes']);
    Route::get('/{train}/details', [TrainSearchController::class, 'getTrainDetails']);
});

Route::prefix('seats')->group(function () {
    Route::get('/map', [SeatController::class, 'getSeatMap']);
    Route::get('/available', [SeatController::class, 'getAvailableSeats']);
    Route::get('/{seat}/details', [SeatController::class, 'getSeatDetails']);
    Route::get('/{seat}/adjacent', [SeatController::class, 'getAdjacentSeats']);

    // These require some form of session/token validation
    Route::post('/select', [SeatController::class, 'selectSeats']);
    Route::post('/release', [SeatController::class, 'releaseSeats']);
});

Route::prefix('train-status')->group(function () {
    Route::get('/system', [\App\Http\Controllers\TrainStatusController::class, 'getSystemStatus']);
    Route::get('/{train}/{date?}', [\App\Http\Controllers\TrainStatusController::class, 'getLiveStatus']);
    Route::get('/{train}/route/{date?}', [\App\Http\Controllers\TrainStatusController::class, 'getRouteProgress']);
    Route::post('/track', [\App\Http\Controllers\TrainStatusController::class, 'trackTrain']);
});
