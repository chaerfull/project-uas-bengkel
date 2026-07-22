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

        $table->foreignId('customer_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('vehicle_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('mechanic_id')
              ->constrained('users')
              ->cascadeOnDelete();

        $table->decimal('total_price', 12, 2);

        $table->enum('status', [
            'pending',
            'process',
            'finished',
            'cancelled'
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
