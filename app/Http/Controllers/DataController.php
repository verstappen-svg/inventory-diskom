<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\DataPengajuan;
use App\Models\Notification;
use Illuminate\Http\Request;

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

        // =====================================================
        // SEARCH
        // =====================================================

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_dataset',
                    'like',
                    '%' . $search . '%'
                )->orWhere(
                    'jenis_data',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        // =====================================================
        // FILTER JENIS DATA
        // =====================================================

        if ($request->filled('jenis_data')) {

            $query->where(
                'jenis_data',
                $request->jenis_data
            );
        }

        // =====================================================
        // FILTER TAHUN
        // =====================================================

        if ($request->filled('tahun')) {

            $query->where(
                'tahun',
                $request->tahun
            );
        }

        // =====================================================
        // FILTER VERIFIKASI
        // =====================================================

        if ($request->filled('verifikasi')) {

            $query->where(
                'verifikasi',
                $request->verifikasi
            );
        }

        // =====================================================
        // PAGINATION
        // =====================================================

        $show = $request->get('show', 10);

        if (!in_array($show, [10, 25, 50, 100])) {
            $show = 10;
        }

        $data = $query
            ->latest()
            ->paginate($show)
            ->withQueryString();

        // =====================================================
        // JENIS DATA
        // =====================================================

        $jenisData = Data::query()
            ->select('jenis_data')
            ->distinct()
            ->orderBy('jenis_data')
            ->pluck('jenis_data');

        // =====================================================
        // TAHUN
        // =====================================================

        $tahunData = Data::query()
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // =====================================================
        // SUMMARY CARD
        // =====================================================

        $totalData = Data::count();

        $totalJenis = Data::distinct(
            'jenis_data'
        )->count('jenis_data');

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

        // =====================================================
        // RETURN VIEW
        // =====================================================

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
     * STORE
     * =========================================================
     */
    public function store(Request $request)
    {
        // =====================================================
        // VALIDASI
        // =====================================================

        $request->validate([

            'nama_dataset' =>
                'required|string|max:255',

            'jenis_data' =>
                'required|string|max:255',

            'tahun' =>
                'required|integer|min:1900|max:2100',

            'file_data' => [
                'required',
                'file',
                'mimes:csv,xls,xlsx,pdf,zip',
                'max:10240',
            ],

        ]);

        // =====================================================
        // UPLOAD FILE
        // =====================================================

        $filePath = null;

        if ($request->hasFile('file_data')) {

            $filePath = $request
                ->file('file_data')
                ->store(
                    'data',
                    'public'
                );
        }

        // =====================================================
        // SIMPAN DATA
        // =====================================================

        $data = Data::create([

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

            'tanggal_pengajuan' =>
                now(),

            'komentar_verifikasi' =>
                null,

        ]);

        // =====================================================
        // NOTIFIKASI
        // =====================================================

        Notification::create([
            'judul' =>
                'Pengajuan Dataset Baru',

            'pesan' =>
                $request->user()->username .
                ' menambahkan dataset "' .
                $data->nama_dataset .
                '" dengan ID ' .
                $data->id .
                ' dan mengajukannya untuk persetujuan.',

            'dibaca' => false,
        ]);

        // =====================================================
        // REDIRECT
        // =====================================================

        return redirect()
            ->route('data.index')
            ->with(
                'success',
                'Data berhasil ditambahkan dan menunggu persetujuan verifikator.'
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

        // =====================================================
        // VALIDASI
        // =====================================================

        $request->validate([

            'nama_dataset' =>
                'required|string|max:255',

            'jenis_data' =>
                'required|string|max:255',

            'tahun' =>
                'required|integer|min:1900|max:2100',

            'file_data' => [
                'nullable',
                'file',
                'mimes:csv,xls,xlsx,pdf,zip',
                'max:10240',
            ],

        ]);

        // =====================================================
        // DATA LAMA
        // =====================================================

        $dataLama = [

            'nama_dataset' =>
                $data->nama_dataset,

            'jenis_data' =>
                $data->jenis_data,

            'tahun' =>
                $data->tahun,

            'file_data' =>
                $data->file_data,

        ];

        // =====================================================
        // DATA BARU
        // =====================================================

        $dataBaru = [

            'nama_dataset' =>
                $request->nama_dataset,

            'jenis_data' =>
                $request->jenis_data,

            'tahun' =>
                $request->tahun,

            'file_data' =>
                $data->file_data,

        ];

        // =====================================================
        // FILE BARU
        // =====================================================

        if ($request->hasFile('file_data')) {

            $dataBaru['file_data'] =
                $request
                    ->file('file_data')
                    ->store(
                        'data',
                        'public'
                    );
        }

        // =====================================================
        // SIMPAN PENGAJUAN EDIT
        // =====================================================

        DataPengajuan::create([

            'data_id' =>
                $data->id,

            'user_id' =>
                $request->user()->id,

            'aksi' =>
                'edit',

            'data_lama' =>
                $dataLama,

            'data_baru' =>
                $dataBaru,

            'status' =>
                'Menunggu Disetujui',

            'komentar' =>
                null,

            'tanggal_pengajuan' =>
                now(),

        ]);

        // =====================================================
        // NOTIFIKASI
        // =====================================================

        Notification::create([
            'judul' =>
                'Perubahan Dataset Diajukan',

            'pesan' =>
                $request->user()->username .
                ' memperbarui dataset "' .
                $data->nama_dataset .
                '" dengan ID ' .
                $data->id .
                ' dan mengajukannya kembali untuk persetujuan.',

            'dibaca' => false,
        ]);

        // =====================================================
        // REDIRECT
        // =====================================================

        return redirect()
            ->route('data.index')
            ->with(
                'success',
                'Perubahan data berhasil diajukan dan menunggu persetujuan verifikator.'
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

        // =====================================================
        // CEK FILE
        // =====================================================

        if (!$data->file_data) {

            abort(
                404,
                'File tidak ditemukan.'
            );
        }

        // =====================================================
        // PATH FILE
        // =====================================================

        $path = storage_path(
            'app/public/' . $data->file_data
        );

        // =====================================================
        // CEK FILE FISIK
        // =====================================================

        if (!file_exists($path)) {

            abort(
                404,
                'File tidak ditemukan di storage.'
            );
        }

        // =====================================================
        // TAMPILKAN FILE
        // =====================================================

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

        // =====================================================
        // DATA LAMA
        // =====================================================

        $dataLama = [

            'nama_dataset' =>
                $data->nama_dataset,

            'jenis_data' =>
                $data->jenis_data,

            'tahun' =>
                $data->tahun,

            'file_data' =>
                $data->file_data,

        ];

        // =====================================================
        // SIMPAN PENGAJUAN HAPUS
        // =====================================================

        DataPengajuan::create([

            'data_id' =>
                $data->id,

            'user_id' =>
                $request->user()->id,

            'aksi' =>
                'hapus',

            'data_lama' =>
                $dataLama,

            'data_baru' =>
                null,

            'status' =>
                'Menunggu Disetujui',

            'komentar' =>
                null,

            'tanggal_pengajuan' =>
                now(),

        ]);

        // =====================================================
        // NOTIFIKASI
        // =====================================================

        Notification::create([
            'judul' =>
                'Penghapusan Dataset Diajukan',

            'pesan' =>
                $request->user()->username .
                ' mengajukan penghapusan dataset "' .
                $data->nama_dataset .
                '" dengan ID ' .
                $data->id .
                ' untuk persetujuan verifikator.',

            'dibaca' => false,
        ]);

        // =====================================================
        // REDIRECT
        // =====================================================

        return redirect()
            ->route('data.index')
            ->with(
                'success',
                'Pengajuan penghapusan berhasil dikirim dan menunggu persetujuan verifikator.'
            );
    }
}