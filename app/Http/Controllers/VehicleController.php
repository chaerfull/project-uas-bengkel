<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('customer')->latest()->get();

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $customers = Customer::all();

        return view('vehicles.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plate_number' => 'required|unique:vehicles',
            'brand_model' => 'required|max:255',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $customers = Customer::all();

        return view('vehicles.edit', compact('vehicle', 'customers'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plate_number' => 'required|unique:vehicles,plate_number,' . $vehicle->id,
            'brand_model' => 'required|max:255',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('vehicles.index')
            ->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
    // ==========================
    // CUSTOMER PORTAL
    // ==========================

    public function customerIndex()
    {
        $vehicles = Vehicle::where(
            'customer_id',
            auth('customer')->id()
        )->latest()->get();

        return view('customer.vehicles.index', compact('vehicles'));
    }

    public function customerCreate()
    {
        return view('customer.vehicles.create');
    }

    public function customerStore(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|unique:vehicles,plate_number',
            'brand_model'  => 'required|max:255',
        ]);

        Vehicle::create([
            'customer_id' => auth('customer')->id(),
            'plate_number' => $request->plate_number,
            'brand_model' => $request->brand_model,
        ]);

        return redirect()
            ->route('customer.vehicles.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }
}