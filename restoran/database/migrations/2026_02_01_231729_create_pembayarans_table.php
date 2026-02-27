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
       Schema::create('pembayaran', function (Blueprint $table) {
        $table->id();

        $table->foreignId('id_transaksi')
            ->constrained('transaksis')
            ->cascadeOnDelete();

        $table->enum('metode_pembayaran', ['cash', 'qris']);
        $table->integer('jumlah_bayar');
        $table->enum('status', ['pending', 'success']);
        $table->dateTime('waktu_bayar');
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
