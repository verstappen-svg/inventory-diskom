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
        Schema::create('hardware', function (Blueprint $table) {
            $table->id();

            $table->string('asset_id')->unique();
            $table->string('nama_barang');
            $table->text('spesifikasi');
            $table->string('jenis_barang');
            $table->year('tahun_pembelian');
            $table->decimal('harga', 15, 2);
            $table->enum('kondisi', [
                'Baik',
                'Perlu Perbaikan',
                'Rusak'
            ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware');
    }
};