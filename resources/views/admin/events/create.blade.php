@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Event Baru</h1>
        <p class="text-sm text-gray-500">Silakan isi form di bawah ini secara lengkap untuk membuat event baru.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Nama Event</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Masukkan nama event" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2.5 border" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2.5 border bg-white" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal & Waktu</label>
                    <input type="datetime-local" name="date" id="date" value="{{ old('date') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2.5 border" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-sm font-semibold text-gray-700 mb-1">Lokasi Tempat / Link Online</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="Contoh: Auditorium Kampus / Zoom Meeting" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2.5 border" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Harga Tiket (Isi 0 jika gratis)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0" placeholder="Contoh: 50000" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2.5 border" required>
                </div>

                <div>
                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">Kuota / Stok Tiket</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 100) }}" min="0" placeholder="Contoh: 100" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2.5 border" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="poster" class="block text-sm font-semibold text-gray-700 mb-1">Poster Event (Opsional)</label>
                <input type="file" name="poster" id="poster" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Event</label>
                <textarea name="description" id="description" rows="4" placeholder="Tuliskan detail info acara di sini..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2.5 border">{{ old('description') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 border-t pt-4">
                <a href="{{ route('admin.events.index') }}" class="text-gray-700 hover:bg-gray-100 px-4 py-2 rounded font-medium border border-gray-300 transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded shadow transition-all">
                    Simpan Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection