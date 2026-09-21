<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Lokasi;
use App\Models\Notification;
use App\Models\VerificationRequest;
use App\Imports\HardwareImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HardwareController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Hardware::with('lokasi');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('asset_id', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%")
                    ->orWhere('spesifikasi', 'like', "%{$search}%")
                    ->orWhere('jenis_barang', 'like', "%{$search}%")
                    ->orWhere('sistem_operasi', 'like', "%{$search}%")
                    ->orWhere('tahun_pembelian', 'like', "%{$search}%")
                    ->orWhere('kondisi', 'like', "%{$search}%")
                    ->orWhereHas('lokasi', function ($lokasiQuery) use ($search) {
                        $lokasiQuery->where(
                            'nama_lokasi',
                            'like',
                            "%{$search}%"
                        );
                    });
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

        $lokasis = Lokasi::orderBy('nama_lokasi')->get();

        return view(
            'hardware.index',
            compact('hardwares', 'lokasis')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE ASSET ID
    |--------------------------------------------------------------------------
    |
    | Format:
    |
    | ED-26-0001  -> End Device
    | SD-26-0001  -> Security Device
    | PD-26-0001  -> Peripheral / Supporting Device
    |
    */

    private function generateAssetId(string $jenisBarang): string
    {
        $year = now()->format('y');

        $endDevices = [
            'PC All in One',
            'PC Desktop',
            'Laptop',
            'NoteBook',
            'Tablet',
            'Smartphone',
            'Perangkat Komunikasi',
        ];

        $securityDevices = [
            'CCTV',
        ];

        if (in_array($jenisBarang, $endDevices)) {

            $prefix = 'ED-' . $year . '-';

        } elseif (in_array($jenisBarang, $securityDevices)) {

            $prefix = 'SD-' . $year . '-';

        } else {

            $prefix = 'PD-' . $year . '-';
        }

        $lastHardware = Hardware::where(
            'asset_id',
            'like',
            $prefix . '%'
        )
            ->orderByRaw(
                "CAST(SUBSTRING(asset_id, 8) AS UNSIGNED) DESC"
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

            'lokasi_id' => [
                'required',
                'exists:lokasi,id',
            ],

            'sistem_operasi' => [
                'nullable',
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

            'lokasi_id.required' =>
                'Lokasi wajib dipilih.',

            'lokasi_id.exists' =>
                'Lokasi yang dipilih tidak valid.',

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


        /*
        |--------------------------------------------------------------------------
        | DEFAULT SISTEM OPERASI
        |--------------------------------------------------------------------------
        */

        $validated['sistem_operasi'] =
            trim($validated['sistem_operasi'] ?? '') ?: 'N/A';


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA + VERIFIKASI + NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (&$validated) {

            /*
             * Generate Asset ID otomatis.
             */
            $validated['asset_id'] = $this->generateAssetId(
                $validated['jenis_barang']
            );


            /*
             * Simpan hardware.
             */
            $hardware = Hardware::create($validated);


            // =================================================
            // TENTUKAN NOMOR BERIKUTNYA
            // =================================================

                'module' =>
                    'hardware',

                'record_id' =>
                    $hardware->asset_id,

                'action' =>
                    'create',

                'data' =>
                    $hardware->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);


            /*
             * Buat notifikasi.
             */
            Notification::create([

                'judul' =>
                    'Pengajuan Hardware Baru',

                'pesan' =>
                    auth()->user()->username .
                    ' menambahkan hardware "' .
                    $hardware->nama_barang .
                    '" dengan ID ' .
                    $hardware->asset_id .
                    ' dan mengajukannya untuk persetujuan.',

                'dibaca' =>
                    false,
            ]);


            // =================================================
            // BUAT PENGAJUAN VERIFIKASI
            // =================================================

            VerifikasiHardware::create([
                'hardware_id' => $hardware->id,
                'status' => 'Menunggu Persetujuan',
            ]);


            // =================================================
            // NOTIFIKASI
            // =================================================

            Notification::create([
                'judul' => 'Pengajuan Hardware Baru',

                'pesan' =>
                    $request->user()->username .
                    ' menambahkan hardware "' .
                    $hardware->nama_barang .
                    '" dengan ID ' .
                    $hardware->asset_id .
                    ' dan mengajukannya untuk persetujuan.',

                'dibaca' => false,
            ]);


            return $hardware;
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
                'max:100',
            ],

            'lokasi_id' => [
                'required',
                'exists:lokasi,id',
            ],

            'sistem_operasi' => [
                'nullable',
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
                'in:Baik,Perlu Perbaikan,Rusak',
            ],

        ], [

            'nama_barang.required' =>
                'Nama barang wajib diisi.',

            'spesifikasi.required' =>
                'Spesifikasi wajib diisi.',

            'jenis_barang.required' =>
                'Jenis barang wajib diisi.',

            'lokasi_id.required' =>
                'Lokasi wajib dipilih.',

            'lokasi_id.exists' =>
                'Lokasi yang dipilih tidak valid.',

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
        |--------------------------------------------------------------------------
        | DEFAULT SISTEM OPERASI
        |--------------------------------------------------------------------------
        */

        $validated['sistem_operasi'] =
            trim($validated['sistem_operasi'] ?? '') ?: 'N/A';


        /*
        |--------------------------------------------------------------------------
        | DATA LAMA
        |--------------------------------------------------------------------------
        */

        $dataLama = $hardwareRecord->toArray();


        /*
        |--------------------------------------------------------------------------
        | UPDATE + VERIFIKASI + NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $hardwareRecord,
            $validated,
            $dataLama
        ) {

            /*
             * Asset ID tetap.
             */
            $hardwareRecord->update($validated);

            'pesan' =>
                $request->user()->username .
                ' memperbarui hardware "' .
                $hardware->nama_barang .
                '" dengan ID ' .
                $hardware->asset_id .
                '.',

            'dibaca' => false,
        ]);


            /*
             * Buat request verifikasi update.
             */
            VerificationRequest::create([

                'module' =>
                    'hardware',

                'record_id' =>
                    $hardwareRecord->asset_id,

                'action' =>
                    'update',

                'data' => [

                    'data_lama' =>
                        $dataLama,

                    'data_baru' =>
                        $hardwareRecord->toArray(),

                ],

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);


            /*
             * Buat notifikasi.
             */
            Notification::create([

                'judul' =>
                    'Perubahan Hardware Diajukan',

                'pesan' =>
                    auth()->user()->username .
                    ' memperbarui hardware "' .
                    $hardwareRecord->nama_barang .
                    '" dengan ID ' .
                    $hardwareRecord->asset_id .
                    ' dan mengajukannya kembali untuk persetujuan.',

                'dibaca' =>
                    false,
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
    | IMPORT EXCEL / CSV
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {
        $request->validate([

            'file' => [
                'required',
                'file',
                'mimes:xlsx,csv',
                'max:10240',
            ],

        ], [

            'file.required' =>
                'File import wajib dipilih.',

            'file.file' =>
                'File yang dipilih tidak valid.',

            'file.mimes' =>
                'File harus berformat Excel (.xlsx) atau CSV (.csv).',

            'file.max' =>
                'Ukuran file maksimal 10 MB.',
        ]);


        try {

            DB::transaction(function () use (
                $request
            ) {

                /*
                |--------------------------------------------------------------------------
                | IMPORT DATA
                |--------------------------------------------------------------------------
                */

                Excel::import(
                    new HardwareImport,
                    $request->file('file')
                );


                /*
                |--------------------------------------------------------------------------
                | NOTIFIKASI IMPORT
                |--------------------------------------------------------------------------
                |
                | Hanya 1 notifikasi untuk 1 proses import.
                | Jadi kalau Excel berisi 600 data,
                | tidak dibuat 600 notification.
                |
                */

                Notification::create([

                    'judul' =>
                        'Import Hardware Baru',

                    'pesan' =>
                        auth()->user()->username .
                        ' melakukan import data hardware melalui file Excel/CSV dan data tersebut berhasil dimasukkan.',

                    'dibaca' =>
                        false,
                ]);
            });


            return redirect()
                ->route('hardware.index')
                ->with(
                    'success',
                    'Data hardware berhasil diimport dan menunggu verifikasi.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('hardware.index')
                ->with(
                    'error',
                    'Import gagal: ' .
                    $e->getMessage()
                );
        }
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


        /*
        |--------------------------------------------------------------------------
        | PENGAJUAN HAPUS + NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $hardwareRecord
        ) {

            /*
             * Buat request verifikasi penghapusan.
             */
            VerificationRequest::create([

                'module' =>
                    'hardware',

                'record_id' =>
                    $hardwareRecord->asset_id,

                'action' =>
                    'delete',

                'data' =>
                    $hardwareRecord->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);


            /*
             * Buat notifikasi.
             */
            Notification::create([

                'judul' =>
                    'Pengajuan Penghapusan Hardware',

                'pesan' =>
                    auth()->user()->username .
                    ' mengajukan penghapusan hardware "' .
                    $hardwareRecord->nama_barang .
                    '" dengan ID ' .
                    $hardwareRecord->asset_id .
                    ' untuk persetujuan verifikator.',

                'dibaca' =>
                    false,
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