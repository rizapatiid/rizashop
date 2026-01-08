<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductShippingMethodsTable extends Migration
{
    public function up(): void
    {
        Schema::create('product_shipping_methods', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('shipping_method_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->unsignedInteger('price')->default(0);

            $table->timestamps();

            $table->unique(['product_id', 'shipping_method_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_shipping_methods');
    }
}
