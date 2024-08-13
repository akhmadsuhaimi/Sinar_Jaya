<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\DataUjiController;
use App\Http\Controllers\HasilPrediksiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JenisProdukController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PerhiasanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PerformanceController;
// use App\Http\Controllers\PredictController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;

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
    return view('login');
});
Route::get('hasil-prediksi/print', [HasilPrediksiController::class, 'print'])->name('hasil-prediksi.print');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/stok', [StokController::class, 'index']);
    Route::resource('pembelian', PembelianController::class);
    Route::resource('penjualan', PenjualanController::class);
    Route::get('performance', [PerformanceController::class, 'index'])->name('performance.index');
    Route::get('datasets', [DatasetController::class, 'index'])->name('datasets.index');
    Route::get('datasets/import', [DatasetController::class, 'importForm'])->name('datasets.importForm');
    Route::post('datasets/import', [DatasetController::class, 'import'])->name('datasets.import');
    // Route::get('predict', [PredictController::class, 'showForm'])->name('predict.form');
    // Route::post('predict', [PredictController::class, 'predict'])->name('predict.predict');
    Route::get('laporan-penjualan', [PenjualanController::class, 'laporanPenjualan'])->name('penjualan.laporan');
    Route::post('laporan-penjualan/filter', [PenjualanController::class, 'filterLaporanPenjualan'])->name('penjualan.filterLaporan');
    Route::resource('data-uji', DataUjiController::class)->only(['index', 'destroy']);
    Route::get('data-uji/{id}', [DataUjiController::class, 'show']);
    Route::get('prediksi-restock', [PenjualanController::class, 'prediksiRestock'])->name('penjualan.prediksi');
    Route::post('prediksi-restock/filter', [PenjualanController::class, 'filterPrediksi'])->name('penjualan.filterPrediksi');

    Route::get('/hasil-prediksi', [HasilPrediksiController::class, 'index'])->name('hasil-prediksi.index');
    Route::get('/hasil-prediksi/{id}', [HasilPrediksiController::class, 'show'])->name('hasil-prediksi.show');
    Route::delete('/hasil-prediksi/{id}', [HasilPrediksiController::class, 'destroy'])->name('hasil-prediksi.destroy');

    Route::post('/data-uji/import', [DataUjiController::class, 'import'])->name('data-uji.import');

    Route::post('pembelian/filterLaporan', [PembelianController::class, 'filterLaporanPembelian'])->name('pembelian.filterLaporan');
    Route::get('stok/cetak-menipis', [StokController::class, 'printStokMenipis'])->name('stok.print_menipis');
Route::get('stok/cetak-terlaris', [StokController::class, 'printPenjualanTerlaris'])->name('stok.print_terlaris');
Route::get('stok/cetak-kurang', [HasilPrediksiController::class, 'printStokKurang'])->name('stok.print_kurang');
Route::get('stok/cetak-cukup', [HasilPrediksiController::class, 'printStokCukup'])->name('stok.print_cukup');


});

Route::group(['middleware' => ['auth', 'leveluser:user']], function () {
});

Route::group(['middleware' => ['auth', 'leveluser:admin']], function () {
    Route::resource('user', UserController::class);
    Route::resource('jenisproduk', JenisProdukController::class);
    Route::resource('perhiasan', PerhiasanController::class);
});


Route::get('login', function () {
    return view('login');
})->name('login');
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name(('postlogin'));
Route::get('/logout', [LoginController::class, 'logout'])->name(('logout'));
