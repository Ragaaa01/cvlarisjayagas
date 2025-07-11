<?php

use App\Http\Controllers\API\ApiAdministratorController;
use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\ApiJenisTabungController;
use App\Http\Controllers\API\ApiPelangganController;
use App\Http\Controllers\API\ApiPelangganProfileController;
use App\Http\Controllers\API\ApiPeminjamanController;
use App\Http\Controllers\Api\ApiPengembalianController;
use App\Http\Controllers\API\ApiRiwayatTransaksiController;
use App\Http\Controllers\API\ApiStatusTabungController;
use App\Http\Controllers\API\ApiTabungController;
use App\Http\Controllers\API\ApiTagihanController;
use App\Http\Controllers\API\ApiTransaksiController;
use App\Http\Controllers\API\ApiTransaksiPelangganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\Api;

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

    // --- Grup untuk semua route Administrator ---
    Route::prefix('administrator')->middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [ApiAdministratorController::class, 'profile']);
        Route::get('/statistics', [ApiAdministratorController::class, 'statistics']);
        Route::get('/pending-accounts', [ApiAdministratorController::class, 'pendingAccounts']);
        Route::post('/confirm-account', [ApiAdministratorController::class, 'confirmAccount']);

        Route::get('/tabung', [ApiTabungController::class, 'index'])->name('tabung.index');
        Route::get('/tabung/{id}', [ApiTabungController::class, 'show'])->name('tabung.show');
        Route::get('/tabung-kode', [ApiTabungController::class, 'showByKode']);
        Route::post('/tabung', [ApiTabungController::class, 'store'])->name('tabung.store');
        Route::put('/tabung/{id}', [ApiTabungController::class, 'update'])->name('tabung.update');
        Route::delete('/tabung/{id}', [ApiTabungController::class, 'destroy'])->name('tabung.destroy');
        Route::get('/tabung-tersedia', [ApiTabungController::class, 'getTabungsTersedia']);

        Route::get('status-tabung', [ApiStatusTabungController::class, 'index']);
        Route::get('jenis-tabung', [ApiJenisTabungController::class, 'index']);

        Route::get('/pelanggan', [ApiPelangganController::class, 'index']);
        Route::post('/pelanggan', [ApiPelangganController::class, 'store']);
        Route::get('/pelanggan/{id}', [ApiPelangganController::class, 'show']);
        Route::put('/pelanggan/{id}', [ApiPelangganController::class, 'update']);
        Route::delete('/pelanggan/{id}', [ApiPelangganController::class, 'destroy']);

        Route::get('/transaksi', [ApiTransaksiController::class, 'index']);
        Route::post('/transaksi', [ApiTransaksiController::class, 'store']);
        Route::get('/transaksi/{id}', [ApiTransaksiController::class, 'show']);
        Route::put('/transaksi/{id}', [ApiTransaksiController::class, 'update']);
        Route::post('/transaksi/{id}/bayar', [ApiTransaksiController::class, 'bayarTagihan']);

        Route::get('/riwayat-transaksi', [ApiRiwayatTransaksiController::class, 'index']);

        Route::post('/pengembalian', [ApiPengembalianController::class, 'store']);

        Route::get('/peminjaman/aktif', [ApiPeminjamanController::class, 'indexAktif']);

        Route::get('/tagihan', [ApiTagihanController::class, 'index']);
        Route::post('/tagihan/{tagihan}/bayar', [ApiTagihanController::class, 'bayar']);
    });

    // Pelanggan routes
    Route::prefix('pelanggan')->middleware('auth:sanctum')->group(function () {
        // Route::get('/profile', [ApiPelangganController::class, 'profile']);
        // Route::get('/jenis-tabung', [ApiJenisTabungController::class, 'index']);
        // Route::get('/jenis-tabung-tersedia', [ApiTransaksiController::class, 'getAvailableJenisTabung']);
        // Route::get('/tabung-tersedia', [ApiTabungController::class, 'getTabungsTersedia']);
        // Route::get('/tabung-aktif', [ApiTabungController::class, 'getTabungAktif']);
        // Route::get('/nearest-transaction-due-date', [ApiTagihanController::class, 'getNearestDueDate']);
        // Route::get('/tagihan', [ApiTagihanController::class, 'index']);
        // Route::post('/tagihan/update-pembayaran', [ApiTagihanController::class, 'updatePembayaran']);

        Route::get('/transaksi', [ApiTransaksiPelangganController::class, 'getTransaksi']);

        Route::get('/profile', [ApiPelangganProfileController::class, 'show']);
        Route::put('/profile', [ApiPelangganProfileController::class, 'update']);
    });
});
