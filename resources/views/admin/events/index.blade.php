@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Data Event</h1>
            <p class="text-sm text-gray-500">Daftar semua event yang tersedia di platform</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded shadow transition-all duration-200">
            + Tambah Event Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="font-bold text-gray-700">Daftar Semua Event</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-600 uppercase text-sm font-semibold bg-gray-50">
                            <th class="py-3 px-4 w-16">No</th>
                            <th class="py-3 px-4">Nama Event</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Harga Tiket</th>
                            <th class="py-3 px-4 text-center w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @forelse($events as $key => $event)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4 font-medium">{{ $key + 1 }}</td>
                                <td class="py-4 px-4 font-semibold text-blue-900">{{ $event->name }}</td>
                                <td class="py-4 px-4">
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-1 rounded-full font-medium">
                                        {{ $event->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-gray-500">
                                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                                </td>
                                <td class="py-4 px-4 font-medium">
                                    @if($event->price == 0)
                                        <span class="text-green-600 font-bold">Gratis</span>
                                    @else
                                        Rp {{ number_format($event->price, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="text-yellow-600 hover:text-yellow-700 font-medium px-3 py-1 border border-yellow-500 rounded hover:bg-yellow-50 transition-all">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium px-3 py-1 border border-red-500 rounded hover:bg-red-50 transition-all">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400 bg-gray-50 rounded-b-lg">
                                    Belum ada data event yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection