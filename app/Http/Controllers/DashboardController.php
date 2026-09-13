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
        } else {
            $tahun = (int) $tahun;
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

        $hardwareDashboard =
            $this->getHardwareDashboard($tahun);

        $hardwareCount =
            $this->getAssetCount(
                'hardwares',
                $tahun
            );

        /*
        |--------------------------------------------------------------------------
        | SOFTWARE
        |--------------------------------------------------------------------------
        */

        $softwareDashboard =
            $this->getSoftwareDashboard($tahun);

        $softwareCount =
            $this->getAssetCount(
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

        $jaringanCount =
            $this->getAssetCount(
                'jaringans',
                $tahun
            );

        $dataCenterCount =
            $this->getAssetCount(
                'data_centers',
                $tahun
            );

        $splpCount =
            $this->getAssetCount(
                'splps',
                $tahun
            );

        $infrastrukturCount =
            $jaringanCount +
            $dataCenterCount;

        /*
        |--------------------------------------------------------------------------
        | SDM
        |--------------------------------------------------------------------------
        */

        $sdmCount =
            $this->getAssetCount(
                'sdms',
                $tahun
            );

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $dataCount =
            $this->getAssetCount(
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

        $statusData =
            $this->getStatusData($tahun);

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
        ];

        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS
        |--------------------------------------------------------------------------
        */

        $activities =
            $this->getActivities($tahun);

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

            'infrastrukturCount' =>
                $infrastrukturCount,

            'jaringanCount' =>
                $jaringanCount,

            'dataCenterCount' =>
                $dataCenterCount,

            'splpCount' =>
                $splpCount,

            'sdmCount' =>
                $sdmCount,

            'dataCount' =>
                $dataCount,

            'hardwareDashboard' =>
                $hardwareDashboard,

            'softwareDashboard' =>
                $softwareDashboard,

            /*
            |--------------------------------------------------------------------------
            | DATA INFRASTRUKTUR UNTUK DASHBOARD
            |--------------------------------------------------------------------------
            |
            | Struktur:
            |
            | jenis
            | - Jaringan
            | - Data Center
            |
            | tenant
            | - Tenant A
            | - Tenant B
            | - dst.
            |
            */

            'infrastrukturDashboard' =>
                $infrastrukturDashboard,

            'statusData' =>
                $statusData,

            'kategoriData' =>
                $kategoriData,

            'infrastrukturDetail' =>
                $infrastrukturDetail,

            'activities' =>
                $activities,

            'verificationData' =>
                $verificationData,

            'role' =>
                $role,
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
                    'dashboard.super-admin',
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
    private function resolveTableName(
        string $table
    ): ?string {

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

            if (
                Schema::hasTable($candidate)
            ) {
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
private function getHardwareDashboard($tahun = null): array
{
    $result = [
        'status' => [
            'Baik' => 0,
            'Perbaikan' => 0,
            'Rusak' => 0,
        ],

        // Jenis hardware dibuat DINAMIS
        'jenis' => [],
    ];

    $table = $this->resolveTableName('hardwares');

    if (!$table) {
        return $result;
    }

    $query = DB::table($table);

    // Filter tahun tetap berlaku
    $this->applyYearFilter(
        $query,
        $table,
        $tahun
    );

    $rows = $query->get();

    $conditionColumn = $this->firstExistingColumn(
        $table,
        [
            'kondisi',
            'status',
            'status_aset',
            'status_barang',
        ]
    );

    $jenisColumn = $this->firstExistingColumn(
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
        | STATUS HARDWARE
        |--------------------------------------------------------------------------
        */

        $condition = $conditionColumn
            ? trim(
                (string) (
                    $row->{$conditionColumn} ?? ''
                )
            )
            : '';

        $conditionLower = strtolower($condition);

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

            // Nilai kosong / tidak dikenali
            // tetap dimasukkan ke Baik seperti logic lama
            $result['status']['Baik']++;
        }


        /*
        |--------------------------------------------------------------------------
        | JENIS HARDWARE - DINAMIS
        |--------------------------------------------------------------------------
        */

        $jenis = $jenisColumn
            ? trim(
                (string) (
                    $row->{$jenisColumn} ?? ''
                )
            )
            : '';

        // Kalau jenis kosong, jangan dibuat kategori kosong
        if ($jenis === '') {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI HURUF
        |--------------------------------------------------------------------------
        |
        | Contoh:
        | Laptop
        | laptop
        | LAPTOP
        |
        | akan dianggap sebagai jenis yang sama.
        |
        */

        $jenisKey = strtolower($jenis);

        $existingJenis = null;

        foreach (array_keys($result['jenis']) as $key) {

            if (strtolower($key) === $jenisKey) {

                $existingJenis = $key;

                break;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG JENIS
        |--------------------------------------------------------------------------
        */

        if ($existingJenis !== null) {

            $result['jenis'][$existingJenis]++;

        } else {

            $result['jenis'][$jenis] = 1;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | URUTKAN DARI JUMLAH TERBANYAK
    |--------------------------------------------------------------------------
    */

    arsort($result['jenis']);

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

        $table =
            $this->resolveTableName('softwares');

        if (!$table) {
            return $result;
        }

        $query = DB::table($table);

        $this->applyYearFilter(
            $query,
            $table,
            $tahun
        );

        $rows = $query->get();

        $today = Carbon::today();

        $thirtyDaysLater =
            Carbon::today()->addDays(30);

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

        foreach ($rows as $row) {

            $pengadaan = '';

            if ($pengadaanColumn) {

                $pengadaan =
                    strtolower(
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

            $tanggalBerakhir = null;

            if ($tanggalBerakhirColumn) {
                $tanggalBerakhir =
                    $row->{$tanggalBerakhirColumn}
                    ?? null;
            }

            if ($tanggalBerakhir) {

                try {

                    $endDate =
                        Carbon::parse(
                            $tanggalBerakhir
                        );

                    if (
                        $endDate->lt($today)
                    ) {

                        $result['status']['Expired']++;

                        continue;
                    }

                    if (
                        $endDate->gte($today) &&
                        $endDate->lte($thirtyDaysLater)
                    ) {

                        $result['status']['Akan Habis']++;

                        continue;
                    }

                    $result['status']['Tersedia']++;

                    continue;

                } catch (\Throwable $e) {
                    // fallback
                }
            }

            if ($statusColumn) {

                $status =
                    strtolower(
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

                $result['status']['Tersedia']++;
            }
        }

        return $result;
    }


    /**
     * ============================================================
     * INFRASTRUKTUR DASHBOARD
     * ============================================================
     *
     * DONUT :
     * - Jaringan
     * - Data Center
     * - SPLP
     *
     * BAR :
     * - Tenant
     *
     * TIDAK menggunakan:
     * - Beli / Sewa
     * - Tersedia / Akan Habis / Expired
     * - Baik / Perbaikan / Rusak
     *
     * ============================================================
     */
    private function getInfrastrukturDashboard(
        $tahun = null
    ): array {

        $result = [
            'jenis' => [
                'Jaringan' => 0,
                'Data Center' => 0,
            ],

            'tenant' => [],
        ];

        /*
        |--------------------------------------------------------------------------
        | JARINGAN
        |--------------------------------------------------------------------------
        */

        $jaringanTable =
            $this->resolveTableName('jaringans');

        if ($jaringanTable) {

            $query = DB::table($jaringanTable);

            $this->applyYearFilter(
                $query,
                $jaringanTable,
                $tahun
            );

            $result['jenis']['Jaringan'] =
                $query->count();
        }

        /*
        |--------------------------------------------------------------------------
        | DATA CENTER
        |--------------------------------------------------------------------------
        |
        | Data Center dihitung untuk donut.
        | Tenant hanya diambil dari tabel Data Center.
        | SPLP tidak digunakan untuk chart Infrastruktur.
        |
        */

        $dataCenterTable =
            $this->resolveTableName('data_centers');

        if ($dataCenterTable) {

            $query = DB::table($dataCenterTable);

            $this->applyYearFilter(
                $query,
                $dataCenterTable,
                $tahun
            );

            $result['jenis']['Data Center'] =
                $query->count();

            $tenantColumn =
                $this->firstExistingColumn(
                    $dataCenterTable,
                    [
                        'tenant',
                        'nama_tenant',
                        'tenant_name',
                        'namaTenant',
                    ]
                );

            if ($tenantColumn) {

                $rows =
                    $query
                        ->select($tenantColumn)
                        ->get();

                foreach ($rows as $row) {

                    $tenant =
                        trim(
                            (string) (
                                $row->{$tenantColumn}
                                ?? ''
                            )
                        );

                    if ($tenant === '') {
                        continue;
                    }

                    /*
                    |--------------------------------------------------------------
                    | Normalisasi tenant agar perbedaan huruf besar/kecil tidak
                    | membuat tenant yang sama menjadi dua kategori.
                    |--------------------------------------------------------------
                    */

                    $tenantKey = strtolower($tenant);
                    $existingTenant = null;

                    foreach (array_keys($result['tenant']) as $existingKey) {

                        if (strtolower($existingKey) === $tenantKey) {
                            $existingTenant = $existingKey;
                            break;
                        }
                    }

                    if ($existingTenant !== null) {
                        $result['tenant'][$existingTenant]++;
                    } else {
                        $result['tenant'][$tenant] = 1;
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | URUTKAN TENANT DARI JUMLAH TERBANYAK
        |--------------------------------------------------------------------------
        */

        arsort($result['tenant']);

        return $result;
    }

    /**
     * ============================================================
     * STATUS INFRASTRUKTUR
     * ============================================================
     *
     * Fungsi ini TETAP dipakai oleh getStatusData().
     * Bukan untuk chart Infrastruktur.
     *
     * ============================================================
     */
    private function getInfrastructureStatus(
        $row
    ): string {

        $pengadaan =
            strtolower(
                trim(
                    (string) (
                        $row->pengadaan
                        ?? ''
                    )
                )
            );

        if ($pengadaan === 'beli') {

            $status =
                trim(
                    (string) (
                        $row->status
                        ?? ''
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
            $row->tanggal_berakhir
            ?? null;

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

        $status =
            trim(
                (string) (
                    $row->status
                    ?? ''
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

        $this->applyYearFilter(
            $query,
            $table,
            $tahun
        );

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

            $yearColumns = [
                'tahun_pembelian',
                'tahun_pengadaan',
                'tahun',
            ];

            $foundYearColumn = false;

            foreach ($yearColumns as $yearColumn) {

                if (
                    !Schema::hasColumn(
                        $table,
                        $yearColumn
                    )
                ) {
                    continue;
                }

                $years =
                    DB::table($table)
                        ->whereNotNull($yearColumn)
                        ->where($yearColumn, '!=', '')
                        ->pluck($yearColumn);

                $tahunList =
                    $tahunList->merge($years);

                $foundYearColumn = true;

                break;
            }

            if ($foundYearColumn) {
                continue;
            }

            $dateColumns = [
                'tanggal_pengadaan',
                'tanggal_pembelian',
                'tgl_pengadaan',
                'tanggal',
                'created_at',
            ];

            foreach ($dateColumns as $dateColumn) {

                if (
                    !Schema::hasColumn(
                        $table,
                        $dateColumn
                    )
                ) {
                    continue;
                }

                $years =
                    DB::table($table)
                        ->whereNotNull($dateColumn)
                        ->selectRaw(
                            "YEAR(`{$dateColumn}`) as tahun"
                        )
                        ->distinct()
                        ->pluck('tahun');

                $tahunList =
                    $tahunList->merge($years);

                break;
            }
        }

        return $tahunList
            ->filter(function ($year) {

                return is_numeric($year) &&
                    (int) $year >= 1900 &&
                    (int) $year <= 2100;
            })
            ->map(function ($year) {

                return (int) $year;
            })
            ->unique()
            ->sortDesc()
            ->values();
    }


    /**
     * ============================================================
     * FILTER TAHUN
     * ============================================================
     */
    private function applyYearFilter(
        $query,
        string $table,
        $tahun
    ) {

        if (
            $tahun === null ||
            $tahun === '' ||
            $tahun === 'all'
        ) {
            return $query;
        }

        $tahun = (int) $tahun;

        $yearColumns = [
            'tahun_pembelian',
            'tahun_pengadaan',
            'tahun',
        ];

        foreach ($yearColumns as $yearColumn) {

            if (
                !Schema::hasColumn(
                    $table,
                    $yearColumn
                )
            ) {
                continue;
            }

            return $query->where(
                $yearColumn,
                $tahun
            );
        }

        $dateColumns = [
            'tanggal_pengadaan',
            'tanggal_pembelian',
            'tgl_pengadaan',
            'tanggal',
            'created_at',
        ];

        foreach ($dateColumns as $dateColumn) {

            if (
                Schema::hasColumn(
                    $table,
                    $dateColumn
                )
            ) {

                return $query->whereYear(
                    $dateColumn,
                    $tahun
                );
            }
        }

        return $query;
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

            $this->applyYearFilter(
                $query,
                $table,
                $tahun
            );

            if (
                $requestedTable === 'hardwares'
            ) {

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

                $rows =
                    $query
                        ->select($column)
                        ->get();

                foreach ($rows as $row) {

                    $value =
                        strtolower(
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

            if (
                $requestedTable === 'softwares'
            ) {

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

                    if (
                        $status === 'Expired'
                    ) {

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

            $rows =
                $query
                    ->select($column)
                    ->get();

            foreach ($rows as $row) {

                $value =
                    strtolower(
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
    private function getActivities($tahun = null)
    {
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

            $hasCreatedAt =
                Schema::hasColumn(
                    $table,
                    'created_at'
                );

            $hasUpdatedAt =
                Schema::hasColumn(
                    $table,
                    'updated_at'
                );

            $fallbackDateColumn =
                $this->getActivityFallbackDateColumn(
                    $table
                );

            if (
                !$hasCreatedAt &&
                !$hasUpdatedAt &&
                !$fallbackDateColumn
            ) {
                continue;
            }

            $query =
                DB::table($table);

            $this->applyYearFilter(
                $query,
                $table,
                $tahun
            );

            $rows = $query->get();

            foreach ($rows as $row) {

                $activityDate = null;

                $activityType = 'created';

                $createdRaw =
                    $hasCreatedAt
                        ? ($row->created_at ?? null)
                        : null;

                $updatedRaw =
                    $hasUpdatedAt
                        ? ($row->updated_at ?? null)
                        : null;

                $createdDate =
                    $this->parseActivityDate(
                        $createdRaw
                    );

                $updatedDate =
                    $this->parseActivityDate(
                        $updatedRaw
                    );

                if ($createdDate) {

                    $activityDate =
                        $createdDate;
                }

                if (
                    $updatedDate &&
                    (
                        !$createdDate ||
                        $updatedDate->gt(
                            $createdDate
                        )
                    )
                ) {

                    $activityDate =
                        $updatedDate;

                    $activityType =
                        'updated';
                }

                if (
                    !$activityDate &&
                    $fallbackDateColumn
                ) {

                    $fallbackRaw =
                        $row->{$fallbackDateColumn}
                        ?? null;

                    $activityDate =
                        $this->parseActivityDate(
                            $fallbackRaw
                        );
                }

                if (!$activityDate) {
                    continue;
                }

                $userId = null;

                if ($activityType === 'updated') {

                    if (
                        isset($row->updated_by) &&
                        $row->updated_by
                    ) {

                        $userId =
                            $row->updated_by;

                    } elseif (
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

                } else {

                    if (
                        isset($row->created_by) &&
                        $row->created_by
                    ) {

                        $userId =
                            $row->created_by;

                    } elseif (
                        isset($row->user_id) &&
                        $row->user_id
                    ) {

                        $userId =
                            $row->user_id;

                    } elseif (
                        isset($row->updated_by) &&
                        $row->updated_by
                    ) {

                        $userId =
                            $row->updated_by;
                    }
                }

                $operator =
                    $this->getActivityUserName(
                        $userId
                    );

                if (
                    $activityType === 'updated'
                ) {

                    $text =
                        'Data ' .
                        $item['label'] .
                        ' diperbarui';

                    $icon =
                        'bi-pencil';

                } else {

                    $text =
                        'Data ' .
                        $item['label'] .
                        ' baru ditambahkan';

                    $icon =
                        $item['icon'];
                }

                $activityDate =
                    $activityDate
                        ->copy()
                        ->setTimezone(
                            'Asia/Jakarta'
                        );

                $tanggal =
                    $activityDate
                        ->locale('id')
                        ->translatedFormat(
                            'd F Y, H:i'
                        );

                $time =
                    $activityDate
                        ->format('H:i');

                $activities->push([
                    'date' =>
                        $activityDate,

                    'tanggal' =>
                        $tanggal,

                    'time' =>
                        $time,

                    'operator' =>
                        $operator,

                    'feature' =>
                        $item['label'],

                    'text' =>
                        $text,

                    'type' =>
                        $activityType,

                    'icon' =>
                        $icon,

                    'table' =>
                        $table,
                ]);
            }
        }

        return $activities
            ->sortByDesc(function ($activity) {

                return $activity['date']->timestamp;

            })
            ->take(10)
            ->values();
    }


    /**
     * ============================================================
     * NAMA USER AKTIVITAS
     * ============================================================
     */
    private function getActivityUserName(
        $userId
    ): string {

        if (
            !$userId ||
            !Schema::hasTable('users')
        ) {
            return 'Operator';
        }

        $user =
            DB::table('users')
                ->where('id', $userId)
                ->first();

        if (!$user) {
            return 'Operator';
        }

        if (
            isset($user->username) &&
            !empty($user->username)
        ) {

            return $user->username;
        }

        if (
            isset($user->name) &&
            !empty($user->name)
        ) {

            return $user->name;
        }

        return 'Operator';
    }


    /**
     * ============================================================
     * PARSE TANGGAL AKTIVITAS
     * ============================================================
     */
    private function parseActivityDate(
        $value
    ): ?Carbon {

        if (
            $value === null ||
            $value === ''
        ) {
            return null;
        }

        try {

            if (
                $value instanceof Carbon
            ) {

                return $value
                    ->copy()
                    ->setTimezone(
                        'Asia/Jakarta'
                    );
            }

            return Carbon::createFromFormat(
                'Y-m-d H:i:s',
                (string) $value,
                'Asia/Jakarta'
            );

        } catch (\Throwable $e) {

            try {

                return Carbon::parse(
                    (string) $value,
                    'Asia/Jakarta'
                );

            } catch (\Throwable $e) {

                return null;
            }
        }
    }


    /**
     * ============================================================
     * CARI KOLOM TANGGAL FALLBACK AKTIVITAS
     * ============================================================
     */
    private function getActivityFallbackDateColumn(
        string $table
    ) {

        $candidates = [
            'tanggal_pengadaan',
            'tanggal_pembelian',
            'tgl_pengadaan',
            'tanggal',
            'tahun_pengadaan',
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

            $query =
                DB::table($table);

            $this->applyYearFilter(
                $query,
                $table,
                $tahun
            );

            $rows =
                $query
                    ->select(
                        $verificationColumn
                    )
                    ->get();

            foreach ($rows as $row) {

                $value =
                    strtolower(
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
                            'menunggu disetujui',
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