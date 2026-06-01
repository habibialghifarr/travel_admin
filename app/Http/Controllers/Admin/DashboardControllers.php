<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket; 
use App\Models\Booking;
use App\Models\Order; // <-- KITA PANGGIL MODEL ORDER DI SINI BIAR RAPI
use Illuminate\Http\Request;

class DashboardControllers extends Controller
{
    public function index()
    {
        // 1. Hitung data asli dari database tabel orders untuk angka di Card Dashboard
        $total_pesanan = Order::count();
        $total_tiket_terjual = Order::sum('jumlah_tiket');
        $total_pendapatan = Order::sum('total_harga');

        // 2. Ambil data tiket untuk tabel manajemen penerbangan di bagian bawah dashboard
        $daftarTiket = Tiket::latest()->get(); 

        // 3. LEMPAR SEMUA VARIABEL YANG DIBUTUHKAN KE VIEW
        return view('admin.dashboard', compact(
            'total_pesanan', 
            'total_tiket_terjual', 
            'total_pendapatan', 
            'daftarTiket'
        ));
    }

    public function halamanPembooking()
    {
        // Menampilkan data pembooking lama (jika view admin.pembooking masih dipakai)
        $semuaPembooking = Booking::with('tiket')->latest()->get(); 
        return view('admin.pembooking', compact('semuaPembooking'));
    }

    public function simpanTiket(Request $request)
    {
        $request->validate([
            'nama_maskapai' => 'required',
            'nomor_penerbangan' => 'required',
            'bandara_asal' => 'required',
            'bandara_tujuan' => 'required',
            'waktu_berangkat' => 'required',
            'harga_tiket' => 'required|numeric',
            'sisa_stok' => 'required|numeric',
        ]);

        Tiket::create($request->all()); 
        return back()->with('notif_sukses', 'Sip! Tiket penerbangan baru berhasil ditambahkan.');
    }

    public function ubahTiket(Request $request, Tiket $tiket) 
    {
        $tiket->update($request->all());
        return back()->with('notif_sukses', 'Mantap! Data tiket berhasil diperbarui.');
    }

    public function hapusTiket(Tiket $tiket) 
    {
        $tiket->delete();
        return back()->with('notif_sukses', 'Data tiket penerbangan telah dihapus dari sistem.');
    }
}