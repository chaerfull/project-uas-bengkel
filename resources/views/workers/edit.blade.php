<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Pekerja</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Form Edit Profile Worker -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-bold text-lg mb-4">Informasi Pekerja</h3>
                <form action="{{ route('workers.update', $worker->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $worker->name }}" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ $worker->email }}" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Role Pekerja</label>
                        <select name="role" class="w-full border rounded p-2" required>
                            <option value="kasir" {{ $worker->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="mechanic" {{ $worker->role == 'mechanic' ? 'selected' : '' }}>Mekanik</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Perbarui Data</button>
                </form>
            </div>

            <!-- Form Reset Password Worker -->
            <div class="bg-white p-6 rounded-lg shadow border-t-4 border-red-500">
                <h3 class="font-bold text-lg mb-4 text-red-600">Reset Password Pekerja</h3>
                <form action="{{ route('workers.reset-password', $worker->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700">Password Baru</label>
                        <input type="password" name="password" class="w-full border rounded p-2" placeholder="Masukkan password baru" required>
                    </div>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Riset Password</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>