<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('software_assets', function (Blueprint $table) {
            $table->string('periode_sewa')->nullable()->after('pengadaan');
        });
    }

    public function down(): void
    {
        Schema::table('software_assets', function (Blueprint $table) {
            $table->dropColumn('periode_sewa');
        });
    }
};