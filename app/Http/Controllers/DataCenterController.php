<?php

namespace App\Http\Controllers;

use App\Models\DataCenter;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DataCenterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HITUNG STATUS OTOMATIS
    |--------------------------------------------------------------------------
    */

    private function getStatusOtomatis($dataCenter)
    {
        /*
        |--------------------------------------------------------------------------
        | JIKA BELI
        |--------------------------------------------------------------------------
        */

        if ($dataCenter->pengadaan === 'Beli') {
            return $dataCenter->status ?? 'Tersedia';
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA SEWA
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

        return $dataCenter->status ?? 'Tersedia';
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
        | HITUNG STATUS OTOMATIS
        |--------------------------------------------------------------------------
        */

        foreach ($dataCenters as $dataCenter) {

            $dataCenter->status_otomatis =
                $this->getStatusOtomatis(
                    $dataCenter
                );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
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
        | DATA UNTUK CARD
        |--------------------------------------------------------------------------
        */

        $allDataCenters = DataCenter::all();

        foreach ($allDataCenters as $dataCenter) {

            $dataCenter->status_otomatis =
                $this->getStatusOtomatis(
                    $dataCenter
                );
        }

        /*
        |--------------------------------------------------------------------------
        | JUMLAH STATUS
        |--------------------------------------------------------------------------
        */

        $tersedia = $allDataCenters
            ->where(
                'status_otomatis',
                'Tersedia'
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
        | DATA TAHUN UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $tahuns = DataCenter::query()
            ->whereNotNull(
                'tanggal_pengadaan'
            )
            ->selectRaw(
                'YEAR(tanggal_pengadaan) as tahun'
            )
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        /*
        |--------------------------------------------------------------------------
        | DATA FILTER VERIFIKASI
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
        | KIRIM KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'infrastruktur.data-center.index',
            compact(
                'dataCenters',
                'totalDataCenter',
                'tersedia',
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
        $validated = $request->validate([

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

            'status' => [
                'nullable',
                'in:Tersedia,Digunakan',
            ],

            'komentar' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | JIKA BELI
        |--------------------------------------------------------------------------
        */

        if ($validated['pengadaan'] === 'Beli') {

            $validated['tanggal_berakhir'] = null;

            $validated['status'] =
                $validated['status'] ?? 'Tersedia';
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA SEWA
        |--------------------------------------------------------------------------
        */

        if ($validated['pengadaan'] === 'Sewa') {

            if (empty($validated['tanggal_berakhir'])) {

                return back()
                    ->withErrors([
                        'tanggal_berakhir' =>
                            'Tanggal berakhir wajib diisi untuk pengadaan sewa.',
                    ])
                    ->withInput();
            }

            $validated['status'] = 'Digunakan';
        }

        /*
        |--------------------------------------------------------------------------
        | GENERATE ID OTOMATIS
        |--------------------------------------------------------------------------
        */

        $prefix = 'INFD-';

        $lastDataCenter = DataCenter::where(
            'id',
            'like',
            $prefix . '%'
        )
            ->orderByRaw(
                'CAST(SUBSTRING(id, 6) AS UNSIGNED) DESC'
            )
            ->first();

        if ($lastDataCenter) {

            $lastNumber = (int) substr(
                $lastDataCenter->id,
                strlen($prefix)
            );

            $newNumber = $lastNumber + 1;

        } else {

            $newNumber = 1;
        }

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

        $validated['verifikasi'] =
            'Menunggu disetujui';

        /*
        |--------------------------------------------------------------------------
        | KOMENTAR
        |--------------------------------------------------------------------------
        */

        $validated['komentar'] = null;

        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        $dataCenter =
            DataCenter::create($validated);

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'judul' =>
                'Pengajuan Data Center Baru',

            'pesan' =>
                $request->user()->username .
                ' menambahkan data center "' .
                $dataCenter->nama_infrastruktur .
                '" dengan ID ' .
                $dataCenter->id .
                ' dan mengajukannya untuk persetujuan.',

            'dibaca' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('data-center.index')
            ->with(
                'success',
                'Data datacenter berhasil diajukan dan menunggu disetujui verifikator.'
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

        $validated = $request->validate([

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

            'status' => [
                'nullable',
                'in:Tersedia,Digunakan',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | CARI DATA
        |--------------------------------------------------------------------------
        */

        $datacenter =
            DataCenter::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | JIKA BELI
        |--------------------------------------------------------------------------
        */

        if ($validated['pengadaan'] === 'Beli') {

            $validated['tanggal_berakhir'] = null;

            $validated['status'] =
                $validated['status'] ?? 'Tersedia';
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA SEWA
        |--------------------------------------------------------------------------
        */

        if ($validated['pengadaan'] === 'Sewa') {

            if (empty($validated['tanggal_berakhir'])) {

                return back()
                    ->withErrors([
                        'tanggal_berakhir' =>
                            'Tanggal berakhir wajib diisi untuk pengadaan sewa.',
                    ])
                    ->withInput();
            }

            $validated['status'] = 'Digunakan';
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI ULANG
        |--------------------------------------------------------------------------
        */

        $validated['verifikasi'] =
            'Menunggu disetujui';

        /*
        |--------------------------------------------------------------------------
        | HAPUS KOMENTAR LAMA
        |--------------------------------------------------------------------------
        */

        $validated['komentar'] = null;

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $datacenter->update($validated);

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'judul' =>
                'Perubahan Data Center Diajukan',

            'pesan' =>
                $request->user()->username .
                ' memperbarui data center "' .
                $datacenter->nama_infrastruktur .
                '" dengan ID ' .
                $datacenter->id .
                ' dan mengajukannya kembali untuk persetujuan.',

            'dibaca' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('data-center.index')
            ->with(
                'success',
                'Perubahan data datacenter berhasil diajukan dan menunggu disetujui verifikator.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Request $request,
        $id
    ) {

        $datacenter =
            DataCenter::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA UNTUK NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        $namaDataCenter =
            $datacenter->nama_infrastruktur;

        $idDataCenter =
            $datacenter->id;

        /*
        |--------------------------------------------------------------------------
        | AJUKAN PENGHAPUSAN
        |--------------------------------------------------------------------------
        */

        $datacenter->update([
            'verifikasi' =>
                'Menunggu disetujui',

            'komentar' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'judul' =>
                'Penghapusan Data Center Diajukan',

            'pesan' =>
                $request->user()->username .
                ' mengajukan penghapusan data center "' .
                $namaDataCenter .
                '" dengan ID ' .
                $idDataCenter .
                ' untuk persetujuan verifikator.',

            'dibaca' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('data-center.index')
            ->with(
                'success',
                'Permintaan penghapusan data berhasil diajukan dan menunggu disetujui verifikator.'
            );
    }
}