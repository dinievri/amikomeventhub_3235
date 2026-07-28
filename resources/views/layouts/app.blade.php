<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmikomEventHub - Temukan Event Seru!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="text-slate-900 min-h-full">

    {{-- NAVBAR BIASA TANPA STICKY --}}
    <div class="max-w-6xl mx-auto px-4 pt-4">
        <nav class="glass px-6 py-4 rounded-2xl border border-slate-200/60 shadow-md flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                    AH
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">AmikomEventHub</span>
            </div>
            <div class="hidden md:flex gap-8 font-medium text-slate-600">
                <a href="#" class="text-indigo-600 font-semibold">Jelajahi</a>
                <a href="#" class="hover:text-indigo-600 transition">Kategori</a>
                <a href="#" class="hover:text-indigo-600 transition">Tentang Kami</a>
            </div>
        </nav>
    </div>

    {{-- CONTENT --}}
    <main class="w-full">
        @yield('content')
    </main>

    {{-- FOOTER BIASA --}}
    <footer class="bg-indigo-900 text-indigo-100 py-12 px-6 mt-12">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-3 col-span-2">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-indigo-900 font-bold text-base">
                        AH
                    </div>
                    <span class="text-xl font-bold text-white">AmikomEventHub</span>
                </div>
                <p class="max-w-xs text-indigo-300 text-sm">
                    Platform reservasi tiket event online terbaik untuk mahasiswa dan penyelenggara profesional.
                </p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-sm">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">Home</a></li>
                    <li><a href="#" class="hover:text-white transition">Semua Event</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 text-sm">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm text-indigo-300">
                    <li>support@eventtiket.com</li>
                    <li>+62 812 3456 7890</li>
                </ul>
            </div>
        </div>
        <div class="max-w-6xl mx-auto pt-8 mt-8 border-t border-indigo-800 text-center text-indigo-400 text-xs">
            &copy; 2026 AmikomEventHub. Built with Laravel & Tailwind CSS.
        </div>
    </footer>

</body>

</html>