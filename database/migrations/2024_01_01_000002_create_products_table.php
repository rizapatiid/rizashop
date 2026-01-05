<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Nama produk
            $table->string('slug')->unique();          // slug untuk URL
            $table->string('sku')->nullable();         // kode produk
            $table->text('description')->nullable();   // deskripsi
            $table->decimal('price', 15, 2);           // harga
            $table->integer('stock')->default(0);      // stok
            $table->boolean('is_active')->default(true); // status aktif/tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
