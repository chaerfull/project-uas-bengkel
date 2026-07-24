<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_number')->unique();

        $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
        $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();

        $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
        $table->foreignId('mechanic_id')->nullable()->constrained('users')->nullOnDelete();

        $table->decimal('total_price', 12, 2)->default(0);

        $table->enum('type', ['booking', 'walk-in'])->default('booking');
        $table->date('booking_date')->nullable();

        $table->enum('status', [
            'pending',      // Menunggu antrean
            'in_progress',  // Sedang diperbaiki mekanik
            'completed',    // Selesai & sudah bayar
            'cancelled'     // Dibatalkan
        ])->default('pending');

        $table->timestamps();
    });

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
