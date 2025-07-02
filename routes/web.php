<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\AkunController;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\TabungController;
use App\Http\Controllers\WEB\TagihanController;
use App\Http\Controllers\WEB\TransaksiController;
use App\Http\Controllers\WEB\NotifikasiController;
use App\Http\Controllers\WEB\PeminjamanController;
use App\Http\Controllers\WEB\PeroranganController;
use App\Http\Controllers\WEB\PerusahaanController;
use App\Http\Controllers\WEB\JenisTabungController;
use App\Http\Controllers\WEB\PengembalianController;
use App\Http\Controllers\WEB\StatusTabungController;
use App\Http\Controllers\WEB\JenisTransaksiController;
use App\Http\Controllers\WEB\StatusTransaksiController;
use App\Http\Controllers\WEB\RiwayatTransaksiController;
use App\Http\Controllers\WEB\NotifikasiTemplateController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware(['auth', 'role:administrator'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    });

});

//Data Akun
Route::get('/admin/akuns', [AkunController::class, 'data_akun'])->name('data_akun');
Route::get('/admin/akuns/create', [AkunController::class, 'create'])->name('create_akun');
Route::post('/admin/akuns', [AkunController::class, 'store'])->name('store_akun');
Route::get('/admin/akuns/{id}/edit', [AkunController::class, 'edit'])->name('edit_akun');
Route::put('/admin/akuns/{id}', [AkunController::class, 'update'])->name('update_akun');
Route::delete('/admin/akuns/{id}', [AkunController::class, 'destroy'])->name('delete_akun');
Route::get('/admin/akuns/{id}', [AkunController::class, 'show'])->name('show_data_akun');
Route::get('/perorangan/search', [AkunController::class, 'searchPerorangan'])->name('search_perorangan');

//Data Perorangan
Route::get('/admin/perorangan', [PeroranganController::class, 'index'])->name('data_perorangan');
Route::get('/admin/perorangan/create', [PeroranganController::class, 'create'])->name('perorangan.create');
Route::post('/admin/perorangan', [PeroranganController::class, 'store'])->name('perorangan.store');
Route::get('/admin/perorangan/{id}/edit', [PeroranganController::class, 'edit'])->name('perorangan.edit');
Route::put('/admin/perorangan/{id}', [PeroranganController::class, 'update'])->name('perorangan.update');
Route::delete('/admin/perorangan/{id}', [PeroranganController::class, 'destroy'])->name('perorangan.destroy');
Route::get('/admin/perorangan/{id}', [PeroranganController::class, 'show'])->name('perorangan.show');

// Data perusahaan
Route::prefix('admin/perusahaan')->group(function () {
    Route::get('/', [PerusahaanController::class, 'index'])->name('data_perusahaan');
    Route::get('/create', [PerusahaanController::class, 'create'])->name('perusahaan.create');
    Route::post('/', [PerusahaanController::class, 'store'])->name('perusahaan.store');
    Route::get('/{id}', [PerusahaanController::class, 'show'])->name('perusahaan.show');
    Route::get('/{id}/edit', [PerusahaanController::class, 'edit'])->name('perusahaan.edit');
    Route::put('/{id}', [PerusahaanController::class, 'update'])->name('perusahaan.update');
    Route::delete('/{id}', [PerusahaanController::class, 'destroy'])->name('perusahaan.destroy');
});

//Data Jenis Tabung
Route::prefix('admin/jenis_tabung')->group(function () {
    Route::get('/', [JenisTabungController::class, 'index'])->name('data_jenis_tabung');
    Route::get('/create', [JenisTabungController::class, 'create'])->name('jenis_tabung.create');
    Route::post('/', [JenisTabungController::class, 'store'])->name('jenis_tabung.store');
    Route::get('/{id}/edit', [JenisTabungController::class, 'edit'])->name('jenis_tabung.edit');
    Route::put('/{id}', [JenisTabungController::class, 'update'])->name('jenis_tabung.update');
    Route::delete('/{id}', [JenisTabungController::class, 'destroy'])->name('jenis_tabung.destroy');
    Route::get('/{id}', [JenisTabungController::class, 'show'])->name('jenis_tabung.show');
});

