<?php

namespace App\Http\Controllers;

use App\Models\SoftwareAsset;
use App\Models\SoftwareCounter;
use App\Models\Notification;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoftwareController extends Controller
{
    /**
     * ============================================================
     * INDEX
     * ============================================================
     */
    public function index(Request $request)
    {
        $query = SoftwareAsset::query();

        // ========================================================
        // SEARCH
        // ========================================================

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('spesifikasi', 'like', "%{$search}%");
            });
        }

        // ========================================================
        // FILTER PENGADAAN
        // ========================================================

        if ($request->filled('pengadaan')) {
            $query->where(
                'pengadaan',
                $request->pengadaan
            );
        }

        // ========================================================
        // AMBIL DATA
        // ========================================================

        $softwares = $query
            ->latest()
            ->get();

        $allSoftwares = SoftwareAsset::all();

        // ========================================================
        // STATISTIK
        // ========================================================

        $totalSoftware = $allSoftwares->count();

        $totalLisensi = $allSoftwares->sum(
            'jumlah_lisensi'
        );

        $today = now()->startOfDay();

        $thirtyDaysLater = now()
            ->addDays(30)
            ->endOfDay();

        // ========================================================
        // SOFTWARE EXPIRED
        // ========================================================

        $expired = $allSoftwares
            ->filter(function ($software) use ($today) {

                return $software->tanggal_berakhir
                    && $software->tanggal_berakhir->lt($today);
            })
            ->count();

        // ========================================================
        // AKAN BERAKHIR
        // ========================================================

        $akanBerakhir = $allSoftwares
            ->filter(function ($software) use (
                $today,
                $thirtyDaysLater
            ) {

                return $software->tanggal_berakhir
                    && $software->tanggal_berakhir->between(
                        $today,
                        $thirtyDaysLater
                    );
            })
            ->count();

        // ========================================================
        // TERSEDIA
        // ========================================================

        $tersedia = $allSoftwares
            ->filter(function ($software) use (
                $thirtyDaysLater
            ) {

                if (!$software->tanggal_berakhir) {
                    return true;
                }

                return $software->tanggal_berakhir
                    ->greaterThan($thirtyDaysLater);
            })
            ->count();

        // ========================================================
        // TOTAL PENGELUARAN PER TAHUN
        // ========================================================

        $totalPengeluaranPertahun = $allSoftwares
            ->sum(function ($software) {

                $harga = (float) $software->harga;

                // Jika beli → langsung dihitung penuh
                if ($software->pengadaan === 'Beli') {
                    return $harga;
                }

                // Jika sewa tetapi tanggal tidak lengkap
                if (
                    !$software->tanggal_pengadaan ||
                    !$software->tanggal_berakhir
                ) {
                    return 0;
                }

                $tanggalMulai =
                    $software->tanggal_pengadaan;

                $tanggalBerakhir =
                    $software->tanggal_berakhir;

                $jumlahBulan =
                    $tanggalMulai->diffInMonths(
                        $tanggalBerakhir
                    );

                $jumlahBulan =
                    max(1, $jumlahBulan);

                return ($harga / $jumlahBulan) * 12;
            });

        // ========================================================
        // RETURN VIEW
        // ========================================================

        return view(
            'software.index',
            compact(
                'softwares',
                'totalSoftware',
                'totalLisensi',
                'akanBerakhir',
                'expired',
                'tersedia',
                'totalPengeluaranPertahun'
            )
        );
    }


    /**
     * ============================================================
     * CREATE
     * ============================================================
     */
    public function create()
    {
        return view('software.create');
    }


    /**
     * ============================================================
     * STORE
     * ============================================================
     */
    public function store(Request $request)
    {
        // ========================================================
        // VALIDASI
        // ========================================================

        $validated = $request->validate([
            'jenis' => [
                'required',
                'string',
                'max:255',
            ],

            'spesifikasi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'jumlah_lisensi' => [
                'required',
                'integer',
                'min:1',
            ],

            'pengadaan' => [
                'required',
                'in:Sewa,Beli',
            ],

            'periode_sewa' => [
                'nullable',
                'string',
                'max:100',
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

        // ========================================================
        // TRANSACTION
        // ========================================================

        DB::transaction(function () use (&$validated) {

            // ----------------------------------------------------
            // GENERATE KODE SOFTWARE
            // ----------------------------------------------------
            //
            // Format:
            // SW-260001
            // SW-260002
            // SW-260003
            //
            // Tahun berubah:
            // SW-270001
            // SW-270002
            //
            // Counter tidak kembali walaupun data dihapus.
            //

            $year = now()->year;

            $counter = SoftwareCounter::where(
                'year',
                $year
            )
                ->lockForUpdate()
                ->first();

            if (!$counter) {

                $counter = SoftwareCounter::create([
                    'year' => $year,
                    'last_number' => 0,
                ]);
            }

            $counter->increment(
                'last_number'
            );

            $number =
                $counter
                    ->fresh()
                    ->last_number;

            $validated['kode'] =
                sprintf(
                    'SW-%02d%04d',
                    $year % 100,
                    $number
                );

            // ----------------------------------------------------
            // STATUS AWAL
            // ----------------------------------------------------

            $validated['verifikasi'] =
                'menunggu';

            $validated['komentar'] =
                null;

            // ----------------------------------------------------
            // SIMPAN SOFTWARE
            // ----------------------------------------------------

            $software =
                SoftwareAsset::create(
                    $validated
                );

            // ----------------------------------------------------
            // REQUEST VERIFIKASI
            // ----------------------------------------------------

            VerificationRequest::create([
                'module' => 'software',
                'record_id' => $software->id,
                'action' => 'create',
                'data' => $software->toArray(),
                'status' => 'menunggu',
                'submitted_by' => auth()->id(),
            ]);

            // ----------------------------------------------------
            // NOTIFIKASI
            // ----------------------------------------------------

            Notification::create([
                'judul' =>
                    'Pengajuan Software Baru',

                'pesan' =>
                    auth()->user()->username .
                    ' menambahkan software "' .
                    $software->jenis .
                    '" dengan kode ' .
                    $software->kode .
                    ' dan mengajukannya untuk persetujuan.',

                'dibaca' => false,
            ]);
        });

        // ========================================================
        // REDIRECT
        // ========================================================

        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Pengajuan penambahan software berhasil dikirim dan menunggu verifikasi.'
            );
    }


    /**
     * ============================================================
     * EDIT
     * ============================================================
     */
    public function edit(SoftwareAsset $software)
    {
        return view(
            'software.edit',
            compact('software')
        );
    }


    /**
     * ============================================================
     * UPDATE
     * ============================================================
     */
    public function update(
        Request $request,
        SoftwareAsset $software
    ) {
        // ========================================================
        // VALIDASI
        // ========================================================

        $validated = $request->validate([
            'jenis' => [
                'required',
                'string',
                'max:255',
            ],

            'spesifikasi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'jumlah_lisensi' => [
                'required',
                'integer',
                'min:1',
            ],

            'pengadaan' => [
                'required',
                'in:Sewa,Beli',
            ],

            'periode_sewa' => [
                'nullable',
                'string',
                'max:100',
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

        // ========================================================
        // TRANSACTION
        // ========================================================

        DB::transaction(function () use (
            $validated,
            $software
        ) {

            // ----------------------------------------------------
            // KODE TIDAK DIUBAH
            // ----------------------------------------------------

            $validated['verifikasi'] =
                'menunggu';

            $validated['komentar'] =
                null;

            // ----------------------------------------------------
            // UPDATE SOFTWARE
            // ----------------------------------------------------

            $software->update(
                $validated
            );

            // Refresh data terbaru
            $software->refresh();

            // ----------------------------------------------------
            // REQUEST VERIFIKASI UPDATE
            // ----------------------------------------------------

            VerificationRequest::create([
                'module' => 'software',
                'record_id' => $software->id,
                'action' => 'update',
                'data' => $software->toArray(),
                'status' => 'menunggu',
                'submitted_by' => auth()->id(),
            ]);

            // ----------------------------------------------------
            // NOTIFIKASI
            // ----------------------------------------------------

            Notification::create([
                'judul' =>
                    'Perubahan Software Diajukan',

                'pesan' =>
                    auth()->user()->username .
                    ' memperbarui software "' .
                    $software->jenis .
                    '" dengan kode ' .
                    $software->kode .
                    ' dan mengajukannya kembali untuk persetujuan.',

                'dibaca' => false,
            ]);
        });

        // ========================================================
        // REDIRECT
        // ========================================================

        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Perubahan software berhasil disimpan dan menunggu verifikasi.'
            );
    }


    /**
     * ============================================================
     * DESTROY
     * ============================================================
     *
     * Data tidak langsung dihapus.
     * Penghapusan dikirim sebagai request verifikasi.
     */
    public function destroy(
        SoftwareAsset $software
    ) {

        // ========================================================
        // SIMPAN INFORMASI UNTUK NOTIFIKASI
        // ========================================================

        $namaSoftware =
            $software->jenis;

        $kodeSoftware =
            $software->kode;

        // ========================================================
        // TRANSACTION
        // ========================================================

        DB::transaction(function () use (
            $software,
            $namaSoftware,
            $kodeSoftware
        ) {

            // ----------------------------------------------------
            // TANDAI MENUNGGU VERIFIKASI
            // ----------------------------------------------------

            $software->update([
                'verifikasi' => 'menunggu',
                'komentar' => null,
            ]);

            // ----------------------------------------------------
            // REQUEST PENGHAPUSAN
            // ----------------------------------------------------

            VerificationRequest::create([
                'module' => 'software',
                'record_id' => $software->id,
                'action' => 'delete',
                'data' => $software->fresh()->toArray(),
                'status' => 'menunggu',
                'submitted_by' => auth()->id(),
            ]);

            // ----------------------------------------------------
            // NOTIFIKASI
            // ----------------------------------------------------

            Notification::create([
                'judul' =>
                    'Penghapusan Software Diajukan',

                'pesan' =>
                    auth()->user()->username .
                    ' mengajukan penghapusan software "' .
                    $namaSoftware .
                    '" dengan kode ' .
                    $kodeSoftware .
                    ' untuk persetujuan verifikator.',

                'dibaca' => false,
            ]);
        });

        // ========================================================
        // REDIRECT
        // ========================================================

        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Pengajuan penghapusan software berhasil dikirim dan menunggu verifikasi.'
            );
    }
}