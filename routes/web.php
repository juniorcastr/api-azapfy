<?php

use App\Http\Controllers\NotasController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'notas'], function() {
    Route::get('/byremetente', [NotasController::class, 'groupByRemete']);
    Route::get('/total', [NotasController::class, 'totalRemetente']);
    Route::get('/entregue', [NotasController::class, 'valorEntregue']);
    Route::get('/emaberto', [NotasController::class, 'emAberto']);
    Route::get('/deixoureceber', [NotasController::class, 'deixouReceber']);
});

