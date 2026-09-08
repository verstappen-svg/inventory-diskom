<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\VerifikasiHardware;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HardwareController extends Controller
{
    /**
     * ============================================================
     * INDEX
     * ============================================================
     */
    public function index()
    {
        $hardwares = Hardware::with('verifikasi')
            ->latest()
            ->get();

        // =====================================================
        // SUMMARY CARD
        // =====================================================

        $jumlahBarang = Hardware::count();

        $hargaBarang = Hardware::sum('harga');

        $perluPerbaikan = Hardware::where(
            'kondisi',
            'Perlu Perbaikan'
        )->count();

        $rusak = Hardware::where(
            'kondisi',
            'Rusak'
        )->count();

        $tersedia = Hardware::where(
            'kondisi',
            'Baik'
        )->count();

        return view('hardware.index', compact(
            'hardwares',
            'jumlahBarang',
            'hargaBarang',
            'perluPerbaikan',
            'rusak',
            'tersedia'
        ));
    }


    /**
     * ============================================================
     * STORE
     * ============================================================
     */
    public function store(Request $request)
    {
        // =====================================================
        // VALIDASI
        // =====================================================

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


        // =====================================================
        // PREFIX ASSET ID
        // =====================================================

        $prefix = match ($validated['jenis_barang']) {

            'Laptop' => 'LP',
            'PC' => 'PC',
            'Printer' => 'PR',
            'Monitor' => 'MN',
            'Keyboard' => 'KB',
            'Mouse' => 'MS',
            'Camera' => 'CM',

            default => strtoupper(
                substr(
                    preg_replace(
                        '/[^A-Za-z]/',
                        '',
                        $validated['jenis_barang']
                    ),
                    0,
                    2
                )
            ),

        };


        // =====================================================
        // TAHUN 2 DIGIT
        // Contoh:
        // 2026 -> 26
        // =====================================================

        $year = substr(
            (string) $validated['tahun_pembelian'],
            -2
        );


        // =====================================================
        // PROSES SIMPAN
        // =====================================================

        $hardware = DB::transaction(function () use (
            $validated,
            $prefix,
            $year,
            $request
        ) {

            // =================================================
            // CARI NOMOR ASSET TERAKHIR
            // =================================================

            $lastHardware = Hardware::where(
                'asset_id',
                'like',
                "{$prefix}-{$year}-%"
            )
                ->orderByDesc('id')
                ->first();


            // =================================================
            // TENTUKAN NOMOR BERIKUTNYA
            // =================================================

            $number = 1;

            if ($lastHardware && $lastHardware->asset_id) {

                $parts = explode(
                    '-',
                    $lastHardware->asset_id
                );

                $lastNumber = end($parts);

                if (is_numeric($lastNumber)) {
                    $number = ((int) $lastNumber) + 1;
                }
            }


            // =================================================
            // GENERATE ASSET ID
            //
            // Contoh:
            // LP-26-001
            // PC-26-002
            // PR-26-003
            // =================================================

            $assetId = sprintf(
                '%s-%s-%03d',
                $prefix,
                $year,
                $number
            );


            // =================================================
            // SIMPAN HARDWARE
            // =================================================

            $hardware = Hardware::create([
                'asset_id' => $assetId,
                'nama_barang' => $validated['nama_barang'],
                'spesifikasi' => $validated['spesifikasi'],
                'jenis_barang' => $validated['jenis_barang'],
                'tahun_pembelian' => $validated['tahun_pembelian'],
                'harga' => $validated['harga'],
                'kondisi' => $validated['kondisi'],
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


        // =====================================================
        // REDIRECT
        // =====================================================

        return redirect()
            ->route('hardware.index')
            ->with(
                'success',
                'Data hardware berhasil ditambahkan.'
            );
    }


    /**
     * ============================================================
     * UPDATE
     * ============================================================
     */
    public function update(
        Request $request,
        Hardware $hardware
    ) {

        // =====================================================
        // VALIDASI
        // =====================================================

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

        ]);


        // =====================================================
        // UPDATE HARDWARE
        // =====================================================

        $hardware->update($validated);


        // =====================================================
        // NOTIFIKASI UPDATE
        // =====================================================

        Notification::create([
            'judul' => 'Hardware Diperbarui',

            'pesan' =>
                $request->user()->username .
                ' memperbarui hardware "' .
                $hardware->nama_barang .
                '" dengan ID ' .
                $hardware->asset_id .
                '.',

            'dibaca' => false,
        ]);


        // =====================================================
        // REDIRECT
        // =====================================================

        return redirect()
            ->route('hardware.index')
            ->with(
                'success',
                'Data hardware berhasil diperbarui.'
            );
    }


    /**
     * ============================================================
     * DESTROY
     * ============================================================
     */
    public function destroy(Hardware $hardware)
    {
        // =====================================================
        // SIMPAN DATA SEBELUM DIHAPUS
        // =====================================================

        $namaHardware = $hardware->nama_barang;

        $assetId = $hardware->asset_id;

        $username = auth()->user()->username;


        // =====================================================
        // HAPUS HARDWARE
        // =====================================================

        $hardware->delete();


        // =====================================================
        // NOTIFIKASI HAPUS
        // =====================================================

        Notification::create([
            'judul' => 'Hardware Dihapus',

            'pesan' =>
                $username .
                ' menghapus hardware "' .
                $namaHardware .
                '" dengan ID ' .
                $assetId .
                '.',

            'dibaca' => false,
        ]);


        // =====================================================
        // REDIRECT
        // =====================================================

        return redirect()
            ->route('hardware.index')
            ->with(
                'success',
                'Data hardware berhasil dihapus.'
            );
    }
}