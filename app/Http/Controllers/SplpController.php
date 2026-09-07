<?php

namespace App\Http\Controllers;

use App\Models\Splp;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SplpController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HITUNG STATUS OTOMATIS
    |--------------------------------------------------------------------------
    */

    private function getStatusOtomatis($splp)
    {
        /*
        |--------------------------------------------------------------------------
        | JIKA BELI
        |--------------------------------------------------------------------------
        */

        if ($splp->pengadaan === 'Beli') {
            return $splp->status ?? 'Tersedia';
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA SEWA
        |--------------------------------------------------------------------------
        */

        if (
            $splp->pengadaan === 'Sewa' &&
            $splp->tanggal_berakhir
        ) {

            $today = Carbon::today();

            $tanggalBerakhir = Carbon::parse(
                $splp->tanggal_berakhir
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

        return $splp->status ?? 'Tersedia';
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Splp::query();

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

        $splps = $query
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | HITUNG STATUS OTOMATIS
        |--------------------------------------------------------------------------
        */

        foreach ($splps as $splp) {

            $splp->status_otomatis =
                $this->getStatusOtomatis($splp);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $splps = $splps
                ->filter(function ($splp) use ($request) {

                    return $splp->status_otomatis ===
                        $request->status;
                })
                ->values();
        }

        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK CARD
        |--------------------------------------------------------------------------
        */

        $allSplps = Splp::all();

        foreach ($allSplps as $splp) {

            $splp->status_otomatis =
                $this->getStatusOtomatis($splp);
        }

        /*
        |--------------------------------------------------------------------------
        | JUMLAH STATUS
        |--------------------------------------------------------------------------
        */

        $tersedia = $allSplps
            ->where(
                'status_otomatis',
                'Tersedia'
            )
            ->count();

        $digunakan = $allSplps
            ->where(
                'status_otomatis',
                'Digunakan'
            )
            ->count();

        $akanHabis = $allSplps
            ->where(
                'status_otomatis',
                'Akan Habis'
            )
            ->count();

        $expired = $allSplps
            ->where(
                'status_otomatis',
                'Expired'
            )
            ->count();

        $totalSplp = $allSplps->count();

        /*
        |--------------------------------------------------------------------------
        | DATA TAHUN UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $tahuns = Splp::query()
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

        $verifikasis = Splp::query()
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
            'infrastruktur.splp.index',
            compact(
                'splps',
                'totalSplp',
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

        $prefix = 'INFSPLP-';

        $lastSplp = Splp::where(
            'id',
            'like',
            $prefix . '%'
        )
            ->orderByRaw(
                'CAST(SUBSTRING(id, 6) AS UNSIGNED) DESC'
            )
            ->first();

        if ($lastSplp) {

            $lastNumber = (int) substr(
                $lastSplp->id,
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

        $splp = Splp::create($validated);

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'judul' =>
                'Pengajuan SPLP Baru',

            'pesan' =>
                $request->user()->username .
                ' menambahkan SPLP "' .
                $splp->nama_infrastruktur .
                '" dengan ID ' .
                $splp->id .
                ' dan mengajukannya untuk persetujuan.',

            'dibaca' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('splp.index')
            ->with(
                'success',
                'Data splp berhasil diajukan dan menunggu disetujui verifikator.'
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

        $splp = Splp::findOrFail($id);

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

        $splp->update($validated);

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'judul' =>
                'Perubahan SPLP Diajukan',

            'pesan' =>
                $request->user()->username .
                ' memperbarui SPLP "' .
                $splp->nama_infrastruktur .
                '" dengan ID ' .
                $splp->id .
                ' dan mengajukannya kembali untuk persetujuan.',

            'dibaca' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('splp.index')
            ->with(
                'success',
                'Perubahan data splp berhasil diajukan dan menunggu disetujui verifikator.'
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

        $splp = Splp::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA UNTUK NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        $namaSplp =
            $splp->nama_infrastruktur;

        $idSplp =
            $splp->id;

        /*
        |--------------------------------------------------------------------------
        | AJUKAN PENGHAPUSAN
        |--------------------------------------------------------------------------
        */

        $splp->update([
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
                'Penghapusan SPLP Diajukan',

            'pesan' =>
                $request->user()->username .
                ' mengajukan penghapusan SPLP "' .
                $namaSplp .
                '" dengan ID ' .
                $idSplp .
                ' untuk persetujuan verifikator.',

            'dibaca' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('splp.index')
            ->with(
                'success',
                'Permintaan penghapusan data berhasil diajukan dan menunggu disetujui verifikator.'
            );
    }
}