<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket; 
use App\Models\Order; // <-- Pastikan Model Order (atau Booking) di-import di atas

class TiketController extends Controller
{
    /**
     * Menampilkan daftar tiket di halaman Pembeli
     */
    public function index()
    {
        $tikets = Tiket::all();
        return view('tiket.index', compact('tikets'));
    }

    /**
     * HALAMAN MANIFEST & VERIFIKASI TIMER 12 JAM (Memperbaiki eror Undefined variable $semuaPembooking)
     */
    public function adminBookings()
    {
        // Ambil semua data transaksi/booking untuk ditampilkan di tabel halaman admin
        // Di sini gua pakai Model Order sesuai nama judul tabel di screenshot lu "Tabel Orders"
        $semuaPembooking = Order::latest()->get(); 

        // LEMPAR VARIABELNYA KE VIEW BIAR FORM @forelse DI BLADE GAK EROR LAGI!
        return view('admin.bookings', compact('semuaPembooking'));
    }

    /**
     * Logika untuk memverifikasi pesanan
     */
    public function verifyBooking($id)
    {
        $order = Order::findOrFail($id);
        // Tambahkan logika update status verifikasi lu di sini, contoh:
        // $order->update(['status' => 'diverifikasi']);

        return redirect()->back()->with('notif_sukses', 'Tiket berhasil diverifikasi! Timer 12 jam dimulai.');
    }

    /**
     * Logika untuk membatalkan verifikasi pesanan
     */
    public function unverifyBooking($id)
    {
        $order = Order::findOrFail($id);
        // Tambahkan logika batalkan status verifikasi lu di sini

        return redirect()->back()->with('notif_sukses', 'Verifikasi tiket berhasil dibatalkan.');
    }
}