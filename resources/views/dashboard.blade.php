@extends('layouts.app') <!-- Sesuaikan path ini jika app.blade.php ada di folder lain -->

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Card Welcome -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-6">
        <h2 class="text-xl font-bold text-slate-800">
            Selamat Datang, {{ auth()->user()->name }}!
        </h2>
        <p class="text-slate-500 text-sm mt-1">Anda sedang berada di halaman Dashboard Admin.</p>
    </div>

    <!-- Card Statistik Admin -->
    @if(auth()->user()->role_id == 1 || (auth()->user()->role && auth()->user()->role->name == 'admin'))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-emerald-500 flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold text-slate-500 uppercase">Total Pendapatan</div>
                    <div class="text-2xl font-black text-slate-800 mt-1">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="text-emerald-500/20 text-5xl">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold text-slate-500 uppercase">Transaksi Hari Ini</div>
                    <div class="text-2xl font-black text-slate-800 mt-1">{{ $transaksiHariIni ?? 0 }} Transaksi</div>
                </div>
                <div class="text-blue-500/20 text-5xl">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
            </div>
        </div>
    @endif
@endsection