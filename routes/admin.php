<?php

use App\Http\Controllers\BusinessSelectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SA01Controller;
use App\Http\Controllers\SA02Controller;
use App\Http\Controllers\SA03Controller;
use App\Http\Controllers\SA04Controller;
use App\Http\Controllers\AD02Controller;
use App\Http\Controllers\AD03Controller;
use App\Http\Controllers\MD02Controller;
use App\Http\Controllers\MD03Controller;
use App\Http\Controllers\MD04Controller;
use App\Http\Controllers\MD05Controller;
use App\Http\Controllers\AD05Controller;
use App\Http\Controllers\AD06Controller;
use App\Http\Controllers\AD18Controller;
use App\Http\Controllers\ProfileSelectionController;
use App\Http\Controllers\AD04Controller;
use App\Http\Controllers\AD07Controller;
use App\Http\Controllers\AD08Controller;
use App\Http\Controllers\AD17Controller;
use App\Http\Controllers\AD19Controller;
use App\Http\Controllers\AD20Controller;
use App\Http\Controllers\AD21Controller;
use App\Http\Controllers\FA01Controller;
use App\Http\Controllers\FA02Controller;
use App\Http\Controllers\FA03Controller;
use App\Http\Controllers\MD06Controller;
use App\Http\Controllers\MD07Controller;
use App\Http\Controllers\MD08Controller;
use App\Http\Controllers\MD09Controller;
use App\Http\Controllers\MD10Controller;
use App\Http\Controllers\MD11Controller;
use App\Http\Controllers\MD12Controller;
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

Route::get('/AD02', [AD02Controller::class, 'index'])->name('AD02');
Route::get('/AD02/header-table', [AD02Controller::class, 'headerTable'])->name('AD02.header-table');
Route::post('/AD02', [AD02Controller::class, 'create'])->name('AD02.create');
Route::put('/AD02/{id}', [AD02Controller::class, 'update'])->name('AD02.update');
Route::delete('/AD02/{id}', [AD02Controller::class, 'delete'])->name('AD02.delete');

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

Route::get('/MD06', [MD06Controller::class, 'index'])->name('MD06');
Route::get('/MD06/header-table', [MD06Controller::class, 'headerTable'])->name('MD06.header-table');
Route::post('/MD06', [MD06Controller::class, 'create'])->name('MD06.create');
Route::put('/MD06/{id}', [MD06Controller::class, 'update'])->name('MD06.update');
Route::delete('/MD06/{id}', [MD06Controller::class, 'delete'])->name('MD06.delete');

Route::get('/MD07', [MD07Controller::class, 'index'])->name('MD07');
Route::post('/MD07', [MD07Controller::class, 'create'])->name('MD07.create');
Route::put('/MD07/{id}', [MD07Controller::class, 'update'])->name('MD07.update');
Route::delete('/MD07/{id}', [MD07Controller::class, 'delete'])->name('MD07.delete');
Route::get('/MD07/detail-table', [MD07Controller::class, 'detailTable'])->name('MD07.detail-table');
Route::post('/MD07/detail-table', [MD07Controller::class, 'detailCreate'])->name('MD07.detail-table.create');
Route::put('/MD07/detail-table/{id}', [MD07Controller::class, 'detailUpdate'])->name('MD07.detail-table.update');
Route::delete('/MD07/detail-table/{id}', [MD07Controller::class, 'detailDelete'])->name('MD07.detail-table.delete');

Route::get('/MD08', [MD08Controller::class, 'index'])->name('MD08');
Route::get('/MD08/header-table', [MD08Controller::class, 'headerTable'])->name('MD08.header-table');
Route::post('/MD08', [MD08Controller::class, 'create'])->name('MD08.create');
Route::put('/MD08/{id}', [MD08Controller::class, 'update'])->name('MD08.update');
Route::delete('/MD08/{id}', [MD08Controller::class, 'delete'])->name('MD08.delete');

Route::get('/MD09', [MD09Controller::class, 'index'])->name('MD09');
Route::post('/MD09', [MD09Controller::class, 'create'])->name('MD09.create');
Route::put('/MD09/{id}', [MD09Controller::class, 'update'])->name('MD09.update');
Route::delete('/MD09/{id}', [MD09Controller::class, 'delete'])->name('MD09.delete');
Route::get('/MD09/detail-table', [MD09Controller::class, 'detailTable'])->name('MD09.detail-table');
Route::post('/MD09/detail-table', [MD09Controller::class, 'detailCreate'])->name('MD09.detail-table.create');
Route::put('/MD09/detail-table/{id}', [MD09Controller::class, 'detailUpdate'])->name('MD09.detail-table.update');
Route::delete('/MD09/detail-table/{id}', [MD09Controller::class, 'detailDelete'])->name('MD09.detail-table.delete');

