<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login admin
     */
    public function showLoginForm()
    {
        // Pastikan Anda sudah membuat file view: resources/views/admin/auth/login.blade.php
        return view('auth.login'); 
        // Catatan: sesuaikan 'auth.login' dengan nama/lokasi file blade login Anda sesuai modul
    }

    /**
     * Memproses data login (Authentication)
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba melakukan otentikasi
        if (Auth::attempt($credentials)) {
            // Jika berhasil, regenerasi session
            $request->session()->regenerate();

            // Arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard'))
                             ->with('success', 'Login berhasil! Selamat datang.');
        }

        // 3. Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login
        return redirect()->route('admin.login')
                         ->with('success', 'Anda telah berhasil logout.');
    }
}