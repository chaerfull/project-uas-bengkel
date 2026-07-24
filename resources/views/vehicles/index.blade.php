@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Kendaraan</h1>

        <a href="{{ route('vehicles.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            + Tambah Kendaraan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Pemilik</th>
                    <th class="px-4 py-3">Nomor Polisi</th>
                    <th class="px-4 py-3">Merk / Model</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($vehicles as $vehicle)
                <tr class="border-b">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $vehicle->customer->name }}</td>
                    <td class="px-4 py-3">{{ $vehicle->plate_number }}</td>
                    <td class="px-4 py-3">{{ $vehicle->brand_model }}</td>

                    <td class="px-4 py-3">

                        <a href="{{ route('vehicles.show',$vehicle->id) }}"
                           class="bg-green-500 text-white px-3 py-1 rounded">
                            Detail
                        </a>

                        <a href="{{ route('vehicles.edit',$vehicle->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form action="{{ route('vehicles.destroy',$vehicle->id) }}"
                              method="POST"
                              class="inline">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Hapus kendaraan ini?')"
                                class="bg-red-600 text-white px-3 py-1 rounded">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center py-5">
                        Belum ada data kendaraan.
                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>
    </div>

</div>
@endsection