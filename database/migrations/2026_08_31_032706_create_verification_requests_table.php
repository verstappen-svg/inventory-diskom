<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_requests', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | DATA PENGAJUAN
            |--------------------------------------------------------------------------
            */

            // Contoh: software, hardware, jaringan, data, sdm
            $table->string('module');

            // ID data asli yang akan diubah.
            // Untuk ADD bisa NULL karena datanya belum dibuat.
            $table->unsignedBigInteger('record_id')->nullable();

            // add / update / delete
            $table->string('action');

            /*
            |--------------------------------------------------------------------------
            | DATA PERUBAHAN
            |--------------------------------------------------------------------------
            |
            | Menyimpan data yang diajukan operator.
            | Contoh:
            | {
            |     "nama_software": "Microsoft 365",
            |     "jenis": "Business Premium",
            |     ...
            | }
            |
            */
            $table->json('data')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS VERIFIKASI
            |--------------------------------------------------------------------------
            |
            | menunggu  = belum diperiksa
            | disetujui = sudah disetujui
            | ditolak   = ditolak verifikator
            |
            */
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak'
            ])->default('menunggu');

            /*
            |--------------------------------------------------------------------------
            | PENGAJU
            |--------------------------------------------------------------------------
            */

            $table->foreignId('submitted_by')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | VERIFIKATOR
            |--------------------------------------------------------------------------
            */

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('verified_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | CATATAN PENOLAKAN
            |--------------------------------------------------------------------------
            */

            $table->text('rejection_reason')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index(['module', 'record_id']);
            $table->index('status');
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_requests');
    }
};