<?php

use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/series');
});




Route::controller(SeriesController::class)->group(function(){

	Route::get('/series','index')->name('series.index');
	Route::get('/series/create','create')->name('series.create');
	Route::post('/series/salvar','store')->name('series.store');
    Route::delete('/series/destroy/{serie}',[SeriesController::class,'destroy'])->name('series.destroy');
    Route::get('/series/{id}/edit','edit')->name('series.edit');
    Route::put('/series/{id}','update')->name('series.update');

});