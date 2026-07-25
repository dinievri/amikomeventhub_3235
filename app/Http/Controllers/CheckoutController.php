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

        // Cek jika harga event 0 atau kosong (Midtrans menolak nominal 0)
        $totalPrice = (int) $event->price;
        if ($totalPrice <= 0) {
            return back()->with('error', 'Harga tiket tidak valid untuk transaksi.');
        }

        $orderId = 'TRX-' . time() . '-' . strtoupper(Str::random(5));

        // 1. Buat Transaksi di DB lebih dulu
        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $totalPrice,
            'status'         => 'pending'
        ]);

        // 2. Setup Konfigurasi Midtrans
        // Gunakan env() langsung sebagai fallback jika config/midtrans.php belum di-set
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
            // Ambil token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan snap token ke DB
            $transaction->update([
                'snap_token' => $snapToken
            ]);

            return redirect()->route('checkout.payment', $transaction->order_id);

        } catch (Exception $e) {
            // Jika koneksi Midtrans gagal/timeout, ubah status transaksi agar tidak menggantung
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

        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        $categories = Category::all();

        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();

        \Midtrans\Config::$serverKey = Config::get('midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        \Midtrans\Config::$isProduction = Config::get('midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));

        try {
            $midtransStatus = \Midtrans\Transaction::status($order_id);

            if (in_array($midtransStatus->transaction_status, ['capture', 'settlement'])) {
                $transaction->update(['status' => 'success']);
            }
        } catch (Exception $e) {
            // Biarkan halaman success tetap muncul meskipun pengecekan status API timeout
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}