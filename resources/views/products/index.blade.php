@extends('layouts.app')

@section('title', 'Kelola Produk & Jasa')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Katalog Produk & Jasa</h2>
        <p class="text-sm text-slate-500">Kelola stok onderdil dan tarif jasa perbaikan.</p>
    </div>
    <!-- Tombol Tambah Produk (Sesuaikan route-nya jika ada) -->
    <a href="{{ route('products.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Produk/Jasa
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-600">
        <thead class="bg-slate-50 border-b border-slate-200 text-slate-700">
            <tr>
                <th class="px-6 py-4 font-semibold">NAMA ITEM</th>
                <th class="px-6 py-4 font-semibold">DESKRIPSI</th>
                <th class="px-6 py-4 font-semibold text-right">HARGA</th>
                <th class="px-6 py-4 font-semibold text-center">STOK</th>
                <th class="px-6 py-4 font-semibold text-center">AKSI</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($products as $product)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4 font-bold text-slate-800">{{ $product->name }}</td>
                <td class="px-6 py-4">{{ Str::limit($product->description, 40) }}</td>
                <td class="px-6 py-4 text-right font-medium text-emerald-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-center">
                    @if($product->stock > 100)
                        <span class="text-slate-500 text-xs font-bold uppercase"><i class="fa-solid fa-infinity"></i> Unlimited (Jasa)</span>
                    @else
                        <span class="bg-slate-100 px-3 py-1 rounded-full font-bold {{ $product->stock < 5 ? 'text-rose-500 bg-rose-50' : 'text-slate-700' }}">
                            {{ $product->stock }}
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 p-2" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
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
                <td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada data produk atau jasa.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection