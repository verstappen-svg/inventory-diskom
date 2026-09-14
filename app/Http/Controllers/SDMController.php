<?php

namespace App\Http\Controllers;

use App\Models\Sdm;
use App\Models\Notification;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SDMController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
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

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('kompetensi', 'like', "%{$search}%");

            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER VERIFIKASI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('verifikasi')) {

            $verifikasi = strtolower(
                trim($request->verifikasi)
            );

            $allowed = [
                'menunggu',
                'disetujui',
                'ditolak',
            ];

            if (in_array($verifikasi, $allowed)) {

                $query->whereHas(
                    'verificationRequests',
                    function ($q) use ($verifikasi) {

                        $q->where('status', $verifikasi)
                            ->whereIn(
                                'id',
                                function ($sub) {

                                    $sub->selectRaw('MAX(id)')
                                        ->from('verification_requests')
                                        ->whereColumn(
                                            'verification_requests.record_id',
                                            'sdms.id'
                                        )
                                        ->where(
                                            'module',
                                            'sdm'
                                        )
                                        ->groupBy('record_id');

                                }
                            );

                    }
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $show = (int) $request->input(
            'show',
            10
        );

        if (!in_array(
            $show,
            [10, 25, 50, 100]
        )) {
            $show = 10;
        }

        $sdm = $query
            ->latest()
            ->paginate($show)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        */

        $totalData = Sdm::count();

        $aktif = Sdm::query()
            ->whereNotNull('masa_berlaku')
            ->whereDate(
                'masa_berlaku',
                '>=',
                now()->toDateString()
            )
            ->count();

        $berakhir = Sdm::query()
            ->whereNotNull('masa_berlaku')
            ->whereDate(
                'masa_berlaku',
                '<',
                now()->toDateString()
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

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


    /*
    |--------------------------------------------------------------------------
    | STORE - TAMBAH BANYAK DATA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'nip' => [
                'required',
                'array',
                'min:1',
            ],

            'nip.*' => [
                'required',
                'string',
                'max:50',
            ],

            'nama' => [
                'required',
                'array',
                'min:1',
            ],

            'nama.*' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'array',
                'min:1',
            ],

            'jabatan.*' => [
                'required',
                'string',
                'max:255',
            ],

            'kompetensi' => [
                'required',
                'array',
                'min:1',
            ],

            'kompetensi.*' => [
                'required',
                'string',
                'max:255',
            ],

            'masa_berlaku' => [
                'required',
                'array',
                'min:1',
            ],

            'masa_berlaku.*' => [
                'required',
                'date',
            ],

            'dokumen' => [
                'required',
                'array',
                'min:1',
            ],

            'dokumen.*' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */

        $nip = $request->input(
            'nip',
            []
        );

        $nama = $request->input(
            'nama',
            []
        );

        $jabatan = $request->input(
            'jabatan',
            []
        );

        $kompetensi = $request->input(
            'kompetensi',
            []
        );

        $masaBerlaku = $request->input(
            'masa_berlaku',
            []
        );

        $dokumen = $request->file(
            'dokumen',
            []
        );

        $jumlahData = count($nip);

        /*
        |--------------------------------------------------------------------------
        | CEK JUMLAH BARIS
        |--------------------------------------------------------------------------
        */

        if (
            count($nama) !== $jumlahData ||
            count($jabatan) !== $jumlahData ||
            count($kompetensi) !== $jumlahData ||
            count($masaBerlaku) !== $jumlahData ||
            count($dokumen) !== $jumlahData
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data yang dikirim tidak lengkap. Silakan periksa setiap baris.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $nip,
            $nama,
            $jabatan,
            $kompetensi,
            $masaBerlaku,
            $dokumen
        ) {

            foreach ($nip as $index => $valueNip) {

                /*
                |--------------------------------------------------------------------------
                | SIMPAN DOKUMEN
                |--------------------------------------------------------------------------
                */

                $dokumenPath = null;

                if (
                    isset($dokumen[$index]) &&
                    $dokumen[$index] instanceof \Illuminate\Http\UploadedFile
                ) {

                    $dokumenPath = $dokumen[$index]
                        ->store(
                            'sdm/dokumen',
                            'public'
                        );
                }

                /*
                |--------------------------------------------------------------------------
                | CREATE DATA SDM
                |--------------------------------------------------------------------------
                */

                $sdm = Sdm::create([

                    'nip' =>
                        $valueNip,

                    'nama' =>
                        $nama[$index],

                    'jabatan' =>
                        $jabatan[$index],

                    'kompetensi' =>
                        $kompetensi[$index],

                    'masa_berlaku' =>
                        $masaBerlaku[$index],

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
                        $sdm->toArray(),

                    'status' =>
                        'menunggu',

                    'submitted_by' =>
                        auth()->id(),

                ]);

                /*
                |--------------------------------------------------------------------------
                | ID TAMPILAN
                |--------------------------------------------------------------------------
                */

                $displayId =
                    'SDM-' .
                    str_pad(
                        $sdm->id,
                        5,
                        '0',
                        STR_PAD_LEFT
                    );

                /*
                |--------------------------------------------------------------------------
                | NOTIFICATION
                |--------------------------------------------------------------------------
                */

                Notification::create([

                    'judul' =>
                        'Data SDM Baru',

                    'pesan' =>
                        auth()->user()->username .
                        ' menambahkan data SDM "' .
                        $sdm->nama .
                        '" dengan ID ' .
                        $displayId .
                        ' dan mengajukannya untuk persetujuan.',

                    'dibaca' =>
                        false,

                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                $jumlahData .
                ' data SDM berhasil ditambahkan dan menunggu verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT / UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Sdm $sdm
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'nip' => [
                'required',
                'string',
                'max:50',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'kompetensi' => [
                'required',
                'string',
                'max:255',
            ],

            'masa_berlaku' => [
                'required',
                'date',
            ],

            'dokumen' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | DOKUMEN BARU
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('dokumen')) {

            $validated['dokumen'] =
                $request
                    ->file('dokumen')
                    ->store(
                        'sdm/dokumen',
                        'public'
                    );

        } else {

            unset(
                $validated['dokumen']
            );

        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PERUBAHAN
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $sdm,
            $validated
        ) {

            $sdm->update(
                $validated
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
                    $sdm
                        ->fresh()
                        ->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),

            ]);

            /*
            |--------------------------------------------------------------------------
            | DISPLAY ID
            |--------------------------------------------------------------------------
            */

            $displayId =
                'SDM-' .
                str_pad(
                    $sdm->id,
                    5,
                    '0',
                    STR_PAD_LEFT
                );

            /*
            |--------------------------------------------------------------------------
            | NOTIFICATION
            |--------------------------------------------------------------------------
            */

            Notification::create([

                'judul' =>
                    'Data SDM Diperbarui',

                'pesan' =>
                    auth()->user()->username .
                    ' memperbarui data SDM "' .
                    $sdm->nama .
                    '" dengan ID ' .
                    $displayId .
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
            ->route('sdm.index')
            ->with(
                'success',
                'Perubahan data SDM berhasil disimpan dan menunggu verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Sdm $sdm
    ) {

        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        $namaSdm =
            $sdm->nama;

        $displayId =
            'SDM-' .
            str_pad(
                $sdm->id,
                5,
                '0',
                STR_PAD_LEFT
            );

        /*
        |--------------------------------------------------------------------------
        | VERIFICATION REQUEST + NOTIFICATION
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $sdm,
            $namaSdm,
            $displayId
        ) {

            /*
            |--------------------------------------------------------------------------
            | REQUEST PENGHAPUSAN
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
                    $sdm->toArray(),

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
                    'Penghapusan Data SDM Diajukan',

                'pesan' =>
                    auth()->user()->username .
                    ' mengajukan penghapusan data SDM "' .
                    $namaSdm .
                    '" dengan ID ' .
                    $displayId .
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
            ->route('sdm.index')
            ->with(
                'success',
                'Pengajuan penghapusan SDM berhasil dikirim dan menunggu verifikasi.'
            );
    }
}