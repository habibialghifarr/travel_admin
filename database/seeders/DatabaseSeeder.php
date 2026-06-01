<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun Admin otomatis
        User::create([
            'name' => 'Admin',
            'email' => 'admin@travel.com',
            'password' => bcrypt('12345'),
            'role' => 'admin'
        ]);

        // Buat akun Customer otomatis (Pakai nama Customer biar sinkron)
        User::create([
            'name' => 'Customer',
            'email' => 'customer@travel.com',
            'password' => bcrypt('54321'),
            'role' => 'pembeli'
        ]);
    }
}