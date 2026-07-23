<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Vehicle;     // 1. Import model Vehicle
use App\Models\Transaction; // 2. Import model Transaction
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ISI TABEL ROLES TERLEBIH DAHULU
        $adminRole    = Role::create(['name' => 'admin']);
        $kasirRole    = Role::create(['name' => 'kasir']);
        $mechanicRole = Role::create(['name' => 'mechanic']);

        // 2. Akun Admin
        User::create([
            'name'     => 'Admin Owner',
            'email'    => 'admin@bengkel.com',
            'password' => Hash::make('password'),
            'role_id'  => $adminRole->id,
        ]);

        // 3. Akun Kasir
        User::create([
            'name'     => 'Kasir Bengkel',
            'email'    => 'kasir@bengkel.com',
            'password' => Hash::make('password'),
            'role_id'  => $kasirRole->id,
        ]);

        // 4. Akun Mekanik
        User::create([
            'name'     => 'Mekanik Handal',
            'email'    => 'mekanik@bengkel.com',
            'password' => Hash::make('password'),
            'role_id'  => $mechanicRole->id,
        ]);

        // 5. Akun Customer Dummy (Simpan ke variabel $customer agar ID-nya dinamis)
        $customer = Customer::create([
            'name'     => 'Budi Pelanggan',
            'email'    => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'phone'    => '081234567890',
        ]);

        // 6. Sampel Produk & Jasa
        Product::create([
            'name'        => 'Oli Shell Helix 1L',
            'price'       => 85000,
            'stock'       => 20,
            'description' => 'Oli mesin berkualitas tinggi',
        ]);

        Product::create([
            'name'        => 'Jasa Servis Rutin',
            'price'       => 50000,
            'discount'    => 0,
            'stock'       => 999, 
            'description' => 'Servis dan pembersihan rutin',
        ]);

        // 7. Data Kendaraan (Dari Tinker kamu)
        $vehicle = Vehicle::create([
            'customer_id'  => $customer->id, // Menggunakan ID customer di atas secara otomatis
            'plate_number' => 'B 1234 ABC',
            'brand_model'  => 'Honda Vario 150',
        ]);

        // 8. Data Transaksi Booking (Dari Tinker kamu)
        Transaction::create([
            'invoice_number' => 'INV-' . date('Ymd') . '-001',
            'customer_id'    => $customer->id,
            'vehicle_id'     => $vehicle->id, // Menggunakan ID vehicle di atas secara otomatis
            'total_price'    => 0,
            'type'           => 'booking',
            'status'         => 'pending',
            'booking_date'   => date('Y-m-d'),
        ]);
    }
}