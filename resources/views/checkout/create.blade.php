@extends('layouts.app') 

@section('title', 'Konfirmasi Pemesanan Tiket') 

@section('content')
<main class="max-w-6xl mx-auto px-6 py-12">
    <h1 class="text-center text-2xl font-black mb-8 text-slate-800">Konfirmasi Pemesanan Tiket</h1>
    
    <div class="flex flex-col md:flex-row gap-8 justify-center items-start">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm w-full md:w-80">
            <h3 class="font-bold text-slate-700 mb-4 border-b pb-2">Detail Event</h3>
            <p class="text-indigo-600 font-bold text-lg mb-2">{{ $event->title }}</p>
            <p class="text-sm text-slate-500 mb-1">📅 {{ $event->date }}</p>
            <p class="text-sm text-slate-500 mb-4">📍 {{ $event->location }}</p>
            
            <div class="flex justify-between items-center pt-4 border-t border-dashed">
                <span class="text-sm text-slate-400">Total Harga:</span>
                <span class="font-black text-slate-800">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm w-full max-w-xl">
            <h3 class="font-bold text-slate-700 mb-6 border-b pb-2">Informasi Data Pemesan</h3>
            
            <form action="{{ route('checkout.store', $event->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Nama Lengkap</label>
                    <input type="text" name="customer_name" required placeholder="Masukkan nama sesuai KTP" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Alamat Email</label>
                    <input type="email" name="customer_email" required placeholder="nama@email.com" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Nomor WhatsApp</label>
                    <input type="text" name="customer_phone" required placeholder="08XXXXXXXXXX" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 transition">
                </div>

                <button type="submit" class="w-full py-4 mt-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Bayar & Ambil Tiket Sekarang
                </button>
            </form>
        </div>
    </div>
</main>
@endsection