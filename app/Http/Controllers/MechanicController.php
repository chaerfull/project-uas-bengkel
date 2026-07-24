<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MechanicController extends Controller
{
    // 1. Menampilkan Dashboard Mekanik (Hanya tugas miliknya)
    public function index()
    {
        // Mengambil transaksi yang ditugaskan ke mekanik yang sedang login
        $tasks = Transaction::with(['customer', 'vehicle', 'details.product'])
            ->where('mechanic_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mechanic.index', compact('tasks'));
    }

    // 2. Memperbarui Status Pengerjaan Kendaraan
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Cari transaksi, pastikan itu benar-benar milik mekanik yang login
        $transaction = Transaction::where('mechanic_id', Auth::id())->findOrFail($id);

        $transaction->update([
            'status' => $request->status,
        ]);

        return redirect()->route('mechanic.index')
            ->with('success', 'Status pengerjaan berhasil diperbarui menjadi ' . str_replace('_', ' ', $request->status) . '!');
    }
}