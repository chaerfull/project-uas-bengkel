@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Pelanggan</h1>

        <a href="{{ route('customers.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            + Tambah Pelanggan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-100">

                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">No HP</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($customers as $customer)

                <tr class="border-b">

                    <td class="px-4 py-3">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $customer->name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $customer->email }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $customer->phone }}
                    </td>

                    <td class="px-4 py-3 text-center">

                        <a href="{{ route('customers.edit',$customer->id) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form action="{{ route('customers.destroy',$customer->id) }}"
                            method="POST"
                            class="inline">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Hapus pelanggan ini?')"
                                class="bg-red-600 text-white px-3 py-1 rounded">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center py-6">
                        Belum ada data pelanggan.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
@endsection