<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota - {{ $transaction->invoice_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white p-8 max-w-md mx-auto font-mono text-sm" onload="window.print()">

    <div class="text-center mb-6">
        <h2 class="text-xl font-bold uppercase">Bengkel Motor Jaya</h2>
        <p class="text-xs text-gray-500">Jl. Raya Serang No. 123 | Telp: 08123456789</p>
        <div class="border-b-2 border-dashed border-gray-400 my-3"></div>
    </div>

    <div class="mb-4">
        <div>Invoice: <strong>{{ $transaction->invoice_number }}</strong></div>
        <div>Pelanggan: {{ $transaction->customer->name ?? 'Walk-in' }}</div>
        <div>Plat Motor: {{ $transaction->vehicle->plate_number ?? '-' }}</div>
        <div>Mekanik: {{ $transaction->mechanic->name ?? '-' }}</div>
    </div>

    <div class="border-b border-gray-300 my-2"></div>

    <!-- Tabel Item Ringkas -->
    <table class="w-full text-left mb-4">
        @foreach($transaction->details as $detail)
        <tr>
            <td colspan="2" class="font-bold">{{ $detail->product->name }}</td>
        </tr>
        <tr class="text-xs border-b border-gray-100">
            <td class="pb-2">{{ $detail->quantity }} x Rp {{ number_format($detail->product->price, 0, ',', '.') }}</td>
            <td class="text-right pb-2 font-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="border-t-2 border-dashed border-gray-400 pt-2 flex justify-between font-bold text-base">
        <span>TOTAL:</span>
        <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
    </div>

    <div class="text-center mt-8 text-xs text-gray-500">
        Terima kasih atas kunjungan Anda!<br>
        --- Garansi Servis 7 Hari ---
    </div>

</body>
</html>