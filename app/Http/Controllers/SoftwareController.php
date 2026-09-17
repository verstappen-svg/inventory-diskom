<?php

namespace App\Http\Controllers;

use App\Models\SoftwareAsset;
use App\Models\SoftwareCategory;
use App\Models\SoftwareCounter;
use App\Models\SoftwareSsl;
use App\Models\SoftwareHosting;
use App\Models\SoftwarePic;
use App\Models\Notification;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SoftwareController extends Controller
{
    /**
     * ============================================================
     * INDEX
     * ============================================================
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATA MASTER
        |--------------------------------------------------------------------------
        */

        $kategoriOptions = SoftwareCategory::where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        $sslOptions = SoftwareSsl::where('status', 'Aktif')
            ->orderBy('nama_ssl')
            ->get();

        $hostingOptions = SoftwareHosting::where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        $picOptions = SoftwarePic::where('status', 'Aktif')
            ->orderBy('nama')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | QUERY TABEL SOFTWARE
        |--------------------------------------------------------------------------
        */

        $query = SoftwareAsset::query()
            ->with([
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
                    ->orWhereHas('category', function ($q) use ($search) {

                        $q->where(
                            'nama',
                            'like',
                            "%{$search}%"
                        );

                    })
                    ->orWhereHas('sslMaster', function ($q) use ($search) {

                        $q->where(
                            'nama_ssl',
                            'like',
                            "%{$search}%"
                        );

                    })
                    ->orWhereHas('hostingMaster', function ($q) use ($search) {

                        $q->where(
                            'nama',
                            'like',
                            "%{$search}%"
                        );

                    })
                    ->orWhereHas('picMaster', function ($q) use ($search) {

                        $q->where(
                            'nama',
                            'like',
                            "%{$search}%"
                        );

                    });

            });

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kategori')) {

            $kategori = $request->kategori;

            $query->where(function ($q) use ($kategori) {

                $q->where('kategori', $kategori)
                    ->orWhereHas('category', function ($categoryQuery) use ($kategori) {

                        $categoryQuery->where(
                            'nama',
                            $kategori
                        );

                    });

            });

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER HOSTING
        |--------------------------------------------------------------------------
        */

        if ($request->filled('hosting')) {

            $hosting = $request->hosting;

            $query->where(function ($q) use ($hosting) {

                $q->where('hosting', $hosting)
                    ->orWhereHas('hostingMaster', function ($hostingQuery) use ($hosting) {

                        $hostingQuery->where(
                            'nama',
                            $hosting
                        );

                    });

            });

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

            $pic = $request->pic;

            $query->where(function ($q) use ($pic) {

                $q->where('pic', $pic)
                    ->orWhereHas('picMaster', function ($picQuery) use ($pic) {

                        $picQuery->where(
                            'nama',
                            $pic
                        );

                    });

            });

        }


        /*
        |--------------------------------------------------------------------------
        | DATA TABEL
        |--------------------------------------------------------------------------
        */

        $softwares = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $allSoftwareQuery = SoftwareAsset::query();


        /*
        |--------------------------------------------------------------------------
        | TOTAL ASET
        |--------------------------------------------------------------------------
        */

        $totalAset = (clone $allSoftwareQuery)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL WEBSITE
        |--------------------------------------------------------------------------
        */

        $totalWebsite = (clone $allSoftwareQuery)
            ->where(function ($q) {

                $q->where(
                    'kategori',
                    'Website'
                )
                ->orWhereHas('category', function ($categoryQuery) {

                    $categoryQuery->where(
                        'nama',
                        'Website'
                    );

                });

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL APLIKASI MONITORING
        |--------------------------------------------------------------------------
        */

        $totalAplikasiMonitoring = (clone $allSoftwareQuery)
            ->where(function ($q) {

                $q->where(
                    'kategori',
                    'Aplikasi Monitoring'
                )
                ->orWhere(
                    'jenis',
                    'Aplikasi Monitoring'
                )
                ->orWhere(
                    'nama_aset',
                    'like',
                    '%Monitoring%'
                )
                ->orWhereHas('category', function ($categoryQuery) {

                    $categoryQuery->where(
                        'nama',
                        'Aplikasi Monitoring'
                    );

                });

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | WEBSITE AKTIF
        |--------------------------------------------------------------------------
        */

        $websiteAktif = (clone $allSoftwareQuery)
            ->where(
                'status',
                'Aktif'
            )
            ->where(function ($q) {

                $q->where(
                    'kategori',
                    'Website'
                )
                ->orWhereHas('category', function ($categoryQuery) {

                    $categoryQuery->where(
                        'nama',
                        'Website'
                    );

                });

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | WEBSITE TIDAK AKTIF
        |--------------------------------------------------------------------------
        */

        $websiteTidakAktif = (clone $allSoftwareQuery)
            ->where(
                'status',
                'Tidak Aktif'
            )
            ->where(function ($q) {

                $q->where(
                    'kategori',
                    'Website'
                )
                ->orWhereHas('category', function ($categoryQuery) {

                    $categoryQuery->where(
                        'nama',
                        'Website'
                    );

                });

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SSL BERLISENSI
        |--------------------------------------------------------------------------
        */

        $sslBerlisensi = (clone $allSoftwareQuery)
            ->where(function ($q) {

                $q->where(
                    'ssl',
                    'Berlisensi.go.id'
                )
                ->orWhereHas('sslMaster', function ($sslQuery) {

                    $sslQuery->where(
                        'nama_ssl',
                        'Berlisensi.go.id'
                    );

                });

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SSL NON BERLISENSI
        |--------------------------------------------------------------------------
        */

        $sslNonBerlisensi = (clone $allSoftwareQuery)
            ->where(function ($q) {

                $q->where(
                    'ssl',
                    'Non berlisensi.go.id'
                )
                ->orWhereHas('sslMaster', function ($sslQuery) {

                    $sslQuery->where(
                        'nama_ssl',
                        'Non berlisensi.go.id'
                    );

                });

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SSL TIDAK MENERAPKAN
        |--------------------------------------------------------------------------
        */

        $sslTidakMenerapkan = (clone $allSoftwareQuery)
            ->where(function ($q) {

                $q->whereIn('ssl', [
                    'Tidak Menerapkan SSL',
                    'Tidak Menggunakan SSL',
                ])
                ->orWhereHas('sslMaster', function ($sslQuery) {

                    $sslQuery->whereIn('nama_ssl', [
                        'Tidak Menerapkan SSL',
                        'Tidak Menggunakan SSL',
                    ]);

                });

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
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

                'kategoriOptions',
                'sslOptions',
                'hostingOptions',
                'picOptions'
            )
        );
    }


    /**
     * ============================================================
     * CREATE
     * ============================================================
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


    /**
     * ============================================================
     * STORE
     * ============================================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->softwareRules(),
            [
                'nama_aset.required' =>
                    'Nama aset software wajib diisi.',

                'kategori_id.required' =>
                    'Kategori wajib dipilih.',

                'kategori_id.exists' =>
                    'Kategori tidak valid atau sudah tidak aktif.',

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

                'tanggal_berakhir.after_or_equal' =>
                    'Tanggal berakhir tidak boleh sebelum tanggal pengadaan.',
            ]
        );


        $masters = $this->resolveMasterData(
            $validated
        );

        $validated = array_merge(
            $validated,
            $masters
        );


        $nilai = (
            $validated['kerahasiaan'] +
            $validated['integritas'] +
            $validated['ketersediaan']
        ) / 3;

        $validated['nilai'] = round(
            $nilai,
            2
        );

        $validated['keterangan'] =
            $this->ciaKeterangan(
                $nilai
            );


        $validated['jenis'] =
            $validated['nama_aset'];

        $validated['jumlah_lisensi'] =
            $validated['jumlah_lisensi'] ?? 1;


        unset(
            $validated['kategori_name'],
            $validated['ssl_name'],
            $validated['hosting_name'],
            $validated['pic_name']
        );


        DB::transaction(function () use (&$validated) {

            $validated['kode'] =
                $this->generateCode();

            $validated['verifikasi'] =
                'menunggu';

            $validated['komentar'] =
                null;


            $software =
                SoftwareAsset::create(
                    $validated
                );


            VerificationRequest::create([
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
            ]);


            Notification::create([
                'judul' =>
                    'Pengajuan Software Baru',

                'pesan' =>
                    auth()->user()->username .
                    ' menambahkan software "' .
                    ($software->nama_aset ?: $software->jenis) .
                    '" dengan kode ' .
                    $software->kode .
                    ' dan mengajukannya untuk persetujuan.',

                'dibaca' =>
                    false,
            ]);
        });


        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Pengajuan penambahan software berhasil dikirim dan menunggu verifikasi.'
            );
    }


    /**
     * ============================================================
     * EDIT
     * ============================================================
     */
    public function edit(
        SoftwareAsset $software
    ) {
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
            ->orderBy('nama'
            )
            ->get();

        $picOptions = SoftwarePic::where(
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


    /**
     * ============================================================
     * UPDATE
     * ============================================================
     */
    public function update(
        Request $request,
        SoftwareAsset $software
    ) {
        $validated = $request->validate(
            $this->softwareRules(),
            [
                'nama_aset.required' =>
                    'Nama aset software wajib diisi.',

                'kategori_id.required' =>
                    'Kategori wajib dipilih.',

                'kategori_id.exists' =>
                    'Kategori tidak valid atau sudah tidak aktif.',

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

                'tanggal_berakhir.after_or_equal' =>
                    'Tanggal berakhir tidak boleh sebelum tanggal pengadaan.',
            ]
        );


        $masters = $this->resolveMasterData(
            $validated
        );

        $validated = array_merge(
            $validated,
            $masters
        );


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


        $validated['jenis'] =
            $validated['nama_aset'];

        $validated['jumlah_lisensi'] =
            $validated['jumlah_lisensi'] ?? 1;


        unset(
            $validated['kategori_name'],
            $validated['ssl_name'],
            $validated['hosting_name'],
            $validated['pic_name']
        );


        $kodeSoftware =
            $software->kode;


        DB::transaction(function () use (
            $validated,
            $software,
            $kodeSoftware
        ) {

            $validated['kode'] =
                $kodeSoftware;

            $validated['verifikasi'] =
                'menunggu';

            $validated['komentar'] =
                null;


            $software->update(
                $validated
            );

            $software->refresh();


            VerificationRequest::create([
                'module' =>
                    'software',

                'record_id' =>
                    $software->id,

                'action' =>
                    'update',

                'data' =>
                    $software->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);


            Notification::create([
                'judul' =>
                    'Perubahan Software Diajukan',

                'pesan' =>
                    auth()->user()->username .
                    ' memperbarui software "' .
                    ($software->nama_aset ?: $software->jenis) .
                    '" dengan kode ' .
                    $software->kode .
                    ' dan mengajukannya kembali untuk persetujuan.',

                'dibaca' =>
                    false,
            ]);
        });


        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Perubahan software berhasil disimpan dan menunggu verifikasi.'
            );
    }


    /**
     * ============================================================
     * DESTROY
     * ============================================================
     */
    public function destroy(
        SoftwareAsset $software
    ) {
        $namaSoftware =
            $software->nama_aset
            ?: $software->jenis
            ?: '-';

        $kodeSoftware =
            $software->kode
            ?: '-';


        DB::transaction(function () use (
            $software,
            $namaSoftware,
            $kodeSoftware
        ) {

            $software->update([
                'verifikasi' =>
                    'menunggu',

                'komentar' =>
                    null,
            ]);


            VerificationRequest::create([
                'module' =>
                    'software',

                'record_id' =>
                    $software->id,

                'action' =>
                    'delete',

                'data' =>
                    $software->fresh()->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);


            Notification::create([
                'judul' =>
                    'Penghapusan Software Diajukan',

                'pesan' =>
                    auth()->user()->username .
                    ' mengajukan penghapusan software "' .
                    $namaSoftware .
                    '" dengan kode ' .
                    $kodeSoftware .
                    ' untuk persetujuan verifikator.',

                'dibaca' =>
                    false,
            ]);
        });


        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Pengajuan penghapusan software berhasil dikirim dan menunggu verifikasi.'
            );
    }


    /**
     * ============================================================
     * IMPORT
     * ============================================================
     */
    public function import(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI FILE
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:5120',
            ],
        ], [
            'file.required' =>
                'File Excel wajib dipilih.',

            'file.file' =>
                'File import tidak valid.',

            'file.mimes' =>
                'File harus berformat XLSX, XLS, atau CSV.',

            'file.max' =>
                'Ukuran file maksimal 5 MB.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | BACA FILE
        |--------------------------------------------------------------------------
        */

        try {

            $file =
                $request->file('file');

            $reader =
                IOFactory::createReaderForFile(
                    $file->getRealPath()
                );

            $reader->setReadDataOnly(true);

            $spreadsheet =
                $reader->load(
                    $file->getRealPath()
                );

            $worksheet =
                $spreadsheet->getActiveSheet();

            $rows =
                $worksheet->toArray(
                    null,
                    true,
                    true,
                    false
                );

        } catch (\Throwable $e) {

            return back()
                ->with(
                    'error',
                    'File gagal dibaca: ' .
                    $e->getMessage()
                );
        }


        if (empty($rows)) {

            return back()
                ->with(
                    'error',
                    'File Excel kosong.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        $rawHeaders =
            array_shift(
                $rows
            );

        $headerMap = [];


        foreach (
            $rawHeaders
            as $index => $header
        ) {

            $normalized =
                $this->normalizeImportHeader(
                    $header
                );

            if ($normalized !== '') {

                $headerMap[$normalized] =
                    $index;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | HEADER WAJIB
        |--------------------------------------------------------------------------
        */

        $requiredHeaders = [
            'nama_aset',
            'kategori',
            'hosting',
            'status',
            'pic',
            'kerahasiaan',
            'integritas',
            'ketersediaan',
        ];


        $missingHeaders = [];


        foreach (
            $requiredHeaders
            as $required
        ) {

            if (
                !array_key_exists(
                    $required,
                    $headerMap
                )
            ) {

                $missingHeaders[] =
                    $required;

            }

        }


        if (!empty($missingHeaders)) {

            return back()
                ->with(
                    'error',
                    'Kolom Excel wajib tidak ditemukan: ' .
                    implode(
                        ', ',
                        $missingHeaders
                    )
                );

        }


        /*
        |--------------------------------------------------------------------------
        | IMPORT
        |--------------------------------------------------------------------------
        */

        try {

            DB::transaction(function () use (
                $rows,
                $headerMap
            ) {

                foreach (
                    $rows as $rowNumber => $row
                ) {

                    $excelRowNumber =
                        $rowNumber + 2;


                    /*
                    |--------------------------------------------------------------
                    | BARIS KOSONG
                    |--------------------------------------------------------------
                    */

                    if (
                        $this->isImportRowEmpty(
                            $row
                        )
                    ) {

                        continue;

                    }


                    /*
                    |--------------------------------------------------------------
                    | DATA ROW
                    |--------------------------------------------------------------
                    */

                    $data =
                        $this->getImportRowData(
                            $row,
                            $headerMap
                        );


                    /*
                    |--------------------------------------------------------------
                    | DATA DASAR
                    |--------------------------------------------------------------
                    */

                    $namaAset =
                        $this->nullableImportString(
                            $data['nama_aset']
                        );

                    $kategoriNama =
                        $this->nullableImportString(
                            $data['kategori']
                        );

                    $hostingNama =
                        $this->nullableImportString(
                            $data['hosting']
                        );

                    $picNama =
                        $this->nullableImportString(
                            $data['pic']
                        );

                    $status =
                        $this->nullableImportString(
                            $data['status']
                        );


                    if (!$namaAset) {

                        throw new \Exception(
                            "Baris {$excelRowNumber}: Nama aset wajib diisi."
                        );

                    }

                    if (!$kategoriNama) {

                        throw new \Exception(
                            "Baris {$excelRowNumber}: Kategori wajib diisi."
                        );

                    }

                    if (!$hostingNama) {

                        throw new \Exception(
                            "Baris {$excelRowNumber}: Hosting wajib diisi."
                        );

                    }

                    if (!$picNama) {

                        throw new \Exception(
                            "Baris {$excelRowNumber}: PIC wajib diisi."
                        );

                    }

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
                            "Baris {$excelRowNumber}: Status harus Aktif atau Tidak Aktif."
                        );

                    }


                    /*
                    |--------------------------------------------------------------
                    | KATEGORI MASTER
                    |--------------------------------------------------------------
                    */

                    $category =
                        SoftwareCategory::where(
                            'status',
                            'Aktif'
                        )
                        ->where(
                            'nama',
                            $kategoriNama
                        )
                        ->first();


                    if (!$category) {

                        throw new \Exception(
                            "Baris {$excelRowNumber}: Kategori '{$kategoriNama}' tidak ditemukan di Data Master atau tidak aktif."
                        );

                    }


                    /*
                    |--------------------------------------------------------------
                    | HOSTING MASTER
                    |--------------------------------------------------------------
                    */

                    $hosting =
                        SoftwareHosting::where(
                            'status',
                            'Aktif'
                        )
                        ->where(
                            'nama',
                            $hostingNama
                        )
                        ->first();


                    if (!$hosting) {

                        throw new \Exception(
                            "Baris {$excelRowNumber}: Hosting '{$hostingNama}' tidak ditemukan di Data Master atau tidak aktif."
                        );

                    }


                    /*
                    |--------------------------------------------------------------
                    | PIC MASTER
                    |--------------------------------------------------------------
                    */

                    $pic =
                        SoftwarePic::where(
                            'status',
                            'Aktif'
                        )
                        ->where(
                            'nama',
                            $picNama
                        )
                        ->first();


                    if (!$pic) {

                        throw new \Exception(
                            "Baris {$excelRowNumber}: PIC '{$picNama}' tidak ditemukan di Data Master atau tidak aktif."
                        );

                    }


                    /*
                    |--------------------------------------------------------------
                    | SSL MASTER
                    |--------------------------------------------------------------
                    */

                    $sslValue =
                        $this->nullableImportString(
                            $data['ssl'] ?? null
                        );

                    try {

                        $ssl =
                            $this->resolveImportSsl(
                                $sslValue
                            );

                    } catch (\Throwable $e) {

                        throw new \Exception(
                            "Baris {$excelRowNumber}: " .
                            $e->getMessage()
                        );

                    }


                    /*
                    |--------------------------------------------------------------
                    | CIA
                    |--------------------------------------------------------------
                    */

                    $kerahasiaan =
                        (int) (
                            $data['kerahasiaan']
                            ?? 0
                        );

                    $integritas =
                        (int) (
                            $data['integritas']
                            ?? 0
                        );

                    $ketersediaan =
                        (int) (
                            $data['ketersediaan']
                            ?? 0
                        );


                    $ciaValues = [
                        'Kerahasiaan' =>
                            $kerahasiaan,

                        'Integritas' =>
                            $integritas,

                        'Ketersediaan' =>
                            $ketersediaan,
                    ];


                    foreach (
                        $ciaValues as $label => $value
                    ) {

                        if (
                            !in_array(
                                $value,
                                [
                                    1,
                                    2,
                                    3,
                                ],
                                true
                            )
                        ) {

                            throw new \Exception(
                                "Baris {$excelRowNumber}: {$label} harus bernilai 1, 2, atau 3."
                            );

                        }

                    }


                    /*
                    |--------------------------------------------------------------
                    | NILAI CIA
                    |--------------------------------------------------------------
                    */

                    $nilai =
                        (
                            $kerahasiaan +
                            $integritas +
                            $ketersediaan
                        ) / 3;


                    /*
                    |--------------------------------------------------------------
                    | DATA SOFTWARE
                    |--------------------------------------------------------------
                    */

                    $softwareData = [

                        'kode' =>
                            $this->generateCode(),

                        'nama_aset' =>
                            $namaAset,

                        'jenis' =>
                            $namaAset,

                        'spesifikasi' =>
                            $this->nullableImportString(
                                $data['spesifikasi']
                                ?? null
                            ),

                        'jumlah_lisensi' =>
                            !empty(
                                $data['jumlah_lisensi']
                                ?? null
                            )
                            ? (int) $data['jumlah_lisensi']
                            : 1,

                        'pengadaan' =>
                            $this->nullableImportString(
                                $data['pengadaan']
                                ?? null
                            ),

                        'harga' =>
                            !empty(
                                $data['harga']
                                ?? null
                            )
                            ? $data['harga']
                            : null,

                        'tanggal_pengadaan' =>
                            $this->normalizeImportDate(
                                $data['tanggal_pengadaan']
                                ?? null
                            ),

                        'tanggal_berakhir' =>
                            $this->normalizeImportDate(
                                $data['tanggal_berakhir']
                                ?? null
                            ),

                        'periode_sewa' =>
                            $this->nullableImportString(
                                $data['periode_sewa']
                                ?? null
                            ),

                        'kategori_id' =>
                            $category->id,

                        'kategori' =>
                            $category->nama,

                        'ssl_id' =>
                            $ssl?->id,

                        'ssl' =>
                            $ssl?->nama_ssl,

                        'hosting_id' =>
                            $hosting->id,

                        'hosting' =>
                            $hosting->nama,

                        'pic_id' =>
                            $pic->id,

                        'pic' =>
                            $pic->nama,

                        'url_homepage' =>
                            $this->nullableImportString(
                                $data['url_homepage']
                                ?? null
                            ),

                        'ip_public' =>
                            $this->nullableImportString(
                                $data['ip_public']
                                ?? null
                            ),

                        'ip_private' =>
                            $this->nullableImportString(
                                $data['ip_private']
                                ?? null
                            ),

                        'status' =>
                            $status,

                        'kerahasiaan' =>
                            $kerahasiaan,

                        'integritas' =>
                            $integritas,

                        'ketersediaan' =>
                            $ketersediaan,

                        'nilai' =>
                            round(
                                $nilai,
                                2
                            ),

                        'keterangan' =>
                            $this->ciaKeterangan(
                                $nilai
                            ),

                        'deskripsi_aplikasi' =>
                            $this->nullableImportString(
                                $data['deskripsi_aplikasi']
                                ?? null
                            ),

                        'verifikasi' =>
                            'menunggu',

                        'komentar' =>
                            null,
                    ];


                    /*
                    |--------------------------------------------------------------
                    | VALIDASI TANGGAL
                    |--------------------------------------------------------------
                    */

                    if (
                        $softwareData['tanggal_pengadaan'] &&
                        $softwareData['tanggal_berakhir'] &&
                        $softwareData['tanggal_berakhir']
                            < $softwareData['tanggal_pengadaan']
                    ) {

                        throw new \Exception(
                            "Baris {$excelRowNumber}: Tanggal berakhir tidak boleh sebelum tanggal pengadaan."
                        );

                    }


                    /*
                    |--------------------------------------------------------------
                    | SIMPAN
                    |--------------------------------------------------------------
                    */

                    $software =
                        SoftwareAsset::create(
                            $softwareData
                        );


                    /*
                    |--------------------------------------------------------------
                    | VERIFICATION REQUEST
                    |--------------------------------------------------------------
                    */

                    VerificationRequest::create([
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
                    ]);


                    /*
                    |--------------------------------------------------------------
                    | NOTIFICATION
                    |--------------------------------------------------------------
                    */

                    Notification::create([
                        'judul' =>
                            'Import Software Baru',

                        'pesan' =>
                            auth()->user()->username .
                            ' mengimport software "' .
                            ($software->nama_aset ?: $software->jenis) .
                            '" dengan kode ' .
                            $software->kode .
                            ' dan mengajukannya untuk persetujuan.',

                        'dibaca' =>
                            false,
                    ]);

                }

            });

        } catch (\Throwable $e) {

            return back()
                ->with(
                    'error',
                    'Import gagal: ' .
                    $e->getMessage()
                );

        }


        /*
        |--------------------------------------------------------------------------
        | BERHASIL
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Data software berhasil diimport dan diajukan untuk verifikasi.'
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

            'nama_aset' => [
                'required',
                'string',
                'max:255',
            ],

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

            'url_homepage' => [
                'nullable',
                'string',
                'max:500',
            ],

            'ip_public' => [
                'nullable',
                'ip',
            ],

            'ip_private' => [
                'nullable',
                'ip',
            ],

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

            'status' => [
                'required',

                Rule::in([
                    'Aktif',
                    'Tidak Aktif',
                ]),
            ],

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

            'kerahasiaan' => [
                'required',
                'integer',

                Rule::in([
                    1,
                    2,
                    3,
                ]),
            ],

            'integritas' => [
                'required',
                'integer',

                Rule::in([
                    1,
                    2,
                    3,
                ]),
            ],

            'ketersediaan' => [
                'required',
                'integer',

                Rule::in([
                    1,
                    2,
                    3,
                ]),
            ],

            'deskripsi_aplikasi' => [
                'nullable',
                'string',
            ],

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

                Rule::in([
                    'Sewa',
                    'Beli',
                ]),
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

        $category =
            SoftwareCategory::where(
                'status',
                'Aktif'
            )
            ->findOrFail(
                $validated['kategori_id']
            );


        $hosting =
            SoftwareHosting::where(
                'status',
                'Aktif'
            )
            ->findOrFail(
                $validated['hosting_id']
            );


        $pic =
            SoftwarePic::where(
                'status',
                'Aktif'
            )
            ->findOrFail(
                $validated['pic_id']
            );


        $ssl =
            !empty(
                $validated['ssl_id']
            )
            ? SoftwareSsl::where(
                'status',
                'Aktif'
            )
            ->findOrFail(
                $validated['ssl_id']
            )
            : null;


        return [

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
                SoftwareCounter::create([
                    'year' =>
                        $year,

                    'last_number' =>
                        0,
                ]);

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
        | KOSONG
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
        | CARI NAMA SSL
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
        | CARI BERDASARKAN TANGGAL EXPIRE
        |--------------------------------------------------------------------------
        */

        $date =
            $this->normalizeImportDate(
                $value
            );


        if ($date) {

            $ssl =
                SoftwareSsl::where(
                    'status',
                    'Aktif'
                )
                ->whereDate(
                    'tanggal_expire',
                    $date
                )
                ->first();


            if ($ssl) {
                return $ssl;
            }

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
        | FORMAT TANGGAL
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

                // Lanjut ke format berikutnya.

            }

        }


        return null;
    }
}