<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\MainController::class, 'index'])->name('home');
Route::redirect('/home', '/');

Route::get('/DASH', [App\Http\Controllers\DashboardController::class, 'index'])->name('DASH');

Route::get('/SA05', [App\Http\Controllers\SA05::class, 'index'])->name('SA05');
Route::get('/SA05/header-table', [App\Http\Controllers\SA05::class, 'headerTable'])->name('SA05.header-table');
Route::post('/SA05', [App\Http\Controllers\SA05::class, 'create'])->name('SA05.create');
Route::put('/SA05/{id}', [App\Http\Controllers\SA05::class, 'update'])->name('SA05.update');
Route::delete('/SA05/{id}', [App\Http\Controllers\SA05::class, 'delete'])->name('SA05.delete');


Route::get('/SA10', [App\Http\Controllers\SA10::class, 'index'])->name('SA10');
