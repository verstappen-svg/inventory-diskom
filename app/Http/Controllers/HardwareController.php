<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HardwareController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Hardware::query();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('asset_id', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%")
                    ->orWhere('spesifikasi', 'like', "%{$search}%")
                    ->orWhere('jenis_barang', 'like', "%{$search}%")
                    ->orWhere('tahun_pembelian', 'like', "%{$search}%")
                    ->orWhere('kondisi', 'like', "%{$search}%");

            });
        }

        $show = (int) $request->get('show', 10);

        if (!in_array($show, [10, 25, 50, 100])) {
            $show = 10;
        }

        $hardwares = $query
            ->latest()
            ->paginate($show)
            ->withQueryString();

        return view('hardware.index', compact('hardwares'));
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE ASSET ID
    |--------------------------------------------------------------------------
    |
    | Format:
    |
    | HW-26-0001
    | HW-26-0002
    | HW-26-0003
    |
    | 26 = dua digit tahun sekarang
    |
    */

    private function generateAssetId(): string
    {
        $year = now()->format('y');

        $prefix = 'HW-' . $year . '-';

        $lastHardware = Hardware::where('asset_id', 'like', $prefix . '%')
            ->orderByRaw(
                "CAST(SUBSTRING(asset_id, 7) AS UNSIGNED) DESC"
            )
            ->first();

        if (!$lastHardware) {
            $number = 1;
        } else {

            $lastNumber = (int) substr(
                $lastHardware->asset_id,
                strlen($prefix)
            );

            $number = $lastNumber + 1;
        }

        return $prefix . str_pad(
            $number,
            4,
            '0',
            STR_PAD_LEFT
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

            'nama_barang' => [
                'required',
                'string',
                'max:255',
            ],

            'spesifikasi' => [
                'required',
                'string',
            ],

            'jenis_barang' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun_pembelian' => [
                'required',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'harga' => [
                'required',
                'numeric',
                'min:0',
            ],

            'kondisi' => [
                'required',
                'string',
                'max:100',
            ],

        ], [

            'nama_barang.required' =>
                'Nama barang wajib diisi.',

            'spesifikasi.required' =>
                'Spesifikasi wajib diisi.',

            'jenis_barang.required' =>
                'Jenis barang wajib diisi.',

            'tahun_pembelian.required' =>
                'Tahun pembelian wajib diisi.',

            'tahun_pembelian.integer' =>
                'Tahun pembelian harus berupa angka.',

            'harga.required' =>
                'Harga wajib diisi.',

            'harga.numeric' =>
                'Harga harus berupa angka.',

            'kondisi.required' =>
                'Kondisi wajib dipilih.',

        ]);


        DB::transaction(function () use ($validated) {

            /*
             * Asset ID dibuat OTOMATIS.
             */
            $validated['asset_id'] = $this->generateAssetId();


            /*
             * Simpan hardware.
             */
            $hardware = Hardware::create($validated);


            /*
             * Buat request verifikasi.
             */
            VerificationRequest::create([

                'module' => 'hardware',

                'record_id' => $hardware->asset_id,

                'action' => 'create',

                'data' => $hardware->toArray(),

                'status' => 'menunggu',

                'submitted_by' => auth()->id(),

            ]);
        });


        return redirect()
            ->route('hardware.index')
            ->with(
                'success',
                'Data hardware berhasil ditambahkan dan menunggu verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        string $hardware
    ) {

        $hardwareRecord = Hardware::where(
            'asset_id',
            $hardware
        )->first();


        if (!$hardwareRecord) {

            return redirect()
                ->route('hardware.index')
                ->with(
                    'error',
                    'Data hardware tidak ditemukan.'
                );
        }


        $validated = $request->validate([

            /*
             * Asset ID TIDAK perlu dikirim dari form.
             * ID hardware tetap.
             */

            'nama_barang' => [
                'required',
                'string',
                'max:255',
            ],

            'spesifikasi' => [
                'required',
                'string',
            ],

            'jenis_barang' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun_pembelian' => [
                'required',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'harga' => [
                'required',
                'numeric',
                'min:0',
            ],

            'kondisi' => [
                'required',
                'string',
                'max:100',
            ],

        ], [

            'nama_barang.required' =>
                'Nama barang wajib diisi.',

            'spesifikasi.required' =>
                'Spesifikasi wajib diisi.',

            'jenis_barang.required' =>
                'Jenis barang wajib diisi.',

            'tahun_pembelian.required' =>
                'Tahun pembelian wajib diisi.',

            'harga.required' =>
                'Harga wajib diisi.',

            'harga.numeric' =>
                'Harga harus berupa angka.',

            'kondisi.required' =>
                'Kondisi wajib dipilih.',

        ]);


        /*
         * Data lama untuk snapshot verifikasi.
         */
        $dataLama = $hardwareRecord->toArray();


        DB::transaction(function () use (
            $hardwareRecord,
            $validated,
            $dataLama
        ) {

            /*
             * Jangan ubah asset_id ketika edit.
             */
            $hardwareRecord->update($validated);

            $hardwareRecord->refresh();


            /*
             * Request verifikasi update.
             */
            VerificationRequest::create([

                'module' => 'hardware',

                'record_id' => $hardwareRecord->asset_id,

                'action' => 'update',

                'data' => [

                    'data_lama' => $dataLama,

                    'data_baru' => $hardwareRecord->toArray(),

                ],

                'status' => 'menunggu',

                'submitted_by' => auth()->id(),

            ]);
        });


        return redirect()
            ->route('hardware.index')
            ->with(
                'success',
                'Data hardware berhasil diperbarui dan menunggu verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(string $hardware)
    {
        $hardwareRecord = Hardware::where(
            'asset_id',
            $hardware
        )->first();


        if (!$hardwareRecord) {

            return redirect()
                ->route('hardware.index')
                ->with(
                    'error',
                    'Data hardware tidak ditemukan.'
                );
        }


        DB::transaction(function () use ($hardwareRecord) {

            VerificationRequest::create([

                'module' => 'hardware',

                'record_id' => $hardwareRecord->asset_id,

                'action' => 'delete',

                'data' => $hardwareRecord->toArray(),

                'status' => 'menunggu',

                'submitted_by' => auth()->id(),

            ]);
        });


        return redirect()
            ->route('hardware.index')
            ->with(
                'success',
                'Permintaan penghapusan hardware berhasil diajukan dan menunggu verifikasi.'
            );
    }
}