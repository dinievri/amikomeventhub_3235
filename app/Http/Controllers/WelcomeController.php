<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;   // Tambahkan ini agar bisa memanggil data Partner
use App\Models\Category;  // Tambahkan ini agar bisa memanggil data Kategori

class WelcomeController extends Controller
{
    public function index()
    {
        // Mengambil semua data partner dan kategori dari database
        $partners = Partner::all();
        $categories = Category::all();

        // Mengirimkan data tersebut ke file view bernama 'welcome.blade.php'
        return view('welcome', compact('partners', 'categories'));
    }
}