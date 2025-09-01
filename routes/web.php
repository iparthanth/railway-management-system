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

// Docs PDF (detailed, per-block)
Route::get('/docs/code-explanation.pdf', [App\Http\Controllers\DocController::class, 'reportPdf'])->name('docs.reportPdf');

// Payment Routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/create/{booking}', [App\Http\Controllers\PaymentController::class, 'create'])->name('create');
    Route::post('/stripe/intent/{booking}', [App\Http\Controllers\PaymentController::class, 'createStripeIntent'])->name('stripe.intent');
    Route::post('/stripe/confirm', [App\Http\Controllers\PaymentController::class, 'confirmStripePayment'])->name('stripe.confirm');
    Route::get('/currencies', [App\Http\Controllers\PaymentController::class, 'getSupportedCurrencies'])->name('currencies');
    Route::get('/status/{payment}', [App\Http\Controllers\PaymentController::class, 'getPaymentStatus'])->name('status');
    Route::post('/webhook/stripe', [App\Http\Controllers\PaymentController::class, 'stripeWebhook'])->name('webhook.stripe');
});

