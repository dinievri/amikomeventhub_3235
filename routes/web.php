<?php

use Illuminate\Support\Facades\Route;

// 1. Import Controller Utama & User
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransWebhookController;

// 2. Import Controller Admin
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CheckInController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Fallback /login untuk customer diarahkan ke Google Login (dipakai otomatis oleh middleware auth:customer)
Route::get('/login', function () {
    return redirect()->route('google.login');
})->name('login');


// ======================================================
// LOGIN GOOGLE (SOCIALITE) - UNTUK CUSTOMER, DI LUAR GRUP ADMIN
// ======================================================
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');


// ======================================================
// FRONTEND & CHECKOUT AREA (Publik / Guest Checkout / Boleh Tanpa Login)
// ======================================================
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/event/{event}', [WelcomeController::class, 'showEvent'])->name('events.show');

// Checkout Routes
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

// Webhook / Callback Midtrans
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle']);

// Halaman statis publik (TIDAK butuh login, sesuai modul awal)
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');
Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/my-ticket', [HomeController::class, 'ticket'])->name('ticket');


// ======================================================
// REVIEW (KHUSUS CUSTOMER YANG SUDAH LOGIN GOOGLE)
// ======================================================
Route::middleware(['auth:customer'])->group(function () {
    Route::post('/events/{event}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});


// ======================================================
// ADMIN AREA
// ======================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // 3. Rute Login Admin
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 4. Panel Administrasi
    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::redirect('events/categories', 'categories');

        // CRUD Resource
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class);
        Route::resource('events', EventController::class);

        // Laporan Transaksi
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

        // Scanner Check-In QR Code
        Route::get('/checkin', [CheckInController::class, 'index'])->name('checkin.index');
        Route::post('/checkin/process', [CheckInController::class, 'process'])->name('checkin.process');
    });
});