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
        Schema::create('data_center_masters', function (Blueprint $table) {
            $table->id();

            $table->enum('jenis', [
                'tenant',
                'site',
                'rack',
                'region',
                'location',
                'role',
                'manufacturer',
                'pic',
            ]);

            $table->string('nama');

            $table->enum('status', [
                'Active',
                'Inactive',
            ])->default('Active');

            $table->timestamps();

            $table->index('jenis');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_center_masters');
    }
};