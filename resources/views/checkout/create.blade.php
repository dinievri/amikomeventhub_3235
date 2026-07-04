@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-3xl font-bold mb-6">
        Checkout Tiket
    </h1>

    @if(session('error'))
        <div class="bg-red-100 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow rounded p-6">

        <h2 class="text-xl font-semibold mb-4">
            {{ $event->title }}
        </h2>

        <p>
            Harga :
            Rp {{ number_format($event->price) }}
        </p>

        <form
            action="{{ route('checkout.store',$event->id) }}"
            method="POST"
            class="mt-5">

            @csrf

            <div class="mb-4">
                <label>Nama Lengkap</label>

                <input
                    type="text"
                    name="customer_name"
                    class="w-full border rounded p-3">
            </div>

            <div class="mb-4">
                <label>Email</label>

                <input
                    type="email"
                    name="customer_email"
                    class="w-full border rounded p-3">
            </div>

            <div class="mb-4">
                <label>No HP</label>

                <input
                    type="text"
                    name="customer_phone"
                    class="w-full border rounded p-3">
            </div>

            <button
                class="bg-indigo-600 text-white px-6 py-3 rounded">

                Checkout Sekarang

            </button>

        </form>

    </div>

</div>

@endsection