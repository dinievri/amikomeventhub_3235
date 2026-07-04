<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AmikomEventHub - Temukan Event Seru!</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .glass {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(10px);
    }
  </style>
</head>

<body class="bg-slate-50 text-slate-900">

  <nav class="glass sticky top-8 z-40 mx-4 mt-4 px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex justify-between items-center">
    <div class="flex items-center gap-2">
      <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
        AH</div>
      <span class="text-xl font-bold tracking-tight">AmikomEventHub</span>
    </div>
    <div class="hidden md:flex gap-8 font-medium">
      <a href="#" class="text-indigo-600">Jelajahi</a>
      <a href="#" class="hover:text-indigo-600 transition">Kategori</a>
      <a href="#" class="hover:text-indigo-600 transition">Tentang Kami</a>
    </div>
  </nav>

  <section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
      <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1 Event Platform</span>
      <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
        Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
      </h1>
      <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
        Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
      </p>
      <div class="flex gap-4">
        <a href="#events" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
          Mulai Jelajah
        </a>
        <a href="#" class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
          Cara Pesan
        </a>
      </div>
    </div>
    <div class="flex-1 relative">
      <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
      <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
      <img src="assets/concert.png" alt="Concert" class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center" onerror="this.src='https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=800&q=80'">

      <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <div>
            <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
            <p class="font-bold">Pembayaran Aman via Midtrans</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
      <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Kategori Acara</h2>
      <p class="text-slate-500 font-medium">Temukan berbagai pilihan event menarik sesuai dengan minat bakatmu.</p>
    </div>
    
    <div class="flex flex-wrap gap-3">
      @forelse($categories as $category)
        <span class="bg-indigo-50 border border-indigo-100 text-indigo-700 px-5 py-2.5 rounded-full font-bold text-sm shadow-sm hover:bg-indigo-600 hover:text-white transition cursor-pointer">
          {{ $category->name }}
        </span>
      @empty
        <!-- Kategori Default / Mock jika database kosong -->
        @foreach(['Musik', 'Teknologi', 'Coding', 'Bisnis', 'Seni'] as $mockCategory)
          <span class="bg-indigo-50 border border-indigo-100 text-indigo-700 px-5 py-2.5 rounded-full font-bold text-sm shadow-sm hover:bg-indigo-600 hover:text-white transition cursor-pointer">
            {{ $mockCategory }}
          </span>
        @endforeach
      @endforelse
    </div>
  </section>

  <section id="events" class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex justify-between items-end mb-12">
      <div>
        <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
        <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
      </div>
      <div class="flex gap-2">
        <button class="p-3 border rounded-xl hover:bg-white hover:shadow-md transition font-semibold">Semua Kategori</button>
      </div>
    </div>

    <!-- Container Grid Event Dinamis -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @forelse($events as $event)
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
          <div class="relative overflow-hidden aspect-[3/4]">
            <!-- Validasi Poster Path -->
            <img src="{{ $event->poster_path ? asset('storage/' . $event->poster_path) : 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=600&q=80' }}" 
                 alt="{{ $event->title }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
                 onerror="this.src='https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=600&q=80'">
            
            <!-- KEAMANAN UTAMA: Menggunakan Null-safe (?->) agar tidak crash jika kategori null -->
            <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
              {{ $event->category?->name ?? 'Event' }}
            </div>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
            <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <!-- KEAMANAN TANGGAL: Cek Carbon Object atau Raw String secara kondisional untuk mencegah crash -->
              <span>
                @if($event->date)
                  {{ $event->date instanceof \Carbon\Carbon ? $event->date->format('d F Y, H:i') : \Carbon\Carbon::parse($event->date)->format('d F Y, H:i') }} WIB
                @else
                  Tanggal belum ditentukan
                @endif
              </span>
            </div>
            <div class="flex justify-between items-center pt-4 border-t">
              <span class="text-2xl font-black text-indigo-600">
                {{ ($event->price ?? 0) > 0 ? 'Rp ' . number_format($event->price, 0, ',', '.') : 'Gratis' }}
              </span>
              <!-- Rute Detail Event Publik -->
              <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">
                Lihat Detail
              </a>
            </div>
          </div>
        </div>
      @empty
        <!-- TAMPILAN CADANGAN (FALLBACK): 3 Event Mock Asli Anda Ditampilkan Kembali Jika Database Kosong -->
        
        <!-- Mock 1: Jazz Night -->
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
          <div class="relative overflow-hidden aspect-[3/4]">
            <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=600&q=80" alt="Jazz Night" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">Musik</div>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">Jazz Night 2024: A Celebration</h3>
            <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>16 November 2024, 19:30 WIB</span>
            </div>
            <div class="flex justify-between items-center pt-4 border-t">
              <span class="text-2xl font-black text-indigo-600">Rp 150.000</span>
              <a href="#" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Lihat Detail (Demo)</a>
            </div>
          </div>
        </div>

        <!-- Mock 2: AI & Future -->
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
          <div class="relative overflow-hidden aspect-[3/4]">
            <img src="https://images.unsplash.com/photo-1591453089816-0fbb971b454c?auto=format&fit=crop&w=600&q=80" alt="AI & Future" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">Technology</div>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">AI & Future: Unleash The Power</h3>
            <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>26 October 2024, 09:00 WIB</span>
            </div>
            <div class="flex justify-between items-center pt-4 border-t">
              <span class="text-2xl font-black text-indigo-600">Rp 50.000</span>
              <a href="#" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Lihat Detail (Demo)</a>
            </div>
          </div>
        </div>

        <!-- Mock 3: Hackathon -->
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
          <div class="relative overflow-hidden aspect-[3/4]">
            <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=600&q=80" alt="Hackathon" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">Coding</div>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">Hackathon 2024: Ultimate Marathon</h3>
            <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>18-20 October 2024 WIB</span>
            </div>
            <div class="flex justify-between items-center pt-4 border-t">
              <span class="text-2xl font-black text-indigo-600">Gratis</span>
              <a href="#" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Lihat Detail (Demo)</a>
            </div>
          </div>
        </div>
      @endforelse
    </div>
  </section>

  <section class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
      <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Partner Resmi AmikomEventHub</h2>
      <p class="text-slate-500 font-medium">Didukung penuh oleh instansi, organisasi, dan perusahaan terpercaya.</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
      @forelse($partners as $partner)
        <div class="bg-white border border-slate-100 rounded-2xl p-5 flex flex-col items-center justify-center h-36 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
          <img src="{{ $partner->logo_url ?: 'https://placehold.co/200x100?text=Logo+Partner' }}" alt="{{ $partner->name }}" class="max-h-14 max-w-full object-contain mb-3" onerror="this.src='https://placehold.co/200x100?text=Logo+Partner'">
          <h5 class="text-xs font-bold text-slate-700 text-center tracking-tight line-clamp-1">{{ $partner->name }}</h5>
        </div>
      @empty
        <!-- Partner Default / Mock jika database kosong -->
        @for($i = 1; $i <= 5; $i++)
          <div class="bg-white border border-slate-100 rounded-2xl p-5 flex flex-col items-center justify-center h-36 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
            <img src="https://placehold.co/200x100?text=Partner+{{ $i }}" alt="Partner Mock" class="max-h-14 max-w-full object-contain mb-3">
            <h5 class="text-xs font-bold text-slate-700 text-center tracking-tight line-clamp-1">Partner Kerja Sama</h5>
          </div>
        @endfor
      @endforelse
    </div>
  </section>

  <footer class="bg-indigo-900 text-indigo-100 py-20 px-6 mt-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
      <div class="space-y-4 col-span-2">
        <div class="flex items-center gap-2">
          <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
          <span class="text-2xl font-bold text-white">AmikomEventHub</span>
        </div>
        <p class="max-w-xs text-indigo-300">Platform reservasi tiket event online terbaik untuk mahasiswa dan penyelenggara profesional.</p>
      </div>
      <div>
        <h4 class="text-white font-bold mb-6">Navigasi</h4>
        <ul class="space-y-4">
          <li><a href="#" class="hover:text-white transition">Home</a></li>
          <li><a href="#" class="hover:text-white transition">Semua Event</a></li>
          <li><a href="#" class="hover:text-white transition">Cara Bayar</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-white font-bold mb-6">Hubungi Kami</h4>
        <ul class="space-y-4">
          <li>support@eventtiket.com</li>
          <li>+62 812 3456 7890</li>
        </ul>
      </div>
    </div>
    <div class="max-w-7xl mx-auto pt-12 mt-12 border-t border-indigo-800 text-center text-indigo-400 text-sm">
      &copy; 2026 AmikomEventHub. Built with Laravel & Tailwind CSS.
    </div>
  </footer>

</body>

</html>