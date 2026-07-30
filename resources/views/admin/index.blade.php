@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800">Admin Dashboard</h1>
            <p class="text-slate-500">Ringkasan performa penjualan dan transaksi.</p>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-bold transition">
                Logout
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- KARTU STATISTIK UTAMA --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <!-- Total Pendapatan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>

        <!-- Transaksi Sukses -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-sm font-bold uppercase mb-1">Transaksi Sukses</p>
            <h3 class="text-2xl font-black text-slate-800">{{ $ticketsSold }}</h3>
        </div>

        <!-- Event Mendatang -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7h-1V5a3 3 0 00-6 0v2H8a2 2 0 00-2 2v1h12V9a2 2 0 00-2-2zm-6 4a2 2 0 00-2 2v3h4v-3a2 2 0 00-2-2z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-sm font-bold uppercase mb-1">Event Mendatang</p>
            <h3 class="text-2xl font-black text-slate-800">{{ $activeEvents }}</h3>
        </div>

        <!-- Transaksi Pending -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-slate-400 text-sm font-bold uppercase mb-1">Transaksi Pending</p>
            <h3 class="text-2xl font-black text-slate-800">{{ $pendingTransactions }}</h3>
        </div>
    </div>

    {{-- KARTU TOTAL PENGGUNA (Tampil khusus Superadmin) --}}
    @if(isset($totalUsers) && $totalUsers !== null)
        <div class="bg-purple-600 text-white p-6 rounded-3xl mb-10 shadow-lg shadow-purple-100 flex items-center justify-between">
            <div>
                <p class="text-purple-200 text-sm font-bold uppercase mb-1">Total Pengguna Terdaftar</p>
                <h3 class="text-3xl font-black">{{ $totalUsers }} Pengguna</h3>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    @endif

    {{-- GRAFIK PERTUMBUHAN EVENT (FITUR SOAL 2) --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 mb-10">
        <h3 class="text-lg font-black text-slate-800 mb-4">Grafik Pertumbuhan Penyelenggaraan Event</h3>
        <div class="relative w-full h-72">
            <canvas id="eventGrowthChart"></canvas>
        </div>
    </div>

    {{-- TABEL TRANSAKSI TERBARU --}}
    @if(isset($recentTransactions) && $recentTransactions->count() > 0)
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 mb-10">
            <h3 class="text-lg font-black text-slate-800 mb-4">Transaksi Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-400 font-bold uppercase text-xs">
                        <tr>
                            <th class="p-3 rounded-l-xl">Order ID</th>
                            <th class="p-3">Nama Pembeli</th>
                            <th class="p-3">Event</th>
                            <th class="p-3">Total</th>
                            <th class="p-3 rounded-r-xl">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentTransactions as $trx)
                            <tr>
                                <td class="p-3 font-mono text-xs font-bold">{{ $trx->order_id }}</td>
                                <td class="p-3 font-semibold text-slate-800">{{ $trx->customer_name }}</td>
                                <td class="p-3">{{ $trx->event->title ?? '-' }}</td>
                                <td class="p-3 font-bold">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    <span class="px-3 py-1 text-xs rounded-full font-bold
                                        {{ $trx->status == 'success' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $trx->status == 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $trx->status == 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ strtoupper($trx->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 text-center">
        <h2 class="text-xl font-black text-slate-800">Selamat datang di Panel Admin!</h2>
        <p class="text-slate-500 mt-3">Gunakan menu di sisi kiri atau atas untuk mengelola Event, Kategori, dan Transaksi.</p>
    </div>

    {{-- SCRIPT CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('eventGrowthChart').getContext('2d');
            
            const monthlyData = {!! json_encode($monthlyEvents ?? []) !!};
            const labels = Object.keys(monthlyData);
            const dataValues = Object.values(monthlyData);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels.length > 0 ? labels : ['Belum ada data'],
                    datasets: [{
                        label: 'Jumlah Event Dibuat',
                        data: dataValues.length > 0 ? dataValues : [0],
                        backgroundColor: 'rgba(99, 102, 241, 0.6)',
                        borderColor: 'rgba(99, 102, 241, 1)',
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            ticks: { stepSize: 1 } 
                        }
                    }
                }
            });
        });
    </script>
@endsection