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
        $user = auth()->user();

        // 1. Jika Superadmin (Role = admin) -> Tampilkan SEMUA data
        if ($user->role === 'admin') {
            $totalRevenue = Transaction::where('status', 'success')->sum('total_price') ?? 0;
            $ticketsSold = Transaction::where('status', 'success')->count() ?? 0;
            $activeEvents = Event::where('date', '>=', now())->count() ?? 0;
            $pendingTransactions = Transaction::where('status', 'pending')->count() ?? 0;
        } 
        // 2. Jika Panitia / HIMA -> Tampilkan HANYA data milik organisasinya
        else {
            $organizationId = $user->organization ? $user->organization->id : null;
            $eventIds = Event::where('organization_id', $organizationId)->pluck('id');

            $totalRevenue = Transaction::whereIn('event_id', $eventIds)->where('status', 'success')->sum('total_price') ?? 0;
            $ticketsSold = Transaction::whereIn('event_id', $eventIds)->where('status', 'success')->count() ?? 0;
            $activeEvents = Event::whereIn('id', $eventIds)->where('date', '>=', now())->count() ?? 0;
            $pendingTransactions = Transaction::whereIn('event_id', $eventIds)->where('status', 'pending')->count() ?? 0;
        }

        // Kirim variabelnya ke dalam view admin.index
        return view('admin.index', compact(
            'totalRevenue', 
            'ticketsSold', 
            'activeEvents', 
            'pendingTransactions'
        ));
    }
}