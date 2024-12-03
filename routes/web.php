<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guests')->group(function () {
    Route::group(['prefix' => '/auth', 'as' => 'auth.'], function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });
    
    Route::get('/', [DashboardController::class, 'home'])->name('home');
});

Route::group(['middleware' => ['authenticate']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});