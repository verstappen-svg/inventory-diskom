<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('software_pics', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 150)->unique();

            $table->enum('status', ['Aktif', 'Tidak Aktif'])
                ->default('Aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('software_pics');
    }
};