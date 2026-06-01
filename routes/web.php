<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardControllers;
use App\Http\Controllers\HalamanDepanController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\TiketController;


// --- ROUTE AUTENTIKASI (LOGIN & LOGOUT) ---
Route::get('/login', [AuthController::class, 'halamanLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// ROUTE YANG WAJIB LOGIN (MENGGUNAKAN AUTH)
Route::middleware('auth')->group(function () {
    
    // 1. DASHBOARD & MANAJEMEN DATA TIKET PESAWAT (DashboardControllers)
    Route::get('/', [DashboardControllers::class, 'index'])->name('admin.dashboard');
    Route::get('/daftar-pembooking', [DashboardControllers::class, 'halamanPembooking'])->name('admin.pembooking');
    Route::post('/tiket/tambah', [DashboardControllers::class, 'simpanTiket'])->name('tiket.simpan');
    Route::put('/tiket/ubah/{tiket}', [DashboardControllers::class, 'ubahTiket'])->name('tiket.ubah');
    Route::delete('/tiket/hapus/{tiket}', [DashboardControllers::class, 'hapusTiket'])->name('tiket.hapus');

    // 2. HALAMAN MANIFEST & VERIFIKASI TIMER 12 JAM (TiketController)
    Route::get('/admin/bookings', [TiketController::class, 'adminBookings'])->name('admin.bookings');
    Route::post('/admin/bookings/{id}/verify', [TiketController::class, 'verifyBooking'])->name('admin.bookings.verify');
    Route::delete('/admin/bookings/{id}/unverify', [TiketController::class, 'unverifyBooking'])->name('admin.bookings.unverify');

    // 3. ROUTE SISI PEMBELI (TiketController)
    Route::get('/tiket', [TiketController::class, 'index'])->name('tiket.index');
    Route::post('/tiket/pesan', [TiketController::class, 'pesan'])->name('tiket.pesan');
    
});



// ROUTE UMUM / PENGUNJUNG BIASA 

Route::post('/proses-pesan-tiket', [HalamanDepanController::class, 'prosesPesan'])->name('pesan.tiket');