<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // gunakan nullable agar tidak merusak data existing
            if (! Schema::hasColumn('users', 'address_full')) {
                $table->text('address_full')->nullable()->after('email'); // alamat lengkap (free text)
            }
            if (! Schema::hasColumn('users', 'village')) {
                $table->string('village')->nullable()->after('address_full'); // desa/kelurahan
            }
            if (! Schema::hasColumn('users', 'subdistrict')) {
                $table->string('subdistrict')->nullable()->after('village'); // kecamatan
            }
            if (! Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('subdistrict'); // kabupaten/kota
            }
            if (! Schema::hasColumn('users', 'province')) {
                $table->string('province')->nullable()->after('city'); // provinsi
            }
            if (! Schema::hasColumn('users', 'country')) {
                $table->string('country')->nullable()->after('province'); // negara
            }
            if (! Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('country'); // kode pos
            }

            // phone fields (opsional jika belum ada)
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
            if (Schema::hasColumn('users', 'address_full')) {
                $table->dropColumn('address_full');
            }
            if (Schema::hasColumn('users', 'village')) {
                $table->dropColumn('village');
            }
            if (Schema::hasColumn('users', 'subdistrict')) {
                $table->dropColumn('subdistrict');
            }
            if (Schema::hasColumn('users', 'province')) {
                $table->dropColumn('province');
            }
            if (Schema::hasColumn('users', 'country')) {
                $table->dropColumn('country');
            }
            if (Schema::hasColumn('users', 'postal_code')) {
                $table->dropColumn('postal_code');
            }
            // note: phone & phone_country left as-is (don't drop automatically)
        });
    }
};
