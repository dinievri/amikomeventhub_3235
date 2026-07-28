<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Menampilkan detail event untuk pengunjung publik (URL: /event/{id})
     */
    public function show($id)
    {
        // KUNCI UTAMA: Kita panggil 'reviews.user' agar data ulasan & nama reviewernya ikut terambil
        $event = Event::with(['reviews.user'])->findOrFail($id);

        // Mengembalikan view publik (show.blade.php kamu)
        return view('events.show', compact('event'));
    }
}