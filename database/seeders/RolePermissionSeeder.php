<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | DAFTAR MENU
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */
        $roles = [
            'super_admin',
            'operator',
            'verifikator',
            'pimpinan',
        ];

        /*
        |--------------------------------------------------------------------------
        | PROSES PER ROLE
        |--------------------------------------------------------------------------
        */
        foreach ($roles as $role) {

            foreach ($menus as [$key, $label, $type, $sort]) {

                /*
                |--------------------------------------------------------------------------
                | DEFAULT PERMISSION
                |--------------------------------------------------------------------------
                */
                $canView = true;

                $canAdd = false;
                $canDelete = false;

                $supportsAdd = true;
                $supportsDelete = true;

                $extraActionLabel = null;
                $extraActionChecked = false;


                /*
                |--------------------------------------------------------------------------
                | SUPER ADMIN
                |--------------------------------------------------------------------------
                */
                if ($role === 'super_admin') {

                    $canView = true;
                    $canAdd = true;
                    $canDelete = true;

                }


                /*
                |--------------------------------------------------------------------------
                | OPERATOR
                |--------------------------------------------------------------------------
                */
                elseif ($role === 'operator') {

                    $canView = true;
                    $canAdd = true;
                    $canDelete = true;

                }


                /*
                |--------------------------------------------------------------------------
                | VERIFIKATOR
                |--------------------------------------------------------------------------
                */
                elseif ($role === 'verifikator') {

                    $canView = true;
                    $canAdd = false;
                    $canDelete = false;

                }


                /*
                |--------------------------------------------------------------------------
                | PIMPINAN
                |--------------------------------------------------------------------------
                */
                elseif ($role === 'pimpinan') {

                    $canView = true;
                    $canAdd = false;
                    $canDelete = false;

                }


                /*
                |--------------------------------------------------------------------------
                | PENGAJUAN
                |--------------------------------------------------------------------------
                */
                if ($key === 'pengajuan') {

                    $extraActionLabel = 'Diajukan';

                    $extraActionChecked =
                        $role === 'operator' ||
                        $role === 'super_admin';

                }


                /*
                |--------------------------------------------------------------------------
                | VERIFIKASI
                |--------------------------------------------------------------------------
                */
                if ($key === 'verifikasi') {

                    // Verifikator menggunakan menu ini
                    $canView =
                        $role === 'super_admin' ||
                        $role === 'verifikator';

                    $canAdd = false;
                    $canDelete = false;

                    $supportsAdd = false;
                    $supportsDelete = false;
                }


                /*
                |--------------------------------------------------------------------------
                | LAPORAN
                |--------------------------------------------------------------------------
                */
                if ($key === 'laporan') {

                    $extraActionLabel = 'Cetak';

                    $extraActionChecked =
                        $role === 'super_admin' ||
                        $role === 'pimpinan';

                    // Laporan tidak memiliki tambah/hapus
                    $canAdd = false;
                    $canDelete = false;

                    $supportsAdd = false;
                    $supportsDelete = false;
                }


                /*
                |--------------------------------------------------------------------------
                | DASHBOARD
                |--------------------------------------------------------------------------
                */
                if ($key === 'dashboard') {

                    $canView = true;

                    $canAdd = false;
                    $canDelete = false;

                    $supportsAdd = false;
                    $supportsDelete = false;
                }


                /*
                |--------------------------------------------------------------------------
                | PIMPINAN
                |--------------------------------------------------------------------------
                */
                if ($role === 'pimpinan') {

                    $canAdd = false;
                    $canDelete = false;

                    // Pimpinan hanya melihat data
                    // Tidak boleh tambah / hapus
                }


                /*
                |--------------------------------------------------------------------------
                | SIMPAN / UPDATE PERMISSION
                |--------------------------------------------------------------------------
                */
                RolePermission::updateOrCreate(
                    [
                        'role' => $role,
                        'menu_key' => $key,
                    ],
                    [
                        'menu_label' => $label,

                        'can_view' => $canView,
                        'can_add' => $canAdd,
                        'can_delete' => $canDelete,

                        'supports_add' => $supportsAdd,
                        'supports_delete' => $supportsDelete,

                        'extra_action_label' => $extraActionLabel,
                        'extra_action_checked' => $extraActionChecked,

                        'sort' => $sort,
                    ]
                );
            }
        }
    }
}