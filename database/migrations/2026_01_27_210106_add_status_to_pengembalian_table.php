<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            // Tambah kolom status dengan enum yang sesuai
            $table->enum('status', ['menunggu', 'dicek', 'selesai', 'dibatalkan'])
                  ->default('menunggu')
                  ->after('petugas_id');
        });
    }

    public function down()
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
