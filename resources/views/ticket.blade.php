@extends('layouts.app')

@section('content')
<div class="min-h-[75vh] bg-slate-50/50 py-12 px-4 sm:px-6 lg:px-8 flex flex-col items-center">
    
    <!-- Wrapper Utama (Dibuat Max Width Rapi) -->
    <div class="w-full max-w-2xl">
        
        <!-- Header Page -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Tiket Saya</h1>
                <p class="text-xs text-gray-500 mt-1">Daftar e-ticket resmi event yang berhasil Anda beli.</p>
            </div>
            <div>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3.5 py-2 rounded-xl transition">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Jika Belum Ada Tiket -->
        @if($transactions->isEmpty())
            <div class="bg-white rounded-2xl p-10 text-center border border-gray-100 shadow-sm">
                <div class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-gray-800">Belum Ada Tiket</h3>
                <p class="text-xs text-gray-400 mt-1 mb-5">Anda belum memiliki transaksi tiket yang berhasil.</p>
                <a href="{{ url('/') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs px-4 py-2.5 rounded-xl transition shadow-sm">
                    Jelajahi Event
                </a>
            </div>
        @else
            <!-- List Tiket (Stack Vertikal Rapi) -->
            <div class="space-y-4">
                @foreach($transactions as $trx)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition overflow-hidden">
                        
                        <!-- Header Tiket -->
                        <div class="p-5 border-b border-gray-50">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-600 text-[11px] font-bold rounded-md uppercase tracking-wide border border-emerald-100">
                                    {{ $trx->status }}
                                </span>
                                <span class="text-xs font-mono font-medium text-gray-400">
                                    {{ $trx->order_id }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-gray-800 mt-1">
                                {{ $trx->event->title ?? 'Event Tidak Ditemukan' }}
                            </h3>
                        </div>

                        <!-- Body Detail Tiket -->
                        <div class="px-5 py-3.5 bg-gray-50/50 space-y-2 text-xs">
                            <div class="flex justify-between items-center text-gray-500">
                                <span>Tanggal Transaksi</span>
                                <span class="font-semibold text-gray-700">{{ $trx->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-500">
                                <span>Email Pemesan</span>
                                <span class="font-semibold text-gray-700 truncate max-w-[200px]">{{ $trx->customer_email }}</span>
                            </div>
                        </div>

                        <!-- Footer Tiket -->
                        <div class="px-5 py-3 bg-white border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-gray-400 block -mb-0.5">Total Bayar</span>
                                <span class="text-sm font-extrabold text-indigo-600">
                                    Rp {{ number_format($trx->gross_amount ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            @if($trx->event_id)
                                <a href="{{ route('events.show', $trx->event_id) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition flex items-center gap-1">
                                    Detail Event <span>→</span>
                                </a>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>

</div>
@endsection