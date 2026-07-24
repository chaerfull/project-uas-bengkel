@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">

<h1 class="text-2xl font-bold mb-6">Tambah Kendaraan</h1>

<form action="{{ route('vehicles.store') }}" method="POST" class="bg-white p-6 rounded shadow">

@csrf

<div class="mb-4">
<label class="block mb-2">Pemilik</label>

<select name="customer_id" class="w-full border rounded p-3">

@foreach($customers as $customer)

<option value="{{ $customer->id }}">
{{ $customer->name }}
</option>

@endforeach

</select>

</div>

<div class="mb-4">
<label class="block mb-2">Nomor Polisi</label>

<input
type="text"
name="plate_number"
class="w-full border rounded p-3">

</div>

<div class="mb-5">
<label class="block mb-2">Merk / Model</label>

<input
type="text"
name="brand_model"
class="w-full border rounded p-3">

</div>

<button class="bg-blue-600 text-white px-6 py-3 rounded">
Simpan
</button>

<a href="{{ route('vehicles.index') }}"
class="ml-2 bg-gray-500 text-white px-6 py-3 rounded">

Kembali

</a>

</form>

</div>
@endsection