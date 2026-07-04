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
     * TAMBAHKAN FUNGSI INI: Untuk menampilkan detail event (Biar ga ngeloop ke admin)
     */
    public function showEvent(Event $event)
    {
        $categories = Category::all();
        
        // Mengarah ke file resources/views/show.blade.php atau resources/views/events/show.blade.php
        // Sesuaikan dengan letak file detail event kamu ya!
        return view('show', compact('event', 'categories')); 
    }
}