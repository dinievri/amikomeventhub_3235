<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        // Verifikasi keaslian request dari Midtrans
        if ($hashed == $request->signature_key) {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            
            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            $transactionStatus = $request->transaction_status;

            // Logika perubahan status transaksi
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $transaction->status = 'failed';
            } else if ($transactionStatus == 'pending') {
                $transaction->status = 'pending';
            }

            $transaction->save();
            return response()->json(['message' => 'OK']);
        }
        
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    private function processSuccess(Transaction $transaction) 
    {
        // Instruksi lanjutan saat transaksi lunas (pemotongan tiket) 
        // akan dibahas pada Modul 13
    }
}