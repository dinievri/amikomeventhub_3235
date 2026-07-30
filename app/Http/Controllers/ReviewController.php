<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Menyimpan review baru untuk sebuah event.
     */
    public function store(Request $request, Event $event)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return back()->with('error', 'Silakan login terlebih dahulu.');
        }

        // 1. Validasi input dari form
        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // 2. Cari transaksi lunas berdasarkan email customer
        $transaction = Transaction::where('event_id', $event->id)
            ->where('customer_email', $customer->email)
            ->where('status', 'success')
            ->first();

        if (!$transaction) {
            return back()->with('error', 'Anda belum pernah membeli tiket untuk event ini, atau status pembayaran belum lunas.');
        }

        // 3. Cegah customer mengisi review dua kali untuk transaksi yang sama
        $existing = Review::where('transaction_id', $transaction->id)->first();
        if ($existing) {
            return back()->with('error', 'Anda sudah pernah memberi ulasan untuk pembelian ini.');
        }

        // 4. Simpan review baru (TAMBAHKAN user_id DI SINI)
        Review::create([
            'user_id'        => $customer->id, // <--- INI SOLUSI UTAMANYA!
            'event_id'       => $event->id,
            'transaction_id' => $transaction->id,
            'rating'         => $data['rating'],
            'comment'        => $data['comment'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}