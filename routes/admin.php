<?php

use App\Http\Controllers\BusinessSelectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SA01Controller;
use App\Http\Controllers\SA02Controller;
use App\Http\Controllers\SA03Controller;
use App\Http\Controllers\SA04Controller;
use App\Http\Controllers\SA05Controller;
use App\Http\Controllers\SA06Controller;
use App\Http\Controllers\MD02Controller;
use App\Http\Controllers\MD03Controller;
use App\Http\Controllers\MD04Controller;
use App\Http\Controllers\MD05Controller;
use App\Http\Controllers\AD02Controller;
use App\Http\Controllers\AD03Controller;
use App\Http\Controllers\AD18Controller;
use App\Http\Controllers\ProfileSelectionController;
use App\Http\Controllers\SA07Controller;
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

Route::get('/SA05', [SA05Controller::class, 'index'])->name('SA05');
Route::get('/SA05/header-table', [SA05Controller::class, 'headerTable'])->name('SA05.header-table');
Route::post('/SA05', [SA05Controller::class, 'create'])->name('SA05.create');
Route::put('/SA05/{id}', [SA05Controller::class, 'update'])->name('SA05.update');
Route::delete('/SA05/{id}', [SA05Controller::class, 'delete'])->name('SA05.delete');

Route::get('/SA06', [SA06Controller::class, 'index'])->name('SA06');
Route::get('/SA06/header-table', [SA06Controller::class, 'headerTable'])->name('SA06.header-table');
Route::post('/SA06', [SA06Controller::class, 'create'])->name('SA06.create');
Route::put('/SA06/{id}', [SA06Controller::class, 'update'])->name('SA06.update');
Route::delete('/SA06/{id}', [SA06Controller::class, 'delete'])->name('SA06.delete');


Route::get('/SA07', [SA07Controller::class, 'index'])->name('SA07');
Route::get('/SA07/header-table', [SA07Controller::class, 'headerTable'])->name('SA07.header-table');
Route::post('/SA07', [SA07Controller::class, 'create'])->name('SA07.create');
Route::put('/SA07/{id}', [SA07Controller::class, 'update'])->name('SA07.update');
Route::delete('/SA07/{id}', [SA07Controller::class, 'delete'])->name('SA07.delete');

Route::get('/MD02', [MD02Controller::class, 'index'])->name('MD02');
Route::get('/MD02/header-table', [MD02Controller::class, 'headerTable'])->name('MD02.header-table');
Route::post('/MD02', [MD02Controller::class, 'create'])->name('MD02.create');
Route::put('/MD02/{id}', [MD02Controller::class, 'update'])->name('MD02.update');
Route::delete('/MD02/{id}', [MD02Controller::class, 'delete'])->name('MD02.delete');

Route::get('/MD03', [MD03Controller::class, 'index'])->name('MD03');
Route::get('/MD03/header-table', [MD03Controller::class, 'headerTable'])->name('MD03.header-table');
Route::post('/MD03', [MD03Controller::class, 'create'])->name('MD03.create');
Route::put('/MD03/{id}', [MD03Controller::class, 'update'])->name('MD03.update');
Route::delete('/MD03/{id}', [MD03Controller::class, 'delete'])->name('MD03.delete');

Route::get('/MD04', [MD04Controller::class, 'index'])->name('MD04');
Route::get('/MD04/header-table', [MD04Controller::class, 'headerTable'])->name('MD04.header-table');
Route::post('/MD04', [MD04Controller::class, 'create'])->name('MD04.create');
Route::put('/MD04/{id}', [MD04Controller::class, 'update'])->name('MD04.update');
Route::delete('/MD04/{id}', [MD04Controller::class, 'delete'])->name('MD04.delete');



Route::get('/MD05', [MD05Controller::class, 'index'])->name('MD05');
Route::get('/MD05/header-table', [MD05Controller::class, 'headerTable'])->name('MD05.header-table');
Route::post('/MD05', [MD05Controller::class, 'create'])->name('MD05.create');
Route::put('/MD05/{id}', [MD05Controller::class, 'update'])->name('MD05.update');
Route::delete('/MD05/{id}', [MD05Controller::class, 'delete'])->name('MD05.delete');


Route::get('/AD02', [AD02Controller::class, 'index'])->name('AD02');
Route::get('/AD02/detail-table', [AD02Controller::class, 'detailTable'])->name('AD02.detail-table');
Route::post('/AD02', [AD02Controller::class, 'create'])->name('AD02.create');
Route::post('/AD02/detail-table', [AD02Controller::class, 'detailCreate'])->name('AD02.detail-table.create');
Route::put('/AD02/{id}', [AD02Controller::class, 'update'])->name('AD02.update');
Route::delete('/AD02/{id}', [AD02Controller::class, 'delete'])->name('AD02.delete');

Route::get('/AD03', [AD03Controller::class, 'index'])->name('AD03');
Route::get('/AD03/header-table', [AD03Controller::class, 'headerTable'])->name('AD03.header-table');
Route::post('/AD03', [AD03Controller::class, 'create'])->name('AD03.create');
Route::put('/AD03/{id}', [AD03Controller::class, 'update'])->name('AD03.update');
Route::delete('/AD03/{id}', [AD03Controller::class, 'delete'])->name('AD03.delete');


Route::post('/AD18', [AD18Controller::class, 'create'])->name('AD18.create');
Route::delete('/AD18', [AD18Controller::class, 'destroy'])->name('AD18.destroy');

Route::get('/business-selection', [BusinessSelectionController::class, 'index'])->name('business-selection');
Route::get('/business-selection/{id}', [BusinessSelectionController::class, 'selectBusiness'])->name('business-selection.select');
Route::get('/profile-selection', [ProfileSelectionController::class, 'index'])->name('profile-selection');
Route::get('/profile-selection/{id}', [ProfileSelectionController::class, 'selectProfile'])->name('profile-selection.select');

Route::post('/search/table/{fragmentcode}/{suffix}', [App\Http\Controllers\SearchSuggestController::class, 'index'])->name('search.index');
Route::post('/search/LAD02/{suffix}', [App\Http\Controllers\SearchSuggestController::class, 'LAD02'])->name('search.LAD02');