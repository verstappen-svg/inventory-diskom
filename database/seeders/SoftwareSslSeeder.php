<?php

namespace Database\Seeders;

use App\Models\SoftwareSsl;
use Illuminate\Database\Seeder;

class SoftwareSslSeeder extends Seeder
{
    public function run(): void
    {
        $ssls = [
            [
                'nama_ssl' => 'Tidak Menggunakan SSL',
                'tanggal_expire' => null,
                'status' => 'Aktif',
            ],
            [
                'nama_ssl' => 'SSL Bekasi Kota',
                'tanggal_expire' => '2026-11-26',
                'status' => 'Aktif',
            ],
            [
                'nama_ssl' => 'SSL Vendor',
                'tanggal_expire' => '2027-01-10',
                'status' => 'Aktif',
            ],
        ];

        foreach ($ssls as $ssl) {
            SoftwareSsl::updateOrCreate(
                ['nama_ssl' => $ssl['nama_ssl']],
                [
                    'tanggal_expire' => $ssl['tanggal_expire'],
                    'status' => $ssl['status'],
                ]
            );
        }
    }
}