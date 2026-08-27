<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_centers', function (Blueprint $table) {

            // ID
            $table->string('id', 10)->primary();


            // =====================================================
            // DATA INFRASTRUKTUR
            // =====================================================

            // Nama perangkat/infrastruktur data center
            $table->string('nama_infrastruktur');

            // Spesifikasi perangkat
            $table->text('spesifikasi')->nullable();


            // =====================================================
            // PENGADAAN
            // =====================================================

            // Jenis pengadaan: Beli / Sewa
            $table->string('pengadaan');

            // Harga pengadaan
            $table->decimal('harga', 20, 2)->default(0);


            // =====================================================
            // TANGGAL
            // =====================================================

            // Tanggal mulai/pengadaan
            $table->date('tanggal_pengadaan');

            // Kosong untuk Beli
            // Otomatis dihitung untuk Sewa
            $table->date('tanggal_berakhir')->nullable();


            // =====================================================
            // STATUS ASET
            // =====================================================

            $table->enum('status', [
                'Tersedia',
                'Digunakan',
                'Akan Habis',
                'Expired'
            ])->default('Tersedia');


            // =====================================================
            // VERIFIKASI
            // =====================================================

            // Status persetujuan dari verifikator
            $table->enum('verifikasi', [
                'Menunggu disetujui',
                'Disetujui',
                'Ditolak'
            ])->default('Menunggu disetujui');

            // Komentar dari verifikator
            $table->text('komentar')->nullable();

            // =====================================================
            // TIMESTAMP
            // =====================================================

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_centers');
    }
};