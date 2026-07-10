<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AmikomEventHub</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-gray-900 text-white flex flex-col">
            <div class="p-5 text-xl font-bold tracking-wider border-b border-gray-800 text-blue-400">
                AmikomEventHub
            </div>
            
            <nav class="flex-1 p-4 space-y-2 text-sm">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-2 mb-1">Main</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg bg-blue-600 text-white font-medium transition">
                    <span>📊 Dashboard</span>
                </a>
                
                <a href="{{ route('admin.events.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition">
                    <span>📅 Manage Events</span>
                </a>

                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-2 pt-4 mb-1">Data Master</p>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition">
                    <span>🏷️ Event Categories</span>
                </a>

                <a href="{{ route('admin.partners.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition">
                    <span>🤝 Partners</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800 text-xs text-gray-500 text-center">
                v1.0 - Admin Panel
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 overflow-x-hidden">
            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
                <h2 class="text-sm font-medium text-gray-500">Welcome back, Admin</h2>
                <div class="flex items-center space-x-3">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-sm font-semibold text-gray-700">Administrator</span>
                </div>
            </header>

            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>