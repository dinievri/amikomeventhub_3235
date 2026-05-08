<?php

use Illuminate\Support\Facades\Route;

// Import Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\EventController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');
Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// Event untuk User (Pastikan method ini ada di Controller)
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');


// ==========================================
// Rute Admin Area (Backend)
// ==========================================
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () { 
    
    // Halaman Dashboard: /admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); 
    
    // CRUD Event: /admin/events
    // Route resource otomatis mengarahkan rute GET ke function index()
    Route::resource('events', EventController::class);

    // CRUD Category: /admin/categories
    Route::resource('categories', CategoryController::class);
    
});