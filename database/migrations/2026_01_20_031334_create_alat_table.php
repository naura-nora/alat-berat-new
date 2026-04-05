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
        Schema::create('alat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('restrict');
            $table->string('kode_alat', 20)->unique();
            $table->string('nama', 200);
            $table->string('merk', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(1);
            $table->string('gambar')->nullable();
            $table->enum('status', ['tersedia', 'rusak', 'dipinjam', 'maintenance'])->default('tersedia');
            $table->decimal('harga_sewa', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
