@extends('layouts.app')

@section('title', 'Tambah Pekerja Baru')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Tambah Pekerja Baru</h2>
    <p class="text-sm text-slate-500">Silakan isi formulir di bawah ini untuk mendaftarkan staf baru.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
    <form action="{{ route('workers.store') }}" method="POST" class="p-6 space-y-6">
        @csrf
        
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Masukkan nama...">
            <!-- Penampil Error -->
            @error('name')
                <span class="text-rose-500 text-xs mt-1 block"><i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email Akun</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="email@bengkel.com">
            @error('email')
                <span class="text-rose-500 text-xs mt-1 block"><i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Password Sementara</label>
            <input type="password" name="password" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Minimal 8 karakter">
            @error('password')
                <span class="text-rose-500 text-xs mt-1 block"><i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Role / Posisi</label>
            <select name="role_id" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                <option value="">-- Pilih Posisi --</option>
                <option value="2" {{ old('role_id') == '2' ? 'selected' : '' }}>Kasir</option>
                <option value="3" {{ old('role_id') == '3' ? 'selected' : '' }}>Mekanik</option>
            </select>
            @error('role_id')
                <span class="text-rose-500 text-xs mt-1 block"><i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $message }}</span>
            @enderror
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm transition">
                Simpan Data
            </button>
            <a href="{{ route('workers.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg text-sm font-bold transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection