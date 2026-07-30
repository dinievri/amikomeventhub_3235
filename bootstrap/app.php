<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // --- REDIRECT GUEST BERDASARKAN URL ---
        $middleware->redirectGuestsTo(function (Request $request) {
            // Jika user mengakses URL berawalan /admin, lempar ke form login admin
            if ($request->is('admin*')) {
                return route('admin.login'); // Sesuai dengan Route::name('admin.')->group(... Route::get('/login')->name('login') ...)
            }
            // Selain itu (customer), lempar ke Google Login
            return route('google.login');
        });

        // --- ALIAS MIDDLEWARE ADMIN ---
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // --- PENGECUALIAN CSRF MIDTRANS ---
        $middleware->validateCsrfTokens(except: [
            '/midtrans/callback',
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();