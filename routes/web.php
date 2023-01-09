<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryKeuanganController;
use App\Http\Controllers\LaporanKeuanganController;
use Illuminate\Support\Facades\DB;

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
    // return view('welcome');

    $data['kategori'] = DB::table('category_keuangan')->where('bActive', 1)->get();
    $data['num_rows'] = DB::table('transaksi_keuangan')->count();
    $data['kode'] = date('Ymd');

    $data['laporan_harian'] = DB::select("SELECT
                                        laporan.szTransId,
                                        laporan.szCategoryId,
                                        kategori.szDesc AS kategori_desc,
                                        laporan.szDesc,
                                        DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') AS dtmTrans,
                                        (CASE
                                            WHEN kategori.szType = 'MASUK' THEN laporan.decAmount
                                            ELSE 0
                                        END) decAmountMasuk,
                                        (CASE
                                            WHEN kategori.szType = 'KELUAR' THEN laporan.decAmount
                                            ELSE 0
                                        END) decAmountKeluar
                                        FROM transaksi_keuangan laporan
                                        LEFT JOIN category_keuangan kategori
                                        ON kategori.szCategoryId = laporan.szCategoryId
                                        WHERE DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') = '" . date('Y-m-d') . "'
                                        ORDER BY DATE_FORMAT(laporan.dtmTrans, '%Y-%m-%d') ASC");

    //return view with data
    return view('laporan_keuangan/laporan_harian', compact('data'));
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
Route::get('/LaporanKeuangan/GetAllLaporanByDate/{tgl}', [LaporanKeuanganController::class, 'GetAllLaporanByDate']);
Route::post('/LaporanKeuangan/add', [LaporanKeuanganController::class, 'add']);
// Route::post('/LaporanKeuangan/store', 'LaporanKeuanganController@store');
Route::get('/LaporanKeuangan/edit/{id}', [LaporanKeuanganController::class, 'edit']);
Route::post('/LaporanKeuangan/update', [LaporanKeuanganController::class, 'update']);
Route::get('/LaporanKeuangan/hapus/{id}', [LaporanKeuanganController::class, 'hapus']);
Route::get('/LaporanKeuangan/get_limit_by_category/{id}', [LaporanKeuanganController::class, 'get_limit_by_category']);
Route::get('/LaporanKeuangan/get_total_amount_in_month/{id}', [LaporanKeuanganController::class, 'get_total_amount_in_month']);

Route::get('/LaporanKeuangan/LaporanMingguan', [LaporanKeuanganController::class, 'LaporanMingguan']);
Route::get('/LaporanKeuangan/LaporanBulanan', [LaporanKeuanganController::class, 'LaporanBulanan']);
Route::get('/LaporanKeuangan/LaporanHarianByDate/{tgl}', [LaporanKeuanganController::class, 'LaporanHarianByDate']);
Route::get('/LaporanKeuangan/Get_category_keuangan_by_type', [LaporanKeuanganController::class, 'Get_category_keuangan_by_type']);
