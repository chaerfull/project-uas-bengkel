<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendapatan = Transaction::where('status', 'completed')->sum('total_price');
        $transaksiHariIni = Transaction::whereDate('created_at', today())->count();
        $stokMenipis = Product::where('stock', '<=', 5)->get();

        return view('dashboard', compact('totalPendapatan', 'transaksiHariIni', 'stokMenipis'));
    }
}