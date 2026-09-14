<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('software_assets', function (Blueprint $table) {

            if (!Schema::hasColumn('software_assets', 'nama_aset')) {
                $table->string('nama_aset')->nullable()->after('kode');
            }

            if (!Schema::hasColumn('software_assets', 'kategori')) {
                $table->string('kategori', 50)->nullable()->after('nama_aset');
            }

            if (!Schema::hasColumn('software_assets', 'ssl')) {
                $table->string('ssl', 100)->nullable()->after('kategori');
            }

            if (!Schema::hasColumn('software_assets', 'url_homepage')) {
                $table->string('url_homepage', 500)->nullable()->after('ssl');
            }

            if (!Schema::hasColumn('software_assets', 'ip_public')) {
                $table->string('ip_public', 45)->nullable()->after('url_homepage');
            }

            if (!Schema::hasColumn('software_assets', 'ip_private')) {
                $table->string('ip_private', 45)->nullable()->after('ip_public');
            }

            if (!Schema::hasColumn('software_assets', 'hosting')) {
                $table->string('hosting', 100)->nullable()->after('ip_private');
            }

            if (!Schema::hasColumn('software_assets', 'status')) {
                $table->string('status', 30)->nullable()->after('hosting');
            }

            if (!Schema::hasColumn('software_assets', 'pic')) {
                $table->string('pic', 150)->nullable()->after('status');
            }

            if (!Schema::hasColumn('software_assets', 'kerahasiaan')) {
                $table->unsignedTinyInteger('kerahasiaan')->nullable()->after('pic');
            }

            if (!Schema::hasColumn('software_assets', 'integritas')) {
                $table->unsignedTinyInteger('integritas')->nullable()->after('kerahasiaan');
            }

            if (!Schema::hasColumn('software_assets', 'ketersediaan')) {
                $table->unsignedTinyInteger('ketersediaan')->nullable()->after('integritas');
            }

            if (!Schema::hasColumn('software_assets', 'nilai')) {
                $table->decimal('nilai', 5, 2)->nullable()->after('ketersediaan');
            }

            if (!Schema::hasColumn('software_assets', 'keterangan')) {
                $table->string('keterangan', 30)->nullable()->after('nilai');
            }

            if (!Schema::hasColumn('software_assets', 'deskripsi_aplikasi')) {
                $table->text('deskripsi_aplikasi')->nullable()->after('keterangan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('software_assets', function (Blueprint $table) {

            $columns = [
                'nama_aset',
                'kategori',
                'ssl',
                'url_homepage',
                'ip_public',
                'ip_private',
                'hosting',
                'status',
                'pic',
                'kerahasiaan',
                'integritas',
                'ketersediaan',
                'nilai',
                'keterangan',
                'deskripsi_aplikasi',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('software_assets', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};