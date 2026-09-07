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
        Schema::create('data_pengajuans', function (Blueprint $table) {

            $table->id();

            // Data asli yang diajukan untuk diubah/dihapus
            $table->foreignId('data_id')
                ->nullable()
                ->constrained('data')
                ->nullOnDelete();

            // Operator yang mengajukan
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Jenis aksi
            $table->enum('aksi', [
                'tambah',
                'edit',
                'hapus'
            ]);

            // Data sebelum perubahan
            $table->json('data_lama')->nullable();

            // Data setelah perubahan / data baru
            $table->json('data_baru')->nullable();

            // Status pengajuan
            $table->enum('status', [
                'Menunggu Disetujui',
                'Disetujui',
                'Ditolak'
            ])->default('Menunggu Disetujui');

            // Komentar verifikator
            $table->text('komentar')->nullable();

            // Waktu pengajuan
            $table->dateTime('tanggal_pengajuan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pengajuans');
    }
};