<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Http\Controllers\AsyncController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('async/request', [AsyncController::class, 'request'])->name('async.request');
Route::get('async/response/{id}', [AsyncController::class, 'response'])->name('async.response');
