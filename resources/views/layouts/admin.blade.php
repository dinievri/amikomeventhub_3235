<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex min-h-screen">

    <aside class="w-64 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
            <span class="text-xl font-bold text-white tracking-tight">AmikomEventHub</span>
        </div>

        <nav class="flex-1 space-y-2">
            <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-4 px-2">Menu Utama</p>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-xl transition">
                Dashboard
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 bg-indigo-800 text-white font-bold rounded-xl shadow-inner">
                Kelola Kategori
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-indigo-200 hover:bg-indigo-800 rounded-xl transition">
                Kelola Event
            </a>
        </nav>
    </aside>

    @yield('content')

</body>

</html>