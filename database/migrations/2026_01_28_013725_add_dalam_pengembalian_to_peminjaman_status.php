<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Update ENUM untuk kolom status di tabel peminjaman
        // Tambahkan 'dalam_pengembalian' dan 'dikembalikan' ke ENUM
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak', 'dipinjam', 'dalam_pengembalian', 'dikembalikan') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Kembalikan ke ENUM sebelumnya (tanpa 'dalam_pengembalian' dan 'dikembalikan')
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak', 'dipinjam') DEFAULT 'pending'");
    }
  
};
