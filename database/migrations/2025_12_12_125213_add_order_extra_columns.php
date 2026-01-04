<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // previous_status untuk menyimpan status sebelum perubahan (nullable)
            if (!Schema::hasColumn('orders', 'previous_status')) {
                $table->string('previous_status', 120)->nullable()->after('status');
            }

            // tracking number & courier (nullable)
            if (!Schema::hasColumn('orders', 'tracking_number')) {
                $table->string('tracking_number', 255)->nullable()->after('shipping_cost');
            }
            if (!Schema::hasColumn('orders', 'shipping_courier')) {
                $table->string('shipping_courier', 120)->nullable()->after('tracking_number');
            }

            // optional: ensure notes long enough
            if (Schema::hasColumn('orders', 'notes')) {
                // nothing
            } else {
                $table->text('notes')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'previous_status')) {
                $table->dropColumn('previous_status');
            }
            if (Schema::hasColumn('orders', 'tracking_number')) {
                $table->dropColumn('tracking_number');
            }
            if (Schema::hasColumn('orders', 'shipping_courier')) {
                $table->dropColumn('shipping_courier');
            }
        });
    }
};
