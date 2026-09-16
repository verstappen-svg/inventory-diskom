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
        | TABEL SUDAH ADA
        |--------------------------------------------------------------------------
        |
        | Tabel data_centers sudah dibuat oleh migration/versi sebelumnya.
        | Migration ini hanya menambahkan field dari struktur Data Center
        | terbaru dari branch Infrastruktur.
        |
        */

        if (!Schema::hasTable('data_centers')) {
            return;
        }

        Schema::table('data_centers', function (Blueprint $table) {

            // =========================================================
            // IDENTITAS PERANGKAT
            // =========================================================

            if (!Schema::hasColumn('data_centers', 'name')) {
                $table->string('name')->nullable()->after('id');
            }

            if (!Schema::hasColumn('data_centers', 'tenant')) {
                $table->string('tenant')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'site')) {
                $table->string('site')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'rack')) {
                $table->string('rack')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'role')) {
                $table->string('role')->nullable();
            }


            // =========================================================
            // SPESIFIKASI PERANGKAT
            // =========================================================

            if (!Schema::hasColumn('data_centers', 'manufacturer')) {
                $table->string('manufacturer')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'type')) {
                $table->string('type')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'platform')) {
                $table->string('platform')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'version')) {
                $table->string('version')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'serial_number')) {
                $table->string('serial_number')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'ip_address')) {
                $table->string('ip_address')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'cpu')) {
                $table->text('cpu')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'harddisk')) {
                $table->text('harddisk')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'ram')) {
                $table->string('ram')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'pic')) {
                $table->string('pic')->nullable();
            }


            // =========================================================
            // INFORMASI ORGANISASI & LOKASI
            // =========================================================

            if (!Schema::hasColumn('data_centers', 'tenant_group')) {
                $table->string('tenant_group')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'region')) {
                $table->string('region')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'location')) {
                $table->string('location')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'position')) {
                $table->string('position')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'rack_face')) {
                $table->string('rack_face')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'ipv4_address')) {
                $table->string('ipv4_address')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'cluster')) {
                $table->string('cluster')->nullable();
            }


            // =========================================================
            // KETERANGAN
            // =========================================================

            if (!Schema::hasColumn('data_centers', 'description')) {
                $table->text('description')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'comments')) {
                $table->text('comments')->nullable();
            }


            // =========================================================
            // OWNER
            // =========================================================

            if (!Schema::hasColumn('data_centers', 'owner_group')) {
                $table->string('owner_group')->nullable();
            }

            if (!Schema::hasColumn('data_centers', 'owner')) {
                $table->string('owner')->nullable();
            }


            // =========================================================
            // RACK
            // =========================================================

            if (!Schema::hasColumn('data_centers', 'u_height')) {
                $table->string('u_height')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('data_centers')) {
            return;
        }

        $columns = [
            'name',
            'tenant',
            'site',
            'rack',
            'role',
            'manufacturer',
            'type',
            'platform',
            'version',
            'serial_number',
            'ip_address',
            'cpu',
            'harddisk',
            'ram',
            'pic',
            'tenant_group',
            'region',
            'location',
            'position',
            'rack_face',
            'ipv4_address',
            'cluster',
            'description',
            'comments',
            'owner_group',
            'owner',
            'u_height',
        ];

        $existingColumns = [];

        foreach ($columns as $column) {
            if (Schema::hasColumn('data_centers', $column)) {
                $existingColumns[] = $column;
            }
        }

        if (!empty($existingColumns)) {
            Schema::table('data_centers', function (Blueprint $table) use ($existingColumns) {
                $table->dropColumn($existingColumns);
            });
        }
    }
};