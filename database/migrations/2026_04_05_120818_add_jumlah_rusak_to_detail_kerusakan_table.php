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
        Schema::table('detail_kerusakan', function (Blueprint $table) {
            $table->integer('jumlah_rusak')->default(1)->after('deskripsi_kerusakan');
            $table->foreignId('detail_peminjaman_id')->nullable()->after('pengembalian_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_kerusakan', function (Blueprint $table) {
            //
        });
    }
};
