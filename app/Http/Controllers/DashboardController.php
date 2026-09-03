<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * ============================================================
     * DASHBOARD
     * ============================================================
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | USER / ROLE
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        $role = strtolower(
            trim($user->role ?? '')
        );

        /*
        |--------------------------------------------------------------------------
        | FILTER TAHUN
        |--------------------------------------------------------------------------
        */

        $tahun = $request->get('tahun');

        if (
            $tahun === null ||
            $tahun === '' ||
            $tahun === 'all'
        ) {
            $tahun = null;
        }

        /*
        |--------------------------------------------------------------------------
        | DAFTAR TAHUN
        |--------------------------------------------------------------------------
        */

        $tahunList = $this->getTahunList();

        /*
        |--------------------------------------------------------------------------
        | HARDWARE
        |--------------------------------------------------------------------------
        */

        $hardwareDashboard = $this->getHardwareDashboard($tahun);

        $hardwareCount = $this->getAssetCount(
            'hardwares',
            $tahun
        );

        /*
        |--------------------------------------------------------------------------
        | SOFTWARE
        |--------------------------------------------------------------------------
        */

        $softwareDashboard = $this->getSoftwareDashboard($tahun);

        $softwareCount = $this->getAssetCount(
            'softwares',
            $tahun
        );

        /*
        |--------------------------------------------------------------------------
        | INFRASTRUKTUR
        |--------------------------------------------------------------------------
        */

        $infrastrukturDashboard =
            $this->getInfrastrukturDashboard($tahun);

        $jaringanCount = $this->getAssetCount(
            'jaringans',
            $tahun
        );

        $dataCenterCount = $this->getAssetCount(
            'data_centers',
            $tahun
        );

        $splpCount = $this->getAssetCount(
            'splps',
            $tahun
        );

        $infrastrukturCount =
            $jaringanCount +
            $dataCenterCount +
            $splpCount;

        /*
        |--------------------------------------------------------------------------
        | SDM
        |--------------------------------------------------------------------------
        */

        $sdmCount = $this->getAssetCount(
            'sdms',
            $tahun
        );

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $dataCount = $this->getAssetCount(
            'data',
            $tahun
        );

        /*
        |--------------------------------------------------------------------------
        | TOTAL ASET
        |--------------------------------------------------------------------------
        */

        $totalAset =
            $hardwareCount +
            $softwareCount +
            $infrastrukturCount +
            $sdmCount +
            $dataCount;

        /*
        |--------------------------------------------------------------------------
        | STATUS ASET
        |--------------------------------------------------------------------------
        */

        $statusData = $this->getStatusData($tahun);

        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        $kategoriData = [
            [
                'nama' => 'Hardware',
                'jumlah' => $hardwareCount,
                'icon' => 'bi-pc-display',
            ],

            [
                'nama' => 'Software',
                'jumlah' => $softwareCount,
                'icon' => 'bi-laptop',
            ],

            [
                'nama' => 'Infrastruktur',
                'jumlah' => $infrastrukturCount,
                'icon' => 'bi-diagram-3',
            ],

            [
                'nama' => 'SDM',
                'jumlah' => $sdmCount,
                'icon' => 'bi-people',
            ],

            [
                'nama' => 'Data',
                'jumlah' => $dataCount,
                'icon' => 'bi-database',
            ],
        ];

        foreach ($kategoriData as &$kategori) {

            $kategori['persentase'] =
                $totalAset > 0
                    ? round(
                        ($kategori['jumlah'] / $totalAset) * 100,
                        1
                    )
                    : 0;
        }

        unset($kategori);

        /*
        |--------------------------------------------------------------------------
        | DETAIL INFRASTRUKTUR
        |--------------------------------------------------------------------------
        */

        $infrastrukturDetail = [
            [
                'nama' => 'Jaringan',
                'jumlah' => $jaringanCount,
            ],

            [
                'nama' => 'Data Center',
                'jumlah' => $dataCenterCount,
            ],

            [
                'nama' => 'SPLP',
                'jumlah' => $splpCount,
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS
        |--------------------------------------------------------------------------
        */

        $activities = $this->getActivities($tahun);

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI
        |--------------------------------------------------------------------------
        */

        $verificationData =
            $this->getVerificationData($tahun);

        /*
        |--------------------------------------------------------------------------
        | DATA VIEW
        |--------------------------------------------------------------------------
        */

        $viewData = [

            'tahun' => $tahun,

            'tahunList' => $tahunList,

            'totalAset' => $totalAset,

            'hardwareCount' => $hardwareCount,

            'softwareCount' => $softwareCount,

            'infrastrukturCount' => $infrastrukturCount,

            'jaringanCount' => $jaringanCount,

            'dataCenterCount' => $dataCenterCount,

            'splpCount' => $splpCount,

            'sdmCount' => $sdmCount,

            'dataCount' => $dataCount,

            'hardwareDashboard' => $hardwareDashboard,

            'softwareDashboard' => $softwareDashboard,

            'infrastrukturDashboard' =>
                $infrastrukturDashboard,

            'statusData' => $statusData,

            'kategoriData' => $kategoriData,

            'infrastrukturDetail' =>
                $infrastrukturDetail,

            'activities' => $activities,

            'verificationData' =>
                $verificationData,

            'role' => $role,
        ];

        /*
        |--------------------------------------------------------------------------
        | VIEW BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */

        switch ($role) {

            case 'operator':

                return view(
                    'dashboard.operator',
                    $viewData
                );

            case 'verifikator':
            case 'verifier':

                return view(
                    'dashboard.verifikator',
                    $viewData
                );

            case 'superadmin':
            case 'super admin':
            case 'super_admin':
            case 'admin':

                return view(
                    'dashboard.superadmin',
                    $viewData
                );

            case 'pimpinan':

                return view(
                    'dashboard.pimpinan',
                    $viewData
                );

            default:

                abort(
                    403,
                    'Role tidak memiliki akses dashboard.'
                );
        }
    }


    /**
     * ============================================================
     * RESOLVE TABLE NAME
     * ============================================================
     */
    private function resolveTableName(string $table): ?string
{
    $candidates = [
        $table,
    ];

    if ($table === 'softwares') {
        $candidates[] = 'software_assets';
        $candidates[] = 'software_asset';
    }

    if ($table === 'hardwares') {
        $candidates[] = 'hardware';
    }

    if ($table === 'sdms') {
        $candidates[] = 'sdm';
    }

    if ($table === 'jaringans') {
        $candidates[] = 'jaringan';
    }

    if ($table === 'splps') {
        $candidates[] = 'splp';
    }

    if ($table === 'data_centers') {
        $candidates[] = 'data_center';
    }

    foreach ($candidates as $candidate) {

        if (Schema::hasTable($candidate)) {
            return $candidate;
        }
    }

    return null;
}


    /**
     * ============================================================
     * HARDWARE DASHBOARD
     * ============================================================
     */
    private function getHardwareDashboard(
        $tahun = null
    ): array {

        $result = [

            'status' => [
                'Baik' => 0,
                'Perbaikan' => 0,
                'Rusak' => 0,
            ],

            'jenis' => [
                'Laptop' => 0,
                'PC' => 0,
                'Printer' => 0,
                'Monitor' => 0,
                'Keyboard' => 0,
                'Mouse' => 0,
                'Camera' => 0,
            ],
        ];

        $table =
            $this->resolveTableName('hardwares');

        if (!$table) {
            return $result;
        }

        $query = DB::table($table);

        if ($tahun) {

            $dateColumn =
                $this->getDateColumn($table);

            if ($dateColumn) {

                $query->whereYear(
                    $dateColumn,
                    $tahun
                );
            }
        }

        $rows = $query->get();

        $conditionColumn =
            $this->firstExistingColumn(
                $table,
                [
                    'kondisi',
                    'status',
                    'status_aset',
                    'status_barang',
                ]
            );

        $jenisColumn =
            $this->firstExistingColumn(
                $table,
                [
                    'jenis_barang',
                    'jenis',
                    'kategori',
                    'tipe',
                ]
            );

        foreach ($rows as $row) {

            /*
            |--------------------------------------------------------------------------
            | KONDISI
            |--------------------------------------------------------------------------
            */

            $condition = $conditionColumn
                ? trim(
                    (string) (
                        $row->{$conditionColumn} ?? ''
                    )
                )
                : '';

            $conditionLower =
                strtolower($condition);

            if (
                in_array(
                    $conditionLower,
                    [
                        'baik',
                        'tersedia',
                        'bagus',
                        'aktif',
                    ],
                    true
                )
            ) {

                $result['status']['Baik']++;

            } elseif (
                in_array(
                    $conditionLower,
                    [
                        'perlu perbaikan',
                        'perbaikan',
                        'diperbaiki',
                        'repair',
                    ],
                    true
                )
            ) {

                $result['status']['Perbaikan']++;

            } elseif (
                in_array(
                    $conditionLower,
                    [
                        'rusak',
                        'damage',
                        'damaged',
                    ],
                    true
                )
            ) {

                $result['status']['Rusak']++;

            } else {

                $result['status']['Baik']++;
            }

            /*
|--------------------------------------------------------------------------
| JENIS
|--------------------------------------------------------------------------
*/

$jenis = $jenisColumn
    ? trim(
        (string) (
            $row->{$jenisColumn} ?? ''
        )
    )
    : '';

$jenisLower = strtolower($jenis);

if (
    str_contains($jenisLower, 'laptop')
) {

    $result['jenis']['Laptop']++;

} elseif (
    in_array(
        $jenisLower,
        [
            'pc',
            'komputer',
            'desktop',
        ],
        true
    )
) {

    $result['jenis']['PC']++;

} elseif (
    str_contains($jenisLower, 'printer')
) {

    $result['jenis']['Printer']++;

} elseif (
    str_contains($jenisLower, 'monitor')
) {

    $result['jenis']['Monitor']++;

} elseif (
    str_contains($jenisLower, 'keyboard')
) {

    $result['jenis']['Keyboard']++;

} elseif (
    str_contains($jenisLower, 'mouse')
) {

    $result['jenis']['Mouse']++;

} elseif (
    str_contains($jenisLower, 'kamera') ||
    str_contains($jenisLower, 'camera')
) {

    $result['jenis']['Camera']++;
}
        }

        return $result;
    }


    /**
     * ============================================================
     * SOFTWARE DASHBOARD
     * ============================================================
     */
    private function getSoftwareDashboard(
        $tahun = null
    ): array {

        $result = [

            'pengadaan' => [
                'Beli' => 0,
                'Sewa' => 0,
            ],

            'status' => [
                'Tersedia' => 0,
                'Akan Habis' => 0,
                'Expired' => 0,
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | CARI TABEL SOFTWARE
        |--------------------------------------------------------------------------
        |
        | Akan menemukan software_assets
        |
        */

        $table =
            $this->resolveTableName('softwares');

        if (!$table) {
            return $result;
        }

        $query = DB::table($table);

        /*
        |--------------------------------------------------------------------------
        | FILTER TAHUN
        |--------------------------------------------------------------------------
        */

        if ($tahun) {

            $dateColumn =
                $this->getDateColumn($table);

            if ($dateColumn) {

                $query->whereYear(
                    $dateColumn,
                    $tahun
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */

        $rows = $query->get();

        $today = Carbon::today();

        $thirtyDaysLater =
            Carbon::today()->addDays(30);

        /*
        |--------------------------------------------------------------------------
        | CEK KOLOM
        |--------------------------------------------------------------------------
        */

        $pengadaanColumn =
            $this->firstExistingColumn(
                $table,
                [
                    'pengadaan',
                    'jenis_pengadaan',
                    'tipe_pengadaan',
                ]
            );

        $tanggalBerakhirColumn =
            $this->firstExistingColumn(
                $table,
                [
                    'tanggal_berakhir',
                    'tgl_berakhir',
                    'tanggal_expired',
                    'masa_berlaku_sampai',
                    'berakhir',
                ]
            );

        $statusColumn =
            $this->firstExistingColumn(
                $table,
                [
                    'status',
                    'status_software',
                    'status_aset',
                ]
            );

        /*
        |--------------------------------------------------------------------------
        | HITUNG DATA
        |--------------------------------------------------------------------------
        */

        foreach ($rows as $row) {

            /*
            |--------------------------------------------------------------------------
            | PENGADAAN
            |--------------------------------------------------------------------------
            */

            $pengadaan = '';

            if ($pengadaanColumn) {

                $pengadaan = strtolower(
                    trim(
                        (string) (
                            $row->{$pengadaanColumn}
                            ?? ''
                        )
                    )
                );
            }

            if ($pengadaan === 'beli') {

                $result['pengadaan']['Beli']++;

            } elseif ($pengadaan === 'sewa') {

                $result['pengadaan']['Sewa']++;
            }

            /*
            |--------------------------------------------------------------------------
            | TANGGAL BERAKHIR
            |--------------------------------------------------------------------------
            */

            $tanggalBerakhir = null;

            if ($tanggalBerakhirColumn) {

                $tanggalBerakhir =
                    $row->{$tanggalBerakhirColumn}
                    ?? null;
            }

            /*
            |--------------------------------------------------------------------------
            | STATUS BERDASARKAN TANGGAL
            |--------------------------------------------------------------------------
            */

            if ($tanggalBerakhir) {

                try {

                    $endDate =
                        Carbon::parse(
                            $tanggalBerakhir
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | EXPIRED
                    |--------------------------------------------------------------------------
                    */

                    if ($endDate->lt($today)) {

                        $result['status']['Expired']++;

                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | AKAN HABIS
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $endDate->gte($today) &&
                        $endDate->lte($thirtyDaysLater)
                    ) {

                        $result['status']['Akan Habis']++;

                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | TERSEDIA
                    |--------------------------------------------------------------------------
                    */

                    $result['status']['Tersedia']++;

                    continue;

                } catch (\Throwable $e) {

                    // lanjut ke status manual
                }
            }

            /*
            |--------------------------------------------------------------------------
            | STATUS MANUAL
            |--------------------------------------------------------------------------
            */

            if ($statusColumn) {

                $status = strtolower(
                    trim(
                        (string) (
                            $row->{$statusColumn}
                            ?? ''
                        )
                    )
                );

                if (
                    in_array(
                        $status,
                        [
                            'expired',
                            'kadaluarsa',
                            'kedaluwarsa',
                        ],
                        true
                    )
                ) {

                    $result['status']['Expired']++;

                } elseif (
                    in_array(
                        $status,
                        [
                            'akan habis',
                            'segera habis',
                        ],
                        true
                    )
                ) {

                    $result['status']['Akan Habis']++;

                } else {

                    $result['status']['Tersedia']++;
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | DEFAULT
                |--------------------------------------------------------------------------
                */

                $result['status']['Tersedia']++;
            }
        }

        return $result;
    }


    /**
     * ============================================================
     * INFRASTRUKTUR DASHBOARD
     * ============================================================
     */
    private function getInfrastrukturDashboard(
        $tahun = null
    ): array {

        $result = [

            'pengadaan' => [
                'Beli' => 0,
                'Sewa' => 0,
            ],

            'status' => [
                'Tersedia' => 0,
                'Akan Habis' => 0,
                'Expired' => 0,
            ],
        ];

        $tables = [
            'jaringans',
            'data_centers',
            'splps',
        ];

        foreach ($tables as $requestedTable) {

            $table =
                $this->resolveTableName(
                    $requestedTable
                );

            if (!$table) {
                continue;
            }

            $query = DB::table($table);

            if ($tahun) {

                $dateColumn =
                    $this->getDateColumn($table);

                if ($dateColumn) {

                    $query->whereYear(
                        $dateColumn,
                        $tahun
                    );
                }
            }

            $rows = $query->get();

            foreach ($rows as $row) {

                $pengadaan = strtolower(
                    trim(
                        (string) (
                            $row->pengadaan ?? ''
                        )
                    )
                );

                if ($pengadaan === 'beli') {

                    $result['pengadaan']['Beli']++;

                } elseif ($pengadaan === 'sewa') {

                    $result['pengadaan']['Sewa']++;
                }

                $status =
                    $this->getInfrastructureStatus(
                        $row
                    );

                if (
                    isset(
                        $result['status'][$status]
                    )
                ) {

                    $result['status'][$status]++;
                }
            }
        }

        return $result;
    }


    /**
     * ============================================================
     * STATUS INFRASTRUKTUR
     * ============================================================
     */
    private function getInfrastructureStatus(
        $row
    ): string {

        $pengadaan = strtolower(
            trim(
                (string) (
                    $row->pengadaan ?? ''
                )
            )
        );

        if ($pengadaan === 'beli') {

            $status = trim(
                (string) (
                    $row->status ?? ''
                )
            );

            if ($status !== '') {

                return strtolower($status) === 'digunakan'
                    ? 'Tersedia'
                    : $status;
            }

            return 'Tersedia';
        }

        $tanggalBerakhir =
            $row->tanggal_berakhir ?? null;

        if ($tanggalBerakhir) {

            try {

                $endDate =
                    Carbon::parse(
                        $tanggalBerakhir
                    );

                if (
                    $endDate->lt(
                        Carbon::today()
                    )
                ) {

                    return 'Expired';
                }

                if (
                    $endDate->lte(
                        Carbon::today()->addDays(30)
                    )
                ) {

                    return 'Akan Habis';
                }

                return 'Tersedia';

            } catch (\Throwable $e) {
                // fallback
            }
        }

        $status = trim(
            (string) (
                $row->status ?? ''
            )
        );

        if (
            strtolower($status) === 'digunakan'
        ) {

            return 'Tersedia';
        }

        return $status !== ''
            ? $status
            : 'Tersedia';
    }


    /**
     * ============================================================
     * JUMLAH ASET
     * ============================================================
     */
    private function getAssetCount(
        string $requestedTable,
        $tahun = null
    ): int {

        $table =
            $this->resolveTableName(
                $requestedTable
            );

        if (!$table) {
            return 0;
        }

        $query = DB::table($table);

        if ($tahun) {

            $dateColumn =
                $this->getDateColumn(
                    $table
                );

            if ($dateColumn) {

                $query->whereYear(
                    $dateColumn,
                    $tahun
                );
            }
        }

        return $query->count();
    }


    /**
     * ============================================================
     * DAFTAR TAHUN
     * ============================================================
     */
    private function getTahunList()
    {
        $tahunList = collect();

        $tables = [
            'hardwares',
            'softwares',
            'jaringans',
            'data_centers',
            'splps',
            'sdms',
            'data',
        ];

        foreach ($tables as $requestedTable) {

            $table =
                $this->resolveTableName(
                    $requestedTable
                );

            if (!$table) {
                continue;
            }

            $dateColumn =
                $this->getDateColumn(
                    $table
                );

            if (!$dateColumn) {
                continue;
            }

            $years = DB::table($table)
                ->whereNotNull($dateColumn)
                ->selectRaw(
                    "YEAR(`{$dateColumn}`) as tahun"
                )
                ->distinct()
                ->pluck('tahun');

            $tahunList =
                $tahunList->merge($years);
        }

        return $tahunList
            ->filter()
            ->map(
                fn ($year) => (int) $year
            )
            ->unique()
            ->sortDesc()
            ->values();
    }


    /**
     * ============================================================
     * STATUS ASET
     * ============================================================
     */
    private function getStatusData(
        $tahun = null
    ): array {

        $statuses = [

            'Aktif' => 0,

            'Pending' => 0,

            'Rusak' => 0,

            'Tidak Digunakan' => 0,
        ];

        $tables = [

            'hardwares',

            'softwares',

            'jaringans',

            'data_centers',

            'splps',

            'sdms',

            'data',
        ];

        foreach ($tables as $requestedTable) {

            $table =
                $this->resolveTableName(
                    $requestedTable
                );

            if (!$table) {
                continue;
            }

            $query = DB::table($table);

            if ($tahun) {

                $dateColumn =
                    $this->getDateColumn(
                        $table
                    );

                if ($dateColumn) {

                    $query->whereYear(
                        $dateColumn,
                        $tahun
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | HARDWARE
            |--------------------------------------------------------------------------
            */

            if ($requestedTable === 'hardwares') {

                $column =
                    $this->firstExistingColumn(
                        $table,
                        [
                            'kondisi',
                            'status',
                            'status_aset',
                            'status_barang',
                        ]
                    );

                if (!$column) {
                    continue;
                }

                $rows = $query
                    ->select($column)
                    ->get();

                foreach ($rows as $row) {

                    $value = strtolower(
                        trim(
                            (string) (
                                $row->{$column}
                                ?? ''
                            )
                        )
                    );

                    if ($value === 'rusak') {

                        $statuses['Rusak']++;

                    } elseif (
                        in_array(
                            $value,
                            [
                                'tidak digunakan',
                                'nonaktif',
                                'non-aktif',
                                'inactive',
                                'tidak aktif',
                            ],
                            true
                        )
                    ) {

                        $statuses['Tidak Digunakan']++;

                    } elseif (
                        in_array(
                            $value,
                            [
                                'pending',
                                'menunggu',
                                'menunggu verifikasi',
                                'proses',
                                'verifikasi',
                            ],
                            true
                        )
                    ) {

                        $statuses['Pending']++;

                    } else {

                        $statuses['Aktif']++;
                    }
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | SOFTWARE
            |--------------------------------------------------------------------------
            */

            if ($requestedTable === 'softwares') {

                $rows = $query->get();

                foreach ($rows as $row) {

                    $end =
                        $row->tanggal_berakhir
                        ?? null;

                    if ($end) {

                        try {

                            $endDate =
                                Carbon::parse($end);

                            if (
                                $endDate->lt(
                                    Carbon::today()
                                )
                            ) {

                                $statuses[
                                    'Tidak Digunakan'
                                ]++;

                                continue;
                            }

                        } catch (\Throwable $e) {
                            // lanjut
                        }
                    }

                    $statuses['Aktif']++;
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | INFRASTRUKTUR
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $requestedTable,
                    [
                        'jaringans',
                        'data_centers',
                        'splps',
                    ],
                    true
                )
            ) {

                $rows = $query->get();

                foreach ($rows as $row) {

                    $status =
                        $this->getInfrastructureStatus(
                            $row
                        );

                    if ($status === 'Expired') {

                        $statuses[
                            'Tidak Digunakan'
                        ]++;

                    } elseif (
                        $status === 'Akan Habis'
                    ) {

                        $statuses['Pending']++;

                    } else {

                        $statuses['Aktif']++;
                    }
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | TABLE LAIN
            |--------------------------------------------------------------------------
            */

            $column =
                $this->firstExistingColumn(
                    $table,
                    [
                        'status',
                        'status_aset',
                        'status_barang',
                    ]
                );

            if (!$column) {
                continue;
            }

            $rows = $query
                ->select($column)
                ->get();

            foreach ($rows as $row) {

                $value = strtolower(
                    trim(
                        (string) (
                            $row->{$column}
                            ?? ''
                        )
                    )
                );

                if (
                    in_array(
                        $value,
                        [
                            'rusak',
                            'damage',
                            'damaged',
                        ],
                        true
                    )
                ) {

                    $statuses['Rusak']++;

                } elseif (
                    in_array(
                        $value,
                        [
                            'pending',
                            'menunggu',
                            'menunggu verifikasi',
                            'proses',
                            'verifikasi',
                        ],
                        true
                    )
                ) {

                    $statuses['Pending']++;

                } elseif (
                    in_array(
                        $value,
                        [
                            'tidak digunakan',
                            'nonaktif',
                            'non-aktif',
                            'inactive',
                            'tidak aktif',
                        ],
                        true
                    )
                ) {

                    $statuses[
                        'Tidak Digunakan'
                    ]++;

                } else {

                    $statuses['Aktif']++;
                }
            }
        }

        return $statuses;
    }


    /**
     * ============================================================
     * AKTIVITAS TERBARU
     * ============================================================
     */
    private function getActivities(
        $tahun = null
    ) {

        $activities = collect();

        $tables = [

            [
                'table' => 'hardwares',
                'label' => 'Hardware',
                'icon' => 'bi-pc-display',
            ],

            [
                'table' => 'softwares',
                'label' => 'Software',
                'icon' => 'bi-laptop',
            ],

            [
                'table' => 'jaringans',
                'label' => 'Jaringan',
                'icon' => 'bi-diagram-3',
            ],

            [
                'table' => 'data_centers',
                'label' => 'Data Center',
                'icon' => 'bi-server',
            ],

            [
                'table' => 'splps',
                'label' => 'SPLP',
                'icon' => 'bi-hdd-network',
            ],

            [
                'table' => 'sdms',
                'label' => 'SDM',
                'icon' => 'bi-people',
            ],

            [
                'table' => 'data',
                'label' => 'Data',
                'icon' => 'bi-database',
            ],
        ];

        foreach ($tables as $item) {

            $requestedTable =
                $item['table'];

            $table =
                $this->resolveTableName(
                    $requestedTable
                );

            if (!$table) {
                continue;
            }

            $timeColumn =
                $this->getActivityDateColumn(
                    $table
                );

            if (!$timeColumn) {
                continue;
            }

            $query = DB::table($table);

            if ($tahun) {

                $dateColumn =
                    $this->getDateColumn(
                        $table
                    );

                if ($dateColumn) {

                    $query->whereYear(
                        $dateColumn,
                        $tahun
                    );
                }
            }

            $rows = $query
                ->orderByDesc($timeColumn)
                ->limit(10)
                ->get();

            foreach ($rows as $row) {

                $dateValue =
                    $row->{$timeColumn}
                    ?? null;

                if (!$dateValue) {
                    continue;
                }

                try {

                    $date =
                        Carbon::parse(
                            $dateValue
                        );

                } catch (\Throwable $e) {

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | OPERATOR
                |--------------------------------------------------------------------------
                */

                $operator = 'Operator';

                $userId = null;

                if (
                    isset($row->user_id) &&
                    $row->user_id
                ) {

                    $userId =
                        $row->user_id;

                } elseif (
                    isset($row->created_by) &&
                    $row->created_by
                ) {

                    $userId =
                        $row->created_by;
                }

                if (
                    $userId &&
                    Schema::hasTable('users')
                ) {

                    $userName =
                        DB::table('users')
                            ->where(
                                'id',
                                $userId
                            )
                            ->value('name');

                    if ($userName) {

                        $operator =
                            $userName;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | AKTIVITAS
                |--------------------------------------------------------------------------
                */

                $text =
                    'Data ' .
                    $item['label'] .
                    ' baru ditambahkan';

                $icon =
                    $item['icon'];

                if (
                    Schema::hasColumn(
                        $table,
                        'created_at'
                    ) &&
                    Schema::hasColumn(
                        $table,
                        'updated_at'
                    )
                ) {

                    $created =
                        $row->created_at
                        ?? null;

                    $updated =
                        $row->updated_at
                        ?? null;

                    if (
                        $created &&
                        $updated &&
                        $created != $updated
                    ) {

                        $text =
                            'Data ' .
                            $item['label'] .
                            ' diperbarui';

                        $icon =
                            'bi-pencil';
                    }
                }

                $activities->push([

                    'date' => $date,

                    'icon' => $icon,

                    'operator' => $operator,

                    'feature' =>
                        $item['label'],

                    'text' => $text,
                ]);
            }
        }

        return $activities
            ->sortByDesc('date')
            ->take(10)
            ->values();
    }


    /**
     * ============================================================
     * VERIFIKASI
     * ============================================================
     */
    private function getVerificationData(
        $tahun = null
    ): array {

        $result = [

            'Menunggu' => 0,

            'Disetujui' => 0,

            'Ditolak' => 0,
        ];

        $tables = [

            'hardwares',

            'softwares',

            'jaringans',

            'data_centers',

            'splps',

            'sdms',

            'data',
        ];

        foreach ($tables as $requestedTable) {

            $table =
                $this->resolveTableName(
                    $requestedTable
                );

            if (!$table) {
                continue;
            }

            $verificationColumn =
                $this->firstExistingColumn(
                    $table,
                    [
                        'verifikasi',
                        'status_verifikasi',
                        'verification_status',
                    ]
                );

            if (!$verificationColumn) {
                continue;
            }

            $query = DB::table($table);

            if ($tahun) {

                $dateColumn =
                    $this->getDateColumn(
                        $table
                    );

                if ($dateColumn) {

                    $query->whereYear(
                        $dateColumn,
                        $tahun
                    );
                }
            }

            $rows = $query
                ->select(
                    $verificationColumn
                )
                ->get();

            foreach ($rows as $row) {

                $value = strtolower(
                    trim(
                        (string) (
                            $row->{$verificationColumn}
                            ?? ''
                        )
                    )
                );

                if (
                    in_array(
                        $value,
                        [
                            'menunggu',
                            'pending',
                            'belum',
                            'belum diverifikasi',
                            'menunggu verifikasi',
                        ],
                        true
                    )
                ) {

                    $result['Menunggu']++;

                } elseif (
                    in_array(
                        $value,
                        [
                            'disetujui',
                            'setuju',
                            'approved',
                            'terverifikasi',
                            'diverifikasi',
                        ],
                        true
                    )
                ) {

                    $result['Disetujui']++;

                } elseif (
                    in_array(
                        $value,
                        [
                            'ditolak',
                            'tolak',
                            'rejected',
                        ],
                        true
                    )
                ) {

                    $result['Ditolak']++;
                }
            }
        }

        return $result;
    }


    /**
     * ============================================================
     * CARI KOLOM TANGGAL
     * ============================================================
     */
    private function getDateColumn(
        string $table
    ) {

        $candidates = [

            'tanggal_pengadaan',

            'tanggal_pembelian',

            'tgl_pengadaan',

            'tanggal',

            'tahun_pengadaan',

            'created_at',
        ];

        foreach ($candidates as $column) {

            if (
                Schema::hasColumn(
                    $table,
                    $column
                )
            ) {

                return $column;
            }
        }

        return null;
    }


    /**
     * ============================================================
     * CARI KOLOM AKTIVITAS
     * ============================================================
     */
    private function getActivityDateColumn(
        string $table
    ) {

        $candidates = [

            'created_at',

            'updated_at',

            'tanggal_pengadaan',

            'tanggal_pembelian',

            'tgl_pengadaan',

            'tanggal',
        ];

        foreach ($candidates as $column) {

            if (
                Schema::hasColumn(
                    $table,
                    $column
                )
            ) {

                return $column;
            }
        }

        return null;
    }


    /**
     * ============================================================
     * CARI KOLOM PERTAMA YANG ADA
     * ============================================================
     */
    private function firstExistingColumn(
        string $table,
        array $columns
    ) {

        foreach ($columns as $column) {

            if (
                Schema::hasColumn(
                    $table,
                    $column
                )
            ) {

                return $column;
            }
        }

        return null;
    }
}