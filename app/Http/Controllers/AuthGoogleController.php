<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;

class AuthGoogleController extends Controller
{
    // Fungsi ini dipanggil saat tombol "Continue with Google" diklik
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Fungsi ini dipanggil Google setelah user berhasil login di sana
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $customer = Customer::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
            ]
        );

        // Simpan data customer ke session, supaya bisa dipakai di halaman checkout
        session([
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
        ]);

        return redirect()->route('home')->with('success', 'Berhasil login dengan Google, silakan pilih event untuk checkout.');
    }
}