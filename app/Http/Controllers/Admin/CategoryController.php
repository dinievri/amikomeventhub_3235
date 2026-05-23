<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori dengan fitur pencarian (Soal 3)
     */
    public function index(Request $request)
    {
        // Mengambil input dari kolom search form HTML
        $search = $request->input('search');

        // Jika ada input pencarian, lakukan filter dengan query LIKE
        if (!empty($search)) {
            $categories = Category::where('name', 'LIKE', '%' . $search . '%')
                ->latest()
                ->get();
        } else {
            // Jika kosong, tampilkan semua data kategori
            $categories = Category::latest()->get();
        }

        // Mengirim data ke view beserta isi pencariannya
        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}