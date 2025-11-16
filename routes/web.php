<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForcePasswordChangeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/verify-email/{token}', [EmailVerificationController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/email/verification-resend', [EmailVerificationController::class, 'resendVerificationEmail'])->name('verification.resend');
Route::get('/set-password', [ForcePasswordChangeController::class, 'index'])->name('password.set');
Route::post('/set-password', [ForcePasswordChangeController::class, 'setPassword'])->name('password.set.update');

Auth::routes();

Route::get('/', function () {
    return "Welcome to the Application!";
});

