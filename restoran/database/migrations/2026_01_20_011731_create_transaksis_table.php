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
        Schema::create('transaksis', function (Blueprint $table) {
                $table->id();
                $table->string('nama_konsumen');
                $table->decimal('total_bayar', 12, 2);
                $table->dateTime('tanggal');
                $table->enum('status', ['pending', 'paid', 'cancel']);
                $table->foreignId('id_user')
                    ->constrained('modify_users')
                    ->cascadeOnDelete();
                $table->foreignId('id_meja')
                    ->nullable()
                    ->constrained('mejas')
                    ->nullOnDelete();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
