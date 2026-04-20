<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    // Method untuk merender halaman Event Detail
    public function show()
    {
        return view('event-detail');
    }

    // Method untuk merender halaman Checkout
    public function checkout()
    {
        return view('checkout');
    }

    // Method untuk merender halaman E-Ticket
    public function ticket()
    {
        return view('ticket');
    }
}