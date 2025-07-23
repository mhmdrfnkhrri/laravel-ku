<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController; // <- pastikan sudah di-include

// Halaman Welcome (default Laravel)
Route::get('/', function () {
    return view('welcome');
});

// Semua route hanya bisa diakses jika sudah login
Route::middleware(['auth'])->group(function () {

    // Dashboard Keuangan
    Route::get('/dashboard', [TransaksiController::class, 'index'])->name('dashboard');

    // Transaksi
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

    // Laporan Keuangan
    Route::get('/laporan', [TransaksiController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/cetak', [TransaksiController::class, 'cetak'])->name('laporan.cetak');

    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
