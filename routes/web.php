<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryKeuanganController;
use App\Http\Controllers\LaporanKeuanganController;

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

Route::get('/CategoryKeuangan', [CategoryKeuanganController::class, 'index']);
Route::get('/CategoryKeuangan/GetAllCategory', [CategoryKeuanganController::class, 'GetAllCategory']);
Route::post('/CategoryKeuangan/add', [CategoryKeuanganController::class, 'add']);
// Route::post('/CategoryKeuangan/store', 'CategoryKeuanganController@store');
Route::get('/CategoryKeuangan/edit/{id}', [CategoryKeuanganController::class, 'edit']);
Route::post('/CategoryKeuangan/update', [CategoryKeuanganController::class, 'update']);
Route::get('/CategoryKeuangan/hapus/{id}', [CategoryKeuanganController::class, 'hapus']);

Route::get('/LaporanKeuangan', [LaporanKeuanganController::class, 'index']);
Route::get('/LaporanKeuangan/GetAllLaporan', [LaporanKeuanganController::class, 'GetAllLaporan']);
Route::post('/LaporanKeuangan/add', [LaporanKeuanganController::class, 'add']);
// Route::post('/LaporanKeuangan/store', 'LaporanKeuanganController@store');
Route::get('/LaporanKeuangan/edit/{id}', [LaporanKeuanganController::class, 'edit']);
Route::post('/LaporanKeuangan/update', [LaporanKeuanganController::class, 'update']);
Route::get('/LaporanKeuangan/hapus/{id}', [LaporanKeuanganController::class, 'hapus']);
