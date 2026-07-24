@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">

<h1 class="text-2xl font-bold mb-6">Edit Kendaraan</h1>

<form action="{{ route('vehicles.update',$vehicle->id) }}" method="POST" class="bg-white p-6 rounded shadow">

@csrf
@method('PUT')

<div class="mb-4">

<label>Pemilik</label>

<select name="customer_id" class="w-full border rounded p-3">

@foreach($customers as $customer)

<option
value="{{ $customer->id }}"
{{ $vehicle->customer_id==$customer->id ? 'selected' : '' }}>

{{ $customer->name }}

</option>

@endforeach

</select>

</div>

<div class="mb-4">

<label>Nomor Polisi</label>

<input
type="text"
name="plate_number"
value="{{ $vehicle->plate_number }}"
class="w-full border rounded p-3">

</div>

<div class="mb-5">

<label>Merk / Model</label>

<input
type="text"
name="brand_model"
value="{{ $vehicle->brand_model }}"
class="w-full border rounded p-3">

</div>

<button class="bg-yellow-500 text-white px-6 py-3 rounded">
Update
</button>

<a href="{{ route('vehicles.index') }}"
class="ml-2 bg-gray-500 text-white px-6 py-3 rounded">

Kembali

</a>

</form>

</div>
@endsection