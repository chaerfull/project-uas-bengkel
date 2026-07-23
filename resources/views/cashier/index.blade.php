@extends('layouts.app')

@section('title', 'Kasir - Dashboard Transaksi')

@section('content')

<!-- Header Halaman -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
            <i class="fa-solid fa-cash-register text-blue-600"></i>
            Portal Kasir Operasional
        </h1>
        <p class="text-slate-500 text-sm mt-1">Kelola antrean masuk, penunjukan mekanik, dan nota transaksi.</p>
    </div>
</div>

<!-- Kartu Ringkasan (Stats) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-xl font-bold">
            <i class="fa-solid fa-clock font-normal"></i>
        </div>
        <div>
            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Booking Menunggu</div>
            <div class="text-2xl font-bold text-slate-900 mt-0.5">{{ $pendingBookings->count() }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-200 text-blue-600 flex items-center justify-center text-xl font-bold">
            <i class="fa-solid fa-wrench"></i>
        </div>
        <div>
            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Servis Hari Ini</div>
            <div class="text-2xl font-bold text-slate-900 mt-0.5">{{ $todayTransactions->count() }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center text-xl font-bold">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
        <div>
            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Selesai</div>
            <div class="text-2xl font-bold text-slate-900 mt-0.5">{{ $todayTransactions->where('status', 'completed')->count() }}</div>
        </div>
    </div>
</div>

<!-- KARTU 1: Antrean Booking Online -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 mb-8 overflow-hidden">
    <div class="bg-slate-900 text-white px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2 font-bold text-base">
            <span class="w-2.5 h-2.5 bg-amber-400 rounded-full animate-ping"></span>
            Antrean Booking Online (Menunggu Mekanik)
        </div>
        <span class="bg-amber-500/20 text-amber-300 text-xs px-3 py-1 rounded-full font-semibold border border-amber-500/30">
            {{ $pendingBookings->count() }} Pesanan
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="p-4 pl-6">No. Invoice</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Kendaraan</th>
                    <th class="p-4">Tgl Booking</th>
                    <th class="p-4 pr-6">Pilih & Tugaskan Mekanik</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($pendingBookings as $booking)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="p-4 pl-6 font-bold text-slate-900 font-mono">{{ $booking->invoice_number }}</td>
                        <td class="p-4">
                            <div class="font-semibold text-slate-800">{{ $booking->customer->name ?? '-' }}</div>
                            <div class="text-xs text-slate-400"><i class="fa-solid fa-phone text-[10px] mr-1"></i>{{ $booking->customer->phone ?? '-' }}</div>
                        </td>
                        <td class="p-4">
                            <span class="bg-slate-100 border border-slate-300 font-mono text-xs px-2 py-1 rounded-md font-bold text-slate-700 uppercase">
                                {{ $booking->vehicle->plate_number ?? '-' }}
                            </span>
                            <span class="text-slate-600 text-xs ml-1.5 font-medium">{{ $booking->vehicle->brand_model ?? '' }}</span>
                        </td>
                        <td class="p-4 text-slate-600 text-xs font-medium">
                            <i class="fa-regular fa-calendar text-slate-400 mr-1"></i>{{ $booking->booking_date ?? '-' }}
                        </td>
                        <td class="p-4 pr-6">
                            <form action="{{ route('cashier.assign', $booking->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <select name="mechanic_id" required class="border border-slate-300 rounded-lg px-3 py-1.5 text-xs bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="">-- Pilih Mekanik --</option>
                                    @foreach($mechanics as $mechanic)
                                        <option value="{{ $mechanic->id }}">{{ $mechanic->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3.5 py-1.5 rounded-lg transition shadow-sm flex items-center gap-1.5">
                                    <i class="fa-solid fa-user-check"></i> Process
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400 text-sm italic">
                            <i class="fa-regular fa-folder-open text-2xl block mb-2 text-slate-300"></i>
                            Tidak ada antrean booking online yang perlu ditugaskan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- KARTU 2: Daftar Semua Transaksi Hari Ini -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-200/80 flex items-center justify-between">
        <h2 class="font-bold text-slate-900 text-lg">Daftar Transaksi Hari Ini</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="p-4 pl-6">Invoice</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Plat Nomor</th>
                    <th class="p-4">Mekanik</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Total Biaya</th>
                    <th class="p-4 text-center pr-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($todayTransactions as $trx)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="p-4 pl-6 font-bold text-slate-900 font-mono">{{ $trx->invoice_number }}</td>
                        <td class="p-4 font-medium text-slate-800">{{ $trx->customer->name ?? 'Walk-in Customer' }}</td>
                        <td class="p-4">
                            <span class="bg-slate-100 border border-slate-200 text-xs px-2 py-0.5 rounded font-mono font-semibold text-slate-700">
                                {{ $trx->vehicle->plate_number ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-slate-700 font-medium">
                            @if($trx->mechanic)
                                <i class="fa-solid fa-user-gear text-slate-400 mr-1"></i>{{ $trx->mechanic->name }}
                            @else
                                <span class="text-slate-400 italic text-xs">Belum ditunjuk</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($trx->status == 'pending')
                                <span class="bg-amber-100 text-amber-800 border border-amber-200 text-xs font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Pending
                                </span>
                            @elseif($trx->status == 'in_progress')
                                <span class="bg-blue-100 text-blue-800 border border-blue-200 text-xs font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-ping"></span> Pengerjaan
                                </span>
                            @elseif($trx->status == 'completed')
                                <span class="bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Selesai
                                </span>
                            @endif
                        </td>
                        <td class="p-4 font-bold text-slate-900">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                        <td class="p-4 text-center pr-6">
                            <a href="{{ route('cashier.payment', $trx->id) }}" class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold px-3.5 py-2 rounded-xl transition shadow-sm">
                                <span>Bayar / Detail</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400 text-sm italic">
                            Belum ada transaksi tercatat hari ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection