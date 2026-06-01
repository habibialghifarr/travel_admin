<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    // Definisikan nama tabel secara eksplisit
    protected $table = 'tikets'; 

    // INI KUNCI UTAMANYA, BRO! Daftarkan semua kolom database lu di sini
    protected $fillable = [
        'nama_maskapai',
        'nomor_penerbangan',
        'bandara_asal',
        'bandara_tujuan',
        'waktu_berangkat',
        'harga_tiket',
        'sisa_stok',
    ];
}