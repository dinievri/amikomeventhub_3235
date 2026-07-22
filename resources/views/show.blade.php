@extends('layouts.app')

@section('content')

<section class="max-w-6xl mx-auto px-6 py-12">

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-12">

        <div class="p-10">

            <div class="inline-flex px-4 py-2 rounded-full bg-indigo-100 text-indigo-700 font-semibold mb-6">
                Event Detail
            </div>

            <h1 class="text-5xl font-bold mb-6">
                {{ $event->title }}
            </h1>

            <div class="grid md:grid-cols-2 gap-8">

                <div>

                    <h3 class="text-lg font-semibold text-slate-500 mb-2">
                        Deskripsi Event
                    </h3>

                    <p class="text-slate-700 leading-relaxed">
                        {{ $event->description }}
                    </p>

                </div>

                <div class="bg-slate-50 rounded-2xl p-8">

                    <h3 class="text-lg font-semibold mb-4">
                        Informasi Tiket
                    </h3>

                    <div class="space-y-3">

                        <div>
                            <span class="text-slate-500">
                                Harga Tiket
                            </span>

                            <h2 class="text-4xl font-bold text-indigo-600">
                                @if($event->price == 0)
                                    Gratis
                                @else
                                    Rp {{ number_format($event->price,0,',','.') }}
                                @endif
                            </h2>
                        </div>

                    </div>

                    <div class="mt-8">

                        <a
                            href="{{ route('checkout.create',$event->id) }}"
                            class="block text-center bg-indigo-600 hover:bg-indigo-700 transition text-white font-semibold py-4 rounded-xl shadow-lg shadow-indigo-100">

                            Pesan Tiket

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ================= SECTION RATING & REVIEWS ================= --}}
    <div class="bg-white rounded-3xl shadow-xl p-10">
        
        {{-- Alert Notifikasi Status --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl mb-6 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-2xl mb-6 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        {{-- Header Rating & Summary --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-8 mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 mb-2">
                    Ulasan & Rating
                </h2>
                <p class="text-slate-500">
                    Pengalaman peserta yang sudah mengikuti acara ini
                </p>
            </div>

            <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 px-6 py-3 rounded-2xl">
                <span class="text-3xl">⭐</span>
                <div>
                    <div class="text-2xl font-bold text-amber-600">
                        {{ $event->averageRating() ?: '0' }} <span class="text-sm text-slate-400 font-normal">/ 5.0</span>
                    </div>
                    <div class="text-xs text-slate-500 font-medium">
                        Dari {{ $event->reviews->count() }} Ulasan
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Tambah Ulasan --}}
        @auth
            <form action="{{ route('reviews.store', $event->id) }}" method="POST" class="bg-slate-50 border border-slate-200 p-6 rounded-2xl mb-10">
                @csrf
                <h3 class="text-lg font-bold text-slate-800 mb-4">
                    Tulis Ulasan Anda
                </h3>

                <div class="grid md:grid-cols-4 gap-4 mb-4">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Pilih Rating
                        </label>
                        <select name="rating" class="w-full p-3.5 rounded-xl border border-slate-200 bg-white font-semibold text-amber-500 focus:outline-none focus:border-indigo-600" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ (4/5)</option>
                            <option value="3">⭐⭐⭐ (3/5)</option>
                            <option value="2">⭐⭐ (2/5)</option>
                            <option value="1">⭐ (1/5)</option>
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Komentar
                        </label>
                        <input type="text" name="comment" placeholder="Tuliskan pendapat Anda tentang event ini..." class="w-full p-3.5 rounded-xl border border-slate-200 bg-white text-slate-800 focus:outline-none focus:border-indigo-600" required>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-xl transition shadow-md shadow-indigo-100">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        @else
            <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl mb-10 text-center">
                <p class="text-slate-600">
                    Ingin memberikan ulasan? <a href="/login" class="text-indigo-600 font-bold hover:underline">Sign In / Login</a> terlebih dahulu.
                </p>
            </div>
        @endauth

        {{-- Daftar Ulasan --}}
        <div class="space-y-6">
            @forelse($event->reviews as $review)
                <div class="p-6 rounded-2xl border border-slate-100 bg-slate-50/50 flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-sm">
                                {{ strtoupper(substr($review->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">{{ $review->user->name }}</h4>
                                <span class="text-xs text-slate-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="text-amber-400 text-sm tracking-widest font-bold">
                            {{ str_repeat('⭐', $review->rating) }}
                        </div>
                    </div>

                    <p class="text-slate-600 text-sm mt-2 leading-relaxed">
                        {{ $review->comment }}
                    </p>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400 italic">
                    Belum ada ulasan untuk event ini. Jadi yang pertama memberikan ulasan!
                </div>
            @endforelse
        </div>

    </div>

</section>

@endsection