<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\AkunController;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\TabungController;
use App\Http\Controllers\WEB\PeroranganController;
use App\Http\Controllers\WEB\PerusahaanController;
use App\Http\Controllers\WEB\JenisTabungController;
use App\Http\Controllers\WEB\StatusTabungController;

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
Route::get('/admin/akuns/{id}', [AkunController::class, 'show'])->name('show_data_akun');
Route::post('/admin/akuns', [AkunController::class, 'store'])->name('store_akun');
Route::put('/admin/akuns/{id}', [AkunController::class, 'update'])->name('update_akun');
Route::delete('/admin/akuns/{id}', [AkunController::class, 'destroy'])->name('delete_akun');
Route::get('/perorangan/search', [AkunController::class, 'searchPerorangan'])->name('search_perorangan');

//Data Perorangan
Route::get('/admin/perorangan', [PeroranganController::class, 'index'])->name('data_perorangan');
Route::post('/admin/perorangan', [PeroranganController::class, 'store'])->name('perorangan.store');
Route::put('/admin/perorangan/{id}', [PeroranganController::class, 'update'])->name('perorangan.update');
Route::delete('/admin/perorangan/{id}', [PeroranganController::class, 'destroy'])->name('perorangan.destroy');
Route::get('/admin/perorangan/{id}', [PeroranganController::class, 'show'])->name('perorangan.show');

//Data Perusahaan
Route::get('/admin/perusahaan', [PerusahaanController::class, 'index'])->name('data_perusahaan');
Route::post('/admin/perusahaan', [PerusahaanController::class, 'store'])->name('perusahaan.store');
Route::put('/admin/perusahaan/{id}', [PerusahaanController::class, 'update'])->name('perusahaan.update');
Route::delete('/admin/perusahaan/{id}', [PerusahaanController::class, 'destroy'])->name('perusahaan.destroy');
Route::get('/admin/perusahaan/{id}', [PerusahaanController::class, 'show'])->name('perusahaan.show');

//Data Jenis Tabung
Route::get('/admin/jenis_tabung', [JenisTabungController::class, 'index'])->name('data_jenis_tabung');
Route::post('/admin/jenis_tabung', [JenisTabungController::class, 'store'])->name('jenis_tabung.store');
Route::put('/admin/jenis_tabung/{id}', [JenisTabungController::class, 'update'])->name('jenis_tabung.update');
Route::delete('/admin/jenis_tabung/{id}', [JenisTabungController::class, 'destroy'])->name('jenis_tabung.destroy');
Route::get('/admin/jenis_tabung/{id}', [JenisTabungController::class, 'show'])->name('jenis_tabung.show');

//Data Status Tabung
Route::get('/admin/status_tabung', [StatusTabungController::class, 'index'])->name('data_status_tabung');
Route::post('/admin/status_tabung', [StatusTabungController::class, 'store'])->name('status_tabung.store');
Route::put('/admin/status_tabung/{id}', [StatusTabungController::class, 'update'])->name('status_tabung.update');
Route::delete('/admin/status_tabung/{id}', [StatusTabungController::class, 'destroy'])->name('status_tabung.destroy');
Route::get('/admin/status_tabung/{id}', [StatusTabungController::class, 'show'])->name('jenis_tabung.show');

//Data Tabung
Route::get('/admin/tabung', [TabungController::class, 'index'])->name('data_tabung');
Route::get('/admin/tabung/create', [TabungController::class, 'create'])->name('tabung.create');
Route::post('/admin/tabung', [TabungController::class, 'store'])->name('tabung.store');
Route::get('/admin/tabung/{id}', [TabungController::class, 'show'])->name('tabung.show');
Route::get('/admin/tabung/{id}/edit', [TabungController::class, 'edit'])->name('tabung.edit');
Route::put('/admin/tabung/{id}', [TabungController::class, 'update'])->name('tabung.update');
Route::delete('/admin/tabung/{id}', [TabungController::class, 'destroy'])->name('tabung.destroy');

