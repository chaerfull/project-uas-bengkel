<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerBookingController extends Controller
{
    public function create()
    {
        $vehicles = Vehicle::where(
            'customer_id',
            Auth::guard('customer')->id()
        )->get();

        return view('customer.booking.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        Transaction::create([
            'invoice_number' => 'INV-' . now()->format('YmdHis'),
            'customer_id'    => Auth::guard('customer')->id(),
            'vehicle_id'     => $request->vehicle_id,
            'user_id'        => null,
            'mechanic_id'    => null,
            'total_price'    => 0,
            'type'           => 'booking',
            'booking_date'   => $request->booking_date,
            'status'         => 'pending',
        ]);

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Booking servis berhasil dibuat.');
    }

    public function history()
    {
        $transactions = Transaction::with('vehicle')
            ->where('customer_id', Auth::guard('customer')->id())
            ->latest()
            ->get();

        return view('customer.booking.history', compact('transactions'));
    }
}