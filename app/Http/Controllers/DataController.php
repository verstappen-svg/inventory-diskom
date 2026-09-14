<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Notification;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    /**
     * =========================================================
     * INDEX
     * =========================================================
     */
    public function index(Request $request)
    {
        $query = Data::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_dataset',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'jenis_data',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'tahun',
                    'like',
                    "%{$search}%"
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS DATA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('jenis_data')) {

            $query->where(
                'jenis_data',
                $request->jenis_data
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TAHUN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tahun')) {

            $query->where(
                'tahun',
                $request->tahun
            );
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

            if ($verifikasi === 'menunggu') {
                $verifikasi = 'Menunggu Disetujui';
            }

            $allowedStatuses = [
                'Menunggu Disetujui',
                'Disetujui',
                'Ditolak',
            ];

            if (in_array($verifikasi, $allowedStatuses)) {

                $query->where(
                    'verifikasi',
                    $verifikasi
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

        $data = $query
            ->latest()
            ->paginate($show)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | DATA JENIS UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $jenisData = Data::query()
            ->select('jenis_data')
            ->whereNotNull('jenis_data')
            ->where(
                'jenis_data',
                '!=',
                ''
            )
            ->distinct()
            ->orderBy('jenis_data')
            ->pluck('jenis_data');


        /*
        |--------------------------------------------------------------------------
        | DATA TAHUN UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $tahunData = Data::query()
            ->select('tahun')
            ->whereNotNull('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalData = Data::count();

        $totalJenis = Data::query()
            ->whereNotNull('jenis_data')
            ->where(
                'jenis_data',
                '!=',
                ''
            )
            ->distinct('jenis_data')
            ->count('jenis_data');

        $totalPending = Data::where(
            'verifikasi',
            'Menunggu Disetujui'
        )->count();

        $totalDisetujui = Data::where(
            'verifikasi',
            'Disetujui'
        )->count();

        $totalDitolak = Data::where(
            'verifikasi',
            'Ditolak'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'data.index',
            compact(
                'data',
                'totalData',
                'totalJenis',
                'totalPending',
                'totalDisetujui',
                'totalDitolak',
                'jenisData',
                'tahunData'
            )
        );
    }


    /**
     * =========================================================
     * STORE - TAMBAH BANYAK DATA SEKALIGUS
     * =========================================================
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'nama_dataset' => [
                'required',
                'array',
                'min:1',
            ],

            'nama_dataset.*' => [
                'required',
                'string',
                'max:255',
            ],

            'jenis_data' => [
                'required',
                'array',
                'min:1',
            ],

            'jenis_data.*' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun' => [
                'required',
                'array',
                'min:1',
            ],

            'tahun.*' => [
                'required',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'file_data' => [
                'required',
                'array',
                'min:1',
            ],

            'file_data.*' => [
                'required',
                'file',
                'mimes:csv,xls,xlsx,pdf,zip',
                'max:10240',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA FORM
        |--------------------------------------------------------------------------
        */

        $namaDataset = $request->input(
            'nama_dataset',
            []
        );

        $jenisData = $request->input(
            'jenis_data',
            []
        );

        $tahun = $request->input(
            'tahun',
            []
        );

        $files = $request->file(
            'file_data',
            []
        );


        /*
        |--------------------------------------------------------------------------
        | CEK JUMLAH BARIS
        |--------------------------------------------------------------------------
        */

        $jumlahData = count($namaDataset);

        if (
            count($jenisData) !== $jumlahData ||
            count($tahun) !== $jumlahData ||
            count($files) !== $jumlahData
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data yang dikirim tidak lengkap. Silakan periksa kembali setiap baris.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN SEMUA DATA
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $namaDataset,
            $jenisData,
            $tahun,
            $files
        ) {

            foreach ($namaDataset as $index => $nama) {

                /*
                |--------------------------------------------------------------------------
                | UPLOAD FILE
                |--------------------------------------------------------------------------
                */

                $filePath = null;

                if (
                    isset($files[$index]) &&
                    $files[$index] instanceof \Illuminate\Http\UploadedFile
                ) {

                    $filePath = $files[$index]->store(
                        'data',
                        'public'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | CREATE DATA
                |--------------------------------------------------------------------------
                */

                $data = Data::create([

                    'nama_dataset' =>
                        $nama,

                    'jenis_data' =>
                        $jenisData[$index],

                    'tahun' =>
                        $tahun[$index],

                    'file_data' =>
                        $filePath,

                    'verifikasi' =>
                        'Menunggu Disetujui',

                    'tanggal_pengajuan' =>
                        now(),

                    'komentar_verifikasi' =>
                        null,

                ]);


                /*
                |--------------------------------------------------------------------------
                | FORMAT ID
                |--------------------------------------------------------------------------
                */

                $datasetId =
                    'DS-' .
                    str_pad(
                        $data->id,
                        5,
                        '0',
                        STR_PAD_LEFT
                    );


                /*
                |--------------------------------------------------------------------------
                | VERIFICATION REQUEST
                |--------------------------------------------------------------------------
                */

                VerificationRequest::create([

                    'module' =>
                        'data',

                    'record_id' =>
                        $data->id,

                    'action' =>
                        'create',

                    'data' =>
                        $data->toArray(),

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
                        'Pengajuan Dataset Baru',

                    'pesan' =>
                        $request->user()->username .
                        ' menambahkan dataset "' .
                        $data->nama_dataset .
                        '" dengan ID ' .
                        $datasetId .
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
            ->route('data.index')
            ->with(
                'success',
                $jumlahData .
                ' dataset berhasil ditambahkan dan menunggu verifikasi.'
            );
    }


    /**
     * =========================================================
     * EDIT
     * =========================================================
     */
    public function edit($id)
    {
        $data = Data::findOrFail($id);

        return view(
            'data.edit',
            compact('data')
        );
    }


    /**
     * =========================================================
     * UPDATE
     * =========================================================
     */
    public function update(
        Request $request,
        $id
    ) {

        $data = Data::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'nama_dataset' => [
                'required',
                'string',
                'max:255',
            ],

            'jenis_data' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun' => [
                'required',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'file_data' => [
                'nullable',
                'file',
                'mimes:csv,xls,xlsx,pdf,zip',
                'max:10240',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA LAMA
        |--------------------------------------------------------------------------
        */

        $dataLama = $data->toArray();


        /*
        |--------------------------------------------------------------------------
        | FILE
        |--------------------------------------------------------------------------
        */

        $filePath = $data->file_data;

        if ($request->hasFile('file_data')) {

            $filePath = $request
                ->file('file_data')
                ->store(
                    'data',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT ID
        |--------------------------------------------------------------------------
        */

        $datasetId =
            'DS-' .
            str_pad(
                $data->id,
                5,
                '0',
                STR_PAD_LEFT
            );


        /*
        |--------------------------------------------------------------------------
        | UPDATE + VERIFICATION
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $data,
            $request,
            $filePath,
            $dataLama,
            $datasetId
        ) {

            $data->update([

                'nama_dataset' =>
                    $request->nama_dataset,

                'jenis_data' =>
                    $request->jenis_data,

                'tahun' =>
                    $request->tahun,

                'file_data' =>
                    $filePath,

                'verifikasi' =>
                    'Menunggu Disetujui',

                'komentar_verifikasi' =>
                    null,

                'tanggal_pengajuan' =>
                    now(),

            ]);


            /*
            |--------------------------------------------------------------------------
            | VERIFICATION REQUEST
            |--------------------------------------------------------------------------
            */

            VerificationRequest::create([

                'module' =>
                    'data',

                'record_id' =>
                    $data->id,

                'action' =>
                    'update',

                'data' => [

                    'data_lama' =>
                        $dataLama,

                    'data_baru' =>
                        $data->fresh()->toArray(),

                ],

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
                    'Perubahan Dataset Diajukan',

                'pesan' =>
                    $request->user()->username .
                    ' memperbarui dataset "' .
                    $data->nama_dataset .
                    '" dengan ID ' .
                    $datasetId .
                    ' dan mengajukannya kembali untuk persetujuan.',

                'dibaca' =>
                    false,

            ]);
        });


        return redirect()
            ->route('data.index')
            ->with(
                'success',
                'Perubahan data berhasil disimpan dan menunggu verifikasi.'
            );
    }


    /**
     * =========================================================
     * PREVIEW FILE
     * =========================================================
     */
    public function preview($id)
    {
        $data = Data::findOrFail($id);

        if (!$data->file_data) {

            abort(
                404,
                'File tidak ditemukan.'
            );
        }

        $path = storage_path(
            'app/public/' .
            $data->file_data
        );

        if (!file_exists($path)) {

            abort(
                404,
                'File tidak ditemukan di storage.'
            );
        }

        return response()->file($path);
    }


    /**
     * =========================================================
     * DESTROY
     * =========================================================
     */
    public function destroy(
        Request $request,
        $id
    ) {

        $data = Data::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | DATA LAMA
        |--------------------------------------------------------------------------
        */

        $dataLama = $data->toArray();


        /*
        |--------------------------------------------------------------------------
        | FORMAT ID
        |--------------------------------------------------------------------------
        */

        $datasetId =
            'DS-' .
            str_pad(
                $data->id,
                5,
                '0',
                STR_PAD_LEFT
            );


        /*
        |--------------------------------------------------------------------------
        | AJUKAN PENGHAPUSAN
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $data,
            $request,
            $dataLama,
            $datasetId
        ) {

            VerificationRequest::create([

                'module' =>
                    'data',

                'record_id' =>
                    $data->id,

                'action' =>
                    'delete',

                'data' =>
                    $dataLama,

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),

            ]);


            /*
            |--------------------------------------------------------------------------
            | DATA TETAP ADA SAMPAI DISETUJUI
            |--------------------------------------------------------------------------
            */

            $data->update([

                'verifikasi' =>
                    'Menunggu Disetujui',

                'komentar_verifikasi' =>
                    null,

            ]);


            /*
            |--------------------------------------------------------------------------
            | NOTIFICATION
            |--------------------------------------------------------------------------
            */

            Notification::create([

                'judul' =>
                    'Penghapusan Dataset Diajukan',

                'pesan' =>
                    $request->user()->username .
                    ' mengajukan penghapusan dataset "' .
                    $data->nama_dataset .
                    '" dengan ID ' .
                    $datasetId .
                    ' untuk persetujuan verifikator.',

                'dibaca' =>
                    false,

            ]);
        });


        return redirect()
            ->route('data.index')
            ->with(
                'success',
                'Pengajuan penghapusan data berhasil dikirim dan menunggu verifikasi.'
            );
    }
}