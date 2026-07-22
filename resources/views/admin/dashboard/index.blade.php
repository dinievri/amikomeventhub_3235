@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
        <p class="text-sm text-gray-500">Pantau performa penjualan tiket event kamu di sini.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200/80 flex flex-col justify-between">
            <span class="text-xs font-semibold text-gray-400 uppercase">Total Pendapatan</span>
            <div class="flex items-baseline space-x-2 mt-2">
                <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
            <span class="text-xs text-green-600 mt-2 font-medium">↑ 14% dari minggu lalu</span>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200/80 flex flex-col justify-between">
            <span class="text-xs font-semibold text-gray-400 uppercase">Tiket Terjual</span>
            <div class="flex items-baseline space-x-2 mt-2">
                <span class="text-2xl font-bold text-gray-900">{{ $ticketsSold }}</span>
                <span class="text-xs text-gray-500 font-medium">pcs</span>
            </div>
            <span class="text-xs text-blue-600 mt-2 font-medium">Dari transaksi sukses</span>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200/80 flex flex-col justify-between">
            <span class="text-xs font-semibold text-gray-400 uppercase">Event Aktif</span>
            <div class="flex items-baseline space-x-2 mt-2">
                <span class="text-2xl font-bold text-gray-900">{{ $activeEvents }}</span>
                <span class="text-xs text-gray-500 font-medium">Acara</span>
            </div>
            <span class="text-xs text-gray-500 mt-2">Belum kadaluwarsa</span>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200/80 flex flex-col justify-between">
            <span class="text-xs font-semibold text-gray-400 uppercase">Transaksi Pending</span>
            <div class="flex items-baseline space-x-2 mt-2">
                <span class="text-2xl font-bold text-yellow-600">{{ $pendingTransactions }}</span>
                <span class="text-xs text-gray-500 font-medium">Menunggu</span>
            </div>
            <span class="text-xs text-yellow-600 mt-2 font-medium">Belum dibayar di Midtrans</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h3 class="text-base font-bold text-gray-900 mb-4">Tren Penjualan Tiket</h3>
        <div class="relative w-full" style="height: 300px;">
            <canvas id="dashboardChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Jumlah Transaksi Sukses',
                    data: [12, 19, 8, 15, 22, 30, 45],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection