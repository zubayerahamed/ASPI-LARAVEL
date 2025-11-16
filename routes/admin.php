<?php

use App\Http\Controllers\BusinessSelectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SA01Controller;
use App\Http\Controllers\SA02Controller;
use App\Http\Controllers\SA03Controller;
use App\Http\Controllers\SA04Controller;
use App\Http\Controllers\AD01Controller;
use App\Http\Controllers\AD02Controller;
use App\Http\Controllers\AD03Controller;
use App\Http\Controllers\AD04Controller;
use App\Http\Controllers\AD05Controller;
use App\Http\Controllers\AD06Controller;
use App\Http\Controllers\AD07Controller;
use App\Http\Controllers\AD18Controller;
use App\Http\Controllers\SA05Controller;
use Illuminate\Support\Facades\Route;

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

Route::get('/AD01', [AD01Controller::class, 'index'])->name('AD01');
Route::get('/AD01/header-table', [AD01Controller::class, 'headerTable'])->name('AD01.header-table');
Route::post('/AD01', [AD01Controller::class, 'create'])->name('AD01.create');
Route::put('/AD01/{id}', [AD01Controller::class, 'update'])->name('AD01.update');
Route::delete('/AD01/{id}', [AD01Controller::class, 'delete'])->name('AD01.delete');

Route::get('/AD02', [AD02Controller::class, 'index'])->name('AD02');
Route::get('/AD02/header-table', [AD02Controller::class, 'headerTable'])->name('AD02.header-table');
Route::post('/AD02', [AD02Controller::class, 'create'])->name('AD02.create');
Route::put('/AD02/{id}', [AD02Controller::class, 'update'])->name('AD02.update');
Route::delete('/AD02/{id}', [AD02Controller::class, 'delete'])->name('AD02.delete');


Route::get('/SA05', [SA05Controller::class, 'index'])->name('SA05');
Route::get('/SA05/header-table', [SA05Controller::class, 'headerTable'])->name('SA05.header-table');
Route::post('/SA05', [SA05Controller::class, 'create'])->name('SA05.create');
Route::put('/SA05/{id}', [SA05Controller::class, 'update'])->name('SA05.update');
Route::delete('/SA05/{id}', [SA05Controller::class, 'delete'])->name('SA05.delete');

Route::get('/AD03', [AD03Controller::class, 'index'])->name('AD03');
Route::get('/AD03/header-table', [AD03Controller::class, 'headerTable'])->name('AD03.header-table');
Route::post('/AD03', [AD03Controller::class, 'create'])->name('AD03.create');
Route::put('/AD03/{id}', [AD03Controller::class, 'update'])->name('AD03.update');
Route::delete('/AD03/{id}', [AD03Controller::class, 'delete'])->name('AD03.delete');

Route::get('/AD04', [AD04Controller::class, 'index'])->name('AD04');
Route::get('/AD04/header-table', [AD04Controller::class, 'headerTable'])->name('AD04.header-table');
Route::post('/AD04', [AD04Controller::class, 'create'])->name('AD04.create');
Route::put('/AD04/{id}', [AD04Controller::class, 'update'])->name('AD04.update');
Route::delete('/AD04/{id}', [AD04Controller::class, 'delete'])->name('AD04.delete');

Route::get('/AD05', [AD05Controller::class, 'index'])->name('AD05');
Route::get('/AD05/header-table', [AD05Controller::class, 'headerTable'])->name('AD05.header-table');
Route::post('/AD05', [AD05Controller::class, 'create'])->name('AD05.create');
Route::put('/AD05/{id}', [AD05Controller::class, 'update'])->name('AD05.update');
Route::delete('/AD05/{id}', [AD05Controller::class, 'delete'])->name('AD05.delete');



Route::get('/AD06', [AD06Controller::class, 'index'])->name('AD06');
Route::get('/AD06/header-table', [AD06Controller::class, 'headerTable'])->name('AD06.header-table');
Route::post('/AD06', [AD06Controller::class, 'create'])->name('AD06.create');
Route::put('/AD06/{id}', [AD06Controller::class, 'update'])->name('AD06.update');
Route::delete('/AD06/{id}', [AD06Controller::class, 'delete'])->name('AD06.delete');


Route::get('/AD07', [AD07Controller::class, 'index'])->name('AD07');
Route::get('/AD07/detail-table', [AD07Controller::class, 'detailTable'])->name('AD07.detail-table');
Route::post('/AD07', [AD07Controller::class, 'create'])->name('AD07.create');
Route::put('/AD07/{id}', [AD07Controller::class, 'update'])->name('AD07.update');
Route::delete('/AD07/{id}', [AD07Controller::class, 'delete'])->name('AD07.delete');



Route::post('/AD18', [AD18Controller::class, 'create'])->name('AD18.create');
Route::delete('/AD18', [AD18Controller::class, 'destroy'])->name('AD18.destroy');

Route::get('/business-selection/{id}', [BusinessSelectionController::class, 'selectBusiness'])->name('business.selection');

Route::post('/search/table/{fragmentcode}/{suffix}', [App\Http\Controllers\SearchSuggestController::class, 'index'])->name('search.index');
Route::post('/search/LAD07/{suffix}', [App\Http\Controllers\SearchSuggestController::class, 'LAD07'])->name('search.LAD07');