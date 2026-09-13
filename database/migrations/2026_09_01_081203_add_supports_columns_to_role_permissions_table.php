<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->boolean('supports_add')->default(true)->after('can_delete');
            $table->boolean('supports_delete')->default(true)->after('supports_add');
        });
    }

    public function down(): void
    {
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->dropColumn(['supports_add', 'supports_delete']);
        });
    }
};