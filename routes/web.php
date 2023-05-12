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

Route::get('/api/groupbyremete', [NotasController::class, 'groupByRemete']);
Route::get('/api/total-remete', [NotasController::class, 'totalPorRemetente']);
Route::get('/api/valor-entregue', [NotasController::class, 'valorEntregue']);
Route::get('/api/valor-receber', [NotasController::class, 'valorReceber']);

