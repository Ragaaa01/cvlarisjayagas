<?php

use App\Http\Controllers\API\Administrator\ApiPengajuanAdministratorController;
use App\Http\Controllers\API\ApiAdministratorController;
use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\ApiDetailTransaksiPelangganController;
use App\Http\Controllers\API\ApiJenisTabungController;
use App\Http\Controllers\API\ApiPelangganController;
use App\Http\Controllers\API\ApiPelangganProfileController;
use App\Http\Controllers\API\ApiPeminjamanController;
use App\Http\Controllers\API\ApiPeminjamanPelangganController;
use App\Http\Controllers\Api\ApiPengajuanPelangganController;
use App\Http\Controllers\Api\ApiPengembalianController;
use App\Http\Controllers\API\ApiRiwayatTransaksiController;
use App\Http\Controllers\API\ApiStatusTabungController;
use App\Http\Controllers\API\ApiTabungController;
use App\Http\Controllers\API\ApiTagihanController;
use App\Http\Controllers\API\ApiTagihanPelangganController;
use App\Http\Controllers\API\ApiTransaksiController;
use App\Http\Controllers\API\ApiTransaksiPelangganController;
use App\Http\Controllers\API\Firebase\FcmTokenController;
use App\Http\Controllers\API\MidtransWebhookController;
use App\Http\Controllers\API\Pelanggan\ApiNotifikasiPelangganController;
use App\Http\Controllers\API\PembayaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\Api;



// routes/api.php
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {

    // FCM Token Management
    Route::post('/user/fcm-token', [FcmTokenController::class, 'store']);

    // Midtrans Webhook Route
    Route::post('/webhook/midtrans', [MidtransWebhookController::class, 'handle']);

    // Logout
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    // Get authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user()->load('perorangan');
    });

    // --- Grup semua route Administrator ---
    Route::prefix('administrator')->middleware('auth:sanctum')->group(function () {

        // Dashboard Management routes
        Route::get('/profile', [ApiAdministratorController::class, 'profile']);
        Route::get('/statistics', [ApiAdministratorController::class, 'statistics']);
        Route::get('/pending-accounts', [ApiAdministratorController::class, 'pendingAccounts']);
        Route::post('/confirm-account', [ApiAdministratorController::class, 'confirmAccount']);

        // Tabung Management routes
        Route::get('/tabung', [ApiTabungController::class, 'index']);
        Route::get('/tabung/{id}', [ApiTabungController::class, 'show']);
        Route::get('/tabung/kode/{kode_tabung}', [ApiTabungController::class, 'showByKodeTabung']);
        Route::get('/tabung-kode/{kode_tabung}', [ApiTabungController::class, 'showByKode']);
        Route::post('/tabung', [ApiTabungController::class, 'store']);
        Route::put('/tabung/{id}', [ApiTabungController::class, 'update']);
        Route::delete('/tabung/{id}', [ApiTabungController::class, 'destroy']);
        Route::get('/tabung-tersedia', [ApiTabungController::class, 'getTabungsTersedia']);

        // Resource Tabung routes
        Route::get('status-tabung', [ApiStatusTabungController::class, 'index']);
        Route::get('jenis-tabung', [ApiJenisTabungController::class, 'index']);

        // Pelanggan Management routes
        Route::get('/pelanggan', [ApiPelangganController::class, 'index']);
        Route::post('/pelanggan', [ApiPelangganController::class, 'store']);
        Route::get('/pelanggan/{id}', [ApiPelangganController::class, 'show']);
        Route::put('/pelanggan/{id}', [ApiPelangganController::class, 'update']);
        Route::delete('/pelanggan/{id}', [ApiPelangganController::class, 'destroy']);

        // Transaksi Management routes
        Route::get('/transaksi', [ApiTransaksiController::class, 'index']);
        Route::post('/transaksi', [ApiTransaksiController::class, 'store']);
        Route::get('/transaksi/{id}', [ApiTransaksiController::class, 'show']);
        Route::put('/transaksi/{id}', [ApiTransaksiController::class, 'update']);
        Route::post('/transaksi/{id}/bayar', [ApiTransaksiController::class, 'bayarTagihan']);

        // Riwayat Transaksi routes
        Route::get('/riwayat-transaksi', [ApiRiwayatTransaksiController::class, 'index']);

        // Pengembalian Routes
        Route::post('/pengembalian', [ApiPengembalianController::class, 'store']);

        // Peminjaman Routes
        Route::get('/peminjaman/aktif', [ApiPeminjamanController::class, 'indexAktif']);

        // Tagihan Management routes
        Route::get('/tagihan', [ApiTagihanController::class, 'index']);
        Route::post('/tagihan/{tagihan}/bayar', [ApiTagihanController::class, 'bayar']);

        // Pengajuan Management routes
        Route::get('/pengajuan', [ApiPengajuanAdministratorController::class, 'index']);
        Route::get('/pengajuan/{transaksi}', [ApiPengajuanAdministratorController::class, 'show']);
        Route::post('/pengajuan/{transaksi}/proses', [ApiPengajuanAdministratorController::class, 'proses']);
    });

    // -- Grup semua route Pelanggan ---
    Route::prefix('pelanggan')->middleware('auth:sanctum')->group(function () {

        // Dashboard Needs Routes
        Route::get('/transaksi', [ApiTransaksiPelangganController::class, 'getTransaksi']);

        // Profile Management Routes
        Route::get('/profile', [ApiPelangganProfileController::class, 'show']);
        Route::put('/profile', [ApiPelangganProfileController::class, 'update']);

        // Halaman Peminjaman Saya Routes
        Route::get('/peminjaman', [ApiPeminjamanPelangganController::class, 'index']);

        // Halaman Tagihan Saya Routes
        Route::get('/tagihan', [ApiTagihanPelangganController::class, 'index']);
        Route::post('/tagihan/{tagihan}/create-payment', [PembayaranController::class, 'createPayment']);

        // Detail Transaksi Sendiri
        Route::get('/transaksi/{transaksi}', [ApiDetailTransaksiPelangganController::class, 'show']);
        Route::get('/transaksi/{transaksi}/riwayat-pembayaran', [ApiDetailTransaksiPelangganController::class, 'getRiwayatPembayaran']);

        // Pengajuan Transaksi
        Route::post('/pengajuan', [ApiPengajuanPelangganController::class, 'store']);
        Route::post('/pengajuan/create-with-payment', [ApiPengajuanPelangganController::class, 'store']);


        Route::get('/jenis-tabung', [ApiJenisTabungController::class, 'getAvailableJenisTabung']);

        // Notifikasi Pelanggan Routes
        Route::get('/notifikasi', [ApiNotifikasiPelangganController::class, 'index']);
        Route::post('/notifikasi/{notifikasi}/baca', [ApiNotifikasiPelangganController::class, 'markAsRead']);
    });
});
