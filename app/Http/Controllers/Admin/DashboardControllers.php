<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket; 
use App\Models\Booking;
use App\Models\Order; 
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
        // Menampilkan data pembooking lama
        $semuaPembooking = Booking::with('tiket')->latest()->get(); 
        return view('admin.pembooking', compact('semuaPembooking'));
    }

    // GUA BERESIN METHOD INI BIAR GAK DOUBLE / BERTUMPUK LAGI, BRO!
    public function simpanTiket(Request $request)
    {
        // 1. Validasi input dari form admin
        $request->validate([
            'nama_maskapai'     => 'required|string|max:255',
            'nomor_penerbangan' => 'required|string|max:50',
            'bandara_asal'      => 'required|string|max:100',
            'bandara_tujuan'    => 'required|string|max:100',
            'harga_tiket'       => 'required|numeric|min:0',
            'sisa_stok'         => 'required|integer|min:0',
        ]);

        // 2. Simpan ke database menggunakan Model Tiket
        Tiket::create([
            'nama_maskapai'     => $request->nama_maskapai,
            'nomor_penerbangan' => $request->nomor_penerbangan,
            'bandara_asal'      => $request->bandara_asal,
            'bandara_tujuan'    => $request->bandara_tujuan,
            'waktu_berangkat'   => now(), // Isi waktu otomatis karena di form modal lu ga ada inputan jam
            'harga_tiket'       => $request->harga_tiket,
            'sisa_stok'         => $request->sisa_stok,
        ]);

        // 3. Kembalikan halaman dengan notif sukses (sesuai template admin lu)
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