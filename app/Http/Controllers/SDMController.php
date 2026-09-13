<?php

namespace App\Http\Controllers;

use App\Models\Sdm;
use App\Models\VerificationRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SDMController extends Controller
{
    /**
     * =========================================================
     * INDEX
     * =========================================================
     */
    public function index(Request $request)
    {
        $query = Sdm::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nip',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'kode_dk',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'nama',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'jabatan',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'kompetensi',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        |
        | Blade menggunakan:
        | $sdm->count()
        | $sdm->total()
        | $sdm->lastPage()
        | $sdm->currentPage()
        | $sdm->url()
        |
        | Jadi harus menggunakan paginate(), bukan get().
        |--------------------------------------------------------------------------
        */
        $show = (int) $request->input('show', 10);

        if (!in_array($show, [10, 25, 50, 100])) {
            $show = 10;
        }

        $sdm = $query
            ->latest()
            ->paginate($show)
            ->withQueryString();

        $sdm = Sdm::latest()->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | TOTAL PERSONEL
        |--------------------------------------------------------------------------
        */
        $totalData = Sdm::count();

        /*
        |--------------------------------------------------------------------------
        | SERTIFIKASI AKTIF
        |--------------------------------------------------------------------------
        |
        | Masa berlaku masih hari ini atau lebih dari hari ini.
        |--------------------------------------------------------------------------
        */
        $aktif = Sdm::query()
            ->whereNotNull('masa_berlaku')
            ->whereDate(
                'masa_berlaku',
                '>=',
                now()->toDateString()
            )
            ->count();

        $aktif = Sdm::where(
            'masa_berlaku',
            '>=',
            now()
        )->count();

        /*
        |--------------------------------------------------------------------------
        | SERTIFIKASI BERAKHIR
        |--------------------------------------------------------------------------
        |
        | Masa berlaku sudah lewat dari hari ini.
        |--------------------------------------------------------------------------
        */
        $berakhir = Sdm::query()
            ->whereNotNull('masa_berlaku')
            ->whereDate(
                'masa_berlaku',
                '<',
                now()->toDateString()
            )
            ->count();

        $berakhir = Sdm::where(
            'masa_berlaku',
            '<',
            now()
        )->count();

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */
        return view(
            'sdm.index',
            compact(
                'sdm',
                'totalData',
                'aktif',
                'berakhir'
            )
        );
    }


    /**
     * =========================================================
     * STORE
     * =========================================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => [
                'required',
                'string',
                'max:50',
            ],

            'kode_dk' => [
                'nullable',
                'string',
                'max:50',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'kompetensi' => [
                'nullable',
                'string',
            ],

            'masa_berlaku' => [
                'nullable',
                'date',
            ],

            'dokumen' => [
                'nullable',
                'file',
                'max:10240',
            ],
        ]);

        $validator = Validator::make(
            $request->all(),
            [

                'nip' =>
                    'required|string|max:20|unique:sdms,nip',

                'nama' =>
                    'required|string|max:100',

                'jabatan' =>
                    'required|string|max:100',

                'kompetensi' =>
                    'required|string|max:150',

                'masa_berlaku' =>
                    'required|date',

                'dokumen' =>
                    'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            ]
        );

        if ($validator->fails()) {

            return back()
                ->withErrors($validator)
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | UPLOAD DOKUMEN
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('dokumen')) {

            $validated['dokumen'] = $request
                ->file('dokumen')
                ->store(
                    'sdm',
                    'public'
                );
        }

        $dokumenPath = null;

        if ($request->hasFile('dokumen')) {

            $dokumenPath =
                $request
                    ->file('dokumen')
                    ->store(
                        'sdm/dokumen',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE KODE BK
        |--------------------------------------------------------------------------
        */

        $kodeBk =
            'BK-' .
            str_pad(
                Sdm::count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA
        |--------------------------------------------------------------------------
        */

        $sdm = Sdm::create([

            'nip' =>
                $request->nip,

            'kode_dk' =>
                $kodeBk,

            'nama' =>
                $request->nama,

            'jabatan' =>
                $request->jabatan,

            'kompetensi' =>
                $request->kompetensi,

            'masa_berlaku' =>
                $request->masa_berlaku,

            'dokumen' =>
                $dokumenPath,

        ]);


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'judul' =>
                'Data SDM Baru',

            'pesan' =>
                $request->user()->username .
                ' menambahkan data SDM "' .
                $sdm->nama .
                '" dengan ID ' .
                $sdm->kode_dk .
                '.',

            'dibaca' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE DATA + VERIFICATION REQUEST
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use ($validated) {

            $sdm = Sdm::create($validated);

            VerificationRequest::create([
                'module' =>
                    'sdm',

                'record_id' =>
                    $sdm->id,

                'action' =>
                    'create',

                'data' =>
                    $sdm->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);
        });

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Data SDM berhasil ditambahkan dan menunggu verifikasi.'
            );

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Data SDM berhasil ditambahkan.'
            );
    }


    /**
     * =========================================================
     * UPDATE
     * =========================================================
     */
    public function update(
        Request $request,
        Sdm $sdm
    ) {
        $validated = $request->validate([
            'nip' => [
                'required',
                'string',
                'max:50',
            ],

            'kode_dk' => [
                'nullable',
                'string',
                'max:50',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'kompetensi' => [
                'nullable',
                'string',
            ],

            'masa_berlaku' => [
                'nullable',
                'date',
            ],

            'dokumen' => [
                'nullable',
                'file',
                'max:10240',
            ],
        ]);

        $validator = Validator::make(
            $request->all(),
            [

                'nip' =>
                    'required|string|max:20|unique:sdms,nip,' .
                    $sdm->id,

                'nama' =>
                    'required|string|max:100',

                'jabatan' =>
                    'required|string|max:100',

                'kompetensi' =>
                    'required|string|max:150',

                'masa_berlaku' =>
                    'required|date',

                'dokumen' =>
                    'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            ]
        );

        if ($validator->fails()) {

            return back()
                ->withErrors($validator)
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | UPLOAD DOKUMEN BARU
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('dokumen')) {

            $validated['dokumen'] = $request
                ->file('dokumen')
                ->store(
                    'sdm',
                    'public'
                );
        }

        $dokumenPath =
            $sdm->dokumen;

        if ($request->hasFile('dokumen')) {

            if ($sdm->dokumen) {

                Storage::disk('public')
                    ->delete(
                        $sdm->dokumen
                    );
            }

            $dokumenPath =
                $request
                    ->file('dokumen')
                    ->store(
                        'sdm/dokumen',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA
        |--------------------------------------------------------------------------
        */

        $sdm->update([

            'nip' =>
                $request->nip,

            'nama' =>
                $request->nama,

            'jabatan' =>
                $request->jabatan,

            'kompetensi' =>
                $request->kompetensi,

            'masa_berlaku' =>
                $request->masa_berlaku,

            'dokumen' =>
                $dokumenPath,

        ]);


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'judul' =>
                'Data SDM Diperbarui',

            'pesan' =>
                $request->user()->username .
                ' memperbarui data SDM "' .
                $sdm->nama .
                '" dengan ID ' .
                $sdm->kode_dk .
                '.',

            'dibaca' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE + VERIFICATION REQUEST
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $sdm,
            $validated
        ) {

            $sdm->update($validated);

            VerificationRequest::create([
                'module' =>
                    'sdm',

                'record_id' =>
                    $sdm->id,

                'action' =>
                    'update',

                'data' =>
                    $sdm->fresh()->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);
        });

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Perubahan data SDM berhasil disimpan dan menunggu verifikasi.'
            );

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Data SDM berhasil diperbarui.'
            );
    }


    /**
     * =========================================================
     * DESTROY
     * =========================================================
    */
    public function destroy(Sdm $sdm)
    {
        /*
        |--------------------------------------------------------------------------
        | AJUKAN PENGHAPUSAN
        |--------------------------------------------------------------------------
        |
        | Data tidak langsung dihapus.
        | Penghapusan masuk ke Verifikasi terlebih dahulu.
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use ($sdm) {

            VerificationRequest::create([
                'module' =>
                    'sdm',

                'record_id' =>
                    $sdm->id,

                'action' =>
                    'delete',

                'data' =>
                    $sdm->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA UNTUK NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        $namaSdm =
            $sdm->nama;

        $kodeSdm =
            $sdm->kode_dk;


        /*
        |--------------------------------------------------------------------------
        | HAPUS DOKUMEN
        |--------------------------------------------------------------------------
        */

        if ($sdm->dokumen) {

            Storage::disk('public')
                ->delete(
                    $sdm->dokumen
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA
        |--------------------------------------------------------------------------
        */

        $sdm->delete();


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'judul' =>
                'Data SDM Dihapus',

            'pesan' =>
                $request->user()->username .
                ' menghapus data SDM "' .
                $namaSdm .
                '" dengan ID ' .
                $kodeSdm .
                '.',

            'dibaca' => false,
        ]);


        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Data SDM berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve(
        Request $request,
        Sdm $sdm
    ) {

        $sdm->update([
            'status_verifikasi' =>
                'disetujui'
        ]);


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'judul' =>
                'Data SDM Disetujui',

            'pesan' =>
                $request->user()->username .
                ' menyetujui data SDM "' .
                $sdm->nama .
                '" dengan ID ' .
                $sdm->kode_dk .
                '.',

            'dibaca' => false,
        ]);


        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Data berhasil disetujui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        Sdm $sdm
    ) {

        $sdm->update([
            'status_verifikasi' =>
                'ditolak'
        ]);


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'judul' =>
                'Data SDM Ditolak',

            'pesan' =>
                $request->user()->username .
                ' menolak data SDM "' .
                $sdm->nama .
                '" dengan ID ' .
                $sdm->kode_dk .
                '.',

            'dibaca' => false,
        ]);

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Pengajuan penghapusan SDM berhasil dikirim dan menunggu verifikasi.'
            );

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Data ditolak.'
            );
    }
}