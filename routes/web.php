<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController; // Pastikan ini ada di bagian atas

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
    return view('login');
});

Route::get('/alamat', function () {
    echo 'welcome';
});

// login customer
Route::get('/depan', [KeranjangController::class, 'daftarbarang'])
    ->middleware(\App\Http\Middleware\CustomerMiddleware::class)
    ->name('depan');
Route::get('/login', function () {
    return view('login');
});

// tambahan route untuk proses login
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// untuk ubah password
Route::get('/ubahpassword', [AuthController::class, 'ubahpassword'])
    ->middleware('customer')
    ->name('ubahpassword');
Route::post('/prosesubahpassword', [AuthController::class, 'prosesubahpassword'])
    ->middleware('customer');

Route::post('/depan/tambah/{id}', [KeranjangController::class, 'tambahKeKeranjang'])->name('tambah.keranjang');
Route::post('/depan/tambah-langsung/{id}', [KeranjangController::class, 'tambahKeKeranjangLangsung'])->name('tambah.keranjang.langsung');
Route::post('/depan/kurangi/{id}', [KeranjangController::class, 'kurangiDariKeranjang'])->name('kurang.keranjang');
Route::delete('/depan/hapus/{id}', [KeranjangController::class, 'hapusDariKeranjang'])->name('hapus.keranjang');

Route::get('/clear-session', [KeranjangController::class, 'clearSession'])->name('clear.session');

Route::post('/depan/proses-pembayaran', [KeranjangController::class, 'prosesPembayaranKasir'])
    ->middleware('customer')
    ->name('proses.pembayaran.kasir');

Route::post('/pembayaran/midtrans/process', [KeranjangController::class, 'prosesPembayaranMidtrans'])->name('midtrans.process');

Route::get('/invoice/{transaksi}', [KeranjangController::class, 'showInvoice'])->name('invoice.show');

Route::get('/riwayat-transaksi', [App\Http\Controllers\KeranjangController::class, 'riwayatTransaksi'])->name('riwayat.transaksi');
Route::get('/riwayat-invoice/{transaksi}', [App\Http\Controllers\KeranjangController::class, 'tampilkanInvoice'])->name('riwayat.invoice');

Route::get('/cari-produk', [KeranjangController::class, 'cariProduk'])->name('cari.produk');