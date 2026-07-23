@extends('layouts.app')

@section('title', 'Kasir - Payment & Details')

@section('content')

<!-- Tombol Kembali (Sembunyi saat cetak) -->
<div class="mb-6 print:hidden">
    <a href="{{ route('cashier.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 font-semibold text-sm transition">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard Kasir
    </a>
</div>

<!-- Header / Info Nota Utuh (Ikut Tercetak) -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-slate-100">
        <div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-1">INVOICE PENJUALAN / SERVIS</span>
            <h1 class="text-2xl font-black text-slate-900 font-mono tracking-tight">{{ $transaction->invoice_number }}</h1>
        </div>
        <div class="print:hidden">
            @if($transaction->status == 'completed')
                <span class="bg-emerald-100 text-emerald-800 font-bold px-3.5 py-1.5 rounded-full text-xs border border-emerald-300 inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check"></i> Lunas & Selesai
                </span>
            @else
                <span class="bg-amber-100 text-amber-800 font-bold px-3.5 py-1.5 rounded-full text-xs border border-amber-300 inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-hourglass-half"></i> Belum Lunas
                </span>
            @endif
        </div>
    </div>

    <!-- Info Detail Pelanggan & Motor -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-6 text-sm">
        <div>
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Pelanggan</div>
            <div class="font-bold text-slate-800">{{ $transaction->customer->name ?? 'Walk-in Customer' }}</div>
            <div class="text-xs text-slate-500">{{ $transaction->customer->phone ?? '-' }}</div>
        </div>
        <div>
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Kendaraan</div>
            <div class="font-bold text-slate-800">{{ $transaction->vehicle->brand_model ?? '-' }}</div>
            <div class="font-mono text-xs font-semibold text-slate-600">{{ $transaction->vehicle->plate_number ?? '-' }}</div>
        </div>
        <div>
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Mekanik Penanggung Jawab</div>
            <div class="font-semibold text-blue-600">{{ $transaction->mechanic->name ?? 'Belum Ditunjuk' }}</div>
        </div>
        <div>
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Tanggal Transaksi</div>
            <div class="font-medium text-slate-700">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Form Tambah Barang / Jasa (Sembunyi saat cetak) -->
    <div class="lg:col-span-1 print:hidden">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sticky top-20">
            <h3 class="font-bold text-slate-900 text-base mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-cart-plus text-blue-600"></i> Tambah Item Sparepart / Jasa
            </h3>

            <form action="{{ route('cashier.detail.add', $transaction->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Produk atau Jasa</label>
                    <select name="product_id" required class="w-full border border-slate-300 rounded-xl p-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-700">
                        <option value="">-- Pilih Barang / Jasa --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} (Stok: {{ $product->stock }}) - Rp {{ number_format($product->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jumlah / Qty</label>
                    <input type="number" name="quantity" value="1" min="1" required class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-medium">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Tambahkan ke Nota
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Rincian Nota & Total Bayar -->
    <div class="lg:col-span-2 print:w-full">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-6">
            <div class="p-4 bg-slate-50/80 border-b border-slate-200/80 font-bold text-slate-800 text-sm flex items-center justify-between">
                <span>Rincian Item Pembelian & Jasa</span>
            </div>

            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                        <th class="p-4 pl-6">Deskripsi Item</th>
                        <th class="p-4 text-right">Harga Satuan</th>
                        <th class="p-4 text-center">Qty</th>
                        <th class="p-4 text-right pr-6">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transaction->details as $detail)
                        <tr>
                            <td class="p-4 pl-6 font-semibold text-slate-800">{{ $detail->product->name ?? '-' }}</td>
                            <td class="p-4 text-right text-slate-600">Rp {{ number_format($detail->product->price ?? 0, 0, ',', '.') }}</td>
                            <td class="p-4 text-center font-bold text-slate-800">{{ $detail->quantity }}</td>
                            <td class="p-4 text-right pr-6 font-bold text-slate-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400 italic text-sm">
                                Belum ada item yang dimasukkan ke dalam nota transaksi ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 font-black text-slate-900 text-base border-t-2 border-slate-200">
                        <td colspan="3" class="p-4 pl-6 text-right uppercase tracking-wider text-xs text-slate-500">Total Tagihan:</td>
                        <td class="p-4 text-right pr-6 text-lg text-blue-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Tombol Aksi (Sembunyi saat cetak) -->
        <div class="flex flex-wrap gap-3 justify-end print:hidden">
            <button onclick="window.print()" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold px-5 py-2.5 rounded-xl text-sm transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak Struk
            </button>

            @if($transaction->status != 'completed')
                <form action="{{ route('cashier.complete', $transaction->id) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah pembayaran tunai/transfer sudah diterima secara sah?')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i> Selesaikan Pembayaran
                    </button>
                </form>
            @endif
        </div>
    </div>

</div>

@endsection