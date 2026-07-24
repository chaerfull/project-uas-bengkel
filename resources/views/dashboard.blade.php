<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

@if(auth()->user()->role == 'admin')
    <!-- Card Statistik Admin Milikmu -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <div class="text-sm font-medium text-gray-500">Total Pendapatan</div>
            <div class="text-2xl font-bold">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <div class="text-sm font-medium text-gray-500">Transaksi Hari Ini</div>
            <div class="text-2xl font-bold">{{ $transaksiHariIni ?? 0 }} Transaksi</div>
        </div>
    </div>
@endif

</x-app-layout>
