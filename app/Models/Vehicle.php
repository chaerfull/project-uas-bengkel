<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'plate_number',
        'brand_model',
    ];

    // Relasi ke Pelanggan
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
