@extends('layouts.app')

@section('title', 'Kelola Workers')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Daftar Pekerja</h2>
        <p class="text-sm text-slate-500">Kelola data Kasir dan Mekanik bengkel Anda.</p>
    </div>
    <!-- Tombol Tambah Pekerja (Sesuaikan route-nya jika ada) -->
    <a href="{{ route('workers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Pekerja
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-600">
        <thead class="bg-slate-50 border-b border-slate-200 text-slate-700">
            <tr>
                <th class="px-6 py-4 font-semibold">NAMA PEKERJA</th>
                <th class="px-6 py-4 font-semibold">EMAIL</th>
                <th class="px-6 py-4 font-semibold">ROLE / POSISI</th>
                <th class="px-6 py-4 font-semibold text-center">AKSI</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($workers as $worker)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4 font-medium text-slate-800">{{ $worker->name }}</td>
                <td class="px-6 py-4">{{ $worker->email }}</td>
                <td class="px-6 py-4">
                    <!-- Penyesuaian pengecekan Role -->
                    @if($worker->role_id == 2 || (isset($worker->role) && $worker->role->name == 'cashier'))
                        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold">Kasir</span>
                    @elseif($worker->role_id == 3 || (isset($worker->role) && $worker->role->name == 'mechanic'))
                        <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">Mekanik</span>
                    @else
                        <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">Admin</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('workers.edit', $worker->id) }}" class="text-blue-500 hover:text-blue-700 p-2" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('workers.destroy', $worker->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pekerja ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-500 hover:text-rose-700 p-2" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada data pekerja.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection