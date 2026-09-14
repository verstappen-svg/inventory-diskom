<?php

namespace Database\Seeders;

use App\Models\SoftwarePic;
use Illuminate\Database\Seeder;

class SoftwarePicSeeder extends Seeder
{
    public function run(): void
    {
        $pics = [
            'Diskominfostandi_E-Govermment',
            'Diskomfostandi_Santik',
            'Diskominfostandi_Statistik',
            'Diskominfostandi_Sekretariat',
            'Diskominfostandi_IKP',
            'Lainnya',
        ];

        foreach ($pics as $pic) {
            SoftwarePic::updateOrCreate(
                ['nama' => $pic],
                ['status' => 'Aktif']
            );
        }
    }
}