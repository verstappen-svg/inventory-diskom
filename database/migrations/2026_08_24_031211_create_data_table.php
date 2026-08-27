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
        Schema::create('data', function (Blueprint $table) {

            $table->id();

            // Nama dataset
            $table->string('nama_dataset');

            // Jenis data
            $table->string('jenis_data');

            // Tahun data
            $table->year('tahun');

            // File yang diajukan operator
            $table->string('file_data')->nullable();

            // Status verifikasi
            $table->enum('verifikasi', [
                'Menunggu Disetujui',
                'Disetujui',
                'Ditolak'
            ])->default('Menunggu Disetujui');

            // Waktu operator mengajukan data
            $table->dateTime('tanggal_pengajuan')->nullable();

            // Komentar dari verifikator jika ditolak
            $table->text('komentar_verifikasi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};