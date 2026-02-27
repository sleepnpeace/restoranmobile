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
        Schema::create('menus', function (Blueprint $table) {
           $table->id();
            $table->string('nama');
            $table->decimal('harga', 10, 2);
            $table->foreignId('id_kategori')
                ->constrained('kategoris')
                ->cascadeOnDelete();
            $table->boolean('status')->default(true);
            $table->integer('stok');
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
