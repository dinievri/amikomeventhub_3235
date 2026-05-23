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
            // Jika kosong, tampilkan semua data partner seperti biasa
            $partners = Partner::latest()->get();
        }

        // Mengirim data ke view beserta isi pencariannya
        return view('admin.partners.index', compact('partners', 'search'));
    }

    /**
     * Menampilkan halaman form tambah partner
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Menyimpan data partner baru ke database (Sudah Fix Validasi Cloud)
     */
    public function store(Request $request)
    {
        // Validasi input: logo_url diubah jadi string biasa agar cloud tidak sensitif/error 500
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'nullable|string|max:255', 
        ]);

        $data = $request->all();

        // PENGAMAN DATABASE: Jika dikosongkan, ganti dengan string kosong agar tidak memicu error general 1364
        if (empty($data['logo_url'])) {
            $data['logo_url'] = '';
        }

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman form edit partner
     */
    public function edit(string $id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Memperbarui data partner di database (Sudah Fix Validasi Cloud)
     */
    public function update(Request $request, string $id)
    {
        // Validasi input edit data
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'nullable|string|max:255',
        ]);

        $partner = Partner::findOrFail($id);
        $data = $request->all();

        // PENGAMAN DATABASE: Tetap jaga nilainya agar tidak null saat proses update berjalan
        if (empty($data['logo_url'])) {
            $data['logo_url'] = '';
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