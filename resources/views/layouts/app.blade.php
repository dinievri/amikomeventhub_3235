<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmikomEventHub - Temukan Event Seru!</title>
    
    {{-- DIREKTIF VITE UNTUK HOT RELOAD --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js untuk interaktivitas Dropdown --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
        }
    </style>
</head>

{{-- FLEXBOX STICKY FOOTER --}}
<body class="text-slate-900 min-h-screen flex flex-col antialiased selection:bg-indigo-500 selection:text-white">

    {{-- NAVBAR STICKY --}}
    <div class="sticky top-0 z-50 max-w-7xl w-full mx-auto px-4 pt-4 pb-2">
        <nav class="glass px-6 py-3.5 rounded-2xl border border-slate-200/80 shadow-sm flex justify-between items-center">
            
            {{-- LOGO BRAND --}}
            <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-md shadow-indigo-200 group-hover:scale-105 transition">
                    AH
                </div>
                <span class="text-xl font-extrabold tracking-tight text-slate-900">AmikomEventHub</span>
            </a>

            {{-- MENU & AUTHENTICATION --}}
            <div class="hidden md:flex items-center gap-8">
                <div class="flex gap-8 font-semibold text-slate-600 text-sm">
                    <a href="{{ route('welcome') }}" class="hover:text-indigo-600 transition">Jelajahi</a>
                    <a href="#kategori" class="hover:text-indigo-600 transition">Kategori</a>
                    <a href="#" class="hover:text-indigo-600 transition">Tentang Kami</a>
                </div>

                {{-- STATUS LOGIN CUSTOMER --}}
                <div class="pl-6 border-l border-slate-200 flex items-center">
                    @auth('customer')
                        @php
                            $user = Auth::guard('customer')->user();
                        @endphp
                        
                        {{-- DROPDOWN USER PROFILE --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2.5 p-1.5 pl-3 rounded-full border border-slate-200 hover:border-indigo-400 hover:shadow-md transition bg-white/80">
                                <span class="text-xs font-bold text-slate-700 max-w-[130px] truncate">
                                    {{ $user->name }}
                                </span>
                                
                                {{-- FOTO PROFIL / AVATAR INISIAL --}}
                                @if(isset($user->avatar) && $user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover border border-indigo-100 shadow-sm">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-xs flex items-center justify-center uppercase shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                @endif

                                {{-- ICON ARROW DOWN --}}
                                <svg class="w-4 h-4 text-slate-400 mr-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            {{-- DROPDOWN MENU FLOATING --}}
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
                                 class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50" 
                                 style="display: none;">
                                
                                {{-- HEADER DROPDOWN --}}
                                <div class="px-4 py-2.5 border-b border-slate-100">
                                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Halo, Selamat Datang</p>
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                                </div>

                                {{-- NAVIGASI USER --}}
                                <div class="py-1">
                                    <a href="{{ url('/my-ticket') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2M5 11a2 2 0 012-2h10a2 2 0 012 2v3a2 2 0 01-2 2H7a2 2 0 01-2-2v-3z"></path>
                                        </svg>
                                        Tiket Saya
                                    </a>
                                </div>

                                {{-- ACTION LOGOUT --}}
                                <div class="border-t border-slate-100 pt-1">
                                    <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-red-500 hover:bg-red-50 transition">
                                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- TOMBOL GOOGLE LOGIN --}}
                        <a href="{{ route('google.login', ['redirect' => url()->current()]) }}" 
                           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-md shadow-indigo-100 hover:scale-105">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.761H12.545z"/>
                            </svg>
                            Sign In dengan Google
                        </a>
                    @endauth
                </div>
            </div>

        </nav>
    </div>

    {{-- CONTENT MAIN --}}
    <main class="w-full flex-grow">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-indigo-950 text-indigo-100 py-12 px-6 mt-16 w-full border-t border-indigo-900">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-3 col-span-2">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black text-base shadow-sm">
                        AH
                    </div>
                    <span class="text-xl font-extrabold text-white">AmikomEventHub</span>
                </div>
                <p class="max-w-xs text-indigo-300/80 text-xs leading-relaxed font-medium">
                    Platform reservasi tiket event online terbaik untuk mahasiswa dan penyelenggara profesional.
                </p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-xs uppercase tracking-wider">Navigasi</h4>
                <ul class="space-y-2.5 text-xs text-indigo-200/80 font-medium">
                    <li><a href="{{ route('welcome') }}" class="hover:text-white transition">Home</a></li>
                    <li><a href="#events" class="hover:text-white transition">Semua Event</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-xs uppercase tracking-wider">Hubungi Kami</h4>
                <ul class="space-y-2.5 text-xs text-indigo-200/80 font-medium">
                    <li>support@amikomeventhub.com</li>
                    <li>+62 812 3456 7890</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto pt-8 mt-8 border-t border-indigo-900/60 text-center text-indigo-400/60 text-[11px] font-medium">
            &copy; 2026 AmikomEventHub. Built with Laravel & Tailwind CSS.
        </div>
    </footer>

</body>

</html>