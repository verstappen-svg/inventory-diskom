<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
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
     * - Akan Habis (30 hari sebelum berakhir)
     * - Expired
     */
    private function getStatusOtomatis($jaringan)
    {
        // Jika pengadaan Beli,
        // tidak membutuhkan tanggal berakhir.
        if ($jaringan->pengadaan === 'Beli') {
            return 'Tersedia';
        }

        // Jika pengadaan Sewa dan memiliki tanggal berakhir.
        if (
            $jaringan->pengadaan === 'Sewa' &&
            $jaringan->tanggal_berakhir
        ) {
            $today = Carbon::today();

            $tanggalBerakhir = Carbon::parse(
                $jaringan->tanggal_berakhir
            );

            // Sudah lewat tanggal berakhir.
            if ($tanggalBerakhir->lt($today)) {
                return 'Expired';
            }

            // Akan berakhir dalam 30 hari.
            if (
                $tanggalBerakhir->gte($today) &&
                $tanggalBerakhir->lte(
                    $today->copy()->addDays(30)
                )
            ) {
                return 'Akan Habis';
            }

            // Masih aktif digunakan.
            return 'Digunakan';
        }

        // Fallback.
        return 'Tersedia';
    }

    /**
     * Menampilkan halaman jaringan.
     */
    public function index(Request $request)
    {
        $query = Jaringan::query();

        // Search
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

        // Filter pengadaan
        if ($request->filled('pengadaan')) {
            $query->where(
                'pengadaan',
                $request->pengadaan
            );
        }

        // Filter verifikasi
        if ($request->filled('verifikasi')) {
            $query->where(
                'verifikasi',
                $request->verifikasi
            );
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear(
                'tanggal_pengadaan',
                $request->tahun
            );
        }

        // Ambil data
        $jaringans = $query
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->get();

        // Hitung status otomatis
        foreach ($jaringans as $jaringan) {
            $jaringan->status_otomatis =
                $this->getStatusOtomatis($jaringan);
        }

        // Filter status otomatis
        if ($request->filled('status')) {
            $jaringans = $jaringans
                ->filter(function ($jaringan) use ($request) {
                    return $jaringan->status_otomatis ===
                        $request->status;
                })
                ->values();
        }

        // Semua data untuk statistik
        $allJaringans = Jaringan::all();

        foreach ($allJaringans as $jaringan) {
            $jaringan->status_otomatis =
                $this->getStatusOtomatis($jaringan);
        }

        // Statistik
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

        // Daftar tahun pengadaan
        $tahuns = Jaringan::query()
            ->whereNotNull('tanggal_pengadaan')
            ->selectRaw(
                'YEAR(tanggal_pengadaan) as tahun'
            )
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // Daftar status verifikasi
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

    /**
     * Menyimpan jaringan baru.
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
        ]);

        /**
         * Jika Beli:
         * tanggal berakhir tidak diperlukan.
         */
        if ($validated['pengadaan'] === 'Beli') {
            $validated['tanggal_berakhir'] = null;
        }

        /**
         * Jika Sewa:
         * tanggal berakhir wajib diisi.
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

        /**
         * Generate ID otomatis.
         *
         * Contoh:
         * INFJAR-001
         * INFJAR-002
         * INFJAR-003
         */
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

        /**
         * Status verifikasi selalu menunggu
         * ketika data baru dibuat.
         */
        $validated['verifikasi'] = 'menunggu';
        $validated['komentar'] = null;

        DB::transaction(function () use ($validated) {

            // Simpan jaringan
            $jaringan = Jaringan::create($validated);

            // Buat request verifikasi
            VerificationRequest::create([
                'module' => 'jaringan',

                'record_id' => $jaringan->id,

                'action' => 'create',

                'data' => $jaringan->toArray(),

                'status' => 'menunggu',

                'submitted_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Data jaringan berhasil ditambahkan dan menunggu verifikasi.'
            );
    }

    /**
     * Memperbarui jaringan.
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
        ]);

        /**
         * Cari data jaringan.
         */
        $jaringan = Jaringan::findOrFail($id);

        /**
         * Jika Beli:
         * tanggal berakhir dikosongkan.
         */
        if ($validated['pengadaan'] === 'Beli') {
            $validated['tanggal_berakhir'] = null;
        }

        /**
         * Jika Sewa:
         * tanggal berakhir wajib diisi.
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

        DB::transaction(function () use (
            $jaringan,
            $validated
        ) {

            /**
             * Update data jaringan.
             *
             * Setiap perubahan kembali
             * membutuhkan verifikasi.
             */
            $jaringan->update([
                ...$validated,

                'verifikasi' => 'menunggu',

                'komentar' => null,
            ]);

            /**
             * Buat request verifikasi update.
             */
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
        });

        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Perubahan jaringan berhasil disimpan dan menunggu verifikasi.'
            );
    }

    /**
     * Mengajukan penghapusan jaringan.
     *
     * Data tidak langsung dihapus.
     * Penghapusan menunggu verifikasi.
     */
    public function destroy($id)
    {
        $jaringan = Jaringan::findOrFail($id);

        DB::transaction(function () use ($jaringan) {

            /**
             * Tandai data sedang menunggu verifikasi.
             */
            $jaringan->update([
                'verifikasi' => 'menunggu',

                'komentar' => null,
            ]);

            /**
             * Buat request penghapusan.
             */
            VerificationRequest::create([
                'module' => 'jaringan',

                'record_id' => $jaringan->id,

                'action' => 'delete',

                'data' => $jaringan->toArray(),

                'status' => 'menunggu',

                'submitted_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Pengajuan penghapusan jaringan berhasil dikirim dan menunggu verifikasi.'
            );
    }
}