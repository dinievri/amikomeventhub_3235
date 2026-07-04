<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction; 
use App\Models\Event;       
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung data agregat asli dari database hasil pertemuan 10-11
        $totalRevenue = Transaction::where('status', 'success')->sum('total_price') ?? 0;
        $ticketsSold = Transaction::where('status', 'success')->count() ?? 0; // atau sesuaikan jika ada qty
        $activeEvents = Event::where('date', '>=', now())->count() ?? 0;
        $pendingTransactions = Transaction::where('status', 'pending')->count() ?? 0;

        // Kirim variabelnya ke dalam view admin.index
        return view('admin.index', compact(
            'totalRevenue', 
            'ticketsSold', 
            'activeEvents', 
            'pendingTransactions'
        ));
    }
}