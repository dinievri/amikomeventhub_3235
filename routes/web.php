<?php

use Illuminate\Support\Facades\Route;

// Import Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CheckoutController;

// Controller Admin
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ======================================================
// FRONTEND / USER AREA
// ======================================================

// Halaman Utama
Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');

// Detail Event
Route::get('/event/{event}', [WelcomeController::class, 'showEvent'])
    ->name('events.show');

// Checkout
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::post('/checkout/{event}', [CheckoutController::class, 'store'])
    ->name('checkout.store');

// Payment Midtrans
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])
    ->name('checkout.payment');

// Success Payment
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])
    ->name('checkout.success');


// ======================================================
// MEMBER AREA (LOGIN)
// ======================================================

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/profil', [HomeController::class, 'profil'])
        ->name('profil');

    Route::get('/katalog', [HomeController::class, 'katalog'])
        ->name('katalog');

    Route::get('/bantuan', [HomeController::class, 'bantuan'])
        ->name('bantuan');

    Route::get('/kontak', [HomeController::class, 'kontak'])
        ->name('kontak');

    Route::get('/checkout', [HomeController::class, 'checkout'])
        ->name('checkout');

    Route::get('/my-ticket', [HomeController::class, 'ticket'])
        ->name('ticket');
});


// ======================================================
// ADMIN AREA
// ======================================================

Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Category CRUD
    Route::resource('categories', CategoryController::class);

    // Partner CRUD
    Route::resource('partners', PartnerController::class);

    // Event CRUD
    Route::resource('events', EventController::class);

    // Transaction Report
    Route::get(
        'transactions',
        [TransactionController::class, 'index']
    )->name('transactions.index');
});