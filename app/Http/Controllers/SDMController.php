<?php

namespace App\Http\Controllers;

use App\Models\Sdm;
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

        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Pengajuan penghapusan SDM berhasil dikirim dan menunggu verifikasi.'
            );
    }
}