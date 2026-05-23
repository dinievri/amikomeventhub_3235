<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Menampilkan daftar partner dengan fitur pencarian (Soal 3)
     */
    public function index(Request $request)
    {
        // Mengambil input dari kolom search form HTML
        $search = $request->input('search');

        // Jika ada input pencarian, lakukan filter dengan query LIKE
        if (!empty($search)) {
            $partners = Partner::where('name', 'LIKE', '%' . $search . '%')
                ->latest()
                ->get();
        } else {
            // Jika kosong, tampilkan semua data partner
            $partners = Partner::latest()->get();
        }

        // Mengirim data ke view beserta isi pencariannya
        return view('admin.partners.index', compact('partners', 'search'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Partner::create($request->all());

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $partner = Partner::findOrFail($id);
        $partner->update($request->all());

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus!');
    }
}