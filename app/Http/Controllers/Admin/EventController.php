<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'poster'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['title', 'category_id', 'date', 'price', 'description', 'location', 'stock']);

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        } else {
            $data['poster_path'] = 'default.jpg';
        }

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
            'poster'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $event = Event::findOrFail($id);

        $data = $request->only(['title', 'category_id', 'date', 'price', 'description', 'location', 'stock']);

        if ($request->hasFile('poster')) {
            if ($event->poster_path && $event->poster_path !== 'default.jpg') {
                Storage::disk('public')->delete($event->poster_path);
            }
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
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