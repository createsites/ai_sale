<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CreditController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/credits/topup', [CreditController::class, 'showTopUpForm'])->name('credits.topup');
    Route::post('/credits/topup', [CreditController::class, 'topUpCredits'])->name('credits.process');

});

Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'callback']);
