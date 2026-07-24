<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Pekerja Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('workers.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" name="email" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Password</label>
                        <input type="password" name="password" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Role Pekerja</label>
                        <select name="role" class="w-full border rounded p-2" required>
                            <option value="kasir">Kasir</option>
                            <option value="mechanic">Mekanik</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Worker</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>