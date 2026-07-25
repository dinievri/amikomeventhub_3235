<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Partner;
use App\Models\Event; // Pastikan model Event di-import
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Menampilkan halaman depan publik (Soal 4)
     */
    public function index()
    {
        // Mengambil semua data kategori dan partner untuk dilempar ke halaman depan
        $categories = Category::latest()->get();
        $partners = Partner::latest()->get();

        // Tambahkan ini jika di halaman welcome kamu butuh nampilkan list event
        $events = Event::latest()->get();

        return view('welcome', compact('categories', 'partners', 'events'));
    }

    /**
     * Menampilkan detail event (Biar ga ngeloop ke admin)
     */
    public function showEvent(Event $event)
    {
        $categories = Category::all();

        // Load relasi reviews sekaligus, biar $event->reviews di Blade bisa langsung dipakai
        // tanpa query berulang (N+1 problem)
        $event->load('reviews');

        // Mengarah ke file resources/views/show.blade.php
        return view('show', compact('event', 'categories'));
    }
}