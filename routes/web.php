<?php

use Illuminate\Support\Facades\Route;

// Import Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
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

// SOAL 4: Mengarahkan halaman utama publik (rute /) ke WelcomeController agar data bisa merender @foreach
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');
Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// Event untuk User
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');


// ==========================================
// Rute Admin Area (Backend)
// ==========================================
Route::group(['prefix' => 'admin'], function () { 
    
    // Halaman Dashboard: /admin
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard'); 
    
    // SOAL 1 & 3: CRUD + Search Kategori (URL: /admin/categories, Nama Route: categories.index, categories.store, dll)
    Route::resource('categories', CategoryController::class);

    // SOAL 2 & 3: CRUD + Search Partner (URL: /admin/partners, Nama Route: partners.index, partners.store, dll)
    Route::resource('partners', PartnerController::class);
    
    // CRUD Event bawaan template awal
    Route::resource('events', EventController::class);

});