@extends('layouts.app')

@section('content')

<div class="container mx-auto px-6 py-6">

<h1 class="text-2xl font-bold mb-6">
Detail Kendaraan
</h1>

<div class="bg-white p-6 rounded shadow">

<p class="mb-3">
<strong>Pemilik :</strong>
{{ $vehicle->customer->name }}
</p>

<p class="mb-3">
<strong>Nomor Polisi :</strong>
{{ $vehicle->plate_number }}
</p>

<p class="mb-5">
<strong>Merk / Model :</strong>
{{ $vehicle->brand_model }}
</p>

<a href="{{ route('vehicles.index') }}"
class="bg-blue-600 text-white px-5 py-2 rounded">

Kembali

</a>

</div>

</div>

@endsection