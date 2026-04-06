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
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            $table->integer('jumlah_baik')->default(0)->after('jumlah');
            $table->integer('jumlah_rusak')->default(0)->after('jumlah_baik');
            $table->enum('kondisi_pengembalian', ['baik', 'sebagian_rusak', 'rusak_total'])->nullable()->after('catatan_pengembalian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            //
        });
    }
};
