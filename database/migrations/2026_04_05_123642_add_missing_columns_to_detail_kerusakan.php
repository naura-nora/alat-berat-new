<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detail_kerusakan', function (Blueprint $table) {
            $table->unsignedBigInteger('detail_peminjaman_id')->nullable()->after('pengembalian_id');
            $table->integer('jumlah_rusak')->default(1)->after('deskripsi_kerusakan');
            $table->foreign('detail_peminjaman_id')->references('id')->on('detail_peminjaman')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('detail_kerusakan', function (Blueprint $table) {
            $table->dropForeign(['detail_peminjaman_id']);
            $table->dropColumn(['detail_peminjaman_id', 'jumlah_rusak']);
        }); 
    }
};
