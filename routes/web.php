<?php

use Illuminate\Support\Facades\Route;

// 1. Import Controller Utama & User
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransWebhookController; // Pastikan import webhook

// 2. Import Controller Admin
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute fallback default Laravel jika terhalang auth (Dilempar ke halaman login Admin)
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


// ======================================================
// FRONTEND & CHECKOUT AREA (Publik / Guest Checkout)
// ======================================================
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/event/{event}', [WelcomeController::class, 'showEvent'])->name('events.show');

// Checkout (Dikeluarkan dari auth sesuai Modul yang menerapkan Guest Checkout)
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

// Webhook / Callback Midtrans (Harus bebas dari middleware CSRF & Auth)
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle']);


// ======================================================
// HALAMAN STATIS / MEMBER (Jika ada pengguna non-admin)
// ======================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
    Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');
    Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');
    Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
    Route::get('/my-ticket', [HomeController::class, 'ticket'])->name('ticket');
});


// ======================================================
// ADMIN AREA 
// ======================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // 3. Rute Login Admin
    // (Bebas dari auth supaya admin bisa buka form login)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    
    // PERBAIKAN: Ubah jadi login.post agar cocok dengan form View sebelumnya
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 4. Panel Administrasi
    // (Wajib sudah login dan role admin)
    Route::middleware(['auth', 'admin'])->group(function () {
        
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Redirect legacy /admin/events/categories URL to the correct categories page
        Route::redirect('events/categories', 'categories');

        // CRUD Resource untuk entitas data
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class);
        Route::resource('events', EventController::class);

        // Laporan Transaksi
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });
});