<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Pastikan ini sesuai dengan nama tabel di phpMyAdmin kamu (bisa 'orders' atau 'bookings')
    protected $table = 'orders'; 

    // BUKA SEMUA GEMBOK PROTEKSI FORM!
    protected $guarded = []; 
}