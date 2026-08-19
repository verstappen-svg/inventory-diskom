<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sdms', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('kode_dk')->nullable();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('kompetensi');
            $table->date('masa_berlaku');
            $table->string('dokumen')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sdms');
    }
};