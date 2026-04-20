<?php

use Illuminate\Support\Facades\Route;

// 1. Import semua Controller yang dibutuhkan di sini
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// Rute User Area (Frontend)
// ==========================================

// Navigasi Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Catatan: Pastikan Anda membuat fungsi profil, katalog, bantuan, dan kontak di dalam HomeController
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');
Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// Event & Pemesanan
// Menggunakan parameter {id} agar rute bisa dinamis untuk setiap event (contoh: /event/1, /event/2)
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');


// ==========================================
// Rute Admin Area (Backend)
// ==========================================

// Menggunakan Route Group agar url otomatis berawalan /admin dan penamaan rute berawalan admin.
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () { 
    
    // Rute: /admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); 
    
    // Rute: /admin/events
    Route::get('/events', [EventController::class, 'indexAdmin'])->name('events.index'); 
    
    // Rute: /admin/categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    
    // Anda bisa menambahkan rute admin lainnya di bawah sini...
    
});