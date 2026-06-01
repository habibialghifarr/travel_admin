<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket; // <-- UBAH DI SINI
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardControllers extends Controller
{
    public function index()
    {
        $totalPenjualan = Booking::where('status_pesanan', 'dibayar')->count();
        $totalPendapatan = Booking::where('status_pesanan', 'dibayar')->sum('total_bayar');
        $totalTiketTerbeli = Booking::where('status_pesanan', 'dibayar')->sum('jumlah_kursi');
        $tiketTerbooking = Booking::where('status_pesanan', 'dibooking')->sum('jumlah_kursi');

        $daftarTiket = Tiket::latest()->get(); // <-- UBAH DI SINI

        return view('admin.dashboard', compact(
            'totalPenjualan', 
            'totalPendapatan', 
            'totalTiketTerbeli', 
            'tiketTerbooking', 
            'daftarTiket'
        ));
    }

    public function halamanPembooking()
    {
        // Panggil relasi tiket yang baru
        $semuaPembooking = Booking::with('tiket')->latest()->get(); // <-- UBAH DI SINI
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

        Tiket::create($request->all()); // <-- UBAH DI SINI
        return back()->with('notif_sukses', 'Sip! Tiket penerbangan baru berhasil ditambahkan.');
    }

    // Ubah parameter Ticket $ticket menjadi Tiket $tiket
    public function ubahTiket(Request $request, Tiket $tiket) 
    {
        $tiket->update($request->all());
        return back()->with('notif_sukses', 'Mantap! Data tiket berhasil diperbarui.');
    }

    // Ubah parameter Ticket $ticket menjadi Tiket $tiket
    public function hapusTiket(Tiket $tiket) 
    {
        $tiket->delete();
        return back()->with('notif_sukses', 'Data tiket penerbangan telah dihapus dari sistem.');
    }
}