<?php

namespace App\Http\Controllers;

use App\Models\SoftwareAsset;
use App\Models\SoftwareCategory;
use App\Models\SoftwareCounter;
use App\Models\SoftwareHosting;
use App\Models\SoftwarePic;
use App\Models\SoftwareSsl;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SoftwareController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = SoftwareAsset::query()->with([
            'category',
            'sslMaster',
            'hostingMaster',
            'picMaster',
        ]);

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama_aset', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhere('ssl', 'like', "%{$search}%")
                    ->orWhere('hosting', 'like', "%{$search}%")
                    ->orWhere('pic', 'like', "%{$search}%")
                    ->orWhere('url_homepage', 'like', "%{$search}%")
                    ->orWhere('ip_public', 'like', "%{$search}%")
                    ->orWhere('ip_private', 'like', "%{$search}%")
                    ->orWhereHas(
                        'category',
                        fn ($q) => $q->where(
                            'nama',
                            'like',
                            "%{$search}%"
                        )
                    )
                    ->orWhereHas(
                        'sslMaster',
                        fn ($q) => $q->where(
                            'nama_ssl',
                            'like',
                            "%{$search}%"
                        )
                    )
                    ->orWhereHas(
                        'hostingMaster',
                        fn ($q) => $q->where(
                            'nama',
                            'like',
                            "%{$search}%"
                        )
                    )
                    ->orWhereHas(
                        'picMaster',
                        fn ($q) => $q->where(
                            'nama',
                            'like',
                            "%{$search}%"
                        )
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */
        if ($request->filled('kategori')) {
            if (is_numeric($request->kategori)) {
                $query->where(
                    'kategori_id',
                    (int) $request->kategori
                );
            } else {
                // Kompatibilitas dengan filter lama.
                $query->where(
                    'kategori',
                    $request->kategori
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER HOSTING
        |--------------------------------------------------------------------------
        */
        if ($request->filled('hosting')) {
            if (is_numeric($request->hosting)) {
                $query->where(
                    'hosting_id',
                    (int) $request->hosting
                );
            } else {
                $query->where(
                    'hosting',
                    $request->hosting
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER PIC
        |--------------------------------------------------------------------------
        */
        if ($request->filled('pic')) {
            if (is_numeric($request->pic)) {
                $query->where(
                    'pic_id',
                    (int) $request->pic
                );
            } else {
                $query->where(
                    'pic',
                    $request->pic
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DATA TABLE
        |--------------------------------------------------------------------------
        */
        $softwares = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */
        $totalAset = SoftwareAsset::count();

        $totalWebsite = SoftwareAsset::whereHas(
            'category',
            fn ($q) => $q->where(
                'nama',
                'Website'
            )
        )->count();

        $totalAplikasiMonitoring = SoftwareAsset::where(
            function ($query) {
                $query->whereRaw(
                    'LOWER(nama_aset) LIKE ?',
                    ['%monitor%']
                )->orWhereRaw(
                    'LOWER(jenis) LIKE ?',
                    ['%monitor%']
                );
            }
        )->count();

        $websiteAktif = SoftwareAsset::whereHas(
            'category',
            fn ($q) => $q->where(
                'nama',
                'Website'
            )
        )
            ->where(
                'status',
                'Aktif'
            )
            ->count();

        $websiteTidakAktif = SoftwareAsset::whereHas(
            'category',
            fn ($q) => $q->where(
                'nama',
                'Website'
            )
        )
            ->where(
                'status',
                'Tidak Aktif'
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK SSL
        |--------------------------------------------------------------------------
        |
        | Tetap mendukung data lama.
        |
        */
        $sslBerlisensi = SoftwareAsset::where(
            function ($q) {
                $q->whereHas(
                    'sslMaster',
                    fn ($ssl) => $ssl->where(
                        'nama_ssl',
                        'SSL Bekasi Kota'
                    )
                )->orWhere(
                    'ssl',
                    'Berlisensi.go.id'
                );
            }
        )->count();

        $sslNonBerlisensi = SoftwareAsset::where(
            function ($q) {
                $q->whereHas(
                    'sslMaster',
                    fn ($ssl) => $ssl->where(
                        'nama_ssl',
                        'SSL Vendor'
                    )
                )->orWhere(
                    'ssl',
                    'Non berlisensi.go.id'
                );
            }
        )->count();

        $sslTidakMenerapkan = SoftwareAsset::where(
            function ($q) {
                $q->whereHas(
                    'sslMaster',
                    fn ($ssl) => $ssl->where(
                        'nama_ssl',
                        'Tidak Menggunakan SSL'
                    )
                )
                    ->orWhere(
                        'ssl',
                        'Tidak Menerapkan SSL'
                    )
                    ->orWhereNull('ssl_id');
            }
        )->count();

        /*
        |--------------------------------------------------------------------------
        | DATA LEGACY
        |--------------------------------------------------------------------------
        */
        $totalLisensi = SoftwareAsset::sum(
            'jumlah_lisensi'
        );

        $today = now()->startOfDay();

        $thirtyDaysLater = now()
            ->copy()
            ->addDays(30)
            ->endOfDay();

        $akanBerakhir = SoftwareAsset::whereNotNull(
            'tanggal_berakhir'
        )
            ->whereBetween(
                'tanggal_berakhir',
                [
                    $today,
                    $thirtyDaysLater,
                ]
            )
            ->count();

        $expired = SoftwareAsset::whereNotNull(
            'tanggal_berakhir'
        )
            ->where(
                'tanggal_berakhir',
                '<',
                $today
            )
            ->count();

        $tersedia = SoftwareAsset::where(
            function ($query) {
                $query->where(
                    'status',
                    'Aktif'
                )->orWhereNull(
                    'status'
                );
            }
        )->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL PENGELUARAN PER TAHUN
        |--------------------------------------------------------------------------
        */
        $allSoftwares = SoftwareAsset::all();

        $totalPengeluaranPertahun = $allSoftwares->sum(
            function ($software) {

                $harga = (float) $software->harga;

                if ($software->pengadaan === 'Beli') {
                    return $harga;
                }

                if (
                    !$software->tanggal_pengadaan ||
                    !$software->tanggal_berakhir
                ) {
                    return 0;
                }

                $jumlahBulan = max(
                    1,
                    $software
                        ->tanggal_pengadaan
                        ->diffInMonths(
                            $software->tanggal_berakhir
                        )
                );

                return (
                    $harga / $jumlahBulan
                ) * 12;
            }
        );

        /*
        |--------------------------------------------------------------------------
        | DATA MASTER AKTIF
        |--------------------------------------------------------------------------
        */
        $kategoriOptions = SoftwareCategory::where(
            'status',
            'Aktif'
        )
            ->orderBy('nama')
            ->get();

        $sslOptions = SoftwareSsl::where(
            'status',
            'Aktif'
        )
            ->orderBy('nama_ssl')
            ->get();

        $hostingOptions = SoftwareHosting::where(
            'status',
            'Aktif'
        )
            ->orderBy('nama')
            ->get();

        $picOptions = SoftwarePic::where(
            'status',
            'Aktif'
        )
            ->orderBy('nama')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */
        return view(
            'software.index',
            compact(
                'softwares',

                'totalAset',
                'totalWebsite',
                'totalAplikasiMonitoring',

                'websiteAktif',
                'websiteTidakAktif',

                'sslBerlisensi',
                'sslNonBerlisensi',
                'sslTidakMenerapkan',

                'totalLisensi',
                'akanBerakhir',
                'expired',
                'tersedia',
                'totalPengeluaranPertahun',

                'kategoriOptions',
                'sslOptions',
                'hostingOptions',
                'picOptions'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $kategoriOptions = SoftwareCategory::where(
            'status',
            'Aktif'
        )
            ->orderBy('nama')
            ->get();

        $sslOptions = SoftwareSsl::where(
            'status',
            'Aktif'
        )
            ->orderBy('nama_ssl')
            ->get();

        $hostingOptions = SoftwareHosting::where(
            'status',
            'Aktif'
        )
            ->orderBy('nama')
            ->get();

        $picOptions = SoftwarePic::where(
            'status',
            'Aktif'
        )
            ->orderBy('nama')
            ->get();

        return view(
            'software.create',
            compact(
                'kategoriOptions',
                'sslOptions',
                'hostingOptions',
                'picOptions'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->softwareRules(),
            [
                'nama_aset.required' =>
                    'Nama aset wajib diisi.',

                'kategori_id.required' =>
                    'Kategori wajib dipilih.',

                'kategori_id.exists' =>
                    'Kategori tidak valid atau sudah tidak aktif.',

                'kategori_sistem_elektronik' => [
                    'nullable',
                    'string',
                    'in:Rendah,Tinggi,Strategis',
                ],

                'ssl_id.exists' =>
                    'SSL tidak valid atau sudah tidak aktif.',

                'hosting_id.required' =>
                    'Hosting wajib dipilih.',

                'hosting_id.exists' =>
                    'Hosting tidak valid atau sudah tidak aktif.',

                'status.required' =>
                    'Status wajib dipilih.',

                'pic_id.required' =>
                    'PIC wajib dipilih.',

                'pic_id.exists' =>
                    'PIC tidak valid atau sudah tidak aktif.',

                'kerahasiaan.required' =>
                    'Nilai kerahasiaan wajib dipilih.',

                'integritas.required' =>
                    'Nilai integritas wajib dipilih.',

                'ketersediaan.required' =>
                    'Nilai ketersediaan wajib dipilih.',

                'ip_public.ip' =>
                    'IP Public tidak valid.',

                'ip_private.ip' =>
                    'IP Private tidak valid.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA MASTER
        |--------------------------------------------------------------------------
        */
        $masters = $this->resolveMasterData(
            $validated
        );

        $validated = array_merge(
            $validated,
            $masters
        );

        /*
        |--------------------------------------------------------------------------
        | HITUNG CIA
        |--------------------------------------------------------------------------
        */
        $nilai = (
            $validated['kerahasiaan'] +
            $validated['integritas'] +
            $validated['ketersediaan']
        ) / 3;

        $validated['nilai'] =
            round(
                $nilai,
                2
            );

        $validated['keterangan'] =
            $this->ciaKeterangan(
                $nilai
            );

        /*
        |--------------------------------------------------------------------------
        | KOMPATIBILITAS FIELD LAMA
        |--------------------------------------------------------------------------
        */
        $validated['jenis'] =
            $validated['nama_aset'];

        $validated['jumlah_lisensi'] =
            $validated['jumlah_lisensi'] ?? 1;

        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA BANTU
        |--------------------------------------------------------------------------
        */
        unset(
            $validated['kategori_name'],
            $validated['ssl_name'],
            $validated['hosting_name'],
            $validated['pic_name']
        );

        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */
        DB::transaction(
            function () use (&$validated) {

                /*
                |--------------------------------------------------------------------------
                | GENERATE KODE
                |--------------------------------------------------------------------------
                */
                $validated['kode'] =
                    $this->generateCode();

                /*
                |--------------------------------------------------------------------------
                | STATUS VERIFIKASI
                |--------------------------------------------------------------------------
                */
                $validated['verifikasi'] =
                    'menunggu';

                $validated['komentar'] =
                    null;

                /*
                |--------------------------------------------------------------------------
                | SIMPAN SOFTWARE
                |--------------------------------------------------------------------------
                */
                $software =
                    SoftwareAsset::create(
                        $validated
                    );

                /*
                |--------------------------------------------------------------------------
                | VERIFICATION REQUEST
                |--------------------------------------------------------------------------
                */
                VerificationRequest::create(
                    [
                        'module' =>
                            'software',

                        'record_id' =>
                            $software->id,

                        'action' =>
                            'create',

                        'data' =>
                            $software->toArray(),

                        'status' =>
                            'menunggu',

                        'submitted_by' =>
                            auth()->id(),
                    ]
                );
            }
        );

        return redirect()
            ->route(
                'software.index'
            )
            ->with(
                'success',
                'Pengajuan penambahan software berhasil dikirim dan menunggu verifikasi.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL / CSV
    |--------------------------------------------------------------------------
    */
    public function import(Request $request)
    {
        $request->validate(
            [
                'file' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls,csv,txt',
                    'max:5120',
                ],
            ],
            [
                'file.required' =>
                    'File Excel/CSV wajib dipilih.',

                'file.file' =>
                    'File yang dipilih tidak valid.',

                'file.mimes' =>
                    'Format file harus XLSX, XLS, CSV, atau TXT.',

                'file.max' =>
                    'Ukuran file maksimal 5 MB.',
            ]
        );

        try {

            /*
            |--------------------------------------------------------------------------
            | LOAD FILE
            |--------------------------------------------------------------------------
            */
            $spreadsheet =
                \PhpOffice\PhpSpreadsheet\IOFactory::load(
                    $request
                        ->file('file')
                        ->getRealPath()
                );

            $sheet =
                $spreadsheet->getActiveSheet();

            $rows =
                $sheet->toArray(
                    null,
                    true,
                    true,
                    false
                );

            if (empty($rows)) {
                return back()->with(
                    'error',
                    'File import kosong atau tidak memiliki data.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | HEADER
            |--------------------------------------------------------------------------
            */
            $rawHeaders =
                array_shift($rows);

            $headers =
                array_map(
                    fn ($header) =>
                        $this->normalizeImportHeader(
                            $header
                        ),
                    $rawHeaders
                );

            $requiredHeaders = [
                'nama_aset',
                'kategori',
                'ssl',
                'url_homepage',
                'ip_public',
                'ip_private',
                'hosting',
                'status',
                'pic',
                'kerahasiaan',
                'integritas',
                'ketersediaan',
                'deskripsi_aplikasi',
            ];

            foreach ($requiredHeaders as $requiredHeader) {

                if (
                    !in_array(
                        $requiredHeader,
                        $headers,
                        true
                    )
                ) {
                    return back()->with(
                        'error',
                        'Kolom "' .
                        str_replace(
                            '_',
                            ' ',
                            $requiredHeader
                        ) .
                        '" tidak ditemukan di file import.'
                    );
                }
            }

            $headerMap =
                array_flip($headers);

            $imported = 0;
            $failed = 0;
            $errors = [];

            /*
            |--------------------------------------------------------------------------
            | TRANSACTION
            |--------------------------------------------------------------------------
            */
            DB::transaction(
                function () use (
                    $rows,
                    $headerMap,
                    &$imported,
                    &$failed,
                    &$errors
                ) {

                    foreach ($rows as $rowNumber => $row) {

                        $excelRow =
                            $rowNumber + 2;

                        if (
                            $this->isImportRowEmpty(
                                $row
                            )
                        ) {
                            continue;
                        }

                        try {

                            $data =
                                $this->getImportRowData(
                                    $row,
                                    $headerMap
                                );

                            /*
                            |--------------------------------------------------------------------------
                            | NAMA
                            |--------------------------------------------------------------------------
                            */
                            $namaAset =
                                trim(
                                    (string)
                                    (
                                        $data['nama_aset']
                                        ?? ''
                                    )
                                );

                            if ($namaAset === '') {
                                throw new \Exception(
                                    'Nama aset wajib diisi.'
                                );
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | MASTER DATA
                            |--------------------------------------------------------------------------
                            */
                            $kategori =
                                $this->nullableImportString(
                                    $data['kategori']
                                    ?? null
                                );

                            $sslRaw =
                                $this->nullableImportString(
                                    $data['ssl']
                                    ?? null
                                );

                            $hosting =
                                $this->nullableImportString(
                                    $data['hosting']
                                    ?? null
                                );

                            $status =
                                $this->nullableImportString(
                                    $data['status']
                                    ?? null
                                );

                            $pic =
                                $this->nullableImportString(
                                    $data['pic']
                                    ?? null
                                );

                            /*
                            |--------------------------------------------------------------------------
                            | KATEGORI
                            |--------------------------------------------------------------------------
                            */
                            $categoryMaster =
                                SoftwareCategory::where(
                                    'status',
                                    'Aktif'
                                )
                                    ->where(
                                        'nama',
                                        $kategori
                                    )
                                    ->first();

                            if (!$categoryMaster) {
                                throw new \Exception(
                                    'Kategori tidak ditemukan di Data Master: ' .
                                    ($kategori ?: '-')
                                );
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | HOSTING
                            |--------------------------------------------------------------------------
                            */
                            $hostingMaster =
                                SoftwareHosting::where(
                                    'status',
                                    'Aktif'
                                )
                                    ->where(
                                        'nama',
                                        $hosting
                                    )
                                    ->first();

                            if (!$hostingMaster) {
                                throw new \Exception(
                                    'Hosting tidak ditemukan di Data Master: ' .
                                    ($hosting ?: '-')
                                );
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | PIC
                            |--------------------------------------------------------------------------
                            */
                            $picMaster =
                                SoftwarePic::where(
                                    'status',
                                    'Aktif'
                                )
                                    ->where(
                                        'nama',
                                        $pic
                                    )
                                    ->first();

                            if (!$picMaster) {
                                throw new \Exception(
                                    'PIC tidak ditemukan di Data Master: ' .
                                    ($pic ?: '-')
                                );
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | SSL
                            |--------------------------------------------------------------------------
                            */
                            $sslMaster =
                                $this->resolveImportSsl(
                                    $sslRaw
                                );

                            /*
                            |--------------------------------------------------------------------------
                            | STATUS
                            |--------------------------------------------------------------------------
                            */
                            if (
                                !in_array(
                                    $status,
                                    [
                                        'Aktif',
                                        'Tidak Aktif',
                                    ],
                                    true
                                )
                            ) {
                                throw new \Exception(
                                    'Status harus Aktif atau Tidak Aktif.'
                                );
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | CIA
                            |--------------------------------------------------------------------------
                            */
                            $kerahasiaan =
                                (int)
                                (
                                    $data['kerahasiaan']
                                    ?? 0
                                );

                            $integritas =
                                (int)
                                (
                                    $data['integritas']
                                    ?? 0
                                );

                            $ketersediaan =
                                (int)
                                (
                                    $data['ketersediaan']
                                    ?? 0
                                );

                            foreach (
                                [
                                    'kerahasiaan' =>
                                        $kerahasiaan,

                                    'integritas' =>
                                        $integritas,

                                    'ketersediaan' =>
                                        $ketersediaan,
                                ]
                                as $field => $value
                            ) {

                                if (
                                    !in_array(
                                        $value,
                                        [1, 2, 3],
                                        true
                                    )
                                ) {
                                    throw new \Exception(
                                        ucfirst($field) .
                                        ' harus 1, 2, atau 3.'
                                    );
                                }
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | IP
                            |--------------------------------------------------------------------------
                            */
                            $ipPublic =
                                $this->nullableImportString(
                                    $data['ip_public']
                                    ?? null
                                );

                            $ipPrivate =
                                $this->nullableImportString(
                                    $data['ip_private']
                                    ?? null
                                );

                            if (
                                $ipPublic !== null &&
                                !filter_var(
                                    $ipPublic,
                                    FILTER_VALIDATE_IP
                                )
                            ) {
                                throw new \Exception(
                                    'IP Public tidak valid: ' .
                                    $ipPublic
                                );
                            }

                            if (
                                $ipPrivate !== null &&
                                !filter_var(
                                    $ipPrivate,
                                    FILTER_VALIDATE_IP
                                )
                            ) {
                                throw new \Exception(
                                    'IP Private tidak valid: ' .
                                    $ipPrivate
                                );
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | CIA RESULT
                            |--------------------------------------------------------------------------
                            */
                            $nilai =
                                round(
                                    (
                                        $kerahasiaan +
                                        $integritas +
                                        $ketersediaan
                                    ) / 3,
                                    2
                                );

                            /*
                            |--------------------------------------------------------------------------
                            | SIMPAN
                            |--------------------------------------------------------------------------
                            */
                            $software =
                                SoftwareAsset::create(
                                    [
                                        'kode' =>
                                            $this->generateCode(),

                                        'nama_aset' =>
                                            $namaAset,

                                        'jenis' =>
                                            $namaAset,

                                        'spesifikasi' =>
                                            null,

                                        /*
                                        | Master ID
                                        */
                                        'kategori_id' =>
                                            $categoryMaster->id,

                                        'ssl_id' =>
                                            $sslMaster?->id,

                                        'hosting_id' =>
                                            $hostingMaster->id,

                                        'pic_id' =>
                                            $picMaster->id,

                                        /*
                                        | Legacy string
                                        */
                                        'kategori' =>
                                            $categoryMaster->nama,

                                        'ssl' =>
                                            $sslMaster?->nama_ssl,

                                        'hosting' =>
                                            $hostingMaster->nama,

                                        'pic' =>
                                            $picMaster->nama,

                                        /*
                                        | Data aplikasi
                                        */
                                        'url_homepage' =>
                                            $this->nullableImportString(
                                                $data['url_homepage']
                                                ?? null
                                            ),

                                        'ip_public' =>
                                            $ipPublic,

                                        'ip_private' =>
                                            $ipPrivate,

                                        'status' =>
                                            $status,

                                        /*
                                        | CIA
                                        */
                                        'kerahasiaan' =>
                                            $kerahasiaan,

                                        'integritas' =>
                                            $integritas,

                                        'ketersediaan' =>
                                            $ketersediaan,

                                        'nilai' =>
                                            $nilai,

                                        'keterangan' =>
                                            $this->ciaKeterangan(
                                                $nilai
                                            ),

                                        'deskripsi_aplikasi' =>
                                            $this->nullableImportString(
                                                $data['deskripsi_aplikasi']
                                                ?? null
                                            ),

                                        /*
                                        | Legacy fields
                                        */
                                        'jumlah_lisensi' =>
                                            1,

                                        'pengadaan' =>
                                            null,

                                        'periode_sewa' =>
                                            null,

                                        'harga' =>
                                            null,

                                        'tanggal_pengadaan' =>
                                            null,

                                        'tanggal_berakhir' =>
                                            null,

                                        /*
                                        | Verification
                                        */
                                        'verifikasi' =>
                                            'menunggu',

                                        'komentar' =>
                                            null,
                                    ]
                                );

                            /*
                            |--------------------------------------------------------------------------
                            | VERIFICATION REQUEST
                            |--------------------------------------------------------------------------
                            */
                            VerificationRequest::create(
                                [
                                    'module' =>
                                        'software',

                                    'record_id' =>
                                        $software->id,

                                    'action' =>
                                        'create',

                                    'data' =>
                                        $software->toArray(),

                                    'status' =>
                                        'menunggu',

                                    'submitted_by' =>
                                        auth()->id(),
                                ]
                            );

                            $imported++;

                        } catch (\Throwable $e) {

                            $failed++;

                            $errors[] =
                                'Baris ' .
                                $excelRow .
                                ': ' .
                                $e->getMessage();
                        }
                    }
                }
            );

            /*
            |--------------------------------------------------------------------------
            | IMPORT GAGAL SEMUA
            |--------------------------------------------------------------------------
            */
            if ($imported === 0) {

                return back()->with(
                    'error',
                    'Tidak ada data yang berhasil diimport. ' .
                    implode(
                        ' | ',
                        array_slice(
                            $errors,
                            0,
                            5
                        )
                    )
                );
            }

            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */
            $message =
                $imported .
                ' data software berhasil diimport dan masuk ke tabel software.';

            if ($failed > 0) {

                $message .=
                    ' ' .
                    $failed .
                    ' baris dilewati karena data tidak valid.';
            }

            return back()
                ->with(
                    'success',
                    $message
                )
                ->with(
                    'import_errors',
                    $errors
                );

        } catch (\Throwable $e) {

            return back()->with(
                'error',
                'Import gagal: ' .
                $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(
        SoftwareAsset $software
    ) {
        return redirect()->route(
            'software.index'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(
        SoftwareAsset $software
    ) {
        $kategoriOptions =
            SoftwareCategory::where(
                'status',
                'Aktif'
            )
                ->orderBy('nama')
                ->get();

        $sslOptions =
            SoftwareSsl::where(
                'status',
                'Aktif'
            )
                ->orderBy('nama_ssl')
                ->get();

        $hostingOptions =
            SoftwareHosting::where(
                'status',
                'Aktif'
            )
                ->orderBy('nama')
                ->get();

        $picOptions =
            SoftwarePic::where(
                'status',
                'Aktif'
            )
                ->orderBy('nama')
                ->get();

        return view(
            'software.edit',
            compact(
                'software',
                'kategoriOptions',
                'sslOptions',
                'hostingOptions',
                'picOptions'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        SoftwareAsset $software
    ) {
        $validated = $request->validate(
            $this->softwareRules(),
            [
                'nama_aset.required' =>
                    'Nama aset wajib diisi.',

                'kategori_id.required' =>
                    'Kategori wajib dipilih.',

                'kategori_id.exists' =>
                    'Kategori tidak valid atau sudah tidak aktif.',

                'kategori_sistem_elektronik' => [
                    'nullable',
                    'string',
                    'in:Rendah,Tinggi,Strategis',
                ],

                'ssl_id.exists' =>
                    'SSL tidak valid atau sudah tidak aktif.',

                'hosting_id.required' =>
                    'Hosting wajib dipilih.',

                'hosting_id.exists' =>
                    'Hosting tidak valid atau sudah tidak aktif.',

                'status.required' =>
                    'Status wajib dipilih.',

                'pic_id.required' =>
                    'PIC wajib dipilih.',

                'pic_id.exists' =>
                    'PIC tidak valid atau sudah tidak aktif.',

                'kerahasiaan.required' =>
                    'Nilai kerahasiaan wajib dipilih.',

                'integritas.required' =>
                    'Nilai integritas wajib dipilih.',

                'ketersediaan.required' =>
                    'Nilai ketersediaan wajib dipilih.',

                'ip_public.ip' =>
                    'IP Public tidak valid.',

                'ip_private.ip' =>
                    'IP Private tidak valid.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | MASTER
        |--------------------------------------------------------------------------
        */
        $masters =
            $this->resolveMasterData(
                $validated
            );

        $validated =
            array_merge(
                $validated,
                $masters
            );

        /*
        |--------------------------------------------------------------------------
        | CIA
        |--------------------------------------------------------------------------
        */
        $nilai = (
            $validated['kerahasiaan'] +
            $validated['integritas'] +
            $validated['ketersediaan']
        ) / 3;

        $validated['nilai'] =
            round(
                $nilai,
                2
            );

        $validated['keterangan'] =
            $this->ciaKeterangan(
                $nilai
            );

        /*
        |--------------------------------------------------------------------------
        | LEGACY
        |--------------------------------------------------------------------------
        */
        $validated['jenis'] =
            $validated['nama_aset'];

        $validated['jumlah_lisensi'] =
            $validated['jumlah_lisensi']
            ?? (
                $software->jumlah_lisensi
                ?: 1
            );

        unset(
            $validated['kategori_name'],
            $validated['ssl_name'],
            $validated['hosting_name'],
            $validated['pic_name']
        );

        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */
        DB::transaction(
            function () use (
                $validated,
                $software
            ) {

                /*
                |--------------------------------------------------------------------------
                | KODE TIDAK BERUBAH
                |--------------------------------------------------------------------------
                */
                unset(
                    $validated['kode']
                );

                /*
                |--------------------------------------------------------------------------
                | VERIFIKASI ULANG
                |--------------------------------------------------------------------------
                */
                $validated['verifikasi'] =
                    'menunggu';

                $validated['komentar'] =
                    null;

                /*
                |--------------------------------------------------------------------------
                | UPDATE
                |--------------------------------------------------------------------------
                */
                $software->update(
                    $validated
                );

                /*
                |--------------------------------------------------------------------------
                | VERIFICATION REQUEST
                |--------------------------------------------------------------------------
                */
                VerificationRequest::create(
                    [
                        'module' =>
                            'software',

                        'record_id' =>
                            $software->id,

                        'action' =>
                            'update',

                        'data' =>
                            $software
                                ->fresh()
                                ->toArray(),

                        'status' =>
                            'menunggu',

                        'submitted_by' =>
                            auth()->id(),
                    ]
                );
            }
        );

        return redirect()
            ->route(
                'software.index'
            )
            ->with(
                'success',
                'Perubahan software berhasil disimpan dan menunggu verifikasi.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy(
        SoftwareAsset $software
    ) {
        DB::transaction(
            function () use (
                $software
            ) {

                /*
                |--------------------------------------------------------------------------
                | TIDAK LANGSUNG HAPUS
                |--------------------------------------------------------------------------
                */
                $software->update(
                    [
                        'verifikasi' =>
                            'menunggu',

                        'komentar' =>
                            null,
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                | REQUEST DELETE
                |--------------------------------------------------------------------------
                */
                VerificationRequest::create(
                    [
                        'module' =>
                            'software',

                        'record_id' =>
                            $software->id,

                        'action' =>
                            'delete',

                        'data' =>
                            $software
                                ->fresh()
                                ->toArray(),

                        'status' =>
                            'menunggu',

                        'submitted_by' =>
                            auth()->id(),
                    ]
                );
            }
        );

        return redirect()
            ->route(
                'software.index'
            )
            ->with(
                'success',
                'Pengajuan penghapusan software berhasil dikirim dan menunggu verifikasi.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION RULES
    |--------------------------------------------------------------------------
    */
    private function softwareRules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | NAMA
            |--------------------------------------------------------------------------
            */
            'nama_aset' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | KATEGORI MASTER
            |--------------------------------------------------------------------------
            */
            'kategori_id' => [
                'required',
                'integer',
                Rule::exists(
                    'software_categories',
                    'id'
                )->where(
                    fn ($q) =>
                        $q->where(
                            'status',
                            'Aktif'
                        )
                ),
            ],

            /*
            |--------------------------------------------------------------------------
            | SSL MASTER
            |--------------------------------------------------------------------------
            */
            'ssl_id' => [
                'nullable',
                'integer',
                Rule::exists(
                    'software_ssls',
                    'id'
                )->where(
                    fn ($q) =>
                        $q->where(
                            'status',
                            'Aktif'
                        )
                ),
            ],

            /*
            |--------------------------------------------------------------------------
            | URL
            |--------------------------------------------------------------------------
            */
            'url_homepage' => [
                'nullable',
                'string',
                'max:500',
            ],

            /*
            |--------------------------------------------------------------------------
            | IP
            |--------------------------------------------------------------------------
            */
            'ip_public' => [
                'nullable',
                'ip',
            ],

            'ip_private' => [
                'nullable',
                'ip',
            ],

            /*
            |--------------------------------------------------------------------------
            | HOSTING MASTER
            |--------------------------------------------------------------------------
            */
            'hosting_id' => [
                'required',
                'integer',
                Rule::exists(
                    'software_hostings',
                    'id'
                )->where(
                    fn ($q) =>
                        $q->where(
                            'status',
                            'Aktif'
                        )
                ),
            ],

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */
            'status' => [
                'required',
                Rule::in(
                    [
                        'Aktif',
                        'Tidak Aktif',
                    ]
                ),
            ],

            /*
            |--------------------------------------------------------------------------
            | PIC MASTER
            |--------------------------------------------------------------------------
            */
            'pic_id' => [
                'required',
                'integer',
                Rule::exists(
                    'software_pics',
                    'id'
                )->where(
                    fn ($q) =>
                        $q->where(
                            'status',
                            'Aktif'
                        )
                ),
            ],

            /*
            |--------------------------------------------------------------------------
            | CIA
            |--------------------------------------------------------------------------
            */
            'kerahasiaan' => [
                'required',
                'integer',
                Rule::in([1, 2, 3]),
            ],

            'integritas' => [
                'required',
                'integer',
                Rule::in([1, 2, 3]),
            ],

            'ketersediaan' => [
                'required',
                'integer',
                Rule::in([1, 2, 3]),
            ],

            /*
            |--------------------------------------------------------------------------
            | DESKRIPSI
            |--------------------------------------------------------------------------
            */
            'deskripsi_aplikasi' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | FIELD LEGACY
            |--------------------------------------------------------------------------
            */
            'spesifikasi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'jumlah_lisensi' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'pengadaan' => [
                'nullable',
                Rule::in(
                    [
                        'Sewa',
                        'Beli',
                    ]
                ),
            ],

            'periode_sewa' => [
                'nullable',
                'string',
                'max:100',
            ],

            'harga' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'tanggal_pengadaan' => [
                'nullable',
                'date',
            ],

            'tanggal_berakhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_pengadaan',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RESOLVE MASTER DATA
    |--------------------------------------------------------------------------
    */
    private function resolveMasterData(
        array $validated
    ): array {
        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */
        $category =
            SoftwareCategory::where(
                'status',
                'Aktif'
            )->findOrFail(
                $validated['kategori_id']
            );

        /*
        |--------------------------------------------------------------------------
        | HOSTING
        |--------------------------------------------------------------------------
        */
        $hosting =
            SoftwareHosting::where(
                'status',
                'Aktif'
            )->findOrFail(
                $validated['hosting_id']
            );

        /*
        |--------------------------------------------------------------------------
        | PIC
        |--------------------------------------------------------------------------
        */
        $pic =
            SoftwarePic::where(
                'status',
                'Aktif'
            )->findOrFail(
                $validated['pic_id']
            );

        /*
        |--------------------------------------------------------------------------
        | SSL
        |--------------------------------------------------------------------------
        */
        $ssl =
            !empty(
                $validated['ssl_id']
            )
                ? SoftwareSsl::where(
                    'status',
                    'Aktif'
                )->findOrFail(
                    $validated['ssl_id']
                )
                : null;

        return [

            /*
            | Legacy string
            */
            'kategori' =>
                $category->nama,

            'ssl' =>
                $ssl?->nama_ssl,

            'hosting' =>
                $hosting->nama,

            'pic' =>
                $pic->nama,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE SOFTWARE CODE
    |--------------------------------------------------------------------------
    */
    private function generateCode(): string
    {
        $year =
            now()->year;

        $counter =
            SoftwareCounter::where(
                'year',
                $year
            )
                ->lockForUpdate()
                ->first();

        if (!$counter) {

            $counter =
                SoftwareCounter::create(
                    [
                        'year' =>
                            $year,

                        'last_number' =>
                            0,
                    ]
                );
        }

        $counter->increment(
            'last_number'
        );

        $number =
            $counter
                ->fresh()
                ->last_number;

        return sprintf(
            'SW-%02d%04d',
            $year % 100,
            $number
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CIA KETERANGAN
    |--------------------------------------------------------------------------
    */
    private function ciaKeterangan(
        float $nilai
    ): string {
        if ($nilai <= 1) {
            return 'Rendah';
        }

        if ($nilai <= 2) {
            return 'Sedang';
        }

        return 'Tinggi';
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT HEADER NORMALIZATION
    |--------------------------------------------------------------------------
    */
    private function normalizeImportHeader(
        $header
    ): string {
        $header =
            trim(
                (string) $header
            );

        $header =
            preg_replace(
                '/\s+/',
                ' ',
                $header
            );

        $header =
            strtolower(
                $header
            );

        $header =
            str_replace(
                [
                    '/',
                    '-',
                    '.',
                ],
                '_',
                $header
            );

        $header =
            preg_replace(
                '/[^a-z0-9_ ]/',
                '',
                $header
            );

        $header =
            str_replace(
                ' ',
                '_',
                $header
            );

        $aliases = [

            'nama_software' =>
                'nama_aset',

            'nama_aset_perangkat_lunak' =>
                'nama_aset',

            'url' =>
                'url_homepage',

            'url_homepage_website' =>
                'url_homepage',

            'deskripsi' =>
                'deskripsi_aplikasi',

            'kerahasiaan_cia' =>
                'kerahasiaan',

            'integritas_cia' =>
                'integritas',

            'ketersediaan_cia' =>
                'ketersediaan',
        ];

        return
            $aliases[$header]
            ?? $header;
    }

    /*
    |--------------------------------------------------------------------------
    | GET IMPORT ROW DATA
    |--------------------------------------------------------------------------
    */
    private function getImportRowData(
        array $row,
        array $headerMap
    ): array {
        $data = [];

        foreach (
            $headerMap
            as $header => $index
        ) {
            $data[$header] =
                $row[$index]
                ?? null;
        }

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK EMPTY IMPORT ROW
    |--------------------------------------------------------------------------
    */
    private function isImportRowEmpty(
        array $row
    ): bool {
        foreach ($row as $value) {

            if (
                $value !== null &&
                trim(
                    (string) $value
                ) !== ''
            ) {
                return false;
            }
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | NULLABLE IMPORT STRING
    |--------------------------------------------------------------------------
    */
    private function nullableImportString(
        $value
    ): ?string {
        $value =
            trim(
                (string) $value
            );

        return
            $value === ''
            ? null
            : $value;
    }

    /*
    |--------------------------------------------------------------------------
    | RESOLVE SSL IMPORT
    |--------------------------------------------------------------------------
    */
    private function resolveImportSsl(
        ?string $value
    ): ?SoftwareSsl {

        /*
        |--------------------------------------------------------------------------
        | KOSONG = TIDAK MENGGUNAKAN SSL
        |--------------------------------------------------------------------------
        */
        if (
            $value === null ||
            $value === ''
        ) {
            return SoftwareSsl::where(
                'status',
                'Aktif'
            )
                ->where(
                    'nama_ssl',
                    'Tidak Menggunakan SSL'
                )
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | CARI BERDASARKAN NAMA SSL
        |--------------------------------------------------------------------------
        */
        $byName =
            SoftwareSsl::where(
                'status',
                'Aktif'
            )
                ->where(
                    'nama_ssl',
                    $value
                )
                ->first();

        if ($byName) {
            return $byName;
        }

        /*
        |--------------------------------------------------------------------------
        | KOMPATIBILITAS:
        | BILA EXCEL MASIH BERISI TANGGAL EXPIRE
        |--------------------------------------------------------------------------
        */
        $date =
            $this->normalizeImportDate(
                $value
            );

        if ($date) {

            return SoftwareSsl::where(
                'status',
                'Aktif'
            )
                ->whereDate(
                    'tanggal_expire',
                    $date
                )
                ->firstOrFail();
        }

        throw new \Exception(
            'SSL tidak ditemukan di Data Master: ' .
            $value
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALIZE IMPORT DATE
    |--------------------------------------------------------------------------
    */
    private function normalizeImportDate(
        $value
    ): ?string {

        if (
            $value === null ||
            trim(
                (string) $value
            ) === ''
        ) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | EXCEL SERIAL DATE
        |--------------------------------------------------------------------------
        */
        if (is_numeric($value)) {

            try {

                return
                    \PhpOffice\PhpSpreadsheet\Shared\Date
                        ::excelToDateTimeObject(
                            (float) $value
                        )
                        ->format(
                            'Y-m-d'
                        );

            } catch (\Throwable $e) {

                return null;
            }
        }

        $value =
            trim(
                (string) $value
            );

        /*
        |--------------------------------------------------------------------------
        | FORMAT DATE
        |--------------------------------------------------------------------------
        */
        foreach (
            [
                'Y-m-d',
                'd-m-Y',
                'd/m/Y',
                'm/d/Y',
                'd M Y',
                'd F Y',
            ]
            as $format
        ) {

            try {

                $date =
                    \DateTime::createFromFormat(
                        $format,
                        $value
                    );

                if (
                    $date &&
                    $date->format(
                        $format
                    ) === $value
                ) {
                    return
                        $date->format(
                            'Y-m-d'
                        );
                }

            } catch (\Throwable $e) {
                // Lanjut format berikutnya.
            }
        }

        return null;
    }
}