<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket; 
use App\Models\Order; 

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
     * HALAMAN MANIFEST & VERIFIKASI TIMER 12 JAM (ADMIN)
     */
    public function adminBookings()
    {
        $semuaPembooking = Order::latest()->get(); 
        return view('admin.bookings', compact('semuaPembooking'));
    }

    /**
     * Logika untuk memverifikasi pesanan (TIMER NYALA SINKRON)
     */
    public function verifyBooking($id)
    {
        $order = Order::findOrFail($id);

        // Mengisi kolom penanda waktu agar JS membaca sisa jam mundur
        $order->verified_at = now(); 
        
        // STATUS DISAMAKAN MENJADI 'Diverifikasi' AGAR SINKRON DENGAN BLADE LU!
        $order->status = 'Diverifikasi';
        
        $order->save();

        return redirect()->back()->with('success', 'Tiket berhasil diverifikasi! Timer 12 jam dimulai.');
    }

    /**
     * Logika untuk menghapus orderan janggal dari database
     */
    public function unverifyBooking($id)
    {
        $order = Order::findOrFail($id);

        // Langsung hapus total data tanpa perlu update status penengah yang tabrakan
        $order->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan dan dihapus permanen!');
    }

    /**
     * PROSES SIMPAN BOOKING TIKET BARU DARI MODAL PEMBELI
     */
    public function pesan(Request $request)
    {
        // 1. Validasi data form modal
        $request->validate([
            'flight' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'gmail' => 'required|email',
            'alamat' => 'required',
            'jumlah_tiket' => 'required|integer|min:1',
            'kelas' => 'required',
            'from' => 'required',
            'to' => 'required',
            'harga_dasar' => 'required|numeric'
        ]);

        // 2. Eksekusi Model
        $booking = new Order(); 

        // 3. Sinkronisasi Kolom Database (`image_e25669.png`)
        $booking->nama_lengkap = $request->nama_lengkap;
        $booking->gmail        = $request->gmail;
        $booking->alamat       = $request->alamat;
        $booking->jumlah_tiket = $request->jumlah_tiket;
        $booking->kelas        = $request->kelas;
        $booking->from         = $request->from;
        $booking->to           = $request->to;
        $booking->flight       = $request->flight;
        
        // Hitung total harga otomatis
        $booking->total_harga  = $request->harga_dasar * $request->jumlah_tiket;
        
        // Status awal default
        $booking->status       = 'Pending'; 
        $booking->verified_at  = null;

        $booking->save(); 

        // 4. Menggunakan session 'success' biar dibaca komponen Alert Blade lu
        return redirect()->back()->with('success', 'Yeay! Berhasil memesan tiket penerbangan!');
    }
}