<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    // 1. Menampilkan Antrean Booking & Daftar Transaksi Kasir
    public function index()
    {
        // Mengambil transaksi booking yang masih pending
        $pendingBookings = Transaction::with(['customer', 'vehicle'])
            ->where('type', 'booking')
            ->where('status', 'pending')
            ->get();

        // PERBAIKAN: Mengambil mekanik secara dinamis dari relasi tabel roles terpisah
        $mechanics = User::whereHas('role', function($query) {
            $query->where('name', 'mechanic');
        })->get();

        // Mengambil transaksi yang sedang berjalan/selesai hari ini
        $todayTransactions = Transaction::with(['customer', 'vehicle', 'mechanic'])
            ->latest()
            ->get();

        return view('cashier.index', compact('pendingBookings', 'mechanics', 'todayTransactions'));
    }

    // 2. Assign / Penunjukan Mekanik ke Booking (SUDAH AMAN)
    public function assignMechanic(Request $request, int $id)
    {
        $request->validate([
            'mechanic_id' => 'required|exists:users,id',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'mechanic_id' => $request->mechanic_id,
            'user_id' => Auth::id(), // ID Kasir yang memproses
            'status'      => 'in_progress', // Status berubah jadi sedang dikerjakan
        ]);

        return redirect()->back()->with('success', 'Mekanik berhasil ditugaskan!');
    }

    // 3. Halaman Form Detail & Pembayaran Transaksi (SUDAH AMAN)
    public function showPaymentForm(int $id)
    {
        $transaction = Transaction::with(['customer', 'vehicle', 'mechanic', 'details.product'])->findOrFail($id);
        $products    = Product::where('stock', '>', 0)->get();

        return view('cashier.payment', compact('transaction', 'products'));
    }

    // 4. Tambah Item Barang / Jasa ke Nota & Potong Stok
    public function addDetail(Request $request, int $transactionId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $transactionId) {
            $product = Product::findOrFail($request->product_id);
            
            // PERBAIKAN: Hitung harga setelah dipotong diskon dari admin
            $hargaBersih = $product->price - $product->discount;
            $subtotal    = $hargaBersih * $request->quantity;

            // PERBAIKAN: Menyimpan harga satuan terkunci ('price') ke detail item
            TransactionDetail::create([
                'transaction_id' => $transactionId,
                'product_id'     => $product->id,
                'quantity'       => $request->quantity,
                'price'          => $hargaBersih, // Mengunci harga saat transaksi sukses
                'subtotal'       => $subtotal,
            ]);

            // Potong stok produk
            $product->decrement('stock', $request->quantity);

            // Update total harga transaksi utama
            $transaction = Transaction::findOrFail($transactionId);
            $transaction->increment('total_price', $subtotal);
        });

        return redirect()->back()->with('success', 'Item berhasil ditambahkan!');
    }

    // 5. Finalisasi Transaksi (Selesai Pembayaran) (SUDAH AMAN)
    public function completeTransaction(int $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'status' => 'completed',
        ]);

        return redirect()->route('cashier.index')->with('success', 'Transaksi Selesai & Pembayaran Berhasil!');
        
    }
    // 6. Fungsi untuk hapus item jika kasir salah input (Mengembalikan stok barang)
    public function deleteDetail(int $id)
    {
        DB::transaction(function () use ($id) {
            $detail = TransactionDetail::findOrFail($id);
            $product = Product::findOrFail($detail->product_id);

            // Kembalikan stok yang sempat dikurangi
            $product->increment('stock', $detail->quantity);

            // Kurangi total harga di transaksi utama
            $transaction = Transaction::findOrFail($detail->transaction_id);
            $transaction->decrement('total_price', $detail->subtotal);

            // Hapus baris detailnya
            $detail->delete();
        });

        return redirect()->back()->with('success', 'Item berhasil dihapus!');
    }

    // Fungsi untuk membuka halaman cetak struk khusus
    public function printInvoice(int $id)
    {
        $transaction = Transaction::with(['customer', 'vehicle', 'mechanic', 'details.product'])->findOrFail($id);
        return view('cashier.print', compact('transaction'));
    }
}
