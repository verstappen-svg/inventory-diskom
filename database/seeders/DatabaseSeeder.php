<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // key, label, supports_add, supports_delete, extra_label, sort
        $menus = [
            ['dashboard', 'Dashboard', false, false, null, 0],
            ['hardware', 'Hardware', true, true, null, 1],
            ['software', 'Software', true, true, null, 2],
            ['infrastruktur.jaringan', 'Jaringan', true, true, null, 3],
            ['infrastruktur.data-center', 'Data Center', true, true, null, 4],
            ['infrastruktur.splp', 'SPLP', true, true, null, 5],
            ['data', 'Data', true, true, null, 6],
            ['sdm', 'SDM', true, true, null, 7],
            ['pengajuan', 'Pengajuan', true, true, 'Diajukan', 8],
            ['verifikasi', 'Verifikasi', false, false, null, 9],
            ['laporan', 'Laporan', false, false, 'Cetak', 10],
        ];

        $roles = ['super_admin', 'operator', 'verifikator', 'pimpinan'];

        foreach ($roles as $role) {
            foreach ($menus as [$key, $label, $supportsAdd, $supportsDelete, $extraLabel, $sort]) {

                $isSuperAdmin = $role === 'super_admin';
                $isOperator   = $role === 'operator';
                $isPimpinan   = $role === 'pimpinan';

                $canView = true;
                $canAdd  = $supportsAdd && ($isSuperAdmin || $isOperator);
                $canDelete = $supportsDelete && ($isSuperAdmin || $isOperator);
                $extraChecked = false;

                if ($key === 'pengajuan') {
                    $extraChecked = $isOperator || $isSuperAdmin;
                }

                if ($key === 'laporan') {
                    $extraChecked = $isSuperAdmin || $isPimpinan;
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
                        'supports_add' => $supportsAdd,
                        'supports_delete' => $supportsDelete,
                        'extra_action_label' => $extraLabel,
                        'extra_action_checked' => $extraChecked,
                        'sort' => $sort,
                    ]
                );
            }
        }
    }
}