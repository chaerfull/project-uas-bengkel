@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">

        <h1 class="text-2xl font-bold mb-6">
            Edit Pelanggan
        </h1>

        <form action="{{ route('customers.update', $customer->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $customer->name) }}"
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
                    value="{{ old('email', $customer->email) }}"
                    class="w-full border rounded-lg p-2">

                @error('email')
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
                    value="{{ old('phone', $customer->phone) }}"
                    class="w-full border rounded-lg p-2">

                @error('phone')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex gap-3">

                <button
                    type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                    Update
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