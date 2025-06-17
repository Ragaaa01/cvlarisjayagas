<?php

use App\Http\Controllers\API\ApiAdministratorController;
use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\ApiJenisTabungController;
use App\Http\Controllers\API\ApiPelangganController;
use App\Http\Controllers\API\ApiStatusTabungController;
use App\Http\Controllers\API\ApiTabungController;
use App\Http\Controllers\API\ApiTagihanController;
use App\Http\Controllers\API\ApiTransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// routes/api.php
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    
    // Get authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user()->load('perorangan');
    });

    // Administrator routes
    Route::prefix('administrator')->group(function () {
        Route::get('/profile', [ApiAdministratorController::class, 'profile']);
        Route::get('/statistics', [ApiAdministratorController::class, 'statistics']);
        Route::get('/pending-accounts', [ApiAdministratorController::class, 'pendingAccounts']);
        Route::post('/confirm-account', [ApiAdministratorController::class, 'confirmAccount']);

        Route::get('/tabung', [ApiTabungController::class, 'index'])->name('tabung.index');
        Route::get('/tabung/{id}', [ApiTabungController::class, 'show'])->name('tabung.show');
        Route::get('/tabung/kode', [ApiTabungController::class, 'showByKode'])->name('tabung.showByKode');
        Route::post('/tabung', [ApiTabungController::class, 'store'])->name('tabung.store');
        Route::put('/tabung/{id}', [ApiTabungController::class, 'update'])->name('tabung.update');
        Route::delete('/tabung/{id}', [ApiTabungController::class, 'destroy'])->name('tabung.destroy');

        Route::get('status-tabung', [ApiStatusTabungController::class, 'index']);
        Route::get('jenis-tabung', [ApiJenisTabungController::class, 'index']);

        Route::get('/pelanggan', [ApiPelangganController::class, 'index']); 
        Route::post('/pelanggan', [ApiPelangganController::class, 'store']); 
        Route::get('/pelanggan/{id}', [ApiPelangganController::class, 'show']); 
        Route::put('/pelanggan/{id}', [ApiPelangganController::class, 'update']); 
        Route::delete('/pelanggan/{id}', [ApiPelangganController::class, 'destroy']); 
    });

    // Pelanggan routes
    Route::prefix('pelanggan')->group(function () {
        Route::get('/profile', [ApiPelangganController::class, 'profile']);
        Route::get('/jenis-tabung', [ApiJenisTabungController::class, 'index']);
        Route::get('/jenis-tabung-tersedia', [ApiTransaksiController::class, 'getAvailableJenisTabung']); 
        Route::get('/tabung-tersedia', [ApiTabungController::class, 'getTabungsTersedia']);
        Route::get('/tabung-aktif', [ApiTabungController::class, 'getTabungAktif']);
        Route::get('/nearest-transaction-due-date', [ApiTagihanController::class, 'getNearestDueDate']); 
        Route::post('/transaksi/peminjaman', [ApiTransaksiController::class, 'createPeminjaman']);
        Route::post('/transaksi/isi-ulang', [ApiTransaksiController::class, 'createIsiUlang']);
        Route::post('/transaksi/gabungan', [ApiTransaksiController::class, 'createGabungan']);
        Route::get('/transaksi/{id}', [ApiTransaksiController::class, 'getTransaksiDetail']); 
        Route::get('/riwayat-transaksi', [ApiTransaksiController::class, 'getRiwayatTransaksi']);
        Route::get('/tagihan', [ApiTagihanController::class, 'index']);
        Route::post('/tagihan/update-pembayaran', [ApiTagihanController::class, 'updatePembayaran']);
    });
});

