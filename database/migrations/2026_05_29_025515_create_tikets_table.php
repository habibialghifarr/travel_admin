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
    Schema::create('tikets', function (Blueprint $table) {
    $table->id();
    $table->string('nama_maskapai');
    $table->string('nomor_penerbangan');
    $table->string('bandara_asal');
    $table->string('bandara_tujuan');
    $table->dateTime('waktu_berangkat');
    $table->decimal('harga_tiket', 12, 2);
    $table->integer('sisa_stok');
    $table->timestamps();
});
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
