@extends('layouts.customer')

@section('title', 'Tambah Kendaraan')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-6">

        <h1 class="text-2xl font-bold mb-6">
            🚗 Tambah Kendaraan
        </h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded-lg mb-5">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.vehicles.store') }}" method="POST">

            @csrf

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Nomor Polisi
                </label>

                <input
                    type="text"
                    name="plate_number"
                    value="{{ old('plate_number') }}"
                    class="w-full border rounded-xl px-4 py-3"
                    placeholder="B 1234 ABC">
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-medium">
                    Merk / Model
                </label>

                <input
                    type="text"
                    name="brand_model"
                    value="{{ old('brand_model') }}"
                    class="w-full border rounded-xl px-4 py-3"
                    placeholder="Honda Beat 2023">
            </div>

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

                Simpan Kendaraan

            </button>

        </form>

    </div>

</div>

@endsection