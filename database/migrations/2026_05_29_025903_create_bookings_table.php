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
    Schema::create('bookings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tiket_id')->constrained()->onDelete('cascade');
    $table->string('nama_pembeli');
    $table->string('nomor_hp');
    $table->integer('jumlah_kursi');
    $table->decimal('total_bayar', 12, 2);
    $table->enum('status_pesanan', ['dibayar', 'dibooking']); 
    $table->timestamps();
});
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
