<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Menampilkan halaman depan publik dengan data kategori & partner (Soal 4)
     */
    public function index()
    {
        // Mengambil semua data dari database secara dinamis
        $partners = Partner::latest()->get();
        $categories = Category::all();
        
        // Opsional: mengambil data event terbaru untuk halaman depan Anda
        $events = Event::with('category')->latest()->take(6)->get();

        // Mengirimkan variabel data ke file view welcome.blade.php
        return view('welcome', compact('partners', 'categories', 'events'));
    }
}