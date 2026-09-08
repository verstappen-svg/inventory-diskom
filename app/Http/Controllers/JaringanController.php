<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
use App\Models\Notification;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JaringanController extends Controller
{
    /**
     * Menentukan status jaringan secara otomatis.
     *
     * Beli:
     * - Tersedia
     *
     * Sewa:
     * - Digunakan
     * - Akan Habis
     * - Expired
     */
    private function getStatusOtomatis($jaringan)
    {
        // Jika pengadaan Beli
        if ($jaringan->pengadaan === 'Beli') {
            return 'Tersedia';
        }

        // Jika pengadaan Sewa dan memiliki tanggal berakhir
        if (
            $jaringan->pengadaan === 'Sewa' &&
            $jaringan->tanggal_berakhir
        ) {
            $today = Carbon::today();

            $tanggalBerakhir = Carbon::parse(
                $jaringan->tanggal_berakhir
            );

            // Sudah lewat tanggal berakhir
            if ($tanggalBerakhir->lt($today)) {
                return 'Expired';
            }

            // Akan berakhir dalam 30 hari
            if (
                $tanggalBerakhir->gte($today) &&
                $tanggalBerakhir->lte(
                    $today->copy()->addDays(30)
                )
            ) {
                return 'Akan Habis';
            }

            // Masih aktif
            return 'Digunakan';
        }

        // Fallback
        return $jaringan->status ?? 'Tersedia';
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Jaringan::query();

        // =====================================================
        // SEARCH
        // =====================================================

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


        // =====================================================
        // FILTER PENGADAAN
        // =====================================================

        if ($request->filled('pengadaan')) {

            $query->where(
                'pengadaan',
                $request->pengadaan
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
        // FILTER TAHUN
        // =====================================================

        if ($request->filled('tahun')) {

            $query->whereYear(
                'tanggal_pengadaan',
                $request->tahun
            );
        }


        // =====================================================
        // AMBIL DATA
        // =====================================================

        $jaringans = $query
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->get();


        // =====================================================
        // HITUNG STATUS OTOMATIS
        // =====================================================

        foreach ($jaringans as $jaringan) {

            $jaringan->status_otomatis =
                $this->getStatusOtomatis($jaringan);
        }


        // =====================================================
        // FILTER STATUS OTOMATIS
        // =====================================================

        if ($request->filled('status')) {

            $jaringans = $jaringans
                ->filter(function ($jaringan) use ($request) {

                    return $jaringan->status_otomatis ===
                        $request->status;
                })
                ->values();
        }


        // =====================================================
        // DATA UNTUK STATISTIK
        // =====================================================

        $allJaringans = Jaringan::all();

        foreach ($allJaringans as $jaringan) {

            $jaringan->status_otomatis =
                $this->getStatusOtomatis($jaringan);
        }


        // =====================================================
        // JUMLAH STATUS
        // =====================================================

        $tersedia = $allJaringans
            ->where('status_otomatis', 'Tersedia')
            ->count();

        $digunakan = $allJaringans
            ->where('status_otomatis', 'Digunakan')
            ->count();

        $akanHabis = $allJaringans
            ->where('status_otomatis', 'Akan Habis')
            ->count();

        $expired = $allJaringans
            ->where('status_otomatis', 'Expired')
            ->count();

        $totalJaringan = $allJaringans->count();


        // =====================================================
        // DATA TAHUN
        // =====================================================

        $tahuns = Jaringan::query()
            ->whereNotNull('tanggal_pengadaan')
            ->selectRaw(
                'YEAR(tanggal_pengadaan) as tahun'
            )
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');


        // =====================================================
        // DATA STATUS VERIFIKASI
        // =====================================================

        $verifikasis = Jaringan::query()
            ->whereNotNull('verifikasi')
            ->select('verifikasi')
            ->distinct()
            ->orderBy('verifikasi')
            ->pluck('verifikasi');


        return view(
            'infrastruktur.jaringan.index',
            compact(
                'jaringans',
                'totalJaringan',
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
        // =====================================================
        // VALIDASI
        // =====================================================

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

        ]);


        // =====================================================
        // JIKA BELI
        // =====================================================

        if ($validated['pengadaan'] === 'Beli') {

            $validated['tanggal_berakhir'] = null;
        }


        // =====================================================
        // JIKA SEWA
        // =====================================================

        if ($validated['pengadaan'] === 'Sewa') {

            if (empty($validated['tanggal_berakhir'])) {

                return back()
                    ->withErrors([
                        'tanggal_berakhir' =>
                            'Tanggal berakhir wajib diisi untuk pengadaan sewa.',
                    ])
                    ->withInput();
            }
        }


        // =====================================================
        // GENERATE ID OTOMATIS
        // Contoh:
        // INFJAR-001
        // INFJAR-002
        // =====================================================

        $prefix = 'INFJAR-';

        $lastJaringan = Jaringan::where(
            'id',
            'like',
            $prefix . '%'
        )
            ->orderByRaw(
                'CAST(SUBSTRING(id, 8) AS UNSIGNED) DESC'
            )
            ->first();


        $newNumber = $lastJaringan
            ? (
                (int) substr(
                    $lastJaringan->id,
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


        // =====================================================
        // STATUS VERIFIKASI
        // =====================================================

        $validated['verifikasi'] =
            'menunggu';

        $validated['komentar'] = null;


        // =====================================================
        // SIMPAN + REQUEST VERIFIKASI
        // =====================================================

        DB::transaction(function () use (
            $validated,
            $request
        ) {

            // Simpan jaringan
            $jaringan = Jaringan::create(
                $validated
            );


            // Buat request verifikasi
            VerificationRequest::create([

                'module' => 'jaringan',

                'record_id' => $jaringan->id,

                'action' => 'create',

                'data' => $jaringan->toArray(),

                'status' => 'menunggu',

                'submitted_by' => auth()->id(),

            ]);


            // =================================================
            // NOTIFIKASI
            // =================================================

            Notification::create([

                'judul' =>
                    'Pengajuan Jaringan Baru',

                'pesan' =>
                    $request->user()->username .
                    ' menambahkan jaringan "' .
                    $jaringan->nama_infrastruktur .
                    '" dengan ID ' .
                    $jaringan->id .
                    ' dan mengajukannya untuk persetujuan.',

                'dibaca' => false,

            ]);
        });


        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Data jaringan berhasil ditambahkan dan menunggu verifikasi.'
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

        // =====================================================
        // VALIDASI
        // =====================================================

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

        ]);


        // =====================================================
        // CARI DATA
        // =====================================================

        $jaringan = Jaringan::findOrFail($id);


        // =====================================================
        // JIKA BELI
        // =====================================================

        if ($validated['pengadaan'] === 'Beli') {

            $validated['tanggal_berakhir'] = null;
        }


        // =====================================================
        // JIKA SEWA
        // =====================================================

        if ($validated['pengadaan'] === 'Sewa') {

            if (empty($validated['tanggal_berakhir'])) {

                return back()
                    ->withErrors([
                        'tanggal_berakhir' =>
                            'Tanggal berakhir wajib diisi untuk pengadaan sewa.',
                    ])
                    ->withInput();
            }
        }


        // =====================================================
        // STATUS VERIFIKASI
        // =====================================================

        $validated['verifikasi'] =
            'menunggu';

        $validated['komentar'] = null;


        // =====================================================
        // UPDATE + REQUEST VERIFIKASI
        // =====================================================

        DB::transaction(function () use (
            $jaringan,
            $validated,
            $request
        ) {

            $jaringan->update(
                $validated
            );


            // Request verifikasi update
            VerificationRequest::create([

                'module' => 'jaringan',

                'record_id' => $jaringan->id,

                'action' => 'update',

                'data' => $jaringan
                    ->fresh()
                    ->toArray(),

                'status' => 'menunggu',

                'submitted_by' => auth()->id(),

            ]);


            // =================================================
            // NOTIFIKASI UPDATE
            // =================================================

            Notification::create([

                'judul' =>
                    'Perubahan Jaringan Diajukan',

                'pesan' =>
                    $request->user()->username .
                    ' memperbarui jaringan "' .
                    $jaringan->nama_infrastruktur .
                    '" dengan ID ' .
                    $jaringan->id .
                    ' dan mengajukannya kembali untuk persetujuan.',

                'dibaca' => false,

            ]);
        });


        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Perubahan jaringan berhasil disimpan dan menunggu verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $jaringan = Jaringan::findOrFail($id);


        // =====================================================
        // SIMPAN DATA UNTUK NOTIFIKASI
        // =====================================================

        $namaJaringan =
            $jaringan->nama_infrastruktur;

        $idJaringan =
            $jaringan->id;

        $username =
            auth()->user()->username;


        // =====================================================
        // AJUKAN PENGHAPUSAN
        // =====================================================

        DB::transaction(function () use (
            $jaringan
        ) {

            // Tandai menunggu verifikasi
            $jaringan->update([

                'verifikasi' =>
                    'menunggu',

                'komentar' =>
                    null,

            ]);


            // Buat request penghapusan
            VerificationRequest::create([

                'module' =>
                    'jaringan',

                'record_id' =>
                    $jaringan->id,

                'action' =>
                    'delete',

                'data' =>
                    $jaringan->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),

            ]);
        });


        // =====================================================
        // NOTIFIKASI
        // =====================================================

        Notification::create([

            'judul' =>
                'Penghapusan Jaringan Diajukan',

            'pesan' =>
                $username .
                ' mengajukan penghapusan jaringan "' .
                $namaJaringan .
                '" dengan ID ' .
                $idJaringan .
                ' untuk persetujuan verifikator.',

            'dibaca' =>
                false,

        ]);


        // =====================================================
        // REDIRECT
        // =====================================================

        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Pengajuan penghapusan jaringan berhasil dikirim dan menunggu verifikasi.'
            );
    }
}