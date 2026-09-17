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
        /*
        |--------------------------------------------------------------------------
        | Tabel jaringans sudah ada dari migration sebelumnya.
        |
        | Migration ini hanya menambahkan field yang dibutuhkan
        | oleh modul Infrastruktur — Jaringan.
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasTable('jaringans')) {
            return;
        }

        Schema::table('jaringans', function (Blueprint $table) {

            // Jenis jaringan:
            // Jalur Kabel FO / Local Loop Sewa
            if (!Schema::hasColumn('jaringans', 'jenis_data')) {
                $table->enum('jenis_data', [
                    'Jalur Kabel FO',
                    'Local Loop Sewa',
                ])->nullable()->after('id');
            }

            // Lokasi jaringan
            if (!Schema::hasColumn('jaringans', 'lokasi')) {
                $table->string('lokasi')->nullable()->after('jenis_data');
            }

            // Jarak kabel FO dalam meter
            if (!Schema::hasColumn('jaringans', 'jarak_kabel')) {
                $table->decimal('jarak_kabel', 10, 2)
                    ->nullable()
                    ->after('lokasi');
            }

            // Jumlah core kabel FO
            if (!Schema::hasColumn('jaringans', 'jumlah_core')) {
                $table->integer('jumlah_core')
                    ->nullable()
                    ->after('jarak_kabel');
            }

            // Jumlah titik untuk Local Loop Sewa
            if (!Schema::hasColumn('jaringans', 'jumlah_titik')) {
                $table->integer('jumlah_titik')
                    ->nullable()
                    ->after('jumlah_core');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('jaringans')) {
            return;
        }

        Schema::table('jaringans', function (Blueprint $table) {

            $columns = [];

            foreach ([
                'jenis_data',
                'lokasi',
                'jarak_kabel',
                'jumlah_core',
                'jumlah_titik',
            ] as $column) {

                if (Schema::hasColumn('jaringans', $column)) {
                    $columns[] = $column;
                }
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};