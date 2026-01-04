<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // hubungkan ke users
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // alamat (kamu sudah punya tabel addresses)
            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete();

            $table->string('order_number')->unique();
            $table->decimal('subtotal', 16, 2)->default(0);
            $table->decimal('shipping_cost', 16, 2)->default(0);
            $table->decimal('total', 16, 2)->default(0);
            $table->string('currency', 10)->default('IDR');

            // status dasar: pending, preparing, shipped, completed, cancelled
            $table->string('status')->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
