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
        Schema::create('verifikasi_hardware', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hardware_id')
                ->constrained('hardware')
                ->onDelete('cascade');

            $table->enum('status', [
                'Menunggu Persetujuan',
                'Disetujui',
                'Ditolak'
            ])->default('Menunggu Persetujuan');

            $table->text('catatan')->nullable();

            $table->unsignedBigInteger('verified_by')->nullable();

            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_hardware');
    }
};