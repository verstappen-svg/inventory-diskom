<?php

namespace Database\Seeders;

use App\Models\SoftwareCategory;
use Illuminate\Database\Seeder;

class SoftwareCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Website',
            'Open Source',
            'Utilities',
            'Lainnya',
        ];

        foreach ($categories as $category) {
            SoftwareCategory::updateOrCreate(
                ['nama' => $category],
                ['status' => 'Aktif']
            );
        }
    }
}