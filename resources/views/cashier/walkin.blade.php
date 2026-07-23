@extends('layouts.app')

@section('title', 'Kasir - Transaksi Walk-In')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Tombol Kembali & Header -->
    <div class="mb-6">
        <a href="{{ route('cashier.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 mb-3 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Dashboard Kasir</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-blue-600"></i>
            Tambah Transaksi Walk-In Baru
        </h1>
        <p class="text-slate-500 text-sm mt-1">Input data pelanggan langsung dan tugaskan mekanik penanggung jawab.</p>
    </div>

    <!-- Card Form -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
        <form action="{{ route('cashier.storeWalkIn') }}" method="POST">
            @csrf

            <!-- Section 1: Tipe Pelanggan -->
            <div class="mb-6">
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Tipe Pelanggan</label>
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2.5 cursor-pointer text-sm font-medium text-slate-700">
                        <input type="radio" id="type_new" name="customer_type" value="new" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500" checked onclick="toggleCustomerType(true)">
                        <span>Pelanggan Baru</span>
                    </label>
                    <label class="flex items-center gap-2.5 cursor-pointer text-sm font-medium text-slate-700">
                        <input type="radio" id="type_existing" name="customer_type" value="existing" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500" onclick="toggleCustomerType(false)">
                        <span>Pelanggan Terdaftar</span>
                    </label>
                </div>
            </div>

            <!-- Form Pelanggan Baru -->
            <div id="section_new_customer" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Pelanggan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" placeholder="Contoh: Budi Santoso">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" placeholder="08123456789">
                </div>
            </div>

            <!-- Form Pelanggan Lama -->
            <div id="section_existing_customer" class="mb-6 hidden">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Pelanggan Terdaftar <span class="text-red-500">*</span></label>
                <select name="customer_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($customers as $cust)
                        <option value="{{ $cust->id }}">{{ $cust->name }} ({{ $cust->phone }})</option>
                    @endforeach
                </select>
            </div>

            <hr class="border-slate-100 my-6">

            <!-- Section 2: Data Kendaraan -->
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Data Kendaraan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Plat Nomor <span class="text-red-500">*</span></label>
                        <input type="text" name="plate_number" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all uppercase font-mono" placeholder="B 1234 ABC" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Merk & Model Kendaraan <span class="text-red-500">*</span></label>
                        <input type="text" name="brand_model" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" placeholder="Honda Vario 150" required>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100 my-6">

            <!-- Section 3: Penugasan Mekanik -->
            <div class="mb-8">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tugaskan Mekanik Penanggung Jawab <span class="text-red-500">*</span></label>
                <select name="mechanic_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" required>
                    <option value="">-- Pilih Mekanik --</option>
                    @foreach($mechanics as $mechanic)
                        <option value="{{ $mechanic->id }}">{{ $mechanic->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow transition-all flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Buat Transaksi & Lanjut Input Nota</span>
            </button>
        </form>
    </div>
</div>

<script>
function toggleCustomerType(isNew) {
    const newSec = document.getElementById('section_new_customer');
    const existSec = document.getElementById('section_existing_customer');
    
    if (isNew) {
        newSec.classList.remove('hidden');
        newSec.classList.add('grid');
        existSec.classList.add('hidden');
    } else {
        newSec.classList.add('hidden');
        newSec.classList.remove('grid');
        existSec.classList.remove('hidden');
    }
}
</script>
@endsection