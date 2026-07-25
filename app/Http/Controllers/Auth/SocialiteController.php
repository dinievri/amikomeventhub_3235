<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    // Redirect user ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback setelah user berhasil/gagal login dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $customer = Customer::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
            ]);

            // Login ke guard "customer", BUKAN guard "web" (guard web khusus Admin/Organizer)
            Auth::guard('customer')->login($customer);

            return redirect()->route('welcome')->with('success', 'Berhasil login dengan Google, silakan lanjutkan pemesanan tiket.');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Gagal login menggunakan akun Google: ' . $e->getMessage());
        }
    }
}