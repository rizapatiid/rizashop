<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingMethodToOrders extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('orders', 'shipping_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('shipping_method')->nullable()->after('shipping_cost');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'shipping_method')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('shipping_method');
            });
        }
    }
}
