<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // PANGGIL MODEL ORDER YANG BARU
use Illuminate\Support\Facades\Auth;

class TiketController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'pembeli') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak bisa beli tiket!');
        }

        $tikets = [
            ['id' => 1, 'flight' => 'GA-101', 'from' => 'JAKARTA (CGK)', 'to' => 'TOKYO (HND)', 'date' => '15 AUG 2026', 'time' => '07:30', 'gate' => '02', 'harga_dasar' => 3000000],
            ['id' => 2, 'flight' => 'SQ-223', 'from' => 'BALI (DPS)', 'to' => 'SINGAPORE (SIN)', 'date' => '20 AUG 2026', 'time' => '13:15', 'gate' => '05', 'harga_dasar' => 1500000],
            ['id' => 3, 'flight' => 'EK-357', 'from' => 'SURABAYA (SUB)', 'to' => 'LONDON (LHR)', 'date' => '28 AUG 2026', 'time' => '21:00', 'gate' => '01', 'harga_dasar' => 7500000]
        ];

        return view('tiket.index', compact('tikets'));
    }

  public function pesan(Request $request)
    {
        // 1. Ubah data string dari form menjadi angka murni
        $harga_dasar = (int) $request->harga_dasar;
        $jumlah_tiket = (int) $request->jumlah_tiket;
        
        // 2. Hitung harga multiplier
        $multiplier = 1;
        if ($request->kelas === 'Bisnis') {
            $multiplier = 2;
        } elseif ($request->kelas === 'First Class') {
            $multiplier = 4;
        }

        // 3. Kalkulasi total
        $total_harga = ($harga_dasar * $multiplier) * $jumlah_tiket;

        // 4. Paksa simpan ke database
        \App\Models\Order::create([
            'nama_lengkap' => $request->nama_lengkap ?? 'Guest Pembeli', 
            'gmail'        => $request->gmail ?? 'pembeli@travel.com',
            'alamat'       => $request->alamat ?? 'Tidak mengisi alamat',
            'jumlah_tiket' => $jumlah_tiket,
            'kelas'        => $request->kelas ?? 'Ekonomi',
            'from'         => $request->from ?? 'Origin',
            'to'           => $request->to ?? 'Destination',
            'flight'       => $request->flight ?? 'FL-000',
            'total_harga'  => $total_harga,
            'status'       => 'Pending'
        ]);

        return redirect()->route('tiket.index')->with('success_pesan', 'Tiket berhasil dipesan! Data sudah aman tersimpan di Database.');
    }
public function adminBookings()
{
    // Ambil semua data dari model Order (tabel orders) urut dari yang terbaru
    $bookings = \App\Models\Order::latest()->get();

    // Lempar data ke file view blade admin
    return view('admin.bookings', compact('bookings'));
}
    public function verifikasi($id)
    {
        // VERIFIKASI DI TABEL ORDERS
        $booking = Order::findOrFail($id);
        $booking->update([
            'status' => 'Verified',
            'verified_at' => now()->toIso8601String()
        ]);

        return back()->with('success', 'Tiket terverifikasi di database!');
    }

    public function hapusBooking($id)
    {
        // HAPUS DI TABEL ORDERS
        $booking = Order::findOrFail($id);
        $booking->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}