@extends('layouts.customer')

@section('title', 'Booking Servis')

@section('content')
<div class="container">

    <h3 class="mb-4">Booking Servis</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('customer.booking.store') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Kendaraan</label>

                    <select name="vehicle_id" class="form-select" required>

                        <option value="">-- Pilih Kendaraan --</option>

                        @foreach($vehicles as $vehicle)

                            <option value="{{ $vehicle->id }}">
                                {{ $vehicle->plate_number }}
                                -
                                {{ $vehicle->brand_model }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Tanggal Booking
                    </label>

                    <input
                        type="date"
                        name="booking_date"
                        class="form-control"
                        required>

                </div>

                <button class="btn btn-warning">

                    Booking Sekarang

                </button>

            </form>

        </div>
    </div>

</div>
@endsection