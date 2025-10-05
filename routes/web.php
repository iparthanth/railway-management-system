<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

// Root → Login
Route::get('/', function () {
    return redirect()->route('login');
})->name('root');

// Auth scaffolding
Auth::routes();

// After login → your custom Home page
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Train Routes (public now; add ->middleware('auth') if you want them protected)
Route::get('/trains', [TrainController::class, 'index'])->name('trains.index');
Route::post('/trains/search', [TrainController::class, 'search'])->name('trains.search');
Route::get('/trains/{id}/seats', [TrainController::class, 'seats'])->name('trains.seats');
Route::post('/trains/{id}/passengers', [TrainController::class, 'passengerForm'])->name('trains.passengers');
Route::get('/trains/{id}/passengers', [TrainController::class, 'passengerForm'])->name('trains.passengers.show');
Route::post('/trains/{id}/book', [TrainController::class, 'storeBooking'])->name('trains.book');

// Booking Routes
Route::prefix('bookings')->name('bookings.')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/{id}', [BookingController::class, 'show'])->name('show');
});

// Payment Routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/create/{booking}', [PaymentController::class, 'create'])->name('create');
    Route::get('/success/{booking}', [PaymentController::class, 'success'])->name('success');
    Route::get('/cancel/{booking}', [PaymentController::class, 'cancel'])->name('cancel');
    Route::post('/webhook/stripe', [PaymentController::class, 'stripeWebhook'])->name('webhook.stripe');
});