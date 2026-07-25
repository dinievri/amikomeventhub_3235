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
     * Hanya customer yang sudah login via Google (guard: customer)
     * DAN pernah membeli tiket event ini dengan status success
     * DAN acaranya sudah lewat H+1 yang boleh mengisi review.
     */
    public function store(Request $request, Event $event)
    {
        $customer = Auth::guard('customer')->user();

        // 1. Validasi input dari form
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // 2. Pastikan customer benar-benar pernah membeli tiket event ini
        //    dan transaksinya sudah lunas (success)
        $transaction = Transaction::where('event_id', $event->id)
            ->where('customer_email', $customer->email)
            ->where('status', 'success')
            ->first();

        abort_unless(
            $transaction,
            403,
            'Anda belum pernah membeli tiket untuk event ini, atau pembayaran belum lunas.'
        );

        // 3. Pastikan acara sudah selesai minimal 1 hari (H+1)
        abort_unless(
            now()->greaterThan($event->date->addDay()),
            403,
            'Review baru bisa diisi sehari setelah acara selesai.'
        );

        // 4. Cegah customer yang sama mengisi review dua kali untuk transaksi yang sama
        $existing = Review::where('transaction_id', $transaction->id)->first();
        if ($existing) {
            return back()->with('error', 'Anda sudah pernah memberi ulasan untuk pembelian ini.');
        }

        // 5. Simpan review baru
        Review::create([
            'event_id' => $event->id,
            'transaction_id' => $transaction->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}