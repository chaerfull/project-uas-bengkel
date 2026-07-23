<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ISI TABEL ROLES TERLEBIH DAHULU (Wajib agar ID-nya tercipta)
        $adminRole   = Role::create(['name' => 'admin']);    // ID otomatis: 1
        $kasirRole   = Role::create(['name' => 'kasir']);    // ID otomatis: 2
        $mechanicRole = Role::create(['name' => 'mechanic']); // ID otomatis: 3

        // 2. Akun Admin (role diganti menjadi role_id)
        User::create([
            'name' => 'Admin Owner',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id, // Mengambil ID nomor 1 secara otomatis
        ]);

        // 3. Akun Kasir
        User::create([
            'name' => 'Kasir Bengkel',
            'email' => 'kasir@bengkel.com',
            'password' => Hash::make('password'),
            'role_id' => $kasirRole->id, // Mengambil ID nomor 2 secara otomatis
        ]);

        // 4. Akun Mekanik
        User::create([
            'name' => 'Mekanik Handal',
            'email' => 'mekanik@bengkel.com',
            'password' => Hash::make('password'),
            'role_id' => $mechanicRole->id, // Mengambil ID nomor 3 secara otomatis
        ]);

        // 5. Akun Customer Dummy (Tetap aman)
        Customer::create([
            'name' => 'Budi Pelanggan',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
        ]);

        // 6. Sampel Produk & Jasa (Ditambahkan nominal discount default 0 agar tidak kosong)
        Product::create([
            'name' => 'Oli Shell Helix 1L',
            'price' => 85000,
            'discount' => 5000, // Contoh produk yang diberi diskon oleh admin
            'stock' => 20,
            'description' => 'Oli mesin berkualitas tinggi',
        ]);

        Product::create([
            'name' => 'Jasa Servis Rutin',
            'price' => 50000,
            'discount' => 0,
            'stock' => 999, 
            'description' => 'Servis dan pembersihan rutin',
        ]);
    }
}
