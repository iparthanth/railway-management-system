<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/search-trains', [HomeController::class, 'searchTrains'])->name('search.trains');
Route::get('/api/stations', [HomeController::class, 'getStations'])->name('api.stations');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Train Information Routes
Route::get('/train-information', [TrainController::class, 'information'])->name('train.information');

// Ticket Verification Routes
Route::get('/verify-ticket', [TicketController::class, 'verify'])->name('ticket.verify');
Route::post('/verify-ticket', [TicketController::class, 'checkTicket'])->name('ticket.check');

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/purchase-history', [AuthController::class, 'purchaseHistory'])->name('purchase.history');
    
    // Booking Routes
    Route::get('/booking/select-seats', [BookingController::class, 'selectSeats'])->name('booking.select-seats');
    Route::post('/booking/confirm-seats', [BookingController::class, 'confirmSeats'])->name('booking.confirm-seats');
    Route::post('/booking/store', [BookingController::class, 'storeBooking'])->name('booking.store');
    Route::get('/booking/{booking}/payment', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{booking}/process-payment', [BookingController::class, 'processPayment'])->name('booking.process-payment');
    Route::get('/booking/{booking}/success', [BookingController::class, 'success'])->name('booking.success');
});
