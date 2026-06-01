<?php

namespace App\Http\Controllers;

use App\Models\Tiket; // <-- UBAH DI SINI
use App\Models\Booking;
use Illuminate\Http\Request;

class HalamanDepanController extends Controller
{
    public function prosesPesan(Request $request)
    {
        $request->validate([
            'tiket_id'     => 'required|exists:tikets,id', // <-- UBAH DI SINI
            'nama_pembeli' => 'required|string',
            'nomor_hp'     => 'required|string',
            'jumlah_kursi' => 'required|numeric|min:1',
        ]);

        $tiket = Tiket::findOrFail($request->tiket_id); // <-- UBAH DI SINI

        if ($tiket->sisa_stok < $request->jumlah_kursi) {
            return back()->with('error', 'Maaf, sisa tiket tidak mencukupi.');
        }

        $totalBayar = $tiket->harga_tiket * $request->jumlah_kursi;

        Booking::create([
            'tiket_id'       => $tiket->id, // <-- UBAH DI SINI
            'nama_pembeli'   => $request->nama_pembeli,
            'nomor_hp'       => $request->nomor_hp,
            'jumlah_kursi'   => $request->jumlah_kursi,
            'total_bayar'    => $totalBayar,
            'status_pesanan' => 'dibooking',
        ]);

        $tiket->decrement('sisa_stok', $request->jumlah_kursi);

        return back()->with('sukses', 'Tiket berhasil dipesan! Silakan lakukan pembayaran.');
    }
}