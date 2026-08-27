<?php

namespace App\Http\Controllers;

use App\Models\SoftwareAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SoftwareController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK TABEL
        |--------------------------------------------------------------------------
        */

        $query = SoftwareAsset::query();

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('spesifikasi', 'like', "%{$search}%");

            });
        }


        // FILTER PENGADAAN
        if ($request->filled('pengadaan')) {

            $query->where(
                'pengadaan',
                $request->pengadaan
            );
        }


        // Data yang ditampilkan pada tabel
        $softwares = $query
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK CARD
        |--------------------------------------------------------------------------
        |
        | Card menggunakan SEMUA data software.
        | Jadi search/filter tidak mengubah jumlah pada card.
        |
        */

        $allSoftwares = SoftwareAsset::all();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SOFTWARE
        |--------------------------------------------------------------------------
        */

        // Total jenis software
        $totalSoftware = $allSoftwares->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL LISENSI
        |--------------------------------------------------------------------------
        */

        // Total seluruh lisensi dari semua software
        $totalLisensi = $allSoftwares->sum('jumlah_lisensi');


        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */

        $today = now()->startOfDay();

        // Batas 30 hari dari sekarang
        $thirtyDaysLater = now()
            ->addDays(30)
            ->endOfDay();


        /*
        |--------------------------------------------------------------------------
        | EXPIRED
        |--------------------------------------------------------------------------
        */

        $expired = $allSoftwares->filter(function ($software) use ($today) {

            return $software->tanggal_berakhir
                && $software->tanggal_berakhir->lt($today);

        })->count();


        /*
        |--------------------------------------------------------------------------
        | AKAN BERAKHIR
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | TERSEDIA
        |--------------------------------------------------------------------------
        |
        | Software dianggap tersedia apabila:
        |
        | 1. Tidak memiliki tanggal berakhir
        |    → perpetual
        |
        | ATAU
        |
        | 2. Tanggal berakhir lebih dari 30 hari lagi
        |
        */

        $tersedia = $allSoftwares->filter(function ($software) use (
            $thirtyDaysLater
        ) {

            // Perpetual / tidak memiliki tanggal berakhir
            if (!$software->tanggal_berakhir) {
                return true;
            }

            // Masih berlaku lebih dari 30 hari
            return $software->tanggal_berakhir
                ->greaterThan($thirtyDaysLater);

        })->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENGELUARAN PER TAHUN
        |--------------------------------------------------------------------------
        */

        $totalPengeluaranPertahun = $allSoftwares->sum(
            function ($software) {

                $harga = (float) $software->harga;


                /*
                |--------------------------------------------------------------------------
                | BELI
                |--------------------------------------------------------------------------
                |
                | Software Beli / Perpetual dihitung
                | sebagai pengeluaran pembelian.
                |
                */

                if ($software->pengadaan === 'Beli') {
                    return $harga;
                }


                /*
                |--------------------------------------------------------------------------
                | SEWA TANPA TANGGAL BERAKHIR
                |--------------------------------------------------------------------------
                */

                if (!$software->tanggal_berakhir) {
                    return 0;
                }


                /*
                |--------------------------------------------------------------------------
                | HITUNG DURASI SEWA
                |--------------------------------------------------------------------------
                */

                $tanggalMulai = $software->tanggal_pengadaan;

                $tanggalBerakhir = $software->tanggal_berakhir;


                $jumlahBulan = $tanggalMulai
                    ->diffInMonths($tanggalBerakhir);


                // Minimal dianggap 1 bulan
                $jumlahBulan = max(
                    1,
                    $jumlahBulan
                );


                /*
                |--------------------------------------------------------------------------
                | KONVERSI KE ESTIMASI BIAYA 1 TAHUN
                |--------------------------------------------------------------------------
                |
                | Contoh:
                |
                | Sewa 3 bulan = Rp 3.000.000
                |
                | Rp 3.000.000 / 3 × 12
                |
                | = Rp 12.000.000 / tahun
                |
                */

                return ($harga / $jumlahBulan) * 12;
            }
        );


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

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


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('software.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'jenis' => [
                'required',
                'string',
                'max:255'
            ],

            'spesifikasi' => [
                'nullable',
                'string',
                'max:255'
            ],

            'jumlah_lisensi' => [
                'required',
                'integer',
                'min:1'
            ],

            'pengadaan' => [
                'required',
                'in:Sewa,Beli'
            ],

            'harga' => [
                'required',
                'numeric',
                'min:0'
            ],

            'tanggal_pengadaan' => [
                'required',
                'date'
            ],

            'tanggal_berakhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_pengadaan'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | GENERATE KODE SOFTWARE
        |--------------------------------------------------------------------------
        */

        $validated['kode'] =
            'SW-' . strtoupper(Str::random(6));


        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        SoftwareAsset::create($validated);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Data software berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(SoftwareAsset $software)
    {
        return view(
            'software.edit',
            compact('software')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        SoftwareAsset $software
    ) {

        $validated = $request->validate([

            'jenis' => [
                'required',
                'string',
                'max:255'
            ],

            'spesifikasi' => [
                'nullable',
                'string',
                'max:255'
            ],

            'jumlah_lisensi' => [
                'required',
                'integer',
                'min:1'
            ],

            'pengadaan' => [
                'required',
                'in:Sewa,Beli'
            ],

            'harga' => [
                'required',
                'numeric',
                'min:0'
            ],

            'tanggal_pengadaan' => [
                'required',
                'date'
            ],

            'tanggal_berakhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_pengadaan'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE DATABASE
        |--------------------------------------------------------------------------
        */

        $software->update($validated);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Data software berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(SoftwareAsset $software)
    {
        $software->delete();


        return redirect()
            ->route('software.index')
            ->with(
                'success',
                'Data software berhasil dihapus.'
            );
    }
}