@extends('layouts.app')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
        
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Checkout Tiket
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Silakan isi data diri Anda dengan benar untuk pemesanan tiket.
            </p>
        </div>

        <div class="bg-indigo-50/70 border border-indigo-100 rounded-2xl p-5 flex flex-col justify-between space-y-1">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-500">Detail Tiket</span>
            <h3 class="text-xl font-bold text-slate-800">
                {{ $ticket->name ?? 'Nama Tiket Tidak Ditemukan' }}
            </h3>
            <p class="text-2xl font-black text-indigo-600 mt-2">
                Rp {{ number_format($ticket->price ?? 0, 0, ',', '.') }}
            </p>
        </div>

        <form action="{{ url('/checkout/' . ($ticket->id ?? '')) }}" method="POST" class="mt-8 space-y-6">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="nama" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required
                        class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-500 sm:text-sm transition duration-200 bg-slate-50/50">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                    <input type="email" id="email" name="email" placeholder="contoh@email.com" required
                        class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-500 sm:text-sm transition duration-200 bg-slate-50/50">
                </div>

                <div>
                    <label for="hp" class="block text-sm font-semibold text-slate-700 mb-1">Nomor HP / WhatsApp</label>
                    <input type="tel" id="hp" name="hp" placeholder="08xxxxxxxxxx" required
                        class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-500 sm:text-sm transition duration-200 bg-slate-50/50">
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition duration-200 shadow-lg shadow-indigo-600/20">
                    Konfirmasi & Bayar Sekarang
                </button>
            </div>
        </form>
        
    </div>
</div>
@endsection