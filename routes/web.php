<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardControllers;
use App\Http\Controllers\HalamanDepanController;
use App\Http\Controllers\AuthController; // Panggil AuthController
use App\Http\Controllers\TiketController;

// --- ROUTE AUTENTIKASI (LOGIN & LOGOUT) ---
Route::get('/login', [AuthController::class, 'halamanLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- ROUTE ADMIN (Hanya bisa diakses setelah login) ---
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardControllers::class, 'index'])->name('admin.dashboard');
    Route::get('/daftar-pembooking', [DashboardControllers::class, 'halamanPembooking'])->name('admin.pembooking');
    // Kita kasih nama routenya: admin.bookings
Route::get('/admin/bookings', [\App\Http\Controllers\TiketController::class, 'adminBookings'])->name('admin.bookings');
    Route::post('/tiket/tambah', [DashboardControllers::class, 'simpanTiket'])->name('tiket.simpan');
    Route::put('/tiket/ubah/{tiket}', [DashboardControllers::class, 'ubahTiket'])->name('tiket.ubah');
    Route::delete('/tiket/hapus/{tiket}', [DashboardControllers::class, 'hapusTiket'])->name('tiket.hapus');
    
});
// Rute untuk Admin Panel
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/bookings', [TiketController::class, 'adminBookings'])->name('admin.bookings');
    Route::post('/admin/verifikasi/{id}', [TiketController::class, 'verifikasi'])->name('admin.verifikasi');
    Route::delete('/admin/hapus/{id}', [TiketController::class, 'hapusBooking'])->name('admin.hapus');
});



// Route khusus Pembeli (Gunakan middleware auth untuk mengamankan)
Route::middleware(['auth'])->group(function () {
    Route::get('/tiket', [TiketController::class, 'index'])->name('tiket.index');
    Route::post('/tiket/pesan', [TiketController::class, 'pesan'])->name('tiket.pesan');
});

// Route Admin (Data Pembookingan & Verifikasi)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/bookings', [TiketController::class, 'adminBookings'])->name('admin.bookings');
    Route::post('/admin/bookings/{id}/verifikasi', [TiketController::class, 'verifikasi'])->name('admin.bookings.verifikasi');
    Route::get('/admin/bookings/{id}/edit', [TiketController::class, 'editBooking'])->name('admin.bookings.edit');
    Route::put('/admin/bookings/{id}', [TiketController::class, 'updateBooking'])->name('admin.bookings.update');
    Route::delete('/admin/bookings/{id}', [TiketController::class, 'hapusBooking'])->name('admin.bookings.delete');
});
// Rute untuk Pembeli (Pastikan sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/tiket', [TiketController::class, 'index'])->name('tiket.index');
    Route::post('/tiket/pesan', [TiketController::class, 'pesan'])->name('tiket.pesan');
});

// --- ROUTE UMUM / PENGUNJUNG ---
Route::post('/proses-pesan-tiket', [HalamanDepanController::class, 'prosesPesan'])->name('pesan.tiket');