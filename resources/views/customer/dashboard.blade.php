@extends('layouts.customer')

@section('title', 'Dashboard Customer')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">
        Selamat Datang, {{ Auth::guard('customer')->user()->name }} 👋
    </h1>

    <p class="text-slate-500 mt-2">
        Kelola kendaraan dan booking servis Anda di MotoServis.
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    <div class="bg-white rounded-2xl shadow-md p-6 border border-slate-100">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-slate-700">Informasi</h2>
            <i class="fa-solid fa-user text-blue-600 text-2xl"></i>
        </div>

        <hr class="my-4">

        <p class="text-sm text-slate-500">Nama</p>
        <p class="font-semibold">{{ Auth::guard('customer')->user()->name }}</p>

        <div class="mt-3">
            <p class="text-sm text-slate-500">Email</p>
            <p>{{ Auth::guard('customer')->user()->email }}</p>
        </div>

        <div class="mt-3">
            <p class="text-sm text-slate-500">No HP</p>
            <p>{{ Auth::guard('customer')->user()->phone }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 border border-slate-100">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-slate-700">Kendaraan Saya</h2>
            <i class="fa-solid fa-motorcycle text-green-600 text-2xl"></i>
        </div>

        <hr class="my-4">

        <p class="text-slate-500 mb-5">
            Belum ada kendaraan yang terdaftar.
        </p>

       <a
    href="{{ route('customer.vehicles.index') }}"
    class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl">

    + Tambah Kendaraan

</a>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 border border-slate-100">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-slate-700">Booking Servis</h2>
            <i class="fa-solid fa-calendar-check text-yellow-500 text-2xl"></i>
        </div>

        <hr class="my-4">

        <p class="text-slate-500 mb-5">
            Booking servis kendaraan Anda.
        </p>

      <a
    href="/customer/booking"
    class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl">

    Booking Sekarang

    </a>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 border border-slate-100">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-slate-700">Riwayat Servis</h2>
            <i class="fa-solid fa-clock-rotate-left text-purple-600 text-2xl"></i>
        </div>

        <hr class="my-4">

        <p class="text-slate-500 mb-5">
    Lihat riwayat booking servis Anda.
</p>

<a
    href="{{ route('customer.booking.history') }}"
    class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl">

    Lihat Riwayat

</a>
    </div>

</div>

@endsection