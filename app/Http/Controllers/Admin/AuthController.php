<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login admin.
     */
    public function showLoginForm()
    {
        // Jika sudah login, langsung ke dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        // Mengarahkan ke resources/views/auth/login.blade.php
        return view('auth.login'); 
    }

    /**
     * Memproses data login (Authentication).
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba proses otentikasi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                             ->with('success', 'Login berhasil! Selamat datang kembali.');
        }

        // 3. Jika gagal
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
                         ->with('success', 'Anda telah berhasil logout.');
    }
}