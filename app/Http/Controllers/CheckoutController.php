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
        // 1. Validasi Input Data Pemesan
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'coupon_code'    => 'nullable|string',
        ]);

        $orderId = 'TRX-' . time() . '-' . strtoupper(Str::random(5));
        $originalPrice = (int) $event->price;
        $discount = 0;

        // 2. Logika Diskon & Kupon
        if ($request->filled('coupon_code')) {
            $code = strtoupper(trim($request->coupon_code));
            
            if ($code === 'MAHASISWA50') {
                $discount = $originalPrice * 0.5; // Diskon 50%
            } elseif ($code === 'GRATIS100') {
                $discount = $originalPrice; // Diskon 100%
            } else {
                return back()->with('error', 'Kode kupon/voucher tidak valid!')->withInput();
            }
        }

        $totalPrice = max(0, $originalPrice - $discount);

        // 3. LOGIKA BYPASS UNTUK TIKET GRATIS / DISKON 100%
        if ($totalPrice <= 0) {
            if (isset($event->stock) && $event->stock < 1) {
                return back()->with('error', 'Maaf, stok tiket ini sudah habis.')->withInput();
            }

            $transaction = Transaction::create([
                'event_id'       => $event->id,
                'order_id'       => $orderId,
                'customer_name'  => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'total_price'    => 0,
                'status'         => 'success', // Direct LUNAS
                'snap_token'     => null
            ]);

            if (isset($event->stock)) {
                $event->decrement('stock');
            }

            // Redirect langsung ke halaman sukses (E-Ticket)
            return redirect()->route('checkout.success', ['order_id' => $transaction->order_id])
                             ->with('success', 'Pendaftaran berhasil! E-Ticket Gratis Anda telah diterbitkan.');
        }

        // 4. LOGIKA PEMBAYARAN MIDTRANS (EVENT BERBAYAR)
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

            $transaction = Transaction::create([
                'event_id'       => $event->id,
                'order_id'       => $orderId,
                'customer_name'  => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'total_price'    => $totalPrice,
                'status'         => 'pending',
                'snap_token'     => $snapToken
            ]);

            // Redirect ke instruksi bayar Midtrans
            return redirect()->route('checkout.payment', ['order_id' => $transaction->order_id]);

        } catch (Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran Midtrans: ' . $e->getMessage())->withInput();
        }
    }

    public function payment($order_id)
    {
        $categories = Category::all();

        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        if ($transaction->status === 'success') {
            return redirect()->route('checkout.success', ['order_id' => $transaction->order_id]);
        }

        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        $categories = Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        if ($transaction->total_price > 0 && $transaction->status !== 'success') {
            \Midtrans\Config::$serverKey = Config::get('midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
            \Midtrans\Config::$isProduction = Config::get('midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));

            try {
                $midtransStatus = \Midtrans\Transaction::status($order_id);

                if (in_array($midtransStatus->transaction_status, ['capture', 'settlement'])) {
                    $transaction->update(['status' => 'success']);
                }
            } catch (Exception $e) {
                // Biarkan tetap lanjut jika ada error jaringan Midtrans
            }
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}