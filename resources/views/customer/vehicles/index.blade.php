@extends('layouts.customer')

@section('title','Kendaraan Saya')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-2xl font-bold">
        Kendaraan Saya
    </h1>

    <a
        href="{{ route('customer.vehicles.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

        + Tambah Kendaraan

    </a>

</div>

@if(session('success'))

<div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded-xl mb-5">

    {{ session('success') }}

</div>

@endif

<div class="bg-white rounded-2xl shadow overflow-hidden">

<table class="min-w-full">

    <thead class="bg-slate-100">

        <tr>

            <th class="px-5 py-3 text-left">
                No Polisi
            </th>

            <th class="px-5 py-3 text-left">
                Merk / Model
            </th>

        </tr>

    </thead>

    <tbody>

        @forelse($vehicles as $vehicle)

        <tr class="border-t">

            <td class="px-5 py-4">

                {{ $vehicle->plate_number }}

            </td>

            <td class="px-5 py-4">

                {{ $vehicle->brand_model }}

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="2" class="text-center py-8 text-slate-500">

                Belum ada kendaraan.

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

@endsection
