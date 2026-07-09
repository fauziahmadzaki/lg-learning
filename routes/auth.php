<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('login', [AuthController::class, 'login']);

    Route::get('forgot-password', [PasswordController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('reset-password/{token}', [PasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('reset-password', [PasswordController::class, 'resetPassword'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('confirm-password', [PasswordController::class, 'showConfirmPassword'])
        ->name('password.confirm');

    Route::post('confirm-password', [PasswordController::class, 'confirmPassword']);

    Route::put('password', [PasswordController::class, 'updatePassword'])
        ->name('password.update');

    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
});
