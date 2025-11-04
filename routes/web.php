<?php

use App\Http\Controllers\BusinessSelectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForcePasswordChangeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SA05Controller;
use App\Http\Controllers\SA10Controller;
use App\Http\Controllers\SA15Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/verify-email/{token}', [EmailVerificationController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/email/verification-resend', [EmailVerificationController::class, 'resendVerificationEmail'])->name('verification.resend');
Route::get('/set-password', [ForcePasswordChangeController::class, 'index'])->name('password.set');
Route::post('/set-password', [ForcePasswordChangeController::class, 'setPassword'])->name('password.set.update');

Auth::routes();

Route::get('/', [MainController::class, 'index'])->name('home');
Route::redirect('/home', '/');

Route::get('/DASH', [DashboardController::class, 'index'])->name('DASH');

Route::get('/SA05', [SA05Controller::class, 'index'])->name('SA05');
Route::get('/SA05/header-table', [SA05Controller::class, 'headerTable'])->name('SA05.header-table');
Route::post('/SA05', [SA05Controller::class, 'create'])->name('SA05.create');
Route::put('/SA05/{id}', [SA05Controller::class, 'update'])->name('SA05.update');
Route::delete('/SA05/{id}', [SA05Controller::class, 'delete'])->name('SA05.delete');


Route::get('/SA10', [SA10Controller::class, 'index'])->name('SA10');
Route::get('/SA10/header-table', [SA10Controller::class, 'headerTable'])->name('SA10.header-table');
Route::post('/SA10', [SA10Controller::class, 'create'])->name('SA10.create');
Route::put('/SA10/{id}', [SA10Controller::class, 'update'])->name('SA10.update');
Route::delete('/SA10/{id}', [SA10Controller::class, 'delete'])->name('SA10.delete');

Route::get('/SA15', [SA15Controller::class, 'index'])->name('SA15');
Route::get('/SA15/header-table', [SA15Controller::class, 'headerTable'])->name('SA15.header-table');
Route::post('/SA15', [SA15Controller::class, 'create'])->name('SA15.create');
Route::put('/SA15/{id}', [SA15Controller::class, 'update'])->name('SA15.update');
Route::delete('/SA15/{id}', [SA15Controller::class, 'delete'])->name('SA15.delete');


Route::get('/business-selection/{id}', [BusinessSelectionController::class, 'selectBusiness'])->name('business.selection');
