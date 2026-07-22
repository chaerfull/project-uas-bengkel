<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'user_id',       // ID Admin/Mekanik dari tabel users
        'mechanic_id',
        'vehicle_id',
        'total_price',
        'type',
        'status',
        'booking_date',
    ];

    // Relasi ke Detail Transaksi
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
