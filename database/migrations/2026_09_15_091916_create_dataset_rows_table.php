<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dataset_rows', function (Blueprint $table) {

            $table->id();

            // Relasi ke dataset pada tabel data
            $table->foreignId('data_id')
                ->constrained('data')
                ->cascadeOnDelete();

            // Menyimpan satu baris data dari Sheet Dataset
            $table->json('row_data');

            $table->timestamps();

            $table->index('data_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dataset_rows');
    }
};