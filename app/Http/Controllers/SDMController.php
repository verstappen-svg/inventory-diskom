<?php

namespace App\Http\Controllers;

use App\Models\Sdm;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SDMController extends Controller
{
    public function index()
    {
        $sdm = Sdm::latest()->paginate(10);

        $aktif = Sdm::where(
            'masa_berlaku',
            '>=',
            now()
        )->count();

        $berakhir = Sdm::where(
            'masa_berlaku',
            '<',
            now()
        )->count();

        return view(
            'sdm.index',
            compact(
                'sdm',
                'aktif',
                'berakhir'
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


        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Data SDM berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Sdm $sdm
    ) {

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


        return redirect()
            ->route('sdm.index')
            ->with(
                'success',
                'Data SDM berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Request $request,
        Sdm $sdm
    ) {

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
                'Data ditolak.'
            );
    }
}