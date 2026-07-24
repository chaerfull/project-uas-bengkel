@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">

    <h1 class="text-2xl font-bold mb-6">
        Detail Pelanggan
    </h1>

    <div class="bg-white p-6 rounded-lg shadow">

        <div class="mb-4">
            <strong>Nama</strong>
            <p>{{ $customer->name }}</p>
        </div>

        <div class="mb-4">
            <strong>Email</strong>
            <p>{{ $customer->email }}</p>
        </div>

        <div class="mb-4">
            <strong>Nomor HP</strong>
            <p>{{ $customer->phone }}</p>
        </div>

        <a href="{{ route('customers.index') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

            Kembali

        </a>

    </div>

</div>
@endsection