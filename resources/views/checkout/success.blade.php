@extends('layouts.app')

@section('content')
<!-- min-h-[70vh] akan memaksa area ini mengambil minimal 70% tinggi layar -->
<div class="min-h-[70vh] flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
  
  <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8 border border-gray-100 text-center">
    
    <!-- Icon Centang -->
    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
      </svg>
    </div>

    <!-- Judul & Subtitle -->
    <h2 class="text-2xl font-bold text-emerald-600 mb-2">Pembayaran Berhasil!</h2>
    <p class="text-xs sm:text-sm text-gray-500 mb-6">Terima kasih telah melakukan pembelian tiket.</p>

    <!-- ALERT PESAN SUKSES / ERROR ULASAN -->
    @if(session('success'))
      <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl font-medium text-center">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="mb-4 p-3 bg-amber-50 border border-amber-200 text-amber-700 text-xs rounded-xl font-medium text-center">
        {{ session('error') }}
      </div>
    @endif

    <!-- Box Detail Transaksi -->
    <div class="bg-gray-50 rounded-xl p-4 text-left space-y-2 mb-6 border border-gray-100">
      <div class="flex justify-between items-center text-xs sm:text-sm">
        <span class="text-gray-500">Order ID</span>
        <span class="font-semibold text-gray-800 font-mono">{{ $transaction->order_id ?? request()->segment(2) }}</span>
      </div>
      <div class="flex justify-between items-center text-xs sm:text-sm">
        <span class="text-gray-500">Email</span>
        <span class="font-semibold text-gray-800 break-all">{{ $transaction->customer_email ?? (auth()->user()->email ?? '-') }}</span>
      </div>
    </div>

    <!-- FORM ULASAN OPSIONAL -->
    @if(isset($transaction->event_id))
      <div class="border-t border-gray-100 pt-6 mt-6 text-left mb-6">
        <h4 class="text-sm font-bold text-gray-800 mb-1">Beri Ulasan Event (Opsional)</h4>
        <p class="text-xs text-gray-400 mb-3">Bagaimana pengalaman pemesanan tiket Anda?</p>

        <form action="{{ route('reviews.store', $transaction->event_id) }}" method="POST">
            @csrf
            <!-- Rating Bintang -->
            <div class="mb-3">
                <select name="rating" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="5">⭐⭐⭐⭐⭐ (5/5) Sangat Puas</option>
                    <option value="4">⭐⭐⭐⭐ (4/5) Puas</option>
                    <option value="3">⭐⭐⭐ (3/5) Cukup</option>
                    <option value="2">⭐⭐ (2/5) Kurang</option>
                    <option value="1">⭐ (1/5) Buruk</option>
                </select>
            </div>

            <!-- Komentar -->
            <div class="mb-3">
                <textarea name="comment" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tuliskan ulasan singkat Anda di sini..."></textarea>
            </div>

            <button type="submit" class="w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold py-2 rounded-xl text-xs transition">
                Kirim Ulasan
            </button>
        </form>
      </div>
    @endif

    <!-- TOMBOL NAVIGASI -->
    <div class="space-y-2">
      <!-- Tombol Lihat E-Ticket -->
      <a href="{{ route('ticket') }}" 
         class="block w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl text-sm transition shadow-md">
        Lihat E-Ticket Saya
      </a>

      <!-- Tombol Kembali ke Beranda -->
      <a href="{{ url('/') }}" 
         class="block w-full py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium rounded-xl text-xs transition">
        Kembali ke Beranda
      </a>
    </div>

  </div>

</div>
@endsection