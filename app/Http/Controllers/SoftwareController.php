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
        |
        | Wajib paginate karena Blade menggunakan:
        | - total()
        | - firstItem()
        | - hasPages()
        | - withQueryString()
        |
        */

        $softwares = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | QUERY STATISTIK
        |--------------------------------------------------------------------------
        |
        | Statistik menggunakan seluruh data.
        | Jadi ketika tabel difilter, angka statistik tidak ikut berubah.
        |
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
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | MASTER DATA
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
        | HITUNG NILAI CIA
        |--------------------------------------------------------------------------
        */

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

        DB::transaction(function () use (&$validated) {

            /*
            |--------------------------------------------------------------------------
            | KODE
            |--------------------------------------------------------------------------
            */

            $validated['kode'] =
                $this->generateCode();


            /*
            |--------------------------------------------------------------------------
            | VERIFIKASI
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
            |--------------------------------------------------------------------------
            | NOTIFICATION
            |--------------------------------------------------------------------------
            */

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


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

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
            ->orderBy('nama')
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
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | MASTER DATA
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


        unset(
            $validated['kategori_name'],
            $validated['ssl_name'],
            $validated['hosting_name'],
            $validated['pic_name']
        );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KODE LAMA
        |--------------------------------------------------------------------------
        */

        $kodeSoftware =
            $software->kode;


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $validated,
            $software,
            $kodeSoftware
        ) {

            /*
            |--------------------------------------------------------------------------
            | KODE TETAP
            |--------------------------------------------------------------------------
            */

            $validated['kode'] =
                $kodeSoftware;


            /*
            |--------------------------------------------------------------------------
            | VERIFIKASI
            |--------------------------------------------------------------------------
            */

            $validated['verifikasi'] =
                'menunggu';

            $validated['komentar'] =
                null;


            /*
            |--------------------------------------------------------------------------
            | UPDATE SOFTWARE
            |--------------------------------------------------------------------------
            */

            $software->update(
                $validated
            );

            $software->refresh();


            /*
            |--------------------------------------------------------------------------
            | VERIFICATION REQUEST
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | NOTIFICATION
            |--------------------------------------------------------------------------
            */

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


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

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
     *
     * Data tidak langsung dihapus.
     * Penghapusan dikirim sebagai request verifikasi.
     */
    public function destroy(
        SoftwareAsset $software
    ) {
        /*
        |--------------------------------------------------------------------------
        | SIMPAN INFORMASI
        |--------------------------------------------------------------------------
        */

        $namaSoftware =
            $software->nama_aset
            ?: $software->jenis
            ?: '-';

        $kodeSoftware =
            $software->kode
            ?: '-';


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $software,
            $namaSoftware,
            $kodeSoftware
        ) {

            /*
            |--------------------------------------------------------------------------
            | TANDAI MENUNGGU VERIFIKASI
            |--------------------------------------------------------------------------
            */

            $software->update([
                'verifikasi' =>
                    'menunggu',

                'komentar' =>
                    null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | REQUEST PENGHAPUSAN
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | NOTIFICATION
            |--------------------------------------------------------------------------
            */

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


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('software.index')
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
            | KATEGORI
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
            | SSL
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
            | HOSTING
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

                Rule::in([
                    'Aktif',
                    'Tidak Aktif',
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | PIC
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

        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        $category =
            SoftwareCategory::where(
                'status',
                'Aktif'
            )
            ->findOrFail(
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
            )
            ->findOrFail(
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
            )
            ->findOrFail(
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
        | KOMPATIBILITAS TANGGAL EXPIRE
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

                // Lanjut ke format berikutnya.

            }

        }


        return null;
    }
}