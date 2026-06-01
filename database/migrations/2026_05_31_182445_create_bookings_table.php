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
        // NAMANYA SEKARANG DIGANTI JADI ORDERS
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('gmail');
            $table->text('alamat');
            $table->integer('jumlah_tiket');
            $table->string('kelas');
            $table->string('from');
            $table->string('to');
            $table->string('flight');
            $table->bigInteger('total_harga');
            $table->string('status')->default('Pending');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};