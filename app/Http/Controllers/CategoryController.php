<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan halaman daftar kategori (GUI Admin)
     */
    public function index()

    {
        // Fungsi ini akan memanggil file index.blade.php yang ada di 
        // folder resources/views/admin/categories/
        return view('admin.categories.index');
    }
    
    // Nanti Anda bisa menambahkan fungsi create, store, edit, update, destroy di sini
    // saat sudah mulai menggunakan Database.
}