<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('software_assets', function (Blueprint $table) {
            $table->string('pengadaan')->nullable()->change();
            $table->string('periode_sewa')->nullable()->change();
            $table->decimal('harga', 15, 2)->nullable()->change();
            $table->date('tanggal_pengadaan')->nullable()->change();
            $table->date('tanggal_berakhir')->nullable()->change();
            $table->integer('jumlah_lisensi')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('software_assets', function (Blueprint $table) {
            $table->string('pengadaan')->nullable(false)->change();
            $table->string('periode_sewa')->nullable(false)->change();
            $table->decimal('harga', 15, 2)->nullable(false)->change();
            $table->date('tanggal_pengadaan')->nullable(false)->change();
            $table->date('tanggal_berakhir')->nullable(false)->change();
            $table->integer('jumlah_lisensi')->nullable(false)->change();
        });
    }
};