<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Partner;
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

        return view('welcome', compact('categories', 'partners'));
    }
}