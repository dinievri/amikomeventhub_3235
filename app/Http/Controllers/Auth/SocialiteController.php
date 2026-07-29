<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    // 1. Fungsi saat tombol "Login dengan Google" diklik
    public function redirectToGoogle()
    {
        // Tambahkan ->stateless() di sini
        return Socialite::driver('google')->stateless()->redirect();
    }

    // 2. Fungsi callback setelah user pilih akun Google (kode milikmu saat ini)
    public function handleGoogleCallback(Request $request)
    {
        // Sudah ada ->stateless() (SUDAH BENAR)
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Simpan atau update data customer
        $customer = Customer::updateOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name'      => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
        ]);

        // Login-kan customer ke guard
        Auth::guard('customer')->login($customer, true);

        return redirect()->to('/dashboard'); // Sesuaikan rute setelah login
    }
}