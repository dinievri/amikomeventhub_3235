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
      $user = auth()->user();

    // LOGIKA MULTI-TENANT:
    // Jika Role = Admin (Superadmin), tampilkan SELURUH event dari semua organisasi.
    if ($user->role === 'admin') {
        $events = Event::with('organization')->latest()->paginate(10);
    } else {
        // Jika Role = Panitia/HIMA, HANYA tampilkan event milik organisasinya sendiri
        $events = Event::whereHas('organization', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->paginate(10);
    }

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
        $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|numeric',
        // tambahkan validasi lainnya...
    ]);

    $user = auth()->user();
    
    // Ambil ID Organisasi milik user yang sedang login
    $organizationId = $user->organization ? $user->organization->id : null;

    Event::create([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'organization_id' => $organizationId, // Automatic assignment ke tenant panitia
        // field lainnya...
    ]);

    return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat!');
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