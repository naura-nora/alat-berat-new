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
        Schema::dropIfExists('barang_hilang');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('barang_hilang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengembalian_id');
            $table->string('nama_alat');
            $table->decimal('harga_ganti_rugi',12,2);
            $table->timestamps();
        });
    }
};
