<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Produk / Jasa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Produk/Jasa</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ $product->price }}" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Stok</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="description" class="w-full border rounded p-2">{{ $product->description }}</textarea>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Perbarui Produk</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>