<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\VerifikasiHardware;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    public function index()
{
    $hardwares = Hardware::with('verifikasi')->latest()->get();

    // Summary Card
    $jumlahBarang = Hardware::count();

    $hargaBarang = Hardware::sum('harga');

    $perluPerbaikan = Hardware::where('kondisi', 'Perlu Perbaikan')->count();

    $rusak = Hardware::where('kondisi', 'Rusak')->count();

    $tersedia = Hardware::where('kondisi', 'Baik')->count();

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
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'required|string',
            'jenis_barang' => 'required|string|max:100',
            'tahun_pembelian' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'kondisi' => 'required|in:Baik,Perlu Perbaikan,Rusak',
        ]);

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

        $lastHardware = Hardware::where('asset_id', 'like', "$prefix-$year-%")
            ->orderByDesc('id')
            ->first();

        $number = $lastHardware
            ? ((int) substr($lastHardware->asset_id, -3)) + 1
            : 1;

        $assetId = sprintf('%s-%s-%03d', $prefix, $year, $number);

        $hardware = Hardware::create([
    'asset_id' => $assetId,
    'nama_barang' => $validated['nama_barang'],
    'spesifikasi' => $validated['spesifikasi'],
    'jenis_barang' => $validated['jenis_barang'],
    'tahun_pembelian' => $validated['tahun_pembelian'],
    'harga' => $validated['harga'],
    'kondisi' => $validated['kondisi'],
]);

VerifikasiHardware::create([
    'hardware_id' => $hardware->id,
    'status' => 'Menunggu Persetujuan',
]);

        return redirect()
            ->route('hardware.index')
            ->with('success', 'Data hardware berhasil ditambahkan.');
    }
    public function update(Request $request, Hardware $hardware)
{
    $validated = $request->validate([
        'nama_barang' => 'required|string|max:255',
        'spesifikasi' => 'required|string',
        'jenis_barang' => 'required|string|max:100',
        'tahun_pembelian' => 'required|integer',
        'harga' => 'required|numeric|min:0',
        'kondisi' => 'required|in:Baik,Perlu Perbaikan,Rusak',
    ]);

    $hardware->update($validated);

    return redirect()
        ->route('hardware.index')
        ->with('success', 'Data hardware berhasil diperbarui.');
}

public function destroy(Hardware $hardware)
{
    $hardware->delete();

    return redirect()
        ->route('hardware.index')
        ->with('success', 'Data hardware berhasil dihapus.');
}
}