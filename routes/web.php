<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\AuthController;

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

// Halaman login default
Route::get('/', function () {
    return view('login');
});

// Halaman login (GET)
Route::get('/login', function () {
    return view('login');
});

// Proses login (POST)
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Halaman utama kasir setelah login
Route::get('/depan', [KeranjangController::class, 'daftarbarang'])
    ->middleware(\App\Http\Middleware\CustomerMiddleware::class)
    ->name('depan');

// Ubah password
Route::get('/ubahpassword', [AuthController::class, 'ubahpassword'])
    ->middleware('customer')
    ->name('ubahpassword');
Route::post('/prosesubahpassword', [AuthController::class, 'prosesubahpassword'])
    ->middleware('customer');

// CRUD Keranjang
Route::post('/depan/tambah/{id}', [KeranjangController::class, 'tambahKeKeranjang'])->name('tambah.keranjang');
Route::post('/depan/tambah-langsung/{id}', [KeranjangController::class, 'tambahKeKeranjangLangsung'])->name('tambah.keranjang.langsung');
Route::post('/depan/kurangi/{id}', [KeranjangController::class, 'kurangiDariKeranjang'])->name('kurang.keranjang');
Route::delete('/depan/hapus/{id}', [KeranjangController::class, 'hapusDariKeranjang'])->name('hapus.keranjang');
Route::get('/clear-session', [KeranjangController::class, 'clearSession'])->name('clear.session');

// Pembayaran
Route::post('/depan/proses-pembayaran', [KeranjangController::class, 'prosesPemb]()
