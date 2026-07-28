@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-6 space-y-6">

    {{-- KARTU 1: DETAIL TIKET & EVENT --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden p-8 border border-slate-100">
        <div class="inline-flex px-4 py-1.5 rounded-full bg-indigo-100 text-indigo-700 font-semibold mb-4 text-xs">
            Event Detail
        </div>

        <h1 class="text-3xl md:text-4xl font-bold mb-6 text-slate-900">
            {{ $event->title }}
        </h1>

        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-sm font-semibold text-slate-500 mb-2">
                    Deskripsi Event
                </h3>
                <p class="text-slate-700 leading-relaxed text-sm">
                    {{ $event->description }}
                </p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                <h3 class="text-base font-semibold mb-3 text-slate-800">
                    Informasi Tiket
                </h3>

                <div class="space-y-3">
                    <div>
                        <span class="text-slate-500 text-xs">Harga Tiket</span>
                        <h2 class="text-3xl font-bold text-indigo-600 mt-1">
                            @if($event->price == 0)
                                Gratis
                            @else
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            @endif
                        </h2>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('checkout.create', $event->id) }}"
                       class="block text-center bg-indigo-600 hover:bg-indigo-700 transition text-white font-semibold py-3 rounded-xl shadow-md shadow-indigo-200 text-sm">
                        Pesan Tiket
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- KARTU 2: ULASAN & RATING --}}
    <div class="bg-white rounded-3xl shadow-xl p-8 border border-slate-100">

        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 p-3 rounded-xl mb-6 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-200 text-red-700 p-3 rounded-xl mb-6 text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @php
            // Memastikan data reviews selalu valid sebagai collection
            $reviewsList = $event->reviews ?? collect();
            $avgRating = $reviewsList->avg('rating') ?: 0;
            $totalReviews = $reviewsList->count();
        @endphp

        {{-- Header Summary --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-6 mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-1">
                    Ulasan & Rating
                </h2>
                <p class="text-slate-500 text-xs">
                    Pengalaman peserta yang sudah mengikuti acara ini
                </p>
            </div>

            <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 px-5 py-2.5 rounded-xl w-fit">
                <span class="text-2xl">⭐</span>
                <div>
                    <div class="text-xl font-bold text-amber-600">
                        {{ number_format($avgRating, 1) }} 
                        <span class="text-xs text-slate-400 font-normal">/ 5.0</span>
                    </div>
                    <div class="text-[11px] text-slate-500 font-medium">
                        Dari {{ $totalReviews }} Ulasan
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Ulasan --}}
        @auth('customer')
            <form action="{{ route('reviews.store', $event->id) }}" method="POST" class="bg-slate-50 border border-slate-200 p-5 rounded-xl mb-6">
                @csrf
                <h3 class="text-sm font-bold text-slate-800 mb-3">
                    Tulis Ulasan Anda
                </h3>

                <div class="grid md:grid-cols-4 gap-3 mb-3">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Pilih Rating
                        </label>
                        <select name="rating" class="w-full p-2.5 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-amber-500 focus:outline-none focus:border-indigo-600" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ (4/5)</option>
                            <option value="3">⭐⭐⭐ (3/5)</option>
                            <option value="2">⭐⭐ (2/5)</option>
                            <option value="1">⭐ (1/5)</option>
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Komentar
                        </label>
                        <input type="text" name="comment" placeholder="Tuliskan pendapat Anda..." class="w-full p-2.5 rounded-lg border border-slate-200 bg-white text-xs text-slate-800 focus:outline-none focus:border-indigo-600" required>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg transition text-xs shadow-sm">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        @else
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl mb-6 text-center">
                <p class="text-slate-600 text-xs">
                    Ingin memberikan ulasan? <a href="{{ route('google.login') }}" class="text-indigo-600 font-bold hover:underline">Sign In / Login dengan Google</a> terlebih dahulu.
                </p>
            </div>
        @endauth

        {{-- List Ulasan --}}
        <div class="space-y-3">
            @forelse($reviewsList as $review)
                @php
                    $reviewerName = $review->user?->name 
                        ?? $review->transaction?->customer_name 
                        ?? 'Anonim';
                @endphp

                <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50 flex flex-col gap-1">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr($reviewerName, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">{{ $reviewerName }}</h4>
                                <span class="text-[10px] text-slate-400">
                                    {{ !empty($review->created_at) ? \Carbon\Carbon::parse($review->created_at)->diffForHumans() : '' }}
                                </span>
                            </div>
                        </div>

                        <div class="text-amber-400 text-[10px] tracking-widest font-bold">
                            {{ str_repeat('⭐', (int) ($review->rating ?? 5)) }}
                        </div>
                    </div>

                    <p class="text-slate-600 text-xs mt-1 leading-relaxed">
                        {{ $review->comment }}
                    </p>
                </div>
            @empty
                <div class="text-center py-6 text-slate-400 italic text-xs">
                    Belum ada ulasan untuk event ini. Jadi yang pertama memberikan ulasan!
                </div>
            @endforelse
        </div>

    </div>

</div>

@endsection