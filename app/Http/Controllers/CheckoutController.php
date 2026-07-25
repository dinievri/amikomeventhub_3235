<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Exception;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $categories = Category::all();

        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
        ]);

        $orderId = 'TRX-' . time() . '-' . strtoupper(Str::random(5));
        $totalPrice = (int) $event->price;

        // ==========================================
        // 1. LOGIKA UNTUK EVENT GRATIS (PRICE <= 0)
        // ==========================================
        if ($totalPrice <= 0) {
            // Cek stok jika ada kolom stok di tabel event
            if (isset($event->stock) && $event->stock < 1) {
                return back()->with('error', 'Maaf, stok tiket untuk event gratis ini sudah habis.');
            }

            // Langsung simpan transaksi dengan status 'success' (Bypass Midtrans)
            $transaction = Transaction::create([
                'event_id'       => $event->id,
                'order_id'       => $orderId,
                'customer_name'  => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'total_price'    => 0,
                'status'         => 'success', // Langsung dianggap LUNAS/BERHASIL
                'snap_token'     => null       // Tidak memerlukan token Midtrans
            ]);

            // Kurangi stok jika event menggunakan sistem kuota/stok
            if (isset($event->stock)) {
                $event->decrement('stock');
            }

            // Redirect langsung ke halaman sukses (E-Ticket)
            return redirect()->route('checkout.success', $transaction->order_id)
                             ->with('success', 'Pendaftaran berhasil! E-Ticket Anda telah diterbitkan.');
        }

        // ==========================================
        // 2. LOGIKA UNTUK EVENT BERBAYAR (MIDTRANS)
        // ==========================================
        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $totalPrice,
            'status'         => 'pending'
        ]);

        // Setup Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = Config::get('midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        \Midtrans\Config::$isProduction = Config::get('midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email'      => $request->customer_email,
                'phone'      => $request->customer_phone,
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $transaction->update([
                'snap_token' => $snapToken
            ]);

            return redirect()->route('checkout.payment', $transaction->order_id);

        } catch (Exception $e) {
            $transaction->update(['status' => 'failed']);

            return back()->with('error', 'Gagal membuat kode bayar Midtrans: ' . $e->getMessage());
        }
    }

    public function payment($order_id)
    {
        $categories = Category::all();

        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        // Jika transaksi ini sudah berstatus success (misal hasil bypass event gratis), 
        // langsung alihkan ke halaman success agar tidak bisa masuk ke halaman payment
        if ($transaction->status === 'success') {
            return redirect()->route('checkout.success', $transaction->order_id);
        }

        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        $categories = Category::all();

        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();

        // Jalankan pengecekan status Midtrans HANYA jika harganya > 0 dan statusnya belum success
        if ($transaction->total_price > 0 && $transaction->status !== 'success') {
            \Midtrans\Config::$serverKey = Config::get('midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
            \Midtrans\Config::$isProduction = Config::get('midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));

            try {
                $midtransStatus = \Midtrans\Transaction::status($order_id);

                if (in_array($midtransStatus->transaction_status, ['capture', 'settlement'])) {
                    $transaction->update(['status' => 'success']);
                }
            } catch (Exception $e) {
                // Biarkan halaman success tetap muncul meskipun pengecekan API timeout
            }
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}