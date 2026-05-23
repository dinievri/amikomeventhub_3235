<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category; // Tambahkan ini agar controller bisa mengakses database Kategori

class CategoryController extends Controller
{
    /**
     * Soal 1: READ - Menampilkan daftar kategori
     * Soal 3: SEARCH - Menyaring data berdasarkan input pencarian admin
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Melakukan pencarian menggunakan Eloquent WHERE LIKE jika input search diisi
        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })->get();

        // Mengembalikan ke file view blade (pastikan kamu membuat file ini nanti)
        return view('admin.categories.index', compact('categories', 'search'));
    }

    /**
     * Soal 1: CREATE - Menyimpan kategori baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Soal 1: UPDATE - Mengubah nama kategori
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Soal 1: DELETE - Menghapus kategori dari database
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}