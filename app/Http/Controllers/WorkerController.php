<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WorkerController extends Controller
{
    public function index()
    {
        // Mengambil hanya user ber-role kasir & mechanic
        $workers = User::whereIn('role', ['kasir', 'mechanic'])->get();
        return view('workers.index', compact('workers'));
    }

    public function create()
    {
        return view('workers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:kasir,mechanic',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('workers.index')->with('success', 'Pekerja berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $worker = User::findOrFail($id);
        return view('workers.edit', compact('worker'));
    }

    public function update(Request $request, $id)
    {
        $worker = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role'  => 'required|in:kasir,mechanic',
        ]);

        $worker->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        return redirect()->route('workers.index')->with('success', 'Data pekerja berhasil diperbarui!');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('workers.index')->with('success', 'Pekerja berhasil dihapus!');
    }

    // Fitur Riset Password Pekerja
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $worker = User::findOrFail($id);
        $worker->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('workers.index')->with('success', 'Password pekerja berhasil diriset!');
    }
}