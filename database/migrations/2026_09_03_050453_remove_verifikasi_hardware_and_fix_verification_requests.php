<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Hapus tabel verifikasi_hardware lama
        |--------------------------------------------------------------------------
        |
        | Hardware sekarang menggunakan verification_requests.
        |
        */
        Schema::dropIfExists('verifikasi_hardware');

        /*
        |--------------------------------------------------------------------------
        | Ubah record_id menjadi STRING
        |--------------------------------------------------------------------------
        |
        | Karena beberapa module menggunakan ID angka dan beberapa menggunakan
        | ID string, record_id harus bisa menampung keduanya.
        |
        */
        if (Schema::hasTable('verification_requests')) {
            Schema::table('verification_requests', function (Blueprint $table) {
                $table->string('record_id', 255)->change();
            });
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Kembalikan record_id ke BIGINT
        |--------------------------------------------------------------------------
        |
        | Catatan:
        | rollback ini hanya aman jika semua record_id yang tersimpan
        | memang berupa angka.
        |
        */
        if (Schema::hasTable('verification_requests')) {
            Schema::table('verification_requests', function (Blueprint $table) {
                $table->unsignedBigInteger('record_id')->change();
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Tabel verifikasi_hardware tidak dibuat kembali.
        |--------------------------------------------------------------------------
        |
        | Sistem sudah dipindahkan ke VerificationRequest sebagai sistem
        | verifikasi tunggal.
        |
        */
    }
};