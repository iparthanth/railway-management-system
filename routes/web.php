<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Authentication routes (login only)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Create demo user route (for testing)
Route::get('/create-demo-user', [AuthController::class, 'createDemoUser']);

// Home routes (both root and /home should work)
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    return view('home');
})->name('home');

Route::get('/home', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    return view('home');
});

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    
    // Simple search route - just shows static results
    Route::post('/search-trains', function() {
        return view('search-results');
    })->name('search.trains');
    
    // Simple booking page
    Route::get('/booking', function() {
        return view('booking.create');
    })->name('booking.create');
    
    
    // Contact page
    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');
    
});
