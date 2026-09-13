<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $lokasi = [
            'E-Government',
            'Sekretariat',
            'Statistik',
            'Persandian dan Statistik',
            'Informasi dan Komunikasi Publik',
        ];

        foreach ($lokasi as $nama) {
            DB::table('lokasi')->updateOrInsert(
                ['nama_lokasi' => $nama],
                [
                    'nama_lokasi' => $nama,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}