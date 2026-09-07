<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('software_assets', function (Blueprint $table) {
            $table->id();

            // Kode/ID software yang tampil di aplikasi
            $table->string('kode')->unique();

            // Nama software
            $table->string('jenis');

            // Contoh: Business Premium, Creative Cloud, Windows Server 2022
            $table->string('spesifikasi')->nullable();

            // Jumlah lisensi yang dimiliki
            $table->unsignedInteger('jumlah_lisensi')->default(1);

            // Jenis pengadaan + periode subscription
            $table->string('pengadaan');

            // Harga pengadaan
            $table->decimal('harga', 15, 2)->default(0);

            // Tanggal mulai/pengadaan
            $table->date('tanggal_pengadaan');

            // Kosong untuk Beli (Perpetual)
            $table->date('tanggal_berakhir')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('software_assets');
    }
};