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
            // IDENTITAS DATA CENTER
            // =========================================================

            // ID Data Center yang dibuat oleh aplikasi
            // Contoh: INFDC-001, INFDC-002, dst.
            $table->string('id_data_center', 20)->primary();

            // =========================================================
            // 28 FIELD SESUAI DATA EXCEL
            // =========================================================

            // 1. Name
            $table->string('name')->nullable();

            // 2. Tahun
            $table->integer('tahun')->nullable();

            // 3. Status
            $table->string('status')->nullable();

            // 4. Tenant
            $table->string('tenant')->nullable();

            // 5. Site
            $table->string('site')->nullable();

            // 6. Rack
            $table->string('rack')->nullable();

            // 7. Role
            $table->string('role')->nullable();

            // 8. Manufacturer
            $table->string('manufacturer')->nullable();

            // 9. Type
            $table->string('type')->nullable();

            // 10. Platform
            $table->string('platform')->nullable();

            // 11. Serial number
            $table->string('serial_number')->nullable();

            // 12. IP Address
            $table->string('ip_address')->nullable();

            // 13. CPU
            $table->text('cpu')->nullable();

            // 14. HARDDISK
            $table->text('harddisk')->nullable();

            // 15. RAM
            $table->string('ram')->nullable();

            // 16. PIC
            $table->string('pic')->nullable();

            // 17. ID
            // ID asli dari Excel / Data Center
            // Contoh: 01, 02, 15
            $table->string('id', 50)->nullable();

            // 18. Tenant Group
            $table->string('tenant_group')->nullable();

            // 19. Region
            $table->string('region')->nullable();

            // 20. Location
            $table->string('location')->nullable();

            // 21. Position
            $table->string('position')->nullable();

            // 22. Rack face
            $table->string('rack_face')->nullable();

            // 23. IPv4 Address
            $table->string('ipv4_address')->nullable();

            // 24. Cluster
            $table->string('cluster')->nullable();

            // 25. Description
            $table->text('description')->nullable();

            // 26. Owner Group
            $table->string('owner_group')->nullable();

            // 27. Owner
            $table->string('owner')->nullable();

            // 28. U Height
            $table->string('u_height')->nullable();

            // =========================================================
            // VERIFIKASI APLIKASI
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