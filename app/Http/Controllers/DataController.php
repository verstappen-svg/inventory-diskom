<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        |
        | Sesuai ENUM database:
        |
        | - Menunggu Disetujui
        | - Disetujui
        | - Ditolak
        |
        |--------------------------------------------------------------------------
        */
        if ($request->filled('verifikasi')) {

            $verifikasi = $request->verifikasi;

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
        $show = (int) $request->input('show', 10);

        if (!in_array($show, [10, 25, 50, 100])) {
            $show = 10;
        }

        $data = $query
            ->latest()
            ->paginate($show)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK FILTER JENIS
        |--------------------------------------------------------------------------
        */
        $jenisData = Data::query()
            ->select('jenis_data')
            ->whereNotNull('jenis_data')
            ->where('jenis_data', '!=', '')
            ->distinct()
            ->orderBy('jenis_data')
            ->pluck('jenis_data');

        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK FILTER TAHUN
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
            ->distinct('jenis_data')
            ->count('jenis_data');

        $totalPending = Data::where(
            'verifikasi',
            'Menunggu Disetujui'
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
                'jenisData',
                'tahunData'
            )
        );
    }


    /**
     * =========================================================
     * STORE
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
                'required',
                'file',
                'mimes:csv,xls,xlsx,pdf,zip',
                'max:10240',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPLOAD FILE
        |--------------------------------------------------------------------------
        */
        $filePath = null;

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
        | CREATE DATA + VERIFICATION REQUEST
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $request,
            $filePath
        ) {

            $data = Data::create([

                'nama_dataset' =>
                    $request->nama_dataset,

                'jenis_data' =>
                    $request->jenis_data,

                'tahun' =>
                    $request->tahun,

                'file_data' =>
                    $filePath,

                /*
                | Status SESUAI ENUM database
                */
                'verifikasi' =>
                    'Menunggu Disetujui',

                'tanggal_pengajuan' =>
                    now(),

                'komentar_verifikasi' =>
                    null,
            ]);

            /*
            | VerificationRequest tetap menggunakan
            | status internal "menunggu".
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
                'Data berhasil ditambahkan dan menunggu verifikasi.'
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
        | SIMPAN DATA LAMA
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
        | UPDATE + VERIFICATION REQUEST
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $data,
            $request,
            $filePath,
            $dataLama
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

                /*
                | Status SESUAI ENUM database
                */
                'verifikasi' =>
                    'Menunggu Disetujui',

                'komentar_verifikasi' =>
                    null,

                'tanggal_pengajuan' =>
                    now(),
            ]);

            /*
            | Simpan snapshot perubahan
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
            'app/public/' . $data->file_data
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
        | AJUKAN PENGHAPUSAN
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use ($data) {

            VerificationRequest::create([

                'module' =>
                    'data',

                'record_id' =>
                    $data->id,

                'action' =>
                    'delete',

                'data' =>
                    $data->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);

            /*
            | Data tetap ada sampai Verifikator menyetujui.
            */
            $data->update([

                'verifikasi' =>
                    'Menunggu Disetujui',

                'komentar_verifikasi' =>
                    null,
            ]);
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
                'Pengajuan penghapusan data berhasil dikirim dan menunggu verifikasi.'
            );
    }
}