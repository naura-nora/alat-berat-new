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
        DB::statement("
            ALTER TABLE peminjaman 
            MODIFY status ENUM(
                'pending',
                'disetujui',
                'ditolak',
                'dipinjam',
                'dalam_pengembalian',
                'menunggu_transaksi',
                'selesai'
            ) DEFAULT 'pending'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE peminjaman 
            MODIFY status ENUM(
                'pending',
                'disetujui',
                'ditolak',
                'dipinjam'
            ) DEFAULT 'pending'
        ");
    }
};
