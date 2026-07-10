<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // --- KODE ALIAS MIDDLEWARE ADMIN ---
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // --- TAMBAHAN MODUL 12: Pengecualian CSRF untuk Webhook Midtrans ---
        // Tanpa kode ini, notifikasi pembayaran dari Midtrans akan ditolak (Error 419)
        $middleware->validateCsrfTokens(except: [
            '/midtrans/callback',
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();