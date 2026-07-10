@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800">Kelola Data Partner</h1>
        <p class="text-sm text-slate-500">Gunakan kolom di bawah untuk mencari partner kerja sama resmi.</p>
    </div>

    <div class="mb-6 flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4 bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.partners.index') }}" method="GET" class="flex items-center gap-2 flex-1 max-w-md">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Ketik nama partner lalu enter..." class="w-full rounded-xl border border-slate-200 p-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition bg-slate-50">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition shadow-sm">
                Cari
            </button>
            @if(!empty($search))
                <a href="{{ route('admin.partners.index') }}" class="bg-slate-400 hover:bg-slate-500 text-white px-4 py-3 rounded-xl text-sm font-bold transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
        <a href="{{ route('admin.partners.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition shadow-sm text-center">
            + Tambah Partner
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                    <th class="p-4 w-20 text-center">No</th>
                    <th class="p-4">Nama Instansi / Partner</th>
                    <th class="p-4 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @forelse($partners as $index => $partner)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 text-center font-medium text-slate-400">{{ $index + 1 }}</td>
                        <td class="p-4 font-semibold text-slate-800">{{ $partner->name }}</td>
                        <td class="p-4 flex justify-center gap-2">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="text-indigo-600 hover:bg-indigo-50 border border-indigo-100 px-3 py-2 rounded-xl font-bold text-xs transition">Edit</a>
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Hapus partner ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:bg-red-50 border border-red-100 px-3 py-2 rounded-xl font-bold text-xs transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-12 text-center text-slate-400 font-medium bg-slate-50/50">Data partner tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection