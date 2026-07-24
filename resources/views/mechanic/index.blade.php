@extends('layouts.app')

@section('title', 'Mekanik - Dashboard Tugas')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Halaman -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
            <i class="fa-solid fa-wrench text-blue-600"></i>
            Dashboard Tugas Servis
        </h1>
        <p class="text-slate-500 text-sm mt-1">Daftar kendaraan yang ditugaskan kepada Anda ({{ Auth::user()->name }}).</p>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Daftar Tugas (Grid) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tasks as $task)
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow relative overflow-hidden">
                
                <!-- Aksen Garis Samping berdasarkan Status -->
                <div class="absolute left-0 top-0 bottom-0 w-1 
                    {{ $task->status === 'completed' ? 'bg-emerald-500' : ($task->status === 'in_progress' ? 'bg-blue-500' : 'bg-amber-500') }}">
                </div>

                <div>
                    <!-- Badge Status & Nomor Invoice -->
                    <div class="flex items-start justify-between mb-4 pl-2">
                        <div>
                            @if($task->status === 'pending')
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-700">MENUNGGU</span>
                            @elseif($task->status === 'in_progress')
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-blue-100 text-blue-700">DIKERJAKAN</span>
                            @else
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700">SELESAI</span>
                            @endif
                        </div>
                        <span class="text-xs text-slate-400 font-mono">{{ $task->invoice_number }}</span>
                    </div>

                    <!-- Informasi Kendaraan -->
                    <div class="mb-5 pl-2">
                        <h3 class="text-lg font-bold text-slate-900">{{ $task->vehicle->brand_model ?? 'Kendaraan Tidak Diketahui' }}</h3>
                        <div class="text-sm font-bold text-blue-600 font-mono mt-1 bg-blue-50 inline-block px-2 py-0.5 rounded border border-blue-100">
                            {{ $task->vehicle->plate_number ?? '-' }}
                        </div>
                        <p class="text-xs text-slate-500 mt-3">Pelanggan: <strong class="text-slate-700">{{ $task->customer->name ?? '-' }}</strong></p>
                    </div>

                    <!-- Daftar Item/Suku Cadang yang Dipesan Kasir -->
                    <div class="border-t border-slate-100 pt-4 mb-4 pl-2">
                        <div class="text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Item & Jasa yang Dikerjakan:</div>
                        <ul class="text-sm text-slate-600 space-y-1.5">
                            @forelse($task->details as $detail)
                                <li class="flex justify-between items-center bg-slate-50 px-2 py-1.5 rounded">
                                    <span class="truncate pr-2">• {{ $detail->product->name ?? 'Item Dihapus' }}</span>
                                    <span class="font-bold text-slate-700 text-xs bg-slate-200 px-1.5 rounded">x{{ $detail->quantity }}</span>
                                </li>
                            @empty
                                <li class="text-slate-400 text-xs italic">Belum ada item ditambahkan kasir</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Form Ubah Status -->
                <form action="{{ route('mechanic.updateStatus', $task->id) }}" method="POST" class="mt-2 pt-4 border-t border-slate-100 pl-2">
                    @csrf
                    @method('PATCH')
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Update Status Pengerjaan:</label>
                    <div class="flex gap-2">
                        <select name="status" class="text-sm rounded-xl border border-slate-200 bg-white text-slate-700 w-full focus:ring-blue-500 outline-none px-3 py-2">
                            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>Dikerjakan (In Progress)</option>
                            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                        </select>
                        <button type="submit" class="bg-slate-900 text-white text-sm px-4 py-2 rounded-xl font-medium hover:bg-slate-800 transition-colors shadow-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        @empty
            <!-- Tampilan Jika Tidak Ada Tugas -->
            <div class="col-span-full bg-white rounded-2xl p-10 border border-slate-200/80 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4 text-3xl">
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-700 mb-1">Pekerjaan Kosong</h3>
                <p class="text-slate-500 text-sm">Belum ada kendaraan yang ditugaskan kepada Anda saat ini. Silakan bersantai sejenak!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection