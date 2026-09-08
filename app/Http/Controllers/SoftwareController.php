<?php

namespace App\Http\Controllers;

use App\Models\SoftwareAsset;
use App\Models\SoftwareCounter;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoftwareController extends Controller
{
    public function index(Request $request)
    {
        $query = SoftwareAsset::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('spesifikasi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('pengadaan')) {
            $query->where('pengadaan', $request->pengadaan);
        }

        $softwares = $query->latest()->get();

        $allSoftwares = SoftwareAsset::all();

        $totalSoftware = $allSoftwares->count();
        $totalLisensi = $allSoftwares->sum('jumlah_lisensi');

        $today = now()->startOfDay();
        $thirtyDaysLater = now()->addDays(30)->endOfDay();

        $expired = $allSoftwares->filter(function ($software) use ($today) {
            return $software->tanggal_berakhir
                && $software->tanggal_berakhir->lt($today);
        })->count();

        $akanBerakhir = $allSoftwares->filter(function ($software) use (
            $today,
            $thirtyDaysLater
        ) {
            return $software->tanggal_berakhir
                && $software->tanggal_berakhir->between(
                    $today,
                    $thirtyDaysLater
                );
        })->count();

        $tersedia = $allSoftwares->filter(function ($software) use (
            $thirtyDaysLater
        ) {
            if (!$software->tanggal_berakhir) {
                return true;
            }

            return $software->tanggal_berakhir
                ->greaterThan($thirtyDaysLater);
        })->count();

        $totalPengeluaranPertahun = $allSoftwares->sum(function ($software) {
            $harga = (float) $software->harga;

            if ($software->pengadaan === 'Beli') {
                return $harga;
            }

            if (
                !$software->tanggal_pengadaan ||
                !$software->tanggal_berakhir
            ) {
                return 0;
            }

            $tanggalMulai = $software->tanggal_pengadaan;
            $tanggalBerakhir = $software->tanggal_berakhir;

            $jumlahBulan = $tanggalMulai->diffInMonths($tanggalBerakhir);
            $jumlahBulan = max(1, $jumlahBulan);

            return ($harga / $jumlahBulan) * 12;
        });

        return view('software.index', compact(
            'softwares',
            'totalSoftware',
            'totalLisensi',
            'akanBerakhir',
            'expired',
            'tersedia',
            'totalPengeluaranPertahun'
        ));
    }

    public function create()
    {
        return view('software.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => ['required', 'string', 'max:255'],
            'spesifikasi' => ['nullable', 'string', 'max:255'],
            'jumlah_lisensi' => ['required', 'integer', 'min:1'],
            'pengadaan' => ['required', 'in:Sewa,Beli'],
            'periode_sewa' => ['nullable', 'string', 'max:100'],
            'harga' => ['required', 'numeric', 'min:0'],
            'tanggal_pengadaan' => ['required', 'date'],
            'tanggal_berakhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_pengadaan',
            ],
        ]);

        DB::transaction(function () use (&$validated) {

            /*
             * ==========================================================
             * GENERATE KODE SOFTWARE
             * Format:
             * SW-260001
             * SW-260002
             * SW-260003
             *
             * Tahun berubah:
             * SW-270001
             * SW-270002
             *
             * Counter TIDAK kembali ke nomor sebelumnya
             * walaupun data software dihapus.
             * ==========================================================
             */

            $year = now()->year;

            $counter = SoftwareCounter::where('year', $year)
                ->lockForUpdate()
                ->first();

            if (!$counter) {
                $counter = SoftwareCounter::create([
                    'year' => $year,
                    'last_number' => 0,
                ]);
            }

            $counter->increment('last_number');

            $number = $counter->fresh()->last_number;

            $validated['kode'] = sprintf(
                'SW-%02d%04d',
                $year % 100,
                $number
            );

            /*
             * Status awal selalu menunggu.
             */
            $validated['verifikasi'] = 'menunggu';
            $validated['komentar'] = null;

            $software = SoftwareAsset::create($validated);

            /*
             * Buat pengajuan verifikasi.
             */
            VerificationRequest::create([
                'module' => 'software',
                'record_id' => $software->id,
                'action' => 'create',
                'data' => $software->toArray(),
                'status' => 'menunggu',
                'submitted_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Pengajuan penambahan software berhasil dikirim dan menunggu verifikasi.'
            );
    }

    public function edit(SoftwareAsset $software)
    {
        return view('software.edit', compact('software'));
    }

    public function update(
        Request $request,
        SoftwareAsset $software
    ) {
        $validated = $request->validate([
            'jenis' => ['required', 'string', 'max:255'],
            'spesifikasi' => ['nullable', 'string', 'max:255'],
            'jumlah_lisensi' => ['required', 'integer', 'min:1'],
            'pengadaan' => ['required', 'in:Sewa,Beli'],
            'periode_sewa' => ['nullable', 'string', 'max:100'],
            'harga' => ['required', 'numeric', 'min:0'],
            'tanggal_pengadaan' => ['required', 'date'],
            'tanggal_berakhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_pengadaan',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $software
        ) {
            /*
             * KODE TIDAK DIUBAH SAAT EDIT.
             *
             * Misalnya:
             * SW-260001
             *
             * tetap SW-260001 meskipun datanya diedit.
             */

            $validated['verifikasi'] = 'menunggu';
            $validated['komentar'] = null;

            $software->update($validated);

            VerificationRequest::create([
                'module' => 'software',
                'record_id' => $software->id,
                'action' => 'update',
                'data' => $software->fresh()->toArray(),
                'status' => 'menunggu',
                'submitted_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Perubahan software berhasil disimpan dan menunggu verifikasi.'
            );
    }

    public function destroy(SoftwareAsset $software)
    {
        DB::transaction(function () use ($software) {

            /*
             * Data TIDAK langsung dihapus.
             *
             * Tetap ada di tabel software_assets dengan status
             * menunggu sampai Verifikator menyetujui.
             */

            $software->update([
                'verifikasi' => 'menunggu',
                'komentar' => null,
            ]);

            VerificationRequest::create([
                'module' => 'software',
                'record_id' => $software->id,
                'action' => 'delete',
                'data' => $software->fresh()->toArray(),
                'status' => 'menunggu',
                'submitted_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Pengajuan penghapusan software berhasil dikirim dan menunggu verifikasi.'
            );
    }
}