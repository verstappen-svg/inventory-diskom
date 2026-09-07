<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\VerifikasiHardware;
use App\Models\Notification;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    public function index()
    {
        $hardwares = Hardware::with('verifikasi')->latest()->get();

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

    public function store(Request $request)
    {
        // =====================================================
        // VALIDASI
        // =====================================================

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'required|string',
            'jenis_barang' => 'required|string|max:100',
            'tahun_pembelian' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'kondisi' => 'required|in:Baik,Perlu Perbaikan,Rusak',
        ]);

        // =====================================================
        // BUAT PREFIX ASSET ID
        // =====================================================

        $prefix = match ($validated['jenis_barang']) {
            'Laptop' => 'LP',
            'PC' => 'PC',
            'Printer' => 'PR',
            'Monitor' => 'MN',
            'Keyboard' => 'KB',
            'Mouse' => 'MS',
            'Camera' => 'CM',
        };

        $year = date('y');

        // =====================================================
        // CARI NOMOR ASSET TERAKHIR
        // =====================================================

        $lastHardware = Hardware::where(
            'asset_id',
            'like',
            "$prefix-$year-%"
        )
            ->orderByDesc('id')
            ->first();

        $number = $lastHardware
            ? ((int) substr($lastHardware->asset_id, -3)) + 1
            : 1;

        // =====================================================
        // GENERATE ASSET ID
        // Contoh: LP-26-001
        // =====================================================

        $assetId = sprintf(
            '%s-%s-%03d',
            $prefix,
            $year,
            $number
        );

        // =====================================================
        // SIMPAN HARDWARE
        // =====================================================

        $hardware = Hardware::create([
            'asset_id' => $assetId,
            'nama_barang' => $validated['nama_barang'],
            'spesifikasi' => $validated['spesifikasi'],
            'jenis_barang' => $validated['jenis_barang'],
            'tahun_pembelian' => $validated['tahun_pembelian'],
            'harga' => $validated['harga'],
            'kondisi' => $validated['kondisi'],
        ]);

        // =====================================================
        // BUAT PENGAJUAN VERIFIKASI
        // =====================================================

        VerifikasiHardware::create([
            'hardware_id' => $hardware->id,
            'status' => 'Menunggu Persetujuan',
        ]);

        // =====================================================
        // NOTIFIKASI PENGAJUAN
        // =====================================================

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

        return redirect()
            ->route('hardware.index')
            ->with(
                'success',
                'Data hardware berhasil ditambahkan.'
            );
    }

    public function update(Request $request, Hardware $hardware)
    {
        // =====================================================
        // VALIDASI
        // =====================================================

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'required|string',
            'jenis_barang' => 'required|string|max:100',
            'tahun_pembelian' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'kondisi' => 'required|in:Baik,Perlu Perbaikan,Rusak',
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

        return redirect()
            ->route('hardware.index')
            ->with(
                'success',
                'Data hardware berhasil diperbarui.'
            );
    }

    public function destroy(Hardware $hardware)
    {
        // =====================================================
        // SIMPAN DATA SEBELUM DIHAPUS
        // =====================================================

        $namaHardware = $hardware->nama_barang;
        $assetId = $hardware->asset_id;

        // Ambil username operator yang menghapus
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

        return redirect()
            ->route('hardware.index')
            ->with(
                'success',
                'Data hardware berhasil dihapus.'
            );
    }
}