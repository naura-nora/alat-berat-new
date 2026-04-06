<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            $table->enum('kondisi_pengembalian', ['baik', 'rusak', 'sebagian_rusak'])->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            $table->enum('kondisi_pengembalian', ['baik', 'rusak'])->nullable()->change();
        });
    }
};
