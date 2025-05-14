<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenjualanController;

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
    return view('welcome');
});

// Rute untuk halaman daftar penjualan
Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');

// Rute untuk halaman create penjualan
Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');

// Rute untuk menyimpan data penjualan
Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');