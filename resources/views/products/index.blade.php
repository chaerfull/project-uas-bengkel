<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Master Data Produk & Jasa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Produk/Jasa</a>

                <table class="min-w-full divide-y divide-gray-200 mt-4 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Nama Produk/Jasa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($products as $product)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-bold rounded {{ $product->stock <= 5 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>