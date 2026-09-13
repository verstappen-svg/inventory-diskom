<?php

namespace Database\Seeders;

use App\Models\SoftwareHosting;
use Illuminate\Database\Seeder;

class SoftwareHostingSeeder extends Seeder
{
    public function run(): void
    {
        $hostings = [
            'DC Pemerintahan Kota Bekasi',
            'BAPENDA',
            'Vendor',
            'Lainnya',
        ];

        foreach ($hostings as $hosting) {
            SoftwareHosting::updateOrCreate(
                ['nama' => $hosting],
                ['status' => 'Aktif']
            );
        }
    }
}