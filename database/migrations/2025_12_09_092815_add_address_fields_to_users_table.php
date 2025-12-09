<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'address_name')) {
                $table->string('address_name')->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('address_name');
            }
            if (! Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('address');
            }
            if (! Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('city');
            }
            // opsional: pastikan phone & phone_country ada (jika tidak, tambahkan)
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('postal_code');
            }
            if (! Schema::hasColumn('users', 'phone_country')) {
                $table->string('phone_country')->nullable()->after('phone');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'address_name')) {
                $table->dropColumn('address_name');
            }
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('users', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('users', 'postal_code')) {
                $table->dropColumn('postal_code');
            }
            // jangan otomatis drop phone/phone_country jika aplikasi lain pakai
        });
    }
};
