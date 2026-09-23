<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Data;
use App\Models\DataCenter;
use App\Models\Hardware;
use App\Models\Jaringan;
use App\Models\Sdm;
use App\Models\SoftwareAsset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class LaporanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        return view(
            'laporan.index',
            $this->buildReportData($request)
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PREVIEW LAPORAN
    |--------------------------------------------------------------------------
    */

    public function preview(Request $request)
    {
        try {
            $data = $this->buildReportData($request);

            $html = view('laporan.index', $data)->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        } catch (Throwable $e) {

            Log::error('LAPORAN PREVIEW ERROR', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    |
    | Menggunakan data yang sama dengan Preview.
    | Jadi:
    |
    | Jenis
    | Kolom
    | Filter
    | Search
    |
    | semuanya tetap mengikuti Report Builder.
    |
    |--------------------------------------------------------------------------
    */

    public function exportExcel(Request $request)
    {
        try {

            $data = $this->buildReportData($request);

            return Excel::download(
                new LaporanExport(
                    $data['jenis'],
                    $data['jenisLabel'],
                    $data['kolom'],
                    $data['kolomDiizinkan'],
                    $data['hasil'],
                    $data['filter']
                ),
                'laporan-inventory-it-assets.xlsx'
            );

        } catch (Throwable $e) {

            Log::error('LAPORAN EXPORT EXCEL ERROR', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat file Excel: ' . $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD REPORT DATA
    |--------------------------------------------------------------------------
    */

    private function buildReportData(Request $request): array
    {
        $jenisConfig = [

            'hardware' => [
                'label' => 'Hardware',
                'icon' => 'bi-pc-display',
                'model' => Hardware::class,
                'table' => (new Hardware())->getTable(),
            ],

            'software' => [
                'label' => 'Software',
                'icon' => 'bi-window-stack',
                'model' => SoftwareAsset::class,
                'table' => (new SoftwareAsset())->getTable(),
            ],

            'jaringan' => [
                'label' => 'Jaringan',
                'icon' => 'bi-diagram-3',
                'model' => Jaringan::class,
                'table' => (new Jaringan())->getTable(),
            ],

            'data-center' => [
                'label' => 'Data Center',
                'icon' => 'bi-server',
                'model' => DataCenter::class,
                'table' => (new DataCenter())->getTable(),
            ],

            'data' => [
                'label' => 'Data',
                'icon' => 'bi-database',
                'model' => Data::class,
                'table' => (new Data())->getTable(),
            ],

            'sdm' => [
                'label' => 'SDM',
                'icon' => 'bi-people',
                'model' => Sdm::class,
                'table' => (new Sdm())->getTable(),
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | KOLOM YANG DIIZINKAN
        |--------------------------------------------------------------------------
        */

        $kolomDiizinkan = [

            'hardware' => [
                'asset_id' => 'Asset ID',
                'nama_barang' => 'Nama Barang',
                'spesifikasi' => 'Spesifikasi',
                'jenis_barang' => 'Jenis Barang',
                'lokasi_id' => 'ID Lokasi',
                'sistem_operasi' => 'Sistem Operasi',
                'tahun_pembelian' => 'Tahun Pembelian',
                'harga' => 'Harga',
                'kondisi' => 'Kondisi',
                'created_at' => 'Tanggal Dibuat',
                'updated_at' => 'Terakhir Diubah',
            ],

            'software' => [
                'kode' => 'Kode',
                'nama_aset' => 'Nama Aset',
                'jenis' => 'Jenis',
                'spesifikasi' => 'Spesifikasi',
                'kategori' => 'Kategori',
                'kategori_sistem_elektronik' => 'Kategori Sistem Elektronik',
                'ssl' => 'SSL',
                'hosting' => 'Hosting',
                'pic' => 'PIC',
                'url_homepage' => 'URL Homepage',
                'ip_public' => 'IP Public',
                'ip_private' => 'IP Private',
                'status' => 'Status',
                'kerahasiaan' => 'Kerahasiaan',
                'integritas' => 'Integritas',
                'ketersediaan' => 'Ketersediaan',
                'nilai' => 'Nilai',
                'keterangan' => 'Keterangan',
                'deskripsi_aplikasi' => 'Deskripsi Aplikasi',
                'jumlah_lisensi' => 'Jumlah Lisensi',
                'pengadaan' => 'Pengadaan',
                'periode_sewa' => 'Periode Sewa',
                'harga' => 'Harga',
                'tanggal_pengadaan' => 'Tanggal Pengadaan',
                'tanggal_berakhir' => 'Tanggal Berakhir',
                'verifikasi' => 'Verifikasi',
                'komentar' => 'Komentar',
                'created_at' => 'Tanggal Dibuat',
                'updated_at' => 'Terakhir Diubah',
            ],

            'jaringan' => [
                'id' => 'ID Jaringan',
                'jenis_data' => 'Jenis Data',
                'lokasi' => 'Lokasi',
                'jarak_kabel' => 'Jarak Kabel',
                'jumlah_core' => 'Jumlah Core',
                'jumlah_titik' => 'Jumlah Titik',
                'verifikasi' => 'Verifikasi',
                'komentar' => 'Komentar',
                'created_at' => 'Tanggal Dibuat',
                'updated_at' => 'Terakhir Diubah',
            ],

            'data-center' => [
                'id_data_center' => 'ID Data Center',
                'name' => 'Nama',
                'tahun' => 'Tahun',
                'status' => 'Status',
                'tenant' => 'Tenant',
                'site' => 'Site',
                'rack' => 'Rack',
                'role' => 'Role',
                'manufacturer' => 'Manufacturer',
                'type' => 'Type',
                'platform' => 'Platform',
                'serial_number' => 'Serial Number',
                'ip_address' => 'IP Address',
                'cpu' => 'CPU',
                'harddisk' => 'Harddisk',
                'ram' => 'RAM',
                'pic' => 'PIC',
                'id' => 'ID Internal',
                'tenant_group' => 'Tenant Group',
                'region' => 'Region',
                'location' => 'Location',
                'position' => 'Position',
                'rack_face' => 'Rack Face',
                'ipv4_address' => 'IPv4 Address',
                'cluster' => 'Cluster',
                'description' => 'Description',
                'owner_group' => 'Owner Group',
                'owner' => 'Owner',
                'u_height' => 'U Height',
                'verifikasi' => 'Verifikasi',
                'komentar' => 'Komentar',
                'created_at' => 'Tanggal Dibuat',
                'updated_at' => 'Terakhir Diubah',
            ],

            'data' => [
                'id' => 'ID',
                'nama_dataset' => 'Nama Dataset',
                'topik' => 'Topik',
                'tahun' => 'Tahun',
                'deskripsi' => 'Deskripsi',
                'metadata' => 'Metadata',
                'file_data' => 'File Data',
                'verifikasi' => 'Verifikasi',
                'tanggal_pengajuan' => 'Tanggal Pengajuan',
                'komentar_verifikasi' => 'Komentar Verifikasi',
                'created_at' => 'Tanggal Dibuat',
                'updated_at' => 'Terakhir Diubah',
            ],

            'sdm' => [
                'id' => 'ID',
                'jenis_pegawai' => 'Jenis Pegawai',
                'nip' => 'NIP',
                'nama' => 'Nama',
                'jabatan' => 'Jabatan',
                'kompetensi' => 'Kompetensi',
                'masa_berlaku' => 'Masa Berlaku',
                'dokumen' => 'Dokumen',
                'created_at' => 'Tanggal Dibuat',
                'updated_at' => 'Terakhir Diubah',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | LABEL JENIS
        |--------------------------------------------------------------------------
        */

        $jenisLabel = collect($jenisConfig)
            ->mapWithKeys(
                fn ($config, $key) => [
                    $key => $config['label']
                ]
            )
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | JENIS YANG DIPILIH
        |--------------------------------------------------------------------------
        */

        $jenisRequest = $request->input('jenis', []);

        if (!is_array($jenisRequest)) {
            $jenisRequest = [$jenisRequest];
        }

        $jenisRequest = array_map(
            fn ($value) => is_scalar($value)
                ? trim((string) $value)
                : '',
            $jenisRequest
        );

        $jenis = array_values(
            array_unique(
                array_intersect(
                    $jenisRequest,
                    array_keys($jenisConfig)
                )
            )
        );


        /*
        |--------------------------------------------------------------------------
        | KOLOM YANG DIPILIH
        |--------------------------------------------------------------------------
        */

        $kolomRequest = $request->input('kolom', []);

        if (!is_array($kolomRequest)) {
            $kolomRequest = [];
        }

        $kolom = [];

        foreach ($jenis as $jenisLaporan) {

            $requested = $kolomRequest[$jenisLaporan] ?? [];

            if (!is_array($requested)) {
                $requested = [];
            }

            $requested = array_values(
                array_filter(
                    $requested,
                    fn ($value) => is_scalar($value)
                )
            );

            $requested = array_map(
                fn ($value) => trim((string) $value),
                $requested
            );

            $allowed = array_keys(
                $kolomDiizinkan[$jenisLaporan] ?? []
            );

            $table = $jenisConfig[$jenisLaporan]['table'];

            $databaseColumns = $this->getTableColumns($table);

            $allowed = array_values(
                array_intersect(
                    $allowed,
                    $databaseColumns
                )
            );

            $kolom[$jenisLaporan] = array_values(
                array_unique(
                    array_intersect(
                        $requested,
                        $allowed
                    )
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER REQUEST
        |--------------------------------------------------------------------------
        */

        $filterRequest = $request->input('filter', []);

        if (!is_array($filterRequest)) {
            $filterRequest = [];
        }

        $getFilter = function (string $key) use ($filterRequest): string {

            $value = $filterRequest[$key] ?? '';

            return is_scalar($value)
                ? trim((string) $value)
                : '';
        };


        $filter = [

            'search' => $getFilter('search'),

            // HARDWARE
            'hardware_tahun' => $getFilter('hardware_tahun'),
            'hardware_kondisi' => $getFilter('hardware_kondisi'),
            'hardware_jenis' => $getFilter('hardware_jenis'),
            'hardware_lokasi' => $getFilter('hardware_lokasi'),

            // SOFTWARE
            'software_tahun' => $getFilter('software_tahun'),
            'software_status' => $getFilter('software_status'),
            'software_kategori' => $getFilter('software_kategori'),
            'software_pengadaan' => $getFilter('software_pengadaan'),
            'software_pic' => $getFilter('software_pic'),

            // JARINGAN
            'jaringan_jenis' => $getFilter('jaringan_jenis'),
            'jaringan_lokasi' => $getFilter('jaringan_lokasi'),
            'jaringan_verifikasi' => $getFilter('jaringan_verifikasi'),

            // DATA CENTER
            'datacenter_tahun' => $getFilter('datacenter_tahun'),
            'datacenter_status' => $getFilter('datacenter_status'),
            'datacenter_tenant' => $getFilter('datacenter_tenant'),
            'datacenter_site' => $getFilter('datacenter_site'),
            'datacenter_rack' => $getFilter('datacenter_rack'),
            'datacenter_region' => $getFilter('datacenter_region'),
            'datacenter_manufacturer' => $getFilter('datacenter_manufacturer'),
            'datacenter_verifikasi' => $getFilter('datacenter_verifikasi'),

            // DATA
            'data_tahun' => $getFilter('data_tahun'),
            'data_topik' => $getFilter('data_topik'),
            'data_verifikasi' => $getFilter('data_verifikasi'),

            // SDM
            'sdm_jenis_pegawai' => $getFilter('sdm_jenis_pegawai'),
            'sdm_jabatan' => $getFilter('sdm_jabatan'),
        ];


        /*
        |--------------------------------------------------------------------------
        | FILTER OPTIONS
        |--------------------------------------------------------------------------
        */

        $filterOptions = [

            'hardware' => [
                'tahun' => collect(),
                'kondisi' => collect(),
                'jenis' => collect(),
                'lokasi' => collect(),
            ],

            'software' => [
                'tahun' => collect(),
                'status' => collect(),
                'kategori' => collect(),
                'pengadaan' => collect(),
                'pic' => collect(),
            ],

            'jaringan' => [
                'jenis' => collect(),
                'lokasi' => collect(),
                'verifikasi' => collect(),
            ],

            'data-center' => [
                'tahun' => collect(),
                'status' => collect(),
                'tenant' => collect(),
                'site' => collect(),
                'rack' => collect(),
                'region' => collect(),
                'manufacturer' => collect(),
                'verifikasi' => collect(),
            ],

            'data' => [
                'tahun' => collect(),
                'topik' => collect(),
                'verifikasi' => collect(),
            ],

            'sdm' => [
                'jenis_pegawai' => collect(),
                'jabatan' => collect(),
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | HARDWARE FILTER OPTIONS
        |--------------------------------------------------------------------------
        */

        $table = (new Hardware())->getTable();

        $filterOptions['hardware']['tahun'] =
            $this->getDistinctOptions(
                Hardware::query(),
                $table,
                'tahun_pembelian',
                true
            );

        $filterOptions['hardware']['kondisi'] =
            $this->getDistinctOptions(
                Hardware::query(),
                $table,
                'kondisi'
            );

        $filterOptions['hardware']['jenis'] =
            $this->getDistinctOptions(
                Hardware::query(),
                $table,
                'jenis_barang'
            );

        $filterOptions['hardware']['lokasi'] =
            $this->getDistinctOptions(
                Hardware::query(),
                $table,
                'lokasi_id'
            );


        /*
        |--------------------------------------------------------------------------
        | SOFTWARE FILTER OPTIONS
        |--------------------------------------------------------------------------
        */

        $table = (new SoftwareAsset())->getTable();

        if (
            $this->hasColumn(
                $table,
                'tanggal_pengadaan'
            )
        ) {

            $filterOptions['software']['tahun'] =
                SoftwareAsset::query()
                    ->whereNotNull('tanggal_pengadaan')
                    ->selectRaw(
                        'YEAR(tanggal_pengadaan) AS tahun'
                    )
                    ->distinct()
                    ->orderByDesc('tahun')
                    ->pluck('tahun')
                    ->filter(
                        fn ($value) => filled($value)
                    )
                    ->map(
                        fn ($value) => trim((string) $value)
                    )
                    ->unique()
                    ->values();
        }

        $filterOptions['software']['status'] =
            $this->getDistinctOptions(
                SoftwareAsset::query(),
                $table,
                'status'
            );

        $filterOptions['software']['kategori'] =
            $this->getDistinctOptions(
                SoftwareAsset::query(),
                $table,
                'kategori'
            );

        $filterOptions['software']['pengadaan'] =
            $this->getDistinctOptions(
                SoftwareAsset::query(),
                $table,
                'pengadaan'
            );

        $filterOptions['software']['pic'] =
            $this->getDistinctOptions(
                SoftwareAsset::query(),
                $table,
                'pic'
            );


        /*
        |--------------------------------------------------------------------------
        | JARINGAN FILTER OPTIONS
        |--------------------------------------------------------------------------
        */

        $table = (new Jaringan())->getTable();

        $filterOptions['jaringan']['jenis'] =
            $this->getDistinctOptions(
                Jaringan::query(),
                $table,
                'jenis_data'
            );

        $filterOptions['jaringan']['lokasi'] =
            $this->getDistinctOptions(
                Jaringan::query(),
                $table,
                'lokasi'
            );

        $filterOptions['jaringan']['verifikasi'] =
            $this->getDistinctOptions(
                Jaringan::query(),
                $table,
                'verifikasi'
            );


        /*
        |--------------------------------------------------------------------------
        | DATA CENTER FILTER OPTIONS
        |--------------------------------------------------------------------------
        */

        $table = (new DataCenter())->getTable();

        $filterOptions['data-center']['tahun'] =
            $this->getDistinctOptions(
                DataCenter::query(),
                $table,
                'tahun',
                true
            );

        $filterOptions['data-center']['status'] =
            $this->getDistinctOptions(
                DataCenter::query(),
                $table,
                'status'
            );

        $filterOptions['data-center']['tenant'] =
            $this->getDistinctOptions(
                DataCenter::query(),
                $table,
                'tenant'
            );

        $filterOptions['data-center']['site'] =
            $this->getDistinctOptions(
                DataCenter::query(),
                $table,
                'site'
            );

        $filterOptions['data-center']['rack'] =
            $this->getDistinctOptions(
                DataCenter::query(),
                $table,
                'rack'
            );

        $filterOptions['data-center']['region'] =
            $this->getDistinctOptions(
                DataCenter::query(),
                $table,
                'region'
            );

        $filterOptions['data-center']['manufacturer'] =
            $this->getDistinctOptions(
                DataCenter::query(),
                $table,
                'manufacturer'
            );

        $filterOptions['data-center']['verifikasi'] =
            $this->getDistinctOptions(
                DataCenter::query(),
                $table,
                'verifikasi'
            );


        /*
        |--------------------------------------------------------------------------
        | DATA FILTER OPTIONS
        |--------------------------------------------------------------------------
        */

        $table = (new Data())->getTable();

        $filterOptions['data']['tahun'] =
            $this->getDistinctOptions(
                Data::query(),
                $table,
                'tahun',
                true
            );

        $filterOptions['data']['topik'] =
            $this->getDistinctOptions(
                Data::query(),
                $table,
                'topik'
            );

        $filterOptions['data']['verifikasi'] =
            $this->getDistinctOptions(
                Data::query(),
                $table,
                'verifikasi'
            );


        /*
        |--------------------------------------------------------------------------
        | SDM FILTER OPTIONS
        |--------------------------------------------------------------------------
        */

        $table = (new Sdm())->getTable();

        $filterOptions['sdm']['jenis_pegawai'] =
            $this->getDistinctOptions(
                Sdm::query(),
                $table,
                'jenis_pegawai'
            );

        $filterOptions['sdm']['jabatan'] =
            $this->getDistinctOptions(
                Sdm::query(),
                $table,
                'jabatan'
            );


        /*
        |--------------------------------------------------------------------------
        | HASIL PREVIEW LAPORAN
        |--------------------------------------------------------------------------
        */

        $hasil = [];


        /*
        |--------------------------------------------------------------------------
        | HARDWARE
        |--------------------------------------------------------------------------
        */

        if (
            in_array('hardware', $jenis, true)
            && !empty($kolom['hardware'])
        ) {

            $query = Hardware::query();

            $this->applyWhere(
                $query,
                'tahun_pembelian',
                $filter['hardware_tahun']
            );

            $this->applyWhere(
                $query,
                'kondisi',
                $filter['hardware_kondisi']
            );

            $this->applyWhere(
                $query,
                'jenis_barang',
                $filter['hardware_jenis']
            );

            $this->applyWhere(
                $query,
                'lokasi_id',
                $filter['hardware_lokasi']
            );

            $this->applySearch(
                $query,
                $filter['search'],
                [
                    'asset_id',
                    'nama_barang',
                    'spesifikasi',
                    'jenis_barang',
                    'sistem_operasi',
                    'kondisi',
                ]
            );

            $this->applyOrderByCreatedAt($query);

            $hasil['hardware'] =
                $query
                    ->limit(100)
                    ->get($kolom['hardware']);
        }


        /*
        |--------------------------------------------------------------------------
        | SOFTWARE
        |--------------------------------------------------------------------------
        */

        if (
            in_array('software', $jenis, true)
            && !empty($kolom['software'])
        ) {

            $query = SoftwareAsset::query();

            if (
                $filter['software_tahun'] !== ''
                && $this->hasColumn(
                    (new SoftwareAsset())->getTable(),
                    'tanggal_pengadaan'
                )
            ) {

                $query->whereYear(
                    'tanggal_pengadaan',
                    $filter['software_tahun']
                );
            }

            $this->applyWhere(
                $query,
                'status',
                $filter['software_status']
            );

            $this->applyWhere(
                $query,
                'kategori',
                $filter['software_kategori']
            );

            $this->applyWhere(
                $query,
                'pengadaan',
                $filter['software_pengadaan']
            );

            $this->applyLike(
                $query,
                'pic',
                $filter['software_pic']
            );

            $this->applySearch(
                $query,
                $filter['search'],
                [
                    'kode',
                    'nama_aset',
                    'jenis',
                    'spesifikasi',
                    'kategori',
                    'ssl',
                    'hosting',
                    'pic',
                    'status',
                    'url_homepage',
                    'ip_public',
                    'ip_private',
                    'keterangan',
                ]
            );

            $this->applyOrderByCreatedAt($query);

            $hasil['software'] =
                $query
                    ->limit(100)
                    ->get($kolom['software']);
        }


        /*
        |--------------------------------------------------------------------------
        | JARINGAN
        |--------------------------------------------------------------------------
        */

        if (
            in_array('jaringan', $jenis, true)
            && !empty($kolom['jaringan'])
        ) {

            $query = Jaringan::query();

            $this->applyWhere(
                $query,
                'jenis_data',
                $filter['jaringan_jenis']
            );

            $this->applyLike(
                $query,
                'lokasi',
                $filter['jaringan_lokasi']
            );

            $this->applyWhere(
                $query,
                'verifikasi',
                $filter['jaringan_verifikasi']
            );

            $this->applySearch(
                $query,
                $filter['search'],
                [
                    'id',
                    'jenis_data',
                    'lokasi',
                    'jarak_kabel',
                    'jumlah_core',
                    'jumlah_titik',
                    'verifikasi',
                    'komentar',
                ]
            );

            $this->applyOrderByCreatedAt($query);

            $hasil['jaringan'] =
                $query
                    ->limit(100)
                    ->get($kolom['jaringan']);
        }


        /*
        |--------------------------------------------------------------------------
        | DATA CENTER
        |--------------------------------------------------------------------------
        */

        if (
            in_array('data-center', $jenis, true)
            && !empty($kolom['data-center'])
        ) {

            $query = DataCenter::query();

            $this->applyWhere(
                $query,
                'tahun',
                $filter['datacenter_tahun']
            );

            $this->applyWhere(
                $query,
                'status',
                $filter['datacenter_status']
            );

            $this->applyWhere(
                $query,
                'tenant',
                $filter['datacenter_tenant']
            );

            $this->applyWhere(
                $query,
                'site',
                $filter['datacenter_site']
            );

            $this->applyWhere(
                $query,
                'rack',
                $filter['datacenter_rack']
            );

            $this->applyWhere(
                $query,
                'region',
                $filter['datacenter_region']
            );

            $this->applyWhere(
                $query,
                'manufacturer',
                $filter['datacenter_manufacturer']
            );

            $this->applyWhere(
                $query,
                'verifikasi',
                $filter['datacenter_verifikasi']
            );

            $this->applySearch(
                $query,
                $filter['search'],
                [
                    'id_data_center',
                    'name',
                    'tenant',
                    'site',
                    'rack',
                    'role',
                    'manufacturer',
                    'type',
                    'platform',
                    'serial_number',
                    'ip_address',
                    'cpu',
                    'harddisk',
                    'ram',
                    'pic',
                    'region',
                    'location',
                    'position',
                    'ipv4_address',
                    'cluster',
                    'description',
                    'owner_group',
                    'owner',
                    'verifikasi',
                ]
            );

            $this->applyOrderByCreatedAt($query);

            $hasil['data-center'] =
                $query
                    ->limit(100)
                    ->get($kolom['data-center']);
        }


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        if (
            in_array('data', $jenis, true)
            && !empty($kolom['data'])
        ) {

            $query = Data::query();

            $this->applyWhere(
                $query,
                'tahun',
                $filter['data_tahun']
            );

            $this->applyWhere(
                $query,
                'topik',
                $filter['data_topik']
            );

            $this->applyWhere(
                $query,
                'verifikasi',
                $filter['data_verifikasi']
            );

            $this->applySearch(
                $query,
                $filter['search'],
                [
                    'id',
                    'nama_dataset',
                    'topik',
                    'tahun',
                    'deskripsi',
                    'file_data',
                    'verifikasi',
                    'komentar_verifikasi',
                ]
            );

            $this->applyOrderByCreatedAt($query);

            $hasil['data'] =
                $query
                    ->limit(100)
                    ->get($kolom['data']);
        }


        /*
        |--------------------------------------------------------------------------
        | SDM
        |--------------------------------------------------------------------------
        */

        if (
            in_array('sdm', $jenis, true)
            && !empty($kolom['sdm'])
        ) {

            $query = Sdm::query();

            $this->applyWhere(
                $query,
                'jenis_pegawai',
                $filter['sdm_jenis_pegawai']
            );

            $this->applyWhere(
                $query,
                'jabatan',
                $filter['sdm_jabatan']
            );

            $this->applySearch(
                $query,
                $filter['search'],
                [
                    'id',
                    'nip',
                    'nama',
                    'jabatan',
                    'kompetensi',
                    'jenis_pegawai',
                    'dokumen',
                ]
            );

            $this->applyOrderByCreatedAt($query);

            $hasil['sdm'] =
                $query
                    ->limit(100)
                    ->get($kolom['sdm']);
        }


        /*
        |--------------------------------------------------------------------------
        | PERINGATAN
        |--------------------------------------------------------------------------
        */

        $peringatan = [];

        foreach ($jenis as $jenisLaporan) {

            if (empty($kolom[$jenisLaporan])) {

                $peringatan[] =
                    'Belum ada kolom yang dipilih untuk '
                    . ($jenisLabel[$jenisLaporan] ?? $jenisLaporan)
                    . '.';
            }
        }


        return compact(
            'jenis',
            'jenisConfig',
            'jenisLabel',
            'kolom',
            'kolomDiizinkan',
            'hasil',
            'filter',
            'filterOptions',
            'peringatan'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DISTINCT FILTER OPTIONS
    |--------------------------------------------------------------------------
    */

    private function getDistinctOptions(
        Builder $query,
        string $table,
        string $column,
        bool $descending = false
    ) {
        try {

            if (!$this->hasColumn($table, $column)) {
                return collect();
            }

            $query
                ->whereNotNull($column)
                ->where($column, '!=', '');

            if ($descending) {

                $query
                    ->select($column)
                    ->distinct()
                    ->orderByDesc($column);

            } else {

                $query
                    ->select($column)
                    ->distinct()
                    ->orderBy($column);
            }

            return $query->pluck($column);

        } catch (Throwable $e) {

            Log::warning(
                'Gagal mengambil opsi filter laporan.',
                [
                    'table' => $table,
                    'column' => $column,
                    'message' => $e->getMessage(),
                ]
            );

            return collect();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | TABLE COLUMNS
    |--------------------------------------------------------------------------
    */

    private function getTableColumns(string $table): array
    {
        try {

            return Schema::getColumnListing($table);

        } catch (Throwable $e) {

            Log::warning(
                'Gagal membaca kolom tabel laporan.',
                [
                    'table' => $table,
                    'message' => $e->getMessage(),
                ]
            );

            return [];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | HAS COLUMN
    |--------------------------------------------------------------------------
    */

    private function hasColumn(
        string $table,
        string $column
    ): bool {
        try {

            return Schema::hasColumn(
                $table,
                $column
            );

        } catch (Throwable $e) {

            Log::warning(
                'Gagal mengecek kolom laporan.',
                [
                    'table' => $table,
                    'column' => $column,
                    'message' => $e->getMessage(),
                ]
            );

            return false;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | HAS COLUMNS
    |--------------------------------------------------------------------------
    */

    private function hasColumns(
        string $table,
        array $columns
    ): bool {

        foreach ($columns as $column) {

            if (!$this->hasColumn($table, $column)) {
                return false;
            }
        }

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | APPLY WHERE
    |--------------------------------------------------------------------------
    */

    private function applyWhere(
        Builder $query,
        string $column,
        string $value
    ): void {

        if ($value === '') {
            return;
        }

        $table = $query
            ->getModel()
            ->getTable();

        if (!$this->hasColumn($table, $column)) {
            return;
        }

        $query->where($column, $value);
    }


    /*
    |--------------------------------------------------------------------------
    | APPLY LIKE
    |--------------------------------------------------------------------------
    */

    private function applyLike(
        Builder $query,
        string $column,
        string $value
    ): void {

        if ($value === '') {
            return;
        }

        $table = $query
            ->getModel()
            ->getTable();

        if (!$this->hasColumn($table, $column)) {
            return;
        }

        $query->where(
            $column,
            'like',
            '%' . $value . '%'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | APPLY SEARCH
    |--------------------------------------------------------------------------
    */

    private function applySearch(
        Builder $query,
        string $search,
        array $columns
    ): void {

        $search = trim($search);

        if (
            $search === ''
            || empty($columns)
        ) {
            return;
        }

        $table = $query
            ->getModel()
            ->getTable();

        $databaseColumns =
            $this->getTableColumns($table);

        $validColumns =
            array_values(
                array_intersect(
                    $columns,
                    $databaseColumns
                )
            );

        if (empty($validColumns)) {
            return;
        }

        $query->where(
            function ($q) use (
                $search,
                $validColumns
            ) {

                foreach (
                    $validColumns
                    as $index => $column
                ) {

                    if ($index === 0) {

                        $q->where(
                            $column,
                            'like',
                            '%' . $search . '%'
                        );

                    } else {

                        $q->orWhere(
                            $column,
                            'like',
                            '%' . $search . '%'
                        );
                    }
                }
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ORDER BY CREATED AT
    |--------------------------------------------------------------------------
    */

    private function applyOrderByCreatedAt(
        Builder $query
    ): void {

        $table = $query
            ->getModel()
            ->getTable();

        if (
            $this->hasColumn(
                $table,
                'created_at'
            )
        ) {

            $query->orderByDesc(
                'created_at'
            );
        }
    }
}