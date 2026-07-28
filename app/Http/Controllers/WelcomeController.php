<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Partner;
use App\Models\Event;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        $partners = Partner::latest()->get();
        $events = Event::latest()->get();

        return view('welcome', compact('categories', 'partners', 'events'));
    }

    /**
     * Menampilkan detail event untuk pengunjung publik (URL: /event/{event})
     */
    public function showEvent(Event $event)
    {
        $categories = Category::all();

        // Load ulasan beserta data user/customer & kategori
        $event->load(['reviews.user', 'category']);

        // UBAH JADI view('show') KARENA FILE ADA DI resources/views/show.blade.php
        return view('show', compact('event', 'categories'));
    }

    /**
     * Method cadangan/alias untuk 'show' jika dipanggil dari tempat lain
     */
    public function show(Event $event)
    {
        return $this->showEvent($event);
    }
}