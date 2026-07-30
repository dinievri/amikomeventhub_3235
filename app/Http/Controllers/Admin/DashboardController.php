<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction; 
use App\Models\Event; 
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $totalRevenue = Transaction::where('status', 'success')->sum('total_price') ?? 0;
            $ticketsSold = Transaction::where('status', 'success')->count() ?? 0;
            $activeEvents = Event::where('date', '>=', now())->count() ?? 0;
            $pendingTransactions = Transaction::where('status', 'pending')->count() ?? 0;
            $totalUsers = User::count();
            
            $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

            // --- TAMBAHAN UNTUK GRAFIK (SOAL 2) ---
            // Data Pertumbuhan Event per Bulan
            $monthlyEvents = Event::select(
                DB::raw("COUNT(*) as count"),
                DB::raw("MONTHNAME(created_at) as month_name")
            )
            ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("MONTHNAME(created_at)"))
            ->pluck('count', 'month_name');

        } else {
            $organizationId = $user->organization ? $user->organization->id : null;
            $eventIds = Event::where('organization_id', $organizationId)->pluck('id');

            $totalRevenue = Transaction::whereIn('event_id', $eventIds)->where('status', 'success')->sum('total_price') ?? 0;
            $ticketsSold = Transaction::whereIn('event_id', $eventIds)->where('status', 'success')->count() ?? 0;
            $activeEvents = Event::whereIn('id', $eventIds)->where('date', '>=', now())->count() ?? 0;
            $pendingTransactions = Transaction::whereIn('event_id', $eventIds)->where('status', 'pending')->count() ?? 0;
            $totalUsers = null;

            $recentTransactions = Transaction::with('event')->whereIn('event_id', $eventIds)->latest()->take(5)->get();

            // --- TAMBAHAN UNTUK GRAFIK (SOAL 2) ---
            $monthlyEvents = Event::whereIn('id', $eventIds)
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw("MONTHNAME(created_at) as month_name")
            )
            ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("MONTHNAME(created_at)"))
            ->pluck('count', 'month_name');
        }

        return view('admin.index', compact(
            'totalRevenue', 
            'ticketsSold', 
            'activeEvents', 
            'pendingTransactions',
            'totalUsers',
            'recentTransactions',
            'monthlyEvents' // Pass data grafik ke view
        ));
    }
}