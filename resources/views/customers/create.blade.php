@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">

        <h1 class="text-2xl font-bold mb-6">
            Tambah Pelanggan
        </h1>

        <form action="{{ route('customers.store') }}" method="POST">

            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border rounded-lg p-2">

                @error('name')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border rounded-lg p-2">

                @error('email')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border rounded-lg p-2">

                @error('password')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    No HP
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="w-full border rounded-lg p-2">

                @error('phone')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex gap-3">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Simpan
                </button>

                <a
                    href="{{ route('customers.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>
@endsection