//Data Status Tabung
Route::prefix('admin/status_tabung')->group(function () {
    Route::get('/', [StatusTabungController::class, 'index'])->name('data_status_tabung');
    Route::get('/create', [StatusTabungController::class, 'create'])->name('status_tabung.create');
    Route::post('/', [StatusTabungController::class, 'store'])->name('status_tabung.store');
    Route::get('/{id}/edit', [StatusTabungController::class, 'edit'])->name('status_tabung.edit');
    Route::put('/{id}', [StatusTabungController::class, 'update'])->name('status_tabung.update');
    Route::delete('/{id}', [StatusTabungController::class, 'destroy'])->name('status_tabung.destroy');
    Route::get('/{id}', [StatusTabungController::class, 'show'])->name('jenis_tabung.show');
});

//Data Tabung
Route::get('/admin/tabung', [TabungController::class, 'index'])->name('data_tabung');
Route::get('/admin/tabung/create', [TabungController::class, 'create'])->name('tabung.create');
Route::post('/admin/tabung', [TabungController::class, 'store'])->name('tabung.store');
Route::get('/admin/tabung/{id}', [TabungController::class, 'show'])->name('tabung.show');
Route::get('/admin/tabung/{id}/edit', [TabungController::class, 'edit'])->name('tabung.edit');
Route::put('/admin/tabung/{id}', [TabungController::class, 'update'])->name('tabung.update');
Route::delete('/admin/tabung/{id}', [TabungController::class, 'destroy'])->name('tabung.destroy');

// Transaksi
Route::get('/admin/transaksi', [TransaksiController::class, 'index'])->name('transaksis.index');
Route::get('/admin/transaksi/create', [TransaksiController::class, 'create'])->name('transaksis.create');
Route::post('/admin/transaksi', [TransaksiController::class, 'store'])->name('transaksis.store');
Route::get('/admin/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksis.show');
Route::get('/admin/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksis.edit');
Route::put('/admin/transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksis.update');
Route::delete('/admin/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksis.destroy');

// Jenis Transaksi

Route::prefix('admin')->group(function () {
    Route::get('/jenis_transaksi', [JenisTransaksiController::class, 'index'])->name('jenis_transaksi.index');
    Route::get('/jenis_transaksi/create', [JenisTransaksiController::class, 'create'])->name('jenis_transaksi.create');
    Route::get('/jenis_transaksi/{id}', [JenisTransaksiController::class, 'show'])->name('jenis_transaksi.show');
    Route::get('/jenis_transaksi/{id}/edit', [JenisTransaksiController::class, 'edit'])->name('jenis_transaksi.edit');
    Route::post('/jenis_transaksi', [JenisTransaksiController::class, 'store'])->name('jenis_transaksi.store');
    Route::put('/jenis_transaksi/{id}', [JenisTransaksiController::class, 'update'])->name('jenis_transaksi.update');
    Route::delete('/jenis_transaksi/{id}', [JenisTransaksiController::class, 'destroy'])->name('jenis_transaksi.destroy');
});
// Rute admin dengan prefix 'admin'
Route::prefix('admin')->name('admin.')->group(function () {
   
    // Rute untuk Status Transaksi
    Route::resource('status_transaksi', StatusTransaksiController::class);

    // Rute untuk Peminjaman
    Route::resource('peminjaman', PeminjamanController::class)->except(['show']);

    // Rute untuk Pengembalian
    Route::resource('pengembalian', PengembalianController::class)->except(['show']);

    // Rute untuk Tagihan
    Route::resource('tagihan', TagihanController::class)->except(['show']);

    // Rute untuk Notifikasi
    Route::resource('notifikasi', NotifikasiController::class)->except(['show']);
    Route::get('notifikasi/{id}/mark-as-read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.mark_as_read');

    // Rute untuk Riwayat Transaksi (hanya index dan show)
    Route::resource('riwayat_transaksi', RiwayatTransaksiController::class)->only(['index', 'show']);

    // Rute untuk Notifikasi Template
    Route::resource('notifikasi_template', NotifikasiTemplateController::class)->except(['show']);
});