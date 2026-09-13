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
        Schema::create('data_centers', function (Blueprint $table) {

            // =========================================================
            // IDENTITAS PERANGKAT
            // =========================================================

            // ID dibuat oleh controller, contoh: INFDC-001
            $table->string('id', 20)->primary();

            $table->string('name')->nullable();

            $table->string('status')->nullable();

            $table->string('tenant')->nullable();

            $table->string('site')->nullable();

            $table->string('rack')->nullable();

            $table->string('role')->nullable();

            // =========================================================
            // SPESIFIKASI PERANGKAT
            // =========================================================

            $table->string('manufacturer')->nullable();

            $table->string('type')->nullable();

            $table->string('platform')->nullable();

            $table->string('version')->nullable();

            $table->string('serial_number')->nullable();

            $table->string('ip_address')->nullable();

            $table->text('cpu')->nullable();

            $table->text('harddisk')->nullable();

            $table->string('ram')->nullable();

            $table->string('pic')->nullable();

            // =========================================================
            // INFORMASI ORGANISASI & LOKASI
            // =========================================================

            $table->string('tenant_group')->nullable();

            $table->string('region')->nullable();

            $table->string('location')->nullable();

            $table->string('position')->nullable();

            $table->string('rack_face')->nullable();

            $table->string('ipv4_address')->nullable();

            $table->string('cluster')->nullable();

            // =========================================================
            // KETERANGAN
            // =========================================================

            $table->text('description')->nullable();

            $table->text('comments')->nullable();

            // =========================================================
            // OWNER
            // =========================================================

            $table->string('owner_group')->nullable();

            $table->string('owner')->nullable();

            // =========================================================
            // RACK
            // =========================================================

            $table->string('u_height')->nullable();

            // =========================================================
            // VERIFIKASI
            // =========================================================

            $table->string('verifikasi', 50)
                ->default('menunggu');

            $table->text('komentar')->nullable();

            // =========================================================
            // TIMESTAMP
            // =========================================================

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_centers');
    }
};