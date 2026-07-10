<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN memiliki role 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Lanjutkan perjalanan jika dia admin
        }

        // Jika bukan admin (misal user biasa), tendang kembali ke halaman depan atau home
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}