<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function ticket()
    {
        // Ambil data customer yang sedang login
        $customer = Auth::guard('customer')->user() ?? Auth::user();

        // Jika belum login, redirect ke halaman login
        if (!$customer) {
            return redirect()->route('customer.login')->with('error', 'Silakan login terlebih dahulu untuk melihat tiket.');
        }

        // Ambil transaksi milik customer yang statusnya success/lunas
        $transactions = Transaction::with('event')
            ->where('customer_email', $customer->email)
            ->where('status', 'success')
            ->latest()
            ->get();

        return view('ticket', compact('transactions'));
    }
}