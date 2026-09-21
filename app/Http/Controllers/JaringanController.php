<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
use App\Models\Notification;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JaringanController extends Controller
{
    /**
     * ============================================================
     * INDEX
     * ============================================================
     */
    public function index(Request $request)
    {
        $query = Jaringan::query();

        // ========================================================
        // SEARCH
        // ========================================================

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('jenis_data', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        // ========================================================
        // FILTER JENIS DATA
        // ========================================================

        if ($request->filled('jenis_data')) {
            $query->where(
                'jenis_data',
                $request->jenis_data
            );
        }

        // ========================================================
        // FILTER VERIFIKASI
        // ========================================================

        if ($request->filled('verifikasi')) {

            $query->where(
                'verifikasi',
                $request->verifikasi
            );
        }

        // ========================================================
        // AMBIL DATA
        // ========================================================

        $jaringans = $query
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->get();

        // ========================================================
        // STATISTIK
        // ========================================================

        $totalJaringan = Jaringan::count();

        $totalFO = Jaringan::where(
            'jenis_data',
            'Jalur Kabel FO'
        )->count();

        $totalLocalLoop = Jaringan::where(
            'jenis_data',
            'Local Loop Sewa'
        )->count();

        $menunggu = Jaringan::where(
            'verifikasi',
            'menunggu'
        )->count();

        $disetujui = Jaringan::where(
            'verifikasi',
            'disetujui'
        )->count();

        $ditolak = Jaringan::where(
            'verifikasi',
            'ditolak'
        )->count();

        // ========================================================
        // DAFTAR JENIS DATA
        // ========================================================

        $jenisDatas = Jaringan::query()
            ->select('jenis_data')
            ->distinct()
            ->orderBy('jenis_data')
            ->pluck('jenis_data');

        // ========================================================
        // DAFTAR VERIFIKASI
        // ========================================================

        $verifikasis = Jaringan::query()
            ->select('verifikasi')
            ->distinct()
            ->orderBy('verifikasi')
            ->pluck('verifikasi');

        // ========================================================
        // RETURN VIEW
        // ========================================================

        return view(
            'infrastruktur.jaringan.index',
            compact(
                'jaringans',
                'totalJaringan',
                'totalFO',
                'totalLocalLoop',
                'menunggu',
                'disetujui',
                'ditolak',
                'jenisDatas',
                'verifikasis'
            )
        );
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
            'jenis_data' => [
                'required',
                'in:Jalur Kabel FO,Local Loop Sewa',
            ],

            'lokasi' => [
                'required',
                'string',
                'max:255',
            ],

            'jarak_kabel' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'jumlah_core' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'jumlah_titik' => [
                'nullable',
                'integer',
                'min:1',
            ],

        ]);

        // ========================================================
        // NORMALISASI DATA BERDASARKAN JENIS
        // ========================================================

        if ($validated['jenis_data'] === 'Jalur Kabel FO') {

            // Jarak kabel wajib
            if (
                !isset($validated['jarak_kabel']) ||
                $validated['jarak_kabel'] === ''
            ) {
                return back()
                    ->withErrors([
                        'jarak_kabel' =>
                            'Jarak kabel wajib diisi untuk Jalur Kabel FO.',
                    ])
                    ->withInput();
            }

            // Jumlah core wajib
            if (
                !isset($validated['jumlah_core']) ||
                $validated['jumlah_core'] === ''
            ) {
                return back()
                    ->withErrors([
                        'jumlah_core' =>
                            'Jumlah core wajib diisi untuk Jalur Kabel FO.',
                    ])
                    ->withInput();
            }

            // FO tidak menggunakan jumlah titik
            $validated['jumlah_titik'] = null;
        }

        if ($validated['jenis_data'] === 'Local Loop Sewa') {

            // Jumlah titik wajib
            if (
                !isset($validated['jumlah_titik']) ||
                $validated['jumlah_titik'] === ''
            ) {
                return back()
                    ->withErrors([
                        'jumlah_titik' =>
                            'Jumlah titik wajib diisi untuk Local Loop Sewa.',
                    ])
                    ->withInput();
            }

            // Local Loop tidak menggunakan data FO
            $validated['jarak_kabel'] = null;
            $validated['jumlah_core'] = null;
        }

        // ========================================================
        // GENERATE ID
        // ========================================================

        $prefix = $validated['jenis_data'] === 'Jalur Kabel FO'
            ? 'FO-'
            : 'LL-';

        $lastJaringan = Jaringan::where(
            'id',
            'like',
            $prefix . '%'
        )
            ->orderByRaw(
                'CAST(SUBSTRING(id, ?) AS UNSIGNED) DESC',
                [strlen($prefix) + 1]
            )
            ->first();

        if ($lastJaringan) {

            $lastNumber = (int) substr(
                $lastJaringan->id,
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

        // ========================================================
        // DEFAULT VERIFIKASI
        // ========================================================

        $validated['verifikasi'] = 'menunggu';

        // ========================================================
        // SIMPAN
        // ========================================================

        DB::transaction(function () use ($validated) {

            // ----------------------------------------------------
            // SIMPAN JARINGAN
            // ----------------------------------------------------

            $jaringan = Jaringan::create([
                'id' => $validated['id'],
                'jenis_data' => $validated['jenis_data'],
                'lokasi' => $validated['lokasi'],
                'jarak_kabel' => $validated['jarak_kabel'] ?? null,
                'jumlah_core' => $validated['jumlah_core'] ?? null,
                'jumlah_titik' => $validated['jumlah_titik'] ?? null,
                'verifikasi' => 'menunggu',
            ]);

            // ----------------------------------------------------
            // REQUEST VERIFIKASI
            // ----------------------------------------------------

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

            // ----------------------------------------------------
            // NOTIFIKASI
            // ----------------------------------------------------

            Notification::create([
                'judul' => 'Pengajuan Jaringan Baru',
                'pesan' =>
                    auth()->user()->username .
                    ' menambahkan jaringan "' .
                    $jaringan->jenis_data .
                    '" di lokasi "' .
                    $jaringan->lokasi .
                    '" dengan ID ' .
                    $jaringan->id .
                    ' dan mengajukannya untuk persetujuan.',
                'dibaca' => false,
            ]);
        });

        // ========================================================
        // REDIRECT
        // ========================================================

        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Data jaringan berhasil ditambahkan dan menunggu verifikasi.'
            );
    }


    /**
     * ============================================================
     * UPDATE
     * ============================================================
     */
    public function update(
        Request $request,
        $id
    ) {
        // ========================================================
        // CARI DATA
        // ========================================================

        $jaringan = Jaringan::findOrFail($id);

        // ========================================================
        // JENIS DATA TIDAK BOLEH BERUBAH
        // ========================================================

        if (
            $request->input('jenis_data') !==
            $jaringan->jenis_data
        ) {
            return back()
                ->withErrors([
                    'jenis_data' =>
                        'Jenis data tidak dapat diubah setelah data dibuat.',
                ])
                ->withInput();
        }

        // ========================================================
        // VALIDASI
        // ========================================================

        $validated = $request->validate([
            'jenis_data' => [
                'required',
                'in:Jalur Kabel FO,Local Loop Sewa',
            ],

            'lokasi' => [
                'required',
                'string',
                'max:255',
            ],

            'jarak_kabel' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'jumlah_core' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'jumlah_titik' => [
                'nullable',
                'integer',
                'min:1',
            ],

        ]);

        // ========================================================
        // NORMALISASI DATA
        // ========================================================

        if ($validated['jenis_data'] === 'Jalur Kabel FO') {

            // Jarak kabel wajib
            if (
                !isset($validated['jarak_kabel']) ||
                $validated['jarak_kabel'] === ''
            ) {
                return back()
                    ->withErrors([
                        'jarak_kabel' =>
                            'Jarak kabel wajib diisi untuk Jalur Kabel FO.',
                    ])
                    ->withInput();
            }

            // Jumlah core wajib
            if (
                !isset($validated['jumlah_core']) ||
                $validated['jumlah_core'] === ''
            ) {
                return back()
                    ->withErrors([
                        'jumlah_core' =>
                            'Jumlah core wajib diisi untuk Jalur Kabel FO.',
                    ])
                    ->withInput();
            }

            // FO tidak menggunakan jumlah titik
            $validated['jumlah_titik'] = null;
        }

        if ($validated['jenis_data'] === 'Local Loop Sewa') {

            // Jumlah titik wajib
            if (
                !isset($validated['jumlah_titik']) ||
                $validated['jumlah_titik'] === ''
            ) {
                return back()
                    ->withErrors([
                        'jumlah_titik' =>
                            'Jumlah titik wajib diisi untuk Local Loop Sewa.',
                    ])
                    ->withInput();
            }

            // Local Loop tidak menggunakan data FO
            $validated['jarak_kabel'] = null;
            $validated['jumlah_core'] = null;
        }

        // ========================================================
        // SIMPAN UPDATE
        // ========================================================

        DB::transaction(function () use (
            $jaringan,
            $validated,
            $request
        ) {

            // ----------------------------------------------------
            // UPDATE DATA JARINGAN
            // ----------------------------------------------------

            $jaringan->update([
                'jenis_data' => $validated['jenis_data'],
                'lokasi' => $validated['lokasi'],
                'jarak_kabel' => $validated['jarak_kabel'] ?? null,
                'jumlah_core' => $validated['jumlah_core'] ?? null,
                'jumlah_titik' => $validated['jumlah_titik'] ?? null,

                // Perubahan harus diverifikasi ulang
                'verifikasi' => 'menunggu',
            ]);

            // ----------------------------------------------------
            // REQUEST VERIFIKASI UPDATE
            // ----------------------------------------------------

            VerificationRequest::create([

                'module' => 'jaringan',
                'record_id' => $jaringan->id,
                'action' => 'update',
                'data' => $jaringan->fresh()->toArray(),
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

            // ----------------------------------------------------
            // NOTIFIKASI
            // ----------------------------------------------------

            Notification::create([
                'judul' => 'Perubahan Jaringan Diajukan',
                'pesan' =>
                    auth()->user()->username .
                    ' memperbarui jaringan "' .
                    $jaringan->jenis_data .
                    '" di lokasi "' .
                    $jaringan->lokasi .
                    '" dengan ID ' .
                    $jaringan->id .
                    ' dan mengajukannya kembali untuk persetujuan.',
                'dibaca' => false,
            ]);
        });

        // ========================================================
        // REDIRECT
        // ========================================================

        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Perubahan jaringan berhasil disimpan dan menunggu verifikasi.'
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
    public function destroy($id)
    {
        // ========================================================
        // CARI DATA
        // ========================================================

        $jaringan = Jaringan::findOrFail($id);

        // Simpan informasi sebelum proses transaksi
        $jenisData = $jaringan->jenis_data;
        $lokasi = $jaringan->lokasi;
        $idJaringan = $jaringan->id;

        // ========================================================
        // TRANSACTION
        // ========================================================

        DB::transaction(function () use (
            $jaringan,
            $jenisData,
            $lokasi,
            $idJaringan
        ) {

            // ----------------------------------------------------
            // TANDAI MENUNGGU VERIFIKASI
            // ----------------------------------------------------

            $jaringan->update([
                'verifikasi' => 'menunggu',
            ]);

            // ----------------------------------------------------
            // REQUEST PENGHAPUSAN
            // ----------------------------------------------------

            VerificationRequest::create([
                'module' => 'jaringan',
                'record_id' => $jaringan->id,
                'action' => 'delete',
                'data' => $jaringan->toArray(),
                'status' => 'menunggu',
                'submitted_by' => auth()->id(),
            ]);

            // ----------------------------------------------------
            // NOTIFIKASI
            // ----------------------------------------------------

            Notification::create([
                'judul' => 'Penghapusan Jaringan Diajukan',
                'pesan' =>
                    auth()->user()->username .
                    ' mengajukan penghapusan jaringan "' .
                    $jenisData .
                    '" di lokasi "' .
                    $lokasi .
                    '" dengan ID ' .
                    $idJaringan .
                    ' untuk persetujuan verifikator.',
                'dibaca' => false,
            ]);
        });

        // ========================================================
        // REDIRECT
        // ========================================================


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