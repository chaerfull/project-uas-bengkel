@extends('layouts.customer')

@section('title','Riwayat Booking')

@section('content')

<div class="container">

    <h3 class="mb-4">
        Riwayat Booking
    </h3>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th>Invoice</th>
                        <th>Kendaraan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($transactions as $trx)

                    <tr>

                        <td>{{ $trx->invoice_number }}</td>

                        <td>
                            {{ $trx->vehicle->plate_number }}
                            -
                            {{ $trx->vehicle->brand_model }}
                        </td>

                        <td>{{ $trx->booking_date }}</td>

                        <td>

                            <span class="badge bg-warning">

                                {{ $trx->status }}

                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="text-center">

                            Belum ada booking.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection