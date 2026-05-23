<?php

use Illuminate\Support\Facades\Route;

// Import Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;

// Controller Khusus Area Admin
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// Rute Publik / User Area (Frontend)
// ==========================================

// Mengarahkan halaman utama publik (rute /) ke WelcomeController
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');
Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// PERBAIKAN: Rute Event untuk USER diarahkan ke HomeController (bukan Admin\EventController)
Route::get('/event/{id}', [HomeController::class, 'showEvent'])->name('events.show');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [HomeController::class, 'ticket'])->name('ticket');


// ==========================================
// Rute Admin Area (Backend)
// ==========================================
// Menambahkan prefix '/admin' dan memberikan awalan nama 'admin.' untuk area admin
Route::prefix('admin')->name('admin.')->group(function () { 
    
    // Halaman Dashboard -> URL: http://127.0.0.1:8000/admin | Nama Route: admin.dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); 
    
    // CRUD Kategori -> URL: /admin/categories
    Route::resource('categories', CategoryController::class);

    // CRUD Partner -> URL: /admin/partners
    Route::resource('partners', PartnerController::class);
    
    // CRUD Event -> URL: /admin/events (Sudah aman, tidak bentrok lagi)
    Route::resource('events', EventController::class);

});