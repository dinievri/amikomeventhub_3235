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
     * Menampilkan daftar semua event (Multi-Tenant)
     */
    public function index()
    {
        $user = auth()->user();

        // LOGIKA MULTI-TENANT:
        // Jika user terhubung ke Organisasi (misal: AMCC / HIMMSI), HANYA tampilkan event milik organisasinya.
        if ($user->organization) {
            $events = Event::where('organization_id', $user->organization->id)
                ->latest()
                ->paginate(10);
        } else {
            // Jika Superadmin murni (tidak punya relasi organisasi), tampilkan SELURUH event.
            $events = Event::with('organization')
                ->latest()
                ->paginate(10);
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
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date',
            'price'       => 'required|numeric|min:0',
            'location'    => 'required|string|max:255',
            'stock'       => 'required|integer|min:0',
            'description' => 'required|string',
            'poster'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();
        
        // Ambil ID Organisasi milik user yang sedang login
        $organizationId = $user->organization ? $user->organization->id : null;

        // Handling Upload Poster Event
        $posterPath = 'default.jpg';
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        Event::create([
            'title'           => $request->title,
            'category_id'     => $request->category_id,
            'date'            => $request->date,
            'price'           => $request->price,
            'location'        => $request->location,
            'stock'           => $request->stock,
            'description'     => $request->description,
            'poster_path'     => $posterPath,
            'organization_id' => $organizationId, // Automatic assignment ke tenant panitia
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat!');
    }

    /**
     * Menampilkan detail event beserta Ulasan & Rating
     */
    public function show(string $id)
    {
        $event = Event::with(['reviews.user', 'organization'])->findOrFail($id);

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
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'location'    => 'required|string|max:255',
            'stock'       => 'required|integer|min:0',
            'poster'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $event = Event::findOrFail($id);

        $data = $request->only(['title', 'category_id', 'date', 'price', 'description', 'location', 'stock']);

        if ($request->hasFile('poster')) {
            // Hapus poster lama jika ada dan bukan default
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

        // Hapus file poster jika ada
        if ($event->poster_path && $event->poster_path !== 'default.jpg') {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }
}