Route::get('/MD10', [MD10Controller::class, 'index'])->name('MD10');
Route::get('/MD10/header-table', [MD10Controller::class, 'headerTable'])->name('MD10.header-table');
Route::post('/MD10', [MD10Controller::class, 'create'])->name('MD10.create');
Route::put('/MD10/{id}', [MD10Controller::class, 'update'])->name('MD10.update');
Route::delete('/MD10/{id}', [MD10Controller::class, 'delete'])->name('MD10.delete');
Route::post('/MD10/{id}/update-sequence/{groupId}/{sequenceDirection}', [MD10Controller::class, 'updateSequence'])->name('MD10.update-sequence');

Route::get('/MD11', [MD11Controller::class, 'index'])->name('MD11');
Route::get('/MD11/header-table', [MD11Controller::class, 'headerTable'])->name('MD11.header-table');
Route::post('/MD11', [MD11Controller::class, 'create'])->name('MD11.create');
Route::put('/MD11/{id}', [MD11Controller::class, 'update'])->name('MD11.update');
Route::delete('/MD11/{id}', [MD11Controller::class, 'delete'])->name('MD11.delete');


Route::get('/MD12', [MD12Controller::class, 'index'])->name('MD12');
Route::get('/MD12/detail-table', [MD12Controller::class, 'detailTable'])->name('MD12.detail-table');
Route::post('/MD12', [MD12Controller::class, 'create'])->name('MD12.create');
Route::put('/MD12/{id}', [MD12Controller::class, 'update'])->name('MD12.update');
Route::delete('/MD12/{id}', [MD12Controller::class, 'delete'])->name('MD12.delete');
// New route for product behaviour dropdown
Route::get('/MD12/product-behaviour-dropdown', [MD12Controller::class, 'productBehaviourDropdown'])->name('MD12.product-behaviour-dropdown');
Route::get('/MD12/attribute-selection-form', [MD12Controller::class, 'attributeSelectionForm'])->name('MD12.attribute-selection-form');
Route::post('/MD12/save-product-attribute', [MD12Controller::class, 'saveProductAttribute'])->name('MD12.save-product-attribute');




Route::get('/AD05', [AD05Controller::class, 'index'])->name('AD05');
Route::get('/AD05/detail-table', [AD05Controller::class, 'detailTable'])->name('AD05.detail-table');
Route::post('/AD05', [AD05Controller::class, 'create'])->name('AD05.create');
Route::post('/AD05/detail-table', [AD05Controller::class, 'detailCreate'])->name('AD05.detail-table.create');
Route::put('/AD05/{id}', [AD05Controller::class, 'update'])->name('AD05.update');
Route::delete('/AD05/{id}', [AD05Controller::class, 'delete'])->name('AD05.delete');

Route::get('/AD06', [AD06Controller::class, 'index'])->name('AD06');
Route::get('/AD06/header-table', [AD06Controller::class, 'headerTable'])->name('AD06.header-table');
Route::post('/AD06', [AD06Controller::class, 'create'])->name('AD06.create');
Route::put('/AD06/{id}', [AD06Controller::class, 'update'])->name('AD06.update');
Route::delete('/AD06/{id}', [AD06Controller::class, 'delete'])->name('AD06.delete');

Route::get('/AD07', [AD07Controller::class, 'index'])->name('AD07');
Route::get('/AD07/header-table', [AD07Controller::class, 'headerTable'])->name('AD07.header-table');
Route::post('/AD07', [AD07Controller::class, 'create'])->name('AD07.create');
Route::put('/AD07/{id}', [AD07Controller::class, 'update'])->name('AD07.update');
Route::delete('/AD07/{id}', [AD07Controller::class, 'delete'])->name('AD07.delete');

Route::get('/AD08', [AD08Controller::class, 'index'])->name('AD08');
Route::get('/AD08/header-table', [AD08Controller::class, 'headerTable'])->name('AD08.header-table');
Route::post('/AD08', [AD08Controller::class, 'create'])->name('AD08.create');
Route::put('/AD08/{id}', [AD08Controller::class, 'update'])->name('AD08.update');
Route::delete('/AD08/{id}', [AD08Controller::class, 'delete'])->name('AD08.delete');

Route::get('/AD17', [AD17Controller::class, 'index'])->name('AD17');
Route::get('/AD17/header-table', [AD17Controller::class, 'headerTable'])->name('AD17.header-table');
Route::post('/AD17', [AD17Controller::class, 'create'])->name('AD17.create');
Route::put('/AD17/{id}', [AD17Controller::class, 'update'])->name('AD17.update');
Route::delete('/AD17/{id}', [AD17Controller::class, 'delete'])->name('AD17.delete');


Route::post('/AD18', [AD18Controller::class, 'create'])->name('AD18.create');
Route::delete('/AD18', [AD18Controller::class, 'destroy'])->name('AD18.destroy');


Route::get('/AD19', [AD19Controller::class, 'index'])->name('AD19');
Route::get('/AD19/header-table', [AD19Controller::class, 'headerTable'])->name('AD19.header-table');
Route::post('/AD19', [AD19Controller::class, 'create'])->name('AD19.create');
Route::put('/AD19/{id}', [AD19Controller::class, 'update'])->name('AD19.update');
Route::delete('/AD19/{id}', [AD19Controller::class, 'delete'])->name('AD19.delete');

Route::get('/AD20', [AD20Controller::class, 'index'])->name('AD20');
Route::get('/AD20/header-table', [AD20Controller::class, 'headerTable'])->name('AD20.header-table');
Route::post('/AD20', [AD20Controller::class, 'create'])->name('AD20.create');
Route::put('/AD20/{id}', [AD20Controller::class, 'update'])->name('AD20.update');
Route::delete('/AD20/{id}', [AD20Controller::class, 'delete'])->name('AD20.delete');

Route::get('/AD21', [AD21Controller::class, 'index'])->name('AD21');
Route::get('/AD21/header-table', [AD21Controller::class, 'headerTable'])->name('AD21.header-table');
Route::post('/AD21', [AD21Controller::class, 'create'])->name('AD21.create');
Route::put('/AD21/{id}', [AD21Controller::class, 'update'])->name('AD21.update');
Route::delete('/AD21/{id}', [AD21Controller::class, 'delete'])->name('AD21.delete');


Route::get('/FA01', [FA01Controller::class, 'index'])->name('FA01');
Route::get('/FA01/header-table', [FA01Controller::class, 'headerTable'])->name('FA01.header-table');
Route::post('/FA01', [FA01Controller::class, 'create'])->name('FA01.create');
Route::put('/FA01/{id}', [FA01Controller::class, 'update'])->name('FA01.update');
Route::delete('/FA01/{id}', [FA01Controller::class, 'delete'])->name('FA01.delete');

Route::get('/FA02', [FA02Controller::class, 'index'])->name('FA02');
Route::get('/FA02/header-table', [FA02Controller::class, 'headerTable'])->name('FA02.header-table');
Route::post('/FA02', [FA02Controller::class, 'create'])->name('FA02.create');
Route::put('/FA02/{id}', [FA02Controller::class, 'update'])->name('FA02.update');
Route::delete('/FA02/{id}', [FA02Controller::class, 'delete'])->name('FA02.delete');




Route::get('/business-selection', [BusinessSelectionController::class, 'index'])->name('business-selection');
Route::get('/business-selection/{id}', [BusinessSelectionController::class, 'selectBusiness'])->name('business-selection.select');
Route::get('/profile-selection', [ProfileSelectionController::class, 'index'])->name('profile-selection');
Route::get('/profile-selection/{id}', [ProfileSelectionController::class, 'selectProfile'])->name('profile-selection.select');

Route::post('/search/table/{fragmentcode}/{suffix}', [App\Http\Controllers\SearchSuggestController::class, 'index'])->name('search.index');
Route::post('/search/LAD05/{suffix}', [App\Http\Controllers\SearchSuggestController::class, 'LAD05'])->name('search.LAD05');
Route::post('/search/LMD07/{suffix}', [App\Http\Controllers\SearchSuggestController::class, 'LMD07'])->name('search.LMD07');
Route::post('/search/LMD09/{suffix}', [App\Http\Controllers\SearchSuggestController::class, 'LMD09'])->name('search.LMD09');
Route::post('/search/LMD12/{suffix}', [App\Http\Controllers\SearchSuggestController::class, 'LMD12'])->name('search.LMD12');