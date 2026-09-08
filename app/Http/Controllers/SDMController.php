<?php

namespace App\Http\Controllers;

use App\Models\Sdm;
use App\Models\Notification;
use App\Models\VerificationRequest;
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

        // =====================================================
        // SEARCH
        // =====================================================

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


        // =====================================================
        // PAGINATION
        // =====================================================

        $show = (int) $request->input(
            'show',
            10
        );

        if (!in_array(
            $show,
            [10, 25, 50, 100]
        )) {
            $show = 10;
        }

        $sdm = $query
            ->latest()
            ->paginate($show)
            ->withQueryString();


        // =====================================================
        // TOTAL PERSONEL
        // =====================================================

        $totalData = Sdm::count();


        // =====================================================
        // SERTIFIKASI AKTIF
        // =====================================================

        $aktif = Sdm::query()
            ->whereNotNull('masa_berlaku')
            ->whereDate(
                'masa_berlaku',
                '>=',
                now()->toDateString()
            )
            ->count();


        // =====================================================
        // SERTIFIKASI BERAKHIR
        // =====================================================

        $berakhir = Sdm::query()
            ->whereNotNull('masa_berlaku')
            ->whereDate(
                'masa_berlaku',
                '<',
                now()->toDateString()
            )
            ->count();


        // =====================================================
        // VIEW
        // =====================================================

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
        // =====================================================
        // VALIDASI
        // =====================================================

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
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],

        ]);


        // =====================================================
        // GENERATE KODE DK JIKA KOSONG
        // =====================================================

        if (empty($validated['kode_dk'])) {

            $validated['kode_dk'] =
                'BK-' .
                str_pad(
                    Sdm::count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
        }


        // =====================================================
        // UPLOAD DOKUMEN
        // =====================================================

        if ($request->hasFile('dokumen')) {

            $validated['dokumen'] =
                $request
                    ->file('dokumen')
                    ->store(
                        'sdm/dokumen',
                        'public'
                    );
        }


        // =====================================================
        // CREATE DATA + VERIFICATION REQUEST
        // =====================================================

        $sdm = DB::transaction(
            function () use (
                $validated
            ) {

                // Simpan data SDM
                $sdm = Sdm::create(
                    $validated
                );


                // Buat request verifikasi
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


                return $sdm;
            }
        );


        // =====================================================
        // NOTIFIKASI
        // =====================================================

        Notification::create([

            'judul' =>
                'Data SDM Baru',

            'pesan' =>
                $request->user()->username .
                ' menambahkan data SDM "' .
                $sdm->nama .
                '" dengan ID ' .
                $sdm->kode_dk .
                ' dan mengajukannya untuk persetujuan.',

            'dibaca' =>
                false,

        ]);


        // =====================================================
        // REDIRECT
        // =====================================================

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Data SDM berhasil ditambahkan dan menunggu verifikasi.'
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

        // =====================================================
        // VALIDASI
        // =====================================================

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
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],

        ]);


        // =====================================================
        // UPLOAD DOKUMEN BARU
        // =====================================================

        if ($request->hasFile('dokumen')) {

            $validated['dokumen'] =
                $request
                    ->file('dokumen')
                    ->store(
                        'sdm/dokumen',
                        'public'
                    );
        }


        // =====================================================
        // UPDATE + VERIFICATION REQUEST
        // =====================================================

        DB::transaction(
            function () use (
                $sdm,
                $validated
            ) {

                // Update data
                $sdm->update(
                    $validated
                );


                // Buat request verifikasi update
                VerificationRequest::create([

                    'module' =>
                        'sdm',

                    'record_id' =>
                        $sdm->id,

                    'action' =>
                        'update',

                    'data' =>
                        $sdm
                            ->fresh()
                            ->toArray(),

                    'status' =>
                        'menunggu',

                    'submitted_by' =>
                        auth()->id(),

                ]);
            }
        );


        // =====================================================
        // NOTIFIKASI
        // =====================================================

        Notification::create([

            'judul' =>
                'Data SDM Diperbarui',

            'pesan' =>
                $request->user()->username .
                ' memperbarui data SDM "' .
                $sdm->nama .
                '" dengan ID ' .
                $sdm->kode_dk .
                ' dan mengajukannya kembali untuk persetujuan.',

            'dibaca' =>
                false,

        ]);


        // =====================================================
        // REDIRECT
        // =====================================================

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Perubahan data SDM berhasil disimpan dan menunggu verifikasi.'
            );
    }


    /**
     * =========================================================
     * DESTROY
     * =========================================================
     *
     * Data tidak langsung dihapus.
     * Penghapusan masuk ke VerificationRequest terlebih dahulu.
     */
    public function destroy(Sdm $sdm)
    {
        // =====================================================
        // SIMPAN DATA UNTUK NOTIFIKASI
        // =====================================================

        $namaSdm =
            $sdm->nama;

        $kodeSdm =
            $sdm->kode_dk;

        $username =
            auth()->user()->username;


        // =====================================================
        // AJUKAN PENGHAPUSAN
        // =====================================================

        DB::transaction(
            function () use (
                $sdm
            ) {

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
            }
        );


        // =====================================================
        // NOTIFIKASI
        // =====================================================

        Notification::create([

            'judul' =>
                'Penghapusan Data SDM Diajukan',

            'pesan' =>
                $username .
                ' mengajukan penghapusan data SDM "' .
                $namaSdm .
                '" dengan ID ' .
                $kodeSdm .
                ' untuk persetujuan verifikator.',

            'dibaca' =>
                false,

        ]);


        // =====================================================
        // REDIRECT
        // =====================================================

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Pengajuan penghapusan SDM berhasil dikirim dan menunggu verifikasi.'
            );
    }
}