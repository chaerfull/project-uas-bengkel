<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin (Owner)
        User::create([
            'name' => 'Admin Owner',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Akun Staf (Kasir & Mekanik)
        User::create([
            'name' => 'Budi Kasir',
            'email' => 'kasir@bengkel.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        User::create([
            'name' => 'Agus Mekanik',
            'email' => 'mekanik@bengkel.com',
            'password' => Hash::make('password'),
            'role' => 'mechanic',
        ]);

        // 3. Customer Dummy
        Customer::create([
            'name' => 'Pelanggan Budi',
            'phone' => '08123456789',
        ]);

        // 4. Produk & Jasa Dummy
        Product::create([
            'name' => 'Oli Mesin Matic 1L',
            'price' => 55000,
            'stock' => 15,
            'description' => 'Oli sintetis mesin matic',
        ]);

        Product::create([
            'name' => 'Jasa Servis Ringan',
            'price' => 35000,
            'stock' => 999, // Untuk jasa stok diset banyak
            'description' => 'Servis dan pembersihan injeksi',
        ]);
    }
}
