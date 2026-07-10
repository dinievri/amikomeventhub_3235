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
        // Menangkap data input dari kolom search form HTML
        $search = $request->input('search');

        // Jika ada input pencarian, saring menggunakan query LIKE
        if (!empty($search)) {
            $partners = Partner::where('name', 'LIKE', '%' . $search . '%')
                ->latest()
                ->get();
        } else {
            // Jika pencarian kosong, tampilkan semua data
            $partners = Partner::latest()->get();
        }

        // Mengirim data ke view beserta isi pencariannya
        return view('admin.partners.index', compact('partners', 'search'));
    }

    /**
     * Menampilkan halaman formulir tambah partner
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Menyimpan data partner baru ke database (Aman untuk SQLite Cloud)
     */
    public function store(Request $request)
    {
        // Validasi input form menggunakan string agar cloud lebih toleran
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'nullable|string|max:255', 
        ]);

        $data = $request->all();

        // FIX SQLITE CLOUD: Jika input logo_url kosong, hapus dari array $data
        // Langkah ini memaksa SQLite mengisi kolom dengan nilai default-nya sehingga terhindar dari Constraint Violation (Error 500)
        if (empty($data['logo_url'])) {
            unset($data['logo_url']);
        }

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman formulir edit partner
     */
    public function edit(string $id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Memperbarui data partner di database (Aman untuk SQLite Cloud)
     */
    public function update(Request $request, string $id)
    {
        // Validasi data input form edit
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'nullable|string|max:255',
        ]);

        $partner = Partner::findOrFail($id);
        $data = $request->all();

        // FIX SQLITE CLOUD: Saat update, jika dikosongkan maka set langsung ke nilai null
        if (empty($data['logo_url'])) {
            $data['logo_url'] = null;
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui!');
    }

    /**
     * Menghapus data partner dari database
     */
    public function destroy(string $id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus!');
    }
}