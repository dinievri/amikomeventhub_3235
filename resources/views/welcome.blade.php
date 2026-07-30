@extends('layouts.app')

@section('content')
  {{-- HERO SECTION --}}
  <section class="max-w-7xl mx-auto px-6 py-16 flex flex-col md:flex-row items-center gap-12">
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
      <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=800&q=80" alt="Concert" class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

      <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white bg-white/80 backdrop-blur">
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

  {{-- KATEGORI SECTION --}}
  <section id="kategori" class="max-w-7xl mx-auto px-6 py-12">
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
        @foreach(['Workshop', 'Seminar', 'Competition', 'Coding', 'Design'] as $mockCategory)
          <span class="bg-indigo-50 border border-indigo-100 text-indigo-700 px-5 py-2.5 rounded-full font-bold text-sm shadow-sm hover:bg-indigo-600 hover:text-white transition cursor-pointer">
            {{ $mockCategory }}
          </span>
        @endforeach
      @endforelse
    </div>
  </section>

  {{-- EVENT TERDEKAT SECTION --}}
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @php
        // Pemetaan gambar default berdasarkan nama/kata kunci judul event
        $defaultImages = [
          'ui/ux' => 'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?auto=format&fit=crop&w=600&q=80',
          'laravel' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80',
          'ai' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=600&q=80',
          'digital marketing' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80',
          'e-sport' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=600&q=80',
          'hackathon' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=600&q=80',
        ];
      @endphp

      @forelse($events as $event)
        @php
          $titleLower = strtolower($event->title);
          $matchedImage = 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&q=80'; // Default seminar/event

          foreach($defaultImages as $key => $imgUrl) {
            if(str_contains($titleLower, $key)) {
              $matchedImage = $imgUrl;
              break;
            }
          }

          // KONDISI PENENTUAN GAMBAR POSTER:
          // Cek apakah poster terisi, bukan 'default.jpg', dan bukan string kosong
          $hasRealPoster = !empty($event->poster_path) && $event->poster_path !== 'default.jpg';
          $finalImageUrl = $hasRealPoster ? asset('storage/' . $event->poster_path) : $matchedImage;
        @endphp

        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col justify-between">
          <div>
            <div class="relative overflow-hidden aspect-[3/4] bg-slate-100">
              <img src="{{ $finalImageUrl }}" 
                   alt="{{ $event->title }}" 
                   class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                   onerror="this.onerror=null; this.src='{{ $matchedImage }}';">
              
              <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600 shadow-sm">
                {{ $event->category?->name ?? 'Event' }}
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition line-clamp-2">{{ $event->title }}</h3>
              <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>
                  @if($event->date)
                    {{ $event->date instanceof \Carbon\Carbon ? $event->date->format('d F Y, H:i') : \Carbon\Carbon::parse($event->date)->format('d F Y, H:i') }} WIB
                  @else
                    Tanggal belum ditentukan
                  @endif
                </span>
              </div>
            </div>
          </div>

          <div class="px-6 pb-6 pt-0">
            <div class="flex justify-between items-center pt-4 border-t border-slate-100">
              <span class="text-2xl font-black text-indigo-600">
                {{ ($event->price ?? 0) > 0 ? 'Rp ' . number_format($event->price, 0, ',', '.') : 'Gratis' }}
              </span>
              <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">
                Lihat Detail
              </a>
            </div>
          </div>
        </div>
      @empty
        <!-- Fallback Mock Data jika database kosong -->
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
          <div class="relative overflow-hidden aspect-[3/4]">
            <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?auto=format&fit=crop&w=600&q=80" alt="UI/UX" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">Workshop</div>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">UI/UX Masterclass</h3>
            <div class="flex justify-between items-center pt-4 border-t">
              <span class="text-2xl font-black text-indigo-600">Rp 50.000</span>
              <a href="#" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Lihat Detail</a>
            </div>
          </div>
        </div>
      @endforelse
    </div>
  </section>

  {{-- PARTNER SECTION --}}
  <section class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
      <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Partner Resmi AmikomEventHub</h2>
      <p class="text-slate-500 font-medium">Didukung penuh oleh instansi, organisasi, dan perusahaan terpercaya.</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
      @forelse($partners as $partner)
        @php
          $logoSrc = $partner->logo_url ?? $partner->logo ?? '';
        @endphp
        <div class="bg-white border border-slate-100 rounded-2xl p-5 flex flex-col items-center justify-center h-36 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
          <img src="{{ Str::startsWith($logoSrc, 'http') ? $logoSrc : asset('storage/' . $logoSrc) }}" 
               alt="{{ $partner->name }}" 
               class="max-h-12 max-w-[80%] object-contain mb-3" 
               onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg'">
          <h5 class="text-xs font-bold text-slate-700 text-center tracking-tight line-clamp-1">{{ $partner->name }}</h5>
        </div>
      @empty
        <!-- Partner Default Resmi -->
        @php
          $mockPartners = [
            ['name' => 'Midtrans', 'logo' => 'https://asset.kompas.com/crops/O3xIe6_3a1K9d494y9NqZ916M2o=/0x0:1000x667/750x500/data/photo/2021/04/15/607817d1e0f06.png'],
            ['name' => 'Google Cloud', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/51/Google_Cloud_logo.svg'],
            ['name' => 'Microsoft', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg'],
            ['name' => 'Laravel', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg'],
            ['name' => 'Tailwind CSS', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/d/d5/Tailwind_CSS_Logo.svg'],
          ];
        @endphp

        @foreach($mockPartners as $p)
          <div class="bg-white border border-slate-100 rounded-2xl p-5 flex flex-col items-center justify-center h-36 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
            <img src="{{ $p['logo'] }}" alt="{{ $p['name'] }}" class="max-h-12 max-w-[80%] object-contain mb-3">
            <h5 class="text-xs font-bold text-slate-700 text-center tracking-tight line-clamp-1">{{ $p['name'] }}</h5>
          </div>
        @endforeach
      @endforelse
    </div>
  </section>
@endsection