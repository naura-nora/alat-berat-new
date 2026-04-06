<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tambah ke detail_peminjaman
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            if (!Schema::hasColumn('detail_peminjaman', 'biaya_kerusakan')) {
                $table->decimal('biaya_kerusakan', 15, 2)->default(0)->after('jumlah_rusak');
            }
        });
        
        // Tambah ke pengembalian
        Schema::table('pengembalian', function (Blueprint $table) {
            if (!Schema::hasColumn('pengembalian', 'biaya_kerusakan')) {
                $table->decimal('biaya_kerusakan', 15, 2)->default(0)->after('status');
            }
        });
    }

    public function down()
    {
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            $table->dropColumn('biaya_kerusakan');
        });
        
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->dropColumn('biaya_kerusakan');
        });
    }
};