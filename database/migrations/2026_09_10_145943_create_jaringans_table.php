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
        Schema::create('jaringans', function (Blueprint $table) {

            // =====================================================
            // ID
            // =====================================================
            //
            // ID dibuat otomatis di Controller berdasarkan
            // jenis data:
            //
            // Jalur Kabel FO:
            // FO-001
            // FO-002
            // FO-003
            //
            // Local Loop Sewa:
            // LL-001
            // LL-002
            // LL-003
            //
            // Migration hanya menyediakan kolom ID.
            // Pembuatan nomor ID dilakukan di Controller.
            //
            $table->string('id', 10)->primary();


            // =====================================================
            // JENIS DATA
            // =====================================================
            //
            // Pilihan:
            // - Jalur Kabel FO
            // - Local Loop Sewa
            //
            $table->enum('jenis_data', [
                'Jalur Kabel FO',
                'Local Loop Sewa'
            ]);


            // =====================================================
            // LOKASI
            // =====================================================
            //
            // Untuk Jalur Kabel FO:
            // Contoh:
            // Kantor Walikota - MPP
            // Kantor Walikota - Perkantoran Juanda
            //
            // Untuk Local Loop Sewa:
            // Contoh:
            // Kecamatan
            // Kelurahan
            // Puskesmas
            // SDN
            // SMPN
            //
            $table->string('lokasi');


            // =====================================================
            // DATA JALUR KABEL FO
            // =====================================================

            // Jarak kabel dalam METER.
            //
            // Contoh:
            // 400   = 400 meter
            // 1500  = 1.500 meter
            // 2000  = 2.000 meter
            // 4000  = 4.000 meter
            //
            // Yang disimpan di database hanya angka.
            // Satuan "m" ditampilkan di Blade.
            //
            // Tidak digunakan untuk Local Loop Sewa.
            //
            $table->decimal('jarak_kabel', 10, 2)->nullable();


            // Jumlah core kabel FO.
            //
            // Contoh:
            // 12 = 12 core
            //
            // Tidak digunakan untuk Local Loop Sewa.
            //
            $table->integer('jumlah_core')->nullable();


            // =====================================================
            // DATA LOCAL LOOP SEWA
            // =====================================================

            // Jumlah titik lokasi.
            //
            // Contoh:
            // Kecamatan = 12
            // Kelurahan = 54
            // Puskesmas = 54
            // SDN       = 315
            // SMPN      = 60
            //
            // Tidak digunakan untuk Jalur Kabel FO.
            //
            $table->integer('jumlah_titik')->nullable();


            // =====================================================
            // VERIFIKASI
            // =====================================================

            // Status verifikasi data.
            //
            // menunggu   = data belum diverifikasi
            // disetujui  = data sudah disetujui
            // ditolak    = data ditolak
            //
            $table->enum('verifikasi', [
                'menunggu',
                'disetujui',
                'ditolak'
            ])->default('menunggu');


            // =====================================================
            // KOMENTAR
            // =====================================================

            // Komentar/catatan dari verifikator.
            //
            $table->text('komentar')->nullable();


            // =====================================================
            // TIMESTAMP
            // =====================================================
            //
            // created_at = waktu data pertama kali dibuat
            // updated_at = waktu data terakhir diubah
            //
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jaringans');
    }
};