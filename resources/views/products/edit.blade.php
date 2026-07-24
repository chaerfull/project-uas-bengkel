@extends('layouts.app')

@section('title', 'Edit Produk atau Jasa')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Edit Data Item</h2>
    <p class="text-sm text-slate-500">Perbarui harga, stok, atau nama untuk <strong>{{ $product->name }}</strong>.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
    <form action="{{ route('products.update', $product->id) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk / Jasa</label>
            <input type="text" name="name" value="{{ $product->name }}" required class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Harga (Rp)</label>
                <input type="number" name="price" value="{{ $product->price }}" required min="0" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Barang</label>
                <input type="number" name="stock" value="{{ $product->stock }}" required min="0" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Singkat</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">{{ $product->description }}</textarea>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm transition">
                Update Data
            </button>
            <a href="{{ route('products.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg text-sm font-bold transition">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection