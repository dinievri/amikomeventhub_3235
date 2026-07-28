<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 min-h-screen py-10 px-4">

    <div class="max-w-4xl mx-auto space-y-8">
        {{-- TOMBOL KEMBALI / NAVBAR SIMPLES --}}
        <div class="flex justify-between items-center bg-white p-4 rounded-2xl shadow-sm">
            <a href="/" class="text-indigo-600 font-bold flex items-center gap-2">
                &larr; Kembali ke Beranda
            </a>
            <span class="font-bold text-slate-800">AmikomEventHub</span>
        </div>

        {{-- CARD 1: DETAIL EVENT --}}
        <div class="bg-white rounded-3xl p-8 shadow-md border border-slate-200">
            <span class="bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded-full text-xs">Event Detail</span>
            <h1 class="text-3xl font-bold text-slate-900 mt-3 mb-4">{{ $event->title }}</h1>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-bold text-slate-500 text-sm mb-1">Deskripsi</h3>
                    <p class="text-slate-700 text-sm leading-relaxed">{{ $event->description }}</p>
                </div>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
                    <span class="text-slate-500 text-xs font-bold">Harga Tiket</span>
                    <h2 class="text-3xl font-bold text-indigo-600 my-2">
                        {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                    </h2>
                    <a href="{{ route('checkout.create', $event->id) }}" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl mt-4 transition">
                        Pesan Tiket
                    </a>
                </div>
            </div>
        </div>

        {{-- CARD 2: RATING & ULASAN --}}
        <div class="bg-white rounded-3xl p-8 shadow-md border border-slate-200">
            <div class="flex justify-between items-center border-b pb-6 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Ulasan & Rating</h2>
                    <p class="text-slate-500 text-xs">Pengalaman peserta acara ini</p>
                </div>
                <div class="bg-amber-50 border border-amber-200 px-4 py-2 rounded-xl text-center">
                    <span class="text-amber-500 font-bold text-xl">⭐ {{ number_format(($event->reviews ?? collect())->avg('rating') ?? 0, 1) }}</span>
                    <p class="text-[10px] text-slate-500">Dari {{ ($event->reviews ?? collect())->count() }} Ulasan</p>
                </div>
            </div>

            {{-- LIST REVIEWS --}}
            <div class="space-y-4">
                @forelse($event->reviews ?? [] as $review)
                    @php
                        $name = $review->user?->name ?? $review->transaction?->customer_name ?? 'Anonim';
                    @endphp
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold text-slate-800 text-sm">{{ $name }}</span>
                            <span class="text-amber-400 font-bold text-xs">{{ str_repeat('⭐', (int)$review->rating) }}</span>
                        </div>
                        <p class="text-slate-600 text-xs">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-center text-slate-400 italic text-sm py-4">Belum ada ulasan untuk event ini.</p>
                @endforelse
            </div>
        </div>
    </div>

</body>
</html>