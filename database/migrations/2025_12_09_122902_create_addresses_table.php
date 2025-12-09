<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // label / nama alamat (Alamat Utama, Rumah, Kantor, dst)
            $table->string('label')->nullable();

            // alamat terperinci
            $table->text('address_full')->nullable();
            $table->string('village')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable()->default('Indonesia');
            $table->string('postal_code')->nullable();

            // nomor telpon kontak untuk alamat ini
            $table->string('phone_country')->nullable();
            $table->string('phone')->nullable();

            // apakah ini alamat utama
            $table->boolean('is_primary')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
