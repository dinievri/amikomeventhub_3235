@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800">Tambah Partner Baru</h1>
        <p class="text-sm text-slate-500">Masukkan nama instansi dan link URL gambar logo partner.</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.partners.store') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Partner</label>
                <input type="text" name="name" id="name" required placeholder="Contoh: PT. Amikom Media" class="w-full rounded-xl border border-slate-200 p-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-slate-50">
            </div>

            <div class="mb-5">
                <label for="logo_url" class="block text-sm font-bold text-slate-700 mb-2">URL Logo Gambar</label>
                <input type="url" name="logo_url" id="logo_url" placeholder="Contoh: https://amikom.ac.id/logo.png" class="w-full rounded-xl border border-slate-200 p-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-slate-50">
                <p class="text-xs text-slate-400 mt-1">Masukkan link langsung menuju gambar logo (diawali http:// atau https://).</p>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                <a href="{{ route('admin.partners.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-5 py-3 rounded-xl text-sm font-bold transition">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition shadow-sm">
                    Simpan Partner
                </button>
            </div>
        </form>
    </div>
</div>
@endsection