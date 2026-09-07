<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['dashboard', 'Dashboard', null, 0],
            ['hardware', 'Hardware', null, 1],
            ['software', 'Software', null, 2],
            ['infrastruktur.jaringan', 'Jaringan', 'sub', 3],
            ['infrastruktur.data-center', 'Data Center', 'sub', 4],
            ['infrastruktur.splp', 'SPLP', 'sub', 5],
            ['data', 'Data', null, 6],
            ['sdm', 'SDM', null, 7],
            ['pengajuan', 'Pengajuan', null, 8],
            ['verifikasi', 'Verifikasi', null, 9],
            ['laporan', 'Laporan', null, 10],
        ];

        $roles = ['super_admin', 'operator', 'verifikator', 'pimpinan'];

        foreach ($roles as $role) {
            foreach ($menus as [$key, $label, $type, $sort]) {

                $isSuperAdmin  = $role === 'super_admin';
                $isOperator    = $role === 'operator';
                $isPimpinan    = $role === 'pimpinan';

                $canView = true;
                $canAdd  = $isSuperAdmin || $isOperator;
                $canDelete = $isSuperAdmin || $isOperator;
                $extraLabel = null;
                $extraChecked = false;

                if ($key === 'pengajuan') {
                    $extraLabel = 'Diajukan';
                    $extraChecked = $isOperator || $isSuperAdmin;
                }

                if ($key === 'laporan') {
                    $extraLabel = 'Cetak';
                    $extraChecked = $isSuperAdmin || $isPimpinan;
                }

                if ($key === 'verifikasi') {
                    $canAdd = false;
                    $canDelete = false;
                }

                if ($isPimpinan) {
                    $canAdd = false;
                    $canDelete = false;
                }

                RolePermission::updateOrCreate(
                    ['role' => $role, 'menu_key' => $key],
                    [
                        'menu_label' => $label,
                        'can_view' => $canView,
                        'can_add' => $canAdd,
                        'can_delete' => $canDelete,
                        'extra_action_label' => $extraLabel,
                        'extra_action_checked' => $extraChecked,
                        'sort' => $sort,
                    ]
                );
            }
        }
    }
}