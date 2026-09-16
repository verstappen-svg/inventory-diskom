<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('software_assets')) {
            return;
        }

        if (!Schema::hasColumn('software_assets', 'kategori_sistem_elektronik')) {
            Schema::table('software_assets', function (Blueprint $table) {
                $table->string('kategori_sistem_elektronik', 30)
                    ->nullable()
                    ->after('pic');
            });
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('software_assets') &&
            Schema::hasColumn('software_assets', 'kategori_sistem_elektronik')
        ) {
            Schema::table('software_assets', function (Blueprint $table) {
                $table->dropColumn('kategori_sistem_elektronik');
            });
        }
    }
};
