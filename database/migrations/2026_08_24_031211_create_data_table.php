<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data', function (Blueprint $table) {

            $table->id();

            // Nama dataset
            $table->string('nama_dataset');

            // Topik dataset
            $table->string('topik');

            // Tahun data
            $table->year('tahun');

            // Deskripsi dataset
            $table->text('deskripsi')->nullable();

            // Metadata dari Sheet Metadata Excel
            $table->json('metadata')->nullable();

            // File Excel dataset
            $table->string('file_data')->nullable();

            // Status verifikasi
            $table->enum('verifikasi', [
                'Menunggu Disetujui',
                'Disetujui',
                'Ditolak'
            ])->default('Menunggu Disetujui');

            // Waktu pengajuan
            $table->dateTime('tanggal_pengajuan')->nullable();

            // Komentar verifikator
            $table->text('komentar_verifikasi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};