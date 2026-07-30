@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan Tiket')

@section('content')
<main class="max-w-6xl mx-auto px-6 py-12">
    <a href="{{ route('events.show', $event->id) }}" class="inline-flex items-center gap-2 text-indigo-600 font-bold text-sm mb-6 hover:underline">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Detail Event
    </a>

    <h1 class="text-center text-2xl font-black mb-8 text-slate-800">Konfirmasi Pemesanan Tiket</h1>

    {{-- Alert Notifikasi Error dari Controller --}}
    @if(session('error'))
        <div class="max-w-2xl mx-auto mb-8 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl font-semibold text-center">
            🚨 {{ session('error') }}
        </div>
    @endif

    {{-- Alert Error Validasi Form --}}
    @if ($errors->any())
        <div class="max-w-2xl mx-auto mb-8 p-4 bg-red-500 text-white rounded-xl font-bold">
            <p class="mb-1">⚠️ Gagal Memproses Form:</p>
            <ul class="list-disc pl-5 text-sm font-normal">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col md:flex-row gap-8 justify-center items-start">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm w-full md:w-80">
            <h3 class="font-bold text-slate-700 mb-4 border-b pb-2">Detail Event</h3>
            <p class="text-indigo-600 font-bold text-lg mb-2">{{ $event->title }}</p>
            
            {{-- FIX TANGGAL DI SINI MENGGUNAKAN CARBON PARSE AGAR TIDAK ERROR LOG --}}
            <p class="text-sm text-slate-500 mb-1">
                📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}
            </p>
            
            <p class="text-sm text-slate-500 mb-4">📍 {{ $event->location }}</p>

            <div class="flex justify-between items-center pt-4 border-t border-dashed">
                <span class="text-sm text-slate-400">Total Harga:</span>
                <span class="font-black text-slate-800">
                    @if($event->price == 0)
                        Gratis
                    @else
                        Rp {{ number_format($event->price, 0, ',', '.') }}
                    @endif
                </span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm w-full max-w-xl">
            <h3 class="font-bold text-slate-700 mb-6 border-b pb-2">Informasi Data Pemesan</h3>

            @guest('customer')
                <a href="{{ route('google.login') }}"
                    class="w-full flex items-center justify-center gap-3 py-4 border-2 border-slate-200 rounded-xl font-bold mb-6 hover:bg-slate-50 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
                    Continue with Google
                </a>
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <span class="text-xs text-slate-400 font-bold uppercase">atau isi manual</span>
                    <div class="flex-1 h-px bg-slate-200"></div>
                </div>
            @else
                <div class="mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded-xl text-sm text-indigo-700 font-semibold">
                    ✅ Anda login sebagai {{ auth('customer')->user()->name }} — data pemesan sudah terisi otomatis.
                </div>
            @endguest

            <form action="{{ route('checkout.store', $event->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Nama Lengkap</label>
                    <input type="text" name="customer_name" required placeholder="Masukkan nama sesuai KTP"
                           value="{{ old('customer_name', auth('customer')->user()->name ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 transition">
                    @error('customer_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Alamat Email</label>
                    <input type="email" name="customer_email" required placeholder="nama@email.com"
                           value="{{ old('customer_email', auth('customer')->user()->email ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 transition">
                    @error('customer_email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Nomor WhatsApp</label>
                    <input type="text" name="customer_phone" required placeholder="08XXXXXXXXXX"
                           value="{{ old('customer_phone', auth('customer')->user()->phone ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 transition">
                    @error('customer_phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Kode Voucher Diskon (Opsional)</label>
                    <input type="text" name="coupon_code" placeholder="Gunakan: MAHASISWA50 / GRATIS100"
                           value="{{ old('coupon_code') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 uppercase font-semibold transition">
                    <span class="text-[11px] text-slate-400 mt-1 block">*Masukkan <b>MAHASISWA50</b> (diskon 50%) atau <b>GRATIS100</b> (Gratis)</span>
                    @error('coupon_code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-4 mt-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    {{ $event->price == 0 ? 'Ambil Tiket Gratis Sekarang' : 'Lanjutkan ke Pembayaran' }}
                </button>
            </form>
        </div>
    </div>
</main>
@endsection