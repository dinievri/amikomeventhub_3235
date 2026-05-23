<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if (!empty($search)) {
            $partners = Partner::where('name', 'LIKE', '%' . $search . '%')->latest()->get();
        } else {
            $partners = Partner::latest()->get();
        }

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
            'logo_url' => 'nullable|url|max:255', // Validasi format URL boleh kosong
        ]);

        $data = $request->all();

        // Jika user tidak mengisi URL logo, isi dengan string kosong agar tidak error database
        if (empty($data['logo_url'])) {
            $data['logo_url'] = '';
        }

        Partner::create($data);

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
            'logo_url' => 'nullable|url|max:255',
        ]);

        $partner = Partner::findOrFail($id);
        $data = $request->all();

        if (empty($data['logo_url'])) {
            $data['logo_url'] = '';
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus!');
    }
}