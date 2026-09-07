<?php

namespace App\Http\Controllers;

use App\Models\DataCenter;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataCenterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STATUS OTOMATIS
    |--------------------------------------------------------------------------
    */

    private function getStatusOtomatis($dataCenter)
    {
        /*
        |--------------------------------------------------------------------------
        | BELI
        |--------------------------------------------------------------------------
        | Pembelian tidak memiliki tanggal berakhir.
        */

        if ($dataCenter->pengadaan === 'Beli') {
            return 'Tidak Berakhir';
        }

        /*
        |--------------------------------------------------------------------------
        | SEWA
        |--------------------------------------------------------------------------
        */

        if (
            $dataCenter->pengadaan === 'Sewa' &&
            $dataCenter->tanggal_berakhir
        ) {
            $today = Carbon::today();

            $tanggalBerakhir = Carbon::parse(
                $dataCenter->tanggal_berakhir
            );

            /*
            |--------------------------------------------------------------------------
            | EXPIRED
            |--------------------------------------------------------------------------
            */

            if ($tanggalBerakhir->lt($today)) {
                return 'Expired';
            }

            /*
            |--------------------------------------------------------------------------
            | AKAN HABIS
            |--------------------------------------------------------------------------
            | Jika sisa masa sewa <= 30 hari.
            */

            if (
                $tanggalBerakhir->gte($today) &&
                $tanggalBerakhir->lte(
                    $today->copy()->addDays(30)
                )
            ) {
                return 'Akan Habis';
            }

            /*
            |--------------------------------------------------------------------------
            | DIGUNAKAN
            |--------------------------------------------------------------------------
            */

            return 'Digunakan';
        }

        /*
        |--------------------------------------------------------------------------
        | FALLBACK
        |--------------------------------------------------------------------------
        */

        return 'Tidak Berakhir';
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = DataCenter::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'id',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'nama_infrastruktur',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'spesifikasi',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER PENGADAAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('pengadaan')) {

            $query->where(
                'pengadaan',
                $request->pengadaan
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER VERIFIKASI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('verifikasi')) {

            $query->where(
                'verifikasi',
                $request->verifikasi
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TAHUN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tahun')) {

            $query->whereYear(
                'tanggal_pengadaan',
                $request->tahun
            );
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */

        $dataCenters = $query
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TAMBAHKAN STATUS OTOMATIS
        |--------------------------------------------------------------------------
        */

        foreach ($dataCenters as $dataCenter) {

            $dataCenter->status_otomatis =
                $this->getStatusOtomatis($dataCenter);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS OTOMATIS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $dataCenters = $dataCenters
                ->filter(function ($dataCenter) use ($request) {

                    return $dataCenter->status_otomatis ===
                        $request->status;
                })
                ->values();
        }

        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK STATISTIK
        |--------------------------------------------------------------------------
        */

        $allDataCenters = DataCenter::all();

        foreach ($allDataCenters as $dataCenter) {

            $dataCenter->status_otomatis =
                $this->getStatusOtomatis($dataCenter);
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG STATUS
        |--------------------------------------------------------------------------
        */

        $tidakBerakhir = $allDataCenters
            ->where(
                'status_otomatis',
                'Tidak Berakhir'
            )
            ->count();

        $digunakan = $allDataCenters
            ->where(
                'status_otomatis',
                'Digunakan'
            )
            ->count();

        $akanHabis = $allDataCenters
            ->where(
                'status_otomatis',
                'Akan Habis'
            )
            ->count();

        $expired = $allDataCenters
            ->where(
                'status_otomatis',
                'Expired'
            )
            ->count();

        $totalDataCenter =
            $allDataCenters->count();

        /*
        |--------------------------------------------------------------------------
        | DAFTAR TAHUN
        |--------------------------------------------------------------------------
        */

        $tahuns = DataCenter::query()
            ->whereNotNull('tanggal_pengadaan')
            ->selectRaw(
                'YEAR(tanggal_pengadaan) as tahun'
            )
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        /*
        |--------------------------------------------------------------------------
        | DAFTAR VERIFIKASI
        |--------------------------------------------------------------------------
        */

        $verifikasis = DataCenter::query()
            ->whereNotNull('verifikasi')
            ->select('verifikasi')
            ->distinct()
            ->orderBy('verifikasi')
            ->pluck('verifikasi');

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'infrastruktur.data-center.index',
            compact(
                'dataCenters',
                'totalDataCenter',
                'tidakBerakhir',
                'digunakan',
                'akanHabis',
                'expired',
                'tahuns',
                'verifikasis'
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
            [
                'nama_infrastruktur' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'spesifikasi' => [
                    'nullable',
                    'string',
                ],

                'pengadaan' => [
                    'required',
                    'in:Beli,Sewa',
                ],

                'harga' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'tanggal_pengadaan' => [
                    'required',
                    'date',
                ],

                'tanggal_berakhir' => [
                    'nullable',
                    'date',
                    'after_or_equal:tanggal_pengadaan',
                ],
            ],
            [
                'nama_infrastruktur.required' =>
                    'Nama infrastruktur wajib diisi.',

                'nama_infrastruktur.max' =>
                    'Nama infrastruktur maksimal 255 karakter.',

                'pengadaan.required' =>
                    'Jenis pengadaan wajib dipilih.',

                'pengadaan.in' =>
                    'Jenis pengadaan harus Beli atau Sewa.',

                'harga.required' =>
                    'Harga wajib diisi.',

                'harga.numeric' =>
                    'Harga harus berupa angka.',

                'harga.min' =>
                    'Harga tidak boleh kurang dari 0.',

                'tanggal_pengadaan.required' =>
                    'Tanggal pengadaan wajib diisi.',

                'tanggal_pengadaan.date' =>
                    'Tanggal pengadaan tidak valid.',

                'tanggal_berakhir.date' =>
                    'Tanggal berakhir tidak valid.',

                'tanggal_berakhir.after_or_equal' =>
                    'Tanggal berakhir tidak boleh sebelum tanggal pengadaan.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | BELI
        |--------------------------------------------------------------------------
        | Tidak mempunyai tanggal berakhir.
        */

        if ($validated['pengadaan'] === 'Beli') {

            $validated['tanggal_berakhir'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | SEWA
        |--------------------------------------------------------------------------
        | Wajib mempunyai tanggal berakhir.
        */

        if ($validated['pengadaan'] === 'Sewa') {

            if (
                empty(
                    $validated['tanggal_berakhir']
                )
            ) {

                return back()
                    ->withErrors([
                        'tanggal_berakhir' =>
                            'Tanggal berakhir wajib diisi untuk pengadaan sewa.',
                    ])
                    ->withInput();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | GENERATE ID
        |--------------------------------------------------------------------------
        */

        $prefix = 'INFDC-';

        $lastDataCenter = DataCenter::where(
            'id',
            'like',
            $prefix . '%'
        )
            ->orderByRaw(
                'CAST(SUBSTRING(id, 7) AS UNSIGNED) DESC'
            )
            ->first();

        $newNumber = $lastDataCenter
            ? (
                (int) substr(
                    $lastDataCenter->id,
                    strlen($prefix)
                )
            ) + 1
            : 1;

        $validated['id'] =
            $prefix .
            str_pad(
                $newNumber,
                3,
                '0',
                STR_PAD_LEFT
            );

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI
        |--------------------------------------------------------------------------
        */

        $validated['verifikasi'] = 'menunggu';

        $validated['komentar'] = null;

        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($validated) {

            $dataCenter = DataCenter::create(
                $validated
            );

            VerificationRequest::create([
                'module' => 'data-center',

                'record_id' =>
                    $dataCenter->id,

                'action' => 'create',

                'data' =>
                    $dataCenter->toArray(),

                'status' => 'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);
        });

        return redirect()
            ->route('data-center.index')
            ->with(
                'success',
                'Data Data Center berhasil ditambahkan dan menunggu verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {
        $validated = $request->validate(
            [
                'nama_infrastruktur' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'spesifikasi' => [
                    'nullable',
                    'string',
                ],

                'pengadaan' => [
                    'required',
                    'in:Beli,Sewa',
                ],

                'harga' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'tanggal_pengadaan' => [
                    'required',
                    'date',
                ],

                'tanggal_berakhir' => [
                    'nullable',
                    'date',
                    'after_or_equal:tanggal_pengadaan',
                ],
            ],
            [
                'nama_infrastruktur.required' =>
                    'Nama infrastruktur wajib diisi.',

                'nama_infrastruktur.max' =>
                    'Nama infrastruktur maksimal 255 karakter.',

                'pengadaan.required' =>
                    'Jenis pengadaan wajib dipilih.',

                'pengadaan.in' =>
                    'Jenis pengadaan harus Beli atau Sewa.',

                'harga.required' =>
                    'Harga wajib diisi.',

                'harga.numeric' =>
                    'Harga harus berupa angka.',

                'harga.min' =>
                    'Harga tidak boleh kurang dari 0.',

                'tanggal_pengadaan.required' =>
                    'Tanggal pengadaan wajib diisi.',

                'tanggal_pengadaan.date' =>
                    'Tanggal pengadaan tidak valid.',

                'tanggal_berakhir.date' =>
                    'Tanggal berakhir tidak valid.',

                'tanggal_berakhir.after_or_equal' =>
                    'Tanggal berakhir tidak boleh sebelum tanggal pengadaan.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | CARI DATA
        |--------------------------------------------------------------------------
        */

        $dataCenter =
            DataCenter::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | BELI
        |--------------------------------------------------------------------------
        */

        if ($validated['pengadaan'] === 'Beli') {

            $validated['tanggal_berakhir'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | SEWA
        |--------------------------------------------------------------------------
        */

        if ($validated['pengadaan'] === 'Sewa') {

            if (
                empty(
                    $validated['tanggal_berakhir']
                )
            ) {

                return back()
                    ->withErrors([
                        'tanggal_berakhir' =>
                            'Tanggal berakhir wajib diisi untuk pengadaan sewa.',
                    ])
                    ->withInput();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE + VERIFIKASI
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $dataCenter,
            $validated
        ) {

            $dataCenter->update([
                ...$validated,

                'verifikasi' =>
                    'menunggu',

                'komentar' =>
                    null,
            ]);

            $dataCenter->refresh();

            VerificationRequest::create([
                'module' =>
                    'data-center',

                'record_id' =>
                    $dataCenter->id,

                'action' =>
                    'update',

                'data' =>
                    $dataCenter->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);
        });

        return redirect()
            ->route('data-center.index')
            ->with(
                'success',
                'Perubahan Data Center berhasil disimpan dan menunggu verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $dataCenter =
            DataCenter::findOrFail($id);

        DB::transaction(function () use (
            $dataCenter
        ) {

            /*
            |--------------------------------------------------------------------------
            | JANGAN LANGSUNG HAPUS
            |--------------------------------------------------------------------------
            | Buat pengajuan penghapusan ke verifikator.
            */

            $dataCenter->update([
                'verifikasi' =>
                    'menunggu',

                'komentar' =>
                    null,
            ]);

            VerificationRequest::create([
                'module' =>
                    'data-center',

                'record_id' =>
                    $dataCenter->id,

                'action' =>
                    'delete',

                'data' =>
                    $dataCenter->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);
        });

        return redirect()
            ->route('data-center.index')
            ->with(
                'success',
                'Pengajuan penghapusan Data Center berhasil dikirim dan menunggu verifikasi.'
            );
    }
}