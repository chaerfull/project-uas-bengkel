@extends('layouts.app')

@section('title', 'Edit Data Pekerja')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Edit Data Pekerja</h2>
    <p class="text-sm text-slate-500">Ubah informasi untuk staf <strong>{{ $worker->name }}</strong>.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
    <form action="{{ route('workers.update', $worker->id) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $worker->name }}" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email Akun</label>
            <input type="email" name="email" value="{{ $worker->email }}" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Ubah Role / Posisi</label>
            <select name="role_id" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                <option value="2" {{ $worker->role_id == 2 ? 'selected' : '' }}>Kasir</option>
                <option value="3" {{ $worker->role_id == 3 ? 'selected' : '' }}>Mekanik</option>
                <option value="1" {{ $worker->role_id == 1 ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="bg-amber-50 border border-amber-200 p-4 rounded-lg">
            <p class="text-sm text-amber-800"><i class="fa-solid fa-circle-info mr-1"></i> Kosongkan jika tidak ingin mengubah password.</p>
            <input type="password" name="password" class="w-full mt-2 rounded-lg border-amber-300 focus:border-amber-500 focus:ring-amber-500 shadow-sm" placeholder="Password Baru (Opsional)">
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm transition">
                Update Data
            </button>
            <a href="{{ route('workers.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg text-sm font-bold transition">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection