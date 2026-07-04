<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // placeholder untuk Midtrans callback
        return response()->json(['status' => 'ok']);
    }
}
