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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();

            // Relasi ke peminjaman
            $table->foreignId('peminjaman_id')
                ->constrained('peminjaman')
                ->cascadeOnDelete();

            // Relasi ke petugas (users)
            $table->foreignId('petugas_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Nomor telepon peminjam
            $table->string('no_telp');

            // Harga sewa per hari
            $table->integer('harga_perhari');

            // Jumlah hari pinjam
            $table->integer('jumlah_hari');

            // Denda manual
            $table->integer('denda')->default(0);

            // Total pembayaran
            $table->integer('total_bayar');

            // Metode pembayaran
            $table->enum('metode_pembayaran', ['kantor', 'transfer']);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
