<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WorkerController extends Controller
{
    public function index()
    {
        // Mengambil hanya user ber-role kasir (2) & mechanic (3)
        $workers = User::whereIn('role_id', [2, 3])->get();
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
            'role_id'  => 'required|in:1,2,3', // <-- Diganti jadi role_id dan angka
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id, // <-- Diganti jadi role_id
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
            'name'    => 'required|string|max:255',
            'email'   => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|in:1,2,3', // <-- Diganti jadi role_id dan angka
        ]);

        // Update data dasar
        $worker->name = $request->name;
        $worker->email = $request->email;
        $worker->role_id = $request->role_id; // <-- Diganti jadi role_id

        // Jika form password diisi, maka password akan ikut diubah
        if ($request->filled('password')) {
            $worker->password = Hash::make($request->password);
        }

        $worker->save();

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