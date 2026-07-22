<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    // Menampilkan halaman kamera scanner
    public function index()
    {
        return view('admin.checkin.index');
    }

    // Memproses hasil scan QR Code
    public function process(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string'
        ]);

        $transaction = Transaction::where('order_id', $request->order_id)->first();

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => '❌ Tiket tidak ditemukan / Tidak Valid!'
            ], 404);
        }

        if ($transaction->status !== 'Success') {
            return response()->json([
                'status'  => 'error',
                'message' => '⚠️ Transaksi belum lunas!'
            ], 400);
        }

        if ($transaction->is_used) {
            return response()->json([
                'status'  => 'warning',
                'message' => '⛔ TIKET SUDAH PERNAH DIGUNAKAN KELUAR/MASUK!'
            ], 400);
        }

        // Tandai tiket sudah dipakai
        $transaction->update(['is_used' => true]);

        return response()->json([
            'status'  => 'success',
            'message' => '✅ CHECK-IN BERHASIL! Selamat Datang, ' . $transaction->customer_name
        ]);
    }
}