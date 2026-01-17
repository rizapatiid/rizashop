<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('product_name')->nullable();
            $table->string('product_sku')->nullable();
            $table->decimal('price', 16, 2)->default(0);
            $table->integer('qty')->default(1);
            $table->decimal('subtotal', 16, 2)->default(0);

            
            // ❌ json TIDAK didukung MySQL lama
            // $table->json('meta')->nullable();

            // ✅ Aman untuk FreeSQLDatabase
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
