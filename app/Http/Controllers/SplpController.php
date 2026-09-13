<?php

namespace App\Http\Controllers;

use App\Models\Splp;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SplpController extends Controller
{
    /**
     * Menentukan status SPLP secara otomatis.
     *
     * Beli
     * - Tidak Berakhir
     *
     * Sewa
     * - Expired   : tanggal berakhir sudah lewat
     * - Akan Habis : sisa <= 30 hari
     * - Digunakan  : sisa > 30 hari
     */
    private function getStatusOtomatis($splp)
    {
        if (strtolower($splp->pengadaan ?? '') === 'beli') {
            return 'Tidak Berakhir';
        }

        if (
            strtolower($splp->pengadaan ?? '') === 'sewa'
            && $splp->tanggal_berakhir
        ) {
            $today = Carbon::today();

            $tanggalBerakhir = Carbon::parse(
                $splp->tanggal_berakhir
            )->startOfDay();

            $daysLeft = $today->diffInDays(
                $tanggalBerakhir,
                false
            );

            if ($daysLeft < 0) {
                return 'Expired';
            }

            if ($daysLeft <= 30) {
                return 'Akan Habis';
            }

            return 'Digunakan';
        }

        return 'Tidak Berakhir';
    }

    /**
     * Generate ID otomatis:
     * INFSPLP-001
     * INFSPLP-002
     * INFSPLP-003
     * dst.
     */
    private function generateSplpId(): string
    {
        $prefix = 'INFSPLP-';

        $lastSplp = Splp::where(
            'id',
            'like',
            $prefix . '%'
        )
            ->orderByRaw(
                'CAST(SUBSTRING(id, 9) AS UNSIGNED) DESC'
            )
            ->first();

        $newNumber = $lastSplp
            ? ((int) substr(
                $lastSplp->id,
                strlen($prefix)
            )) + 1
            : 1;

        return $prefix . str_pad(
            $newNumber,
            3,
            '0',
            STR_PAD_LEFT
        );
    }

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
        | DATA SPLP
        |--------------------------------------------------------------------------
        */
        $splps = $query
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | STATUS OTOMATIS
        |--------------------------------------------------------------------------
        */
        foreach ($splps as $splp) {
            $splp->status_otomatis =
                $this->getStatusOtomatis($splp);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS OTOMATIS
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
        | STATISTIK
        |--------------------------------------------------------------------------
        */
        $allSplps = Splp::all();

        foreach ($allSplps as $splp) {
            $splp->status_otomatis =
                $this->getStatusOtomatis($splp);
        }

        $tidakBerakhir = $allSplps
            ->where(
                'status_otomatis',
                'Tidak Berakhir'
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
        | DAFTAR TAHUN
        |--------------------------------------------------------------------------
        */
        $tahuns = Splp::query()
            ->whereNotNull('tanggal_pengadaan')
            ->selectRaw(
                'YEAR(tanggal_pengadaan) as tahun'
            )
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        /*
        |--------------------------------------------------------------------------
        | DAFTAR STATUS VERIFIKASI
        |--------------------------------------------------------------------------
        */
        $verifikasis = Splp::query()
            ->whereNotNull('verifikasi')
            ->select('verifikasi')
            ->distinct()
            ->orderBy('verifikasi')
            ->pluck('verifikasi');

        return view(
            'infrastruktur.splp.index',
            compact(
                'splps',
                'totalSplp',
                'tidakBerakhir',
                'digunakan',
                'akanHabis',
                'expired',
                'tahuns',
                'verifikasis'
            )
        );
    }

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
        ]);

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
            if (empty($validated['tanggal_berakhir'])) {
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
        | ID OTOMATIS
        |--------------------------------------------------------------------------
        */
        $validated['id'] =
            $this->generateSplpId();

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI
        |--------------------------------------------------------------------------
        */
        $validated['verifikasi'] = 'menunggu';
        $validated['komentar'] = null;

        DB::transaction(function () use ($validated) {

            $splp = Splp::create(
                $validated
            );

            VerificationRequest::create([
                'module' => 'splp',

                'record_id' => $splp->id,

                'action' => 'create',

                'data' => $splp->toArray(),

                'status' => 'menunggu',

                'submitted_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('splp.index')
            ->with(
                'success',
                'Data SPLP berhasil ditambahkan dan menunggu verifikasi.'
            );
    }

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
        ]);

        $splp = Splp::findOrFail($id);

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
            if (empty($validated['tanggal_berakhir'])) {
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
        | SIMPAN + AJUKAN VERIFIKASI
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $splp,
            $validated
        ) {

            $splp->update([
                ...$validated,

                'verifikasi' => 'menunggu',

                'komentar' => null,
            ]);

            $splp->refresh();

            VerificationRequest::create([
                'module' => 'splp',

                'record_id' => $splp->id,

                'action' => 'update',

                'data' => [
                    'data_lama' => $splp->getOriginal(),
                    'data_baru' => $splp->toArray(),
                ],

                'status' => 'menunggu',

                'submitted_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('splp.index')
            ->with(
                'success',
                'Perubahan SPLP berhasil disimpan dan menunggu verifikasi.'
            );
    }

    public function destroy($id)
    {
        $splp = Splp::findOrFail($id);

        DB::transaction(function () use ($splp) {

            /*
            |--------------------------------------------------------------------------
            | JANGAN HAPUS FISIK
            |--------------------------------------------------------------------------
            | Data tetap ada sampai Verifikator menyetujui.
            */

            $splp->update([
                'verifikasi' => 'menunggu',

                'komentar' => null,
            ]);

            VerificationRequest::create([
                'module' => 'splp',

                'record_id' => $splp->id,

                'action' => 'delete',

                'data' => $splp->toArray(),

                'status' => 'menunggu',

                'submitted_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('splp.index')
            ->with(
                'success',
                'Pengajuan penghapusan SPLP berhasil dikirim dan menunggu verifikasi.'
            );
    }
}