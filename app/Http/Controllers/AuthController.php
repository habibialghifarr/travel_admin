<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function halamanLogin()
    {
        return view('auth.login');
    }

    // Memproses data login menggunakan Username
    public function prosesLogin(Request $request)
    {
        // Validasi input username, bukan email lagi
        $kredensial = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Proses autentikasi mencocokkan kolom 'name' (username) di database
        if (Auth::attempt(['name' => $kredensial['username'], 'password' => $kredensial['password']])) {
            $request->session()->regenerate();
            
            // Cek apakah user beneran admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
if (Auth::user()->role === 'pembeli') {
    return redirect()->route('tiket.index');
}
            // Jika ternyata dia pembeli, logout paksa
            Auth::logout();
            return back()->with('error_login', 'Akses ditolak! Halaman ini khusus untuk Admin.')->withInput();
        }

        // Jika gagal login
        return back()->with('error_login', 'Username atau password salah! silakan cek kembali.')->withInput();
    }

    // Memproses Logout (Kembalikan fungsi yang tadi terpotong)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
} // Penutup kelas AuthController