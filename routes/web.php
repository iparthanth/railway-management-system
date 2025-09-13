<?php

use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Train Routes
Route::get('/trains', [App\Http\Controllers\TrainController::class, 'index'])->name('trains.index');
Route::post('/trains/search', [App\Http\Controllers\TrainController::class, 'search'])->name('trains.search');
Route::get('/trains/{id}/seats', [App\Http\Controllers\TrainController::class, 'seats'])->name('trains.seats');
Route::post('/trains/{id}/passengers', [App\Http\Controllers\TrainController::class, 'passengerForm'])->name('trains.passengers');
Route::get('/trains/{id}/passengers', [App\Http\Controllers\TrainController::class, 'passengerForm'])->name('trains.passengers.show');
Route::post('/trains/{id}/book', [App\Http\Controllers\TrainController::class, 'storeBooking'])->name('trains.book');



// Booking Routes
Route::prefix('bookings')->name('bookings.')->group(function () {
    Route::get('/', [App\Http\Controllers\BookingController::class, 'index'])->name('index');
    Route::get('/{id}', [App\Http\Controllers\BookingController::class, 'show'])->name('show');
});

// Payment Routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/create/{booking}', [App\Http\Controllers\PaymentController::class, 'create'])->name('create');
    Route::get('/success/{booking}', [App\Http\Controllers\PaymentController::class, 'success'])->name('success');
    Route::get('/cancel/{booking}', [App\Http\Controllers\PaymentController::class, 'cancel'])->name('cancel');
    Route::post('/webhook/stripe', [App\Http\Controllers\PaymentController::class, 'stripeWebhook'])->name('webhook.stripe');
});

