<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        // Mengambil mekanik secara dinamis dari relasi role
        $mechanics = User::whereHas('role', function($query) {
            $query->where('name', 'mechanic');
        })->get();

        // Mengambil transaksi yang sedang berjalan/selesai hari ini
        $todayTransactions = Transaction::with(['customer', 'vehicle', 'mechanic'])
            ->latest()
            ->get();

        return view('cashier.index', compact('pendingBookings', 'mechanics', 'todayTransactions'));
    }

    // 2. Assign / Penunjukan Mekanik ke Booking
    public function assignMechanic(Request $request, int $id)
    {
        $request->validate([
            'mechanic_id' => 'required|exists:users,id',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'mechanic_id' => $request->mechanic_id,
            'user_id'     => Auth::id(), // ID Kasir yang memproses
            'status'      => 'in_progress', // Status berubah jadi sedang dikerjakan
        ]);

        return redirect()->back()->with('success', 'Mekanik berhasil ditugaskan!');
    }

    // 3. Form Transaksi Walk-In (Pelanggan Langsung di Tempat)
    public function createWalkIn()
    {
        $mechanics = User::whereHas('role', function($query) {
            $query->where('name', 'mechanic');
        })->get();

        $customers = Customer::all();

        return view('cashier.walkin', compact('mechanics', 'customers'));
    }

    public function storeWalkIn(Request $request)
    {
        $request->validate([
            'customer_type' => 'required|in:new,existing',
            'name'          => 'required_if:customer_type,new|nullable|string|max:255',
            'phone'         => 'required_if:customer_type,new|nullable|string|max:20',
            'customer_id'   => 'required_if:customer_type,existing|nullable|exists:customers,id',
            'plate_number'  => 'required|string|max:15',
            'brand_model'   => 'required|string|max:255',
            'mechanic_id'   => 'required|exists:users,id',
        ]);

        $transaction = DB::transaction(function () use ($request) {
            // 1. Handling Pelanggan (Gunakan firstOrCreate agar tidak bentrok Unique Constraint)
            if ($request->customer_type === 'new') {
                $customer = Customer::firstOrCreate(
                    ['phone' => $request->phone], // Cari berdasarkan No. HP
                    [
                        'name'     => $request->name,
                        'email'    => strtolower(str_replace(' ', '', $request->name)) . rand(100, 999) . '@mail.com',
                        'password' => Hash::make('12345678'),
                    ]
                );
                $customerId = $customer->id;
            } else {
                $customerId = $request->customer_id;
            }

            // 2. Handling Kendaraan
            $vehicle = Vehicle::firstOrCreate(
                ['plate_number' => strtoupper(str_replace(' ', '', $request->plate_number))],
                [
                    'customer_id' => $customerId,
                    'brand_model' => $request->brand_model
                ]
            );

            // 3. Generate Nomor Invoice
            $today = date('Ymd');
            $countToday = Transaction::whereDate('created_at', now()->today())->count() + 1;
            $invoiceNumber = 'INV-' . $today . '-' . sprintf('%03d', $countToday);

            // 4. Simpan & Return Hasil Transaksi
            return Transaction::create([
                'invoice_number' => $invoiceNumber,
                'customer_id'    => $customerId,
                'user_id'        => Auth::id(),
                'mechanic_id'    => $request->mechanic_id,
                'vehicle_id'     => $vehicle->id,
                'total_price'    => 0,
                'type'           => 'walk-in',
                'status'         => 'in_progress',
                'booking_date'   => now(),
            ]);
        });

        return redirect()->route('cashier.payment', $transaction->id)
            ->with('success', 'Transaksi Walk-In berhasil dibuat!');
    }

    // 5. Halaman Form Detail & Pembayaran Transaksi
    public function showPaymentForm(int $id)
    {
        $transaction = Transaction::with(['customer', 'vehicle', 'mechanic', 'details.product'])->findOrFail($id);
        $products    = Product::where('stock', '>', 0)->get();

        return view('cashier.payment', compact('transaction', 'products'));
    }

    // 6. Tambah Item Barang / Jasa ke Nota & Potong Stok
    public function addDetail(Request $request, int $transactionId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Validasi: Cek kecukupan stok barang
        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', "Stok tidak cukup! Stok tersisa: {$product->stock}");
        }

        DB::transaction(function () use ($request, $transactionId, $product) {
            $hargaBersih = $product->price - $product->discount;
            $subtotal    = $hargaBersih * $request->quantity;

            TransactionDetail::create([
                'transaction_id' => $transactionId,
                'product_id'     => $product->id,
                'quantity'       => $request->quantity,
                'price'          => $hargaBersih,
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

    // 7. Finalisasi Transaksi (Selesai Pembayaran)
    public function completeTransaction(int $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'status' => 'completed',
        ]);

        return redirect()->route('cashier.index')->with('success', 'Transaksi Selesai & Pembayaran Berhasil!');
    }

    // 8. Hapus Item Detail (Rollback Stok & Total Harga)
    public function deleteDetail(int $id)
    {
        DB::transaction(function () use ($id) {
            $detail  = TransactionDetail::findOrFail($id);
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

    // 9. Cetak Struk
    public function printInvoice(int $id)
    {
        $transaction = Transaction::with(['customer', 'vehicle', 'mechanic', 'details.product'])->findOrFail($id);
        return view('cashier.print', compact('transaction'));
    }
}