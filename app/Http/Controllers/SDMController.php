<?php

namespace App\Http\Controllers;

use App\Models\Sdm;
use App\Models\Notification;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SDMController extends Controller
{
    /**
     * ============================================================
     * INDEX
     * ============================================================
     */
    public function index(Request $request)
    {
        $query = Sdm::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('kompetensi', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS PEGAWAI
        |
        | Jenis pegawai ditentukan dari panjang NIP:
        | 18 digit = PNS
        | 20 digit = PPPK
        |--------------------------------------------------------------------------
        */
        if ($request->filled('jenis_pegawai')) {
            $jenisPegawai = strtoupper(
                trim($request->jenis_pegawai)
            );

            if ($jenisPegawai === 'PNS') {

                $query->whereRaw(
                    'CHAR_LENGTH(nip) = 18'
                );

            } elseif ($jenisPegawai === 'PPPK') {

                $query->whereRaw(
                    'CHAR_LENGTH(nip) = 20'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER VERIFIKASI
        |--------------------------------------------------------------------------
        */
        if ($request->filled('verifikasi')) {

            $status = strtolower(
                trim($request->verifikasi)
            );

            $query->whereHas(
                'verificationRequests',
                function ($q) use ($status) {

                    $q->whereIn('id', function ($sub) {

                        $sub->selectRaw('MAX(id)')
                            ->from('verification_requests')
                            ->where(
                                'module',
                                'sdm'
                            )
                            ->groupBy(
                                'record_id'
                            );

                    })->whereRaw(
                        'LOWER(status) = ?',
                        [$status]
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $perPage = (int) $request->get(
            'per_page',
            10
        );

        if (!in_array(
            $perPage,
            [10, 25, 50, 100]
        )) {
            $perPage = 10;
        }

        $sdm = $query
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */
        $totalData = Sdm::count();

        $aktif = Sdm::where(function ($q) {

            $q->whereNull(
                'masa_berlaku'
            )->orWhere(
                'masa_berlaku',
                '>=',
                now()->toDateString()
            );

        })->count();

        $berakhir = Sdm::whereNotNull(
            'masa_berlaku'
        )
            ->where(
                'masa_berlaku',
                '<',
                now()->toDateString()
            )
            ->count();

        return view(
            'sdm.index',
            compact(
                'sdm',
                'totalData',
                'aktif',
                'berakhir'
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
        $request->validate(
            [
                'nip' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'nip.*' => [
                    'required',
                    'string',
                    'regex:/^[0-9]+$/'
                ],

                'nama' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'nama.*' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'jabatan' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'jabatan.*' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'kompetensi' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'kompetensi.*' => [
                    'required',
                    'string'
                ],

                'masa_berlaku' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'masa_berlaku.*' => [
                    'required',
                    'date'
                ],

                'dokumen' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'dokumen.*' => [
                    'required',
                    'file',
                    'mimes:pdf,jpg,jpeg,png',
                    'max:5120'
                ],
            ],
            [
                'nip.required' =>
                    'NIP wajib diisi.',

                'nip.*.required' =>
                    'NIP wajib diisi.',

                'nip.*.regex' =>
                    'NIP hanya boleh berisi angka.',

                'nama.required' =>
                    'Nama wajib diisi.',

                'nama.*.required' =>
                    'Nama wajib diisi.',

                'jabatan.required' =>
                    'Jabatan wajib diisi.',

                'jabatan.*.required' =>
                    'Jabatan wajib diisi.',

                'kompetensi.required' =>
                    'Kompetensi wajib diisi.',

                'kompetensi.*.required' =>
                    'Kompetensi wajib diisi.',

                'masa_berlaku.required' =>
                    'Masa berlaku wajib diisi.',

                'masa_berlaku.*.required' =>
                    'Masa berlaku wajib diisi.',

                'dokumen.required' =>
                    'Dokumen wajib diunggah.',

                'dokumen.*.required' =>
                    'Dokumen wajib diunggah.',

                'dokumen.*.mimes' =>
                    'Dokumen harus berupa PDF, JPG, JPEG, atau PNG.',

                'dokumen.*.max' =>
                    'Ukuran dokumen maksimal 5 MB.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | CEK JUMLAH BARIS
        |--------------------------------------------------------------------------
        */
        $jumlahNip = count($request->nip);
        $jumlahNama = count($request->nama);
        $jumlahJabatan = count($request->jabatan);
        $jumlahKompetensi = count($request->kompetensi);
        $jumlahMasaBerlaku = count($request->masa_berlaku);

        if (
            $jumlahNip !== $jumlahNama ||
            $jumlahNip !== $jumlahJabatan ||
            $jumlahNip !== $jumlahKompetensi ||
            $jumlahNip !== $jumlahMasaBerlaku
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data SDM tidak lengkap. Silakan periksa kembali setiap baris.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI SETIAP NIP
        |--------------------------------------------------------------------------
        */
        foreach (
            $request->nip as $index => $nip
        ) {

            $nip = trim($nip);

            $baris = $index + 1;


            /*
            |--------------------------------------------------------------------------
            | NIP HANYA ANGKA
            |--------------------------------------------------------------------------
            */
            if (
                !preg_match(
                    '/^[0-9]+$/',
                    $nip
                )
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        "NIP pada Data SDM {$baris} hanya boleh berisi angka."
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | NIP HARUS 18 ATAU 20 DIGIT
            |--------------------------------------------------------------------------
            */
            if (
                strlen($nip) !== 18 &&
                strlen($nip) !== 20
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        "NIP pada Data SDM {$baris} harus tepat 18 digit untuk PNS atau 20 digit untuk PPPK."
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | CEK DUPLIKAT DATABASE
            |--------------------------------------------------------------------------
            */
            if (
                Sdm::where(
                    'nip',
                    $nip
                )->exists()
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        "NIP {$nip} sudah terdaftar."
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | CEK DUPLIKAT DALAM BATCH
            |--------------------------------------------------------------------------
            */
            $jumlahNipSama = 0;

            foreach (
                $request->nip as $nipCheck
            ) {

                if (
                    trim($nipCheck) === $nip
                ) {
                    $jumlahNipSama++;
                }
            }

            if ($jumlahNipSama > 1) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        "NIP {$nip} dimasukkan lebih dari satu kali."
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */
        DB::beginTransaction();

        try {

            foreach (
                $request->nip as $index => $nip
            ) {

                $nip = trim($nip);


                /*
                |--------------------------------------------------------------------------
                | UPLOAD DOKUMEN
                |--------------------------------------------------------------------------
                */
                $dokumenPath = null;

                if (
                    isset(
                        $request->file(
                            'dokumen'
                        )[$index]
                    )
                ) {

                    $dokumenPath =
                        $request
                            ->file('dokumen')[$index]
                            ->store(
                                'dokumen_sdm',
                                'public'
                            );
                }


                /*
                |--------------------------------------------------------------------------
                | SIMPAN SDM
                |
                | TIDAK ADA jenis_pegawai
                | karena kolom tersebut tidak ada di database.
                |--------------------------------------------------------------------------
                */
                $sdm = Sdm::create([
                    'nip' =>
                        $nip,

                    'nama' =>
                        $request->nama[$index],

                    'jabatan' =>
                        $request->jabatan[$index],

                    'kompetensi' =>
                        $request->kompetensi[$index],

                    'masa_berlaku' =>
                        $request->masa_berlaku[$index],

                    'dokumen' =>
                        $dokumenPath,
                ]);


                /*
                |--------------------------------------------------------------------------
                | VERIFICATION REQUEST
                |--------------------------------------------------------------------------
                */
                VerificationRequest::create([
                    'module' =>
                        'sdm',

                    'record_id' =>
                        $sdm->id,

                    'action' =>
                        'create',

                    'data' =>
                        json_encode(
                            $sdm->toArray()
                        ),

                    'status' =>
                        'Menunggu',

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
                        'Pengajuan Data SDM',

                    'pesan' =>
                        'Data SDM "' .
                        $sdm->nama .
                        '" menunggu verifikasi.',

                    'dibaca' =>
                        false,
                ]);
            }


            DB::commit();


            return redirect()
                ->route('sdm.index')
                ->with(
                    'success',
                    'Data SDM berhasil ditambahkan dan menunggu verifikasi.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data SDM gagal disimpan. ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * ============================================================
     * UPDATE
     * ============================================================
     */
    public function update(
        Request $request,
        $id
    ) {

        $sdm = Sdm::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */
        $request->validate(
            [
                'nip' => [
                    'required',
                    'string',
                    'regex:/^[0-9]+$/'
                ],

                'nama' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'jabatan' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'kompetensi' => [
                    'required',
                    'string'
                ],

                'masa_berlaku' => [
                    'required',
                    'date'
                ],

                'dokumen' => [
                    'nullable',
                    'file',
                    'mimes:pdf,jpg,jpeg,png',
                    'max:5120'
                ],
            ],
            [
                'nip.required' =>
                    'NIP wajib diisi.',

                'nip.regex' =>
                    'NIP hanya boleh berisi angka.',

                'nama.required' =>
                    'Nama wajib diisi.',

                'jabatan.required' =>
                    'Jabatan wajib diisi.',

                'kompetensi.required' =>
                    'Kompetensi wajib diisi.',

                'masa_berlaku.required' =>
                    'Masa berlaku wajib diisi.',

                'dokumen.mimes' =>
                    'Dokumen harus berupa PDF, JPG, JPEG, atau PNG.',

                'dokumen.max' =>
                    'Ukuran dokumen maksimal 5 MB.',
            ]
        );


        $nip = trim(
            $request->nip
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI PANJANG NIP
        |--------------------------------------------------------------------------
        */
        if (
            strlen($nip) !== 18 &&
            strlen($nip) !== 20
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'NIP harus tepat 18 digit untuk PNS atau 20 digit untuk PPPK.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK DUPLIKAT NIP
        |--------------------------------------------------------------------------
        */
        $nipExists = Sdm::where(
            'nip',
            $nip
        )
            ->where(
                'id',
                '!=',
                $sdm->id
            )
            ->exists();

        if ($nipExists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    "NIP {$nip} sudah digunakan oleh data SDM lain."
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DATA LAMA
        |--------------------------------------------------------------------------
        */
        $oldData =
            $sdm->toArray();


        /*
        |--------------------------------------------------------------------------
        | DATA BARU
        |--------------------------------------------------------------------------
        */
        $newData = [
            'nip' =>
                $nip,

            'nama' =>
                $request->nama,

            'jabatan' =>
                $request->jabatan,

            'kompetensi' =>
                $request->kompetensi,

            'masa_berlaku' =>
                $request->masa_berlaku,
        ];


        /*
        |--------------------------------------------------------------------------
        | UPLOAD DOKUMEN BARU
        |--------------------------------------------------------------------------
        */
        if (
            $request->hasFile(
                'dokumen'
            )
        ) {

            $dokumenPath =
                $request
                    ->file('dokumen')
                    ->store(
                        'dokumen_sdm',
                        'public'
                    );

            $newData['dokumen'] =
                $dokumenPath;
        }


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | UPDATE
            |--------------------------------------------------------------------------
            */
            $sdm->update(
                $newData
            );


            /*
            |--------------------------------------------------------------------------
            | VERIFICATION REQUEST
            |--------------------------------------------------------------------------
            */
            VerificationRequest::create([
                'module' =>
                    'sdm',

                'record_id' =>
                    $sdm->id,

                'action' =>
                    'update',

                'data' =>
                    json_encode([
                        'old' =>
                            $oldData,

                        'new' =>
                            $sdm
                                ->fresh()
                                ->toArray(),
                    ]),

                'status' =>
                    'Menunggu',

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
                    'Perubahan Data SDM',

                'pesan' =>
                    'Perubahan data SDM "' .
                    $sdm->nama .
                    '" menunggu verifikasi.',

                'dibaca' =>
                    false,
            ]);


            DB::commit();


            return redirect()
                ->route('sdm.index')
                ->with(
                    'success',
                    'Data SDM berhasil diperbarui dan menunggu verifikasi.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data SDM gagal diperbarui. ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * ============================================================
     * DELETE
     * ============================================================
     */
    public function destroy($id)
    {
        $sdm =
            Sdm::findOrFail($id);


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | AJUKAN PENGHAPUSAN
            |--------------------------------------------------------------------------
            */
            VerificationRequest::create([
                'module' =>
                    'sdm',

                'record_id' =>
                    $sdm->id,

                'action' =>
                    'delete',

                'data' =>
                    json_encode(
                        $sdm->toArray()
                    ),

                'status' =>
                    'Menunggu',

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
                    'Penghapusan Data SDM',

                'pesan' =>
                    'Penghapusan data SDM "' .
                    $sdm->nama .
                    '" menunggu verifikasi.',

                'dibaca' =>
                    false,
            ]);


            DB::commit();


            return redirect()
                ->route('sdm.index')
                ->with(
                    'success',
                    'Penghapusan data SDM berhasil diajukan dan menunggu verifikasi.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    'Pengajuan penghapusan gagal. ' .
                    $e->getMessage()
                );
        }
    }
}