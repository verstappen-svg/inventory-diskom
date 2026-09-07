<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JaringanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HITUNG STATUS OTOMATIS
    |--------------------------------------------------------------------------
    */

    private function getStatusOtomatis($jaringan)
    {
        /*
        |--------------------------------------------------------------------------
        | JIKA BELI
        |--------------------------------------------------------------------------
        */

        if ($jaringan->pengadaan === 'Beli') {
            return $jaringan->status ?? 'Tersedia';
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA SEWA
        |--------------------------------------------------------------------------
        */

        if (
            $jaringan->pengadaan === 'Sewa' &&
            $jaringan->tanggal_berakhir
        ) {

            $today = Carbon::today();

            $tanggalBerakhir = Carbon::parse(
                $jaringan->tanggal_berakhir
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


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('id', 'like', "%{$search}%")
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
        |
        | Filter berdasarkan tahun dari tanggal_pengadaan.
        |
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

        $jaringans = $query
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | HITUNG STATUS OTOMATIS
        |--------------------------------------------------------------------------
        */

        foreach ($jaringans as $jaringan) {

            $jaringan->status_otomatis =
                $this->getStatusOtomatis($jaringan);
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        |
        | Status tidak langsung diambil dari database karena:
        |
        | Beli  -> Tersedia / Digunakan
        | Sewa  -> Digunakan / Akan Habis / Expired
        |
        | Jadi status dihitung terlebih dahulu.
        |
        */

        if ($request->filled('status')) {

            $jaringans = $jaringans
                ->filter(function ($jaringan) use ($request) {

                    return $jaringan->status_otomatis ===
                        $request->status;
                })
                ->values();
        }


        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK CARD
        |--------------------------------------------------------------------------
        |
        | Card selalu menghitung seluruh data,
        | tidak mengikuti filter tabel.
        |
        */

        $allJaringans = Jaringan::all();


        foreach ($allJaringans as $jaringan) {

            $jaringan->status_otomatis =
                $this->getStatusOtomatis($jaringan);
        }


        /*
        |--------------------------------------------------------------------------
        | JUMLAH STATUS
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | DATA TAHUN UNTUK FILTER
        |--------------------------------------------------------------------------
        |
        | Mengambil tahun unik dari tanggal_pengadaan.
        |
        */

        $tahuns = Jaringan::query()
            ->whereNotNull('tanggal_pengadaan')
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

        $verifikasis = Jaringan::query()
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

        $prefix = 'INFJ-';

        $lastJaringan = Jaringan::where(
            'id',
            'like',
            $prefix . '%'
        )
            ->orderByRaw(
                'CAST(SUBSTRING(id, 6) AS UNSIGNED) DESC'
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

        Jaringan::create($validated);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Data jaringan berhasil diajukan dan menunggu disetujui verifikator.'
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

        $jaringan = Jaringan::findOrFail($id);


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

        $jaringan->update($validated);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Perubahan data jaringan berhasil diajukan dan menunggu disetujui verifikator.'
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


        /*
        |--------------------------------------------------------------------------
        | AJUKAN PENGHAPUSAN
        |--------------------------------------------------------------------------
        */

        $jaringan->update([
            'verifikasi' => 'Menunggu disetujui',
            'komentar' => null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('jaringan.index')
            ->with(
                'success',
                'Permintaan penghapusan data berhasil diajukan dan menunggu disetujui verifikator.'
            );
    }
}