<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Menampilkan daftar semua event
     */
    public function index()
    {
        $events = Event::with('category')->latest()->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Menampilkan form tambah event baru
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    /**
     * Menyimpan data event baru ke database
     */
    public function store(Request $request)
    {
        // Validasi wajib menyertakan semua kolom database Anda
        $request->validate([
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'date'          => 'required',
            'price'         => 'required|numeric|min:0',
            'description'   => 'nullable|string',
            'location'      => 'required|string|max:255',
            'stock'         => 'required|integer|min:0',
            'poster_path'   => 'nullable|string|max:255',
        ]);

        // Ambil semua data inputan
        $data = $request->all();

        // Jaga-jaga jika poster kosong, beri nilai default teks
        if (empty($data['poster_path'])) {
            $data['poster_path'] = 'default.jpg';
        }

        // Simpan ke database
        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail event
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Menampilkan form edit event
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all();

        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * Memperbarui data event di database
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'date'          => 'required',
            'price'         => 'required|numeric|min:0',
            'description'   => 'nullable|string',
            'location'      => 'required|string|max:255',
            'stock'         => 'required|integer|min:0',
            'poster_path'   => 'nullable|string|max:255',
        ]);

        $event = Event::findOrFail($id);
        
        $data = $request->all();
        if (empty($data['poster_path'])) {
            $data['poster_path'] = 'default.jpg';
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Menghapus data event
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }
}