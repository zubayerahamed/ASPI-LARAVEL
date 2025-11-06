<?php

use App\Http\Controllers\BusinessSelectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForcePasswordChangeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SA01Controller;
use App\Http\Controllers\SA02Controller;
use App\Http\Controllers\SA03Controller;
use App\Http\Controllers\SA04Controller;
use App\Http\Controllers\SA05Controller;
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

Route::get('/SA01', [SA01Controller::class, 'index'])->name('SA01');
Route::get('/SA01/header-table', [SA01Controller::class, 'headerTable'])->name('SA01.header-table');
Route::post('/SA01', [SA01Controller::class, 'create'])->name('SA01.create');
Route::put('/SA01/{id}', [SA01Controller::class, 'update'])->name('SA01.update');
Route::delete('/SA01/{id}', [SA01Controller::class, 'delete'])->name('SA01.delete');


Route::get('/SA02', [SA02Controller::class, 'index'])->name('SA02');
Route::get('/SA02/header-table', [SA02Controller::class, 'headerTable'])->name('SA02.header-table');
Route::post('/SA02', [SA02Controller::class, 'create'])->name('SA02.create');
Route::put('/SA02/{id}', [SA02Controller::class, 'update'])->name('SA02.update');
Route::delete('/SA02/{id}', [SA02Controller::class, 'delete'])->name('SA02.delete');

Route::get('/SA03', [SA03Controller::class, 'index'])->name('SA03');
Route::get('/SA03/header-table', [SA03Controller::class, 'headerTable'])->name('SA03.header-table');
Route::post('/SA03', [SA03Controller::class, 'create'])->name('SA03.create');
Route::put('/SA03/{id}', [SA03Controller::class, 'update'])->name('SA03.update');
Route::delete('/SA03/{id}', [SA03Controller::class, 'delete'])->name('SA03.delete');

Route::get('/SA04', [SA04Controller::class, 'index'])->name('SA04');
Route::get('/SA04/header-table', [SA04Controller::class, 'headerTable'])->name('SA04.header-table');
Route::post('/SA04', [SA04Controller::class, 'create'])->name('SA04.create');
Route::put('/SA04/{id}', [SA04Controller::class, 'update'])->name('SA04.update');
Route::delete('/SA04/{id}', [SA04Controller::class, 'delete'])->name('SA04.delete');

Route::get('/SA05', [SA05Controller::class, 'index'])->name('SA05');
Route::get('/SA05/header-table', [SA05Controller::class, 'headerTable'])->name('SA05.header-table');
Route::post('/SA05', [SA05Controller::class, 'create'])->name('SA05.create');
Route::put('/SA05/{id}', [SA05Controller::class, 'update'])->name('SA05.update');
Route::delete('/SA05/{id}', [SA05Controller::class, 'delete'])->name('SA05.delete');


Route::get('/business-selection/{id}', [BusinessSelectionController::class, 'selectBusiness'])->name('business.selection');
