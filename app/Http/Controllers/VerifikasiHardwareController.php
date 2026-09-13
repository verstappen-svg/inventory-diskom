<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\VerifikasiHardware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiHardwareController extends Controller
{
    public function update(Request $request, Hardware $hardware)
    {
        $validated = $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan' => 'nullable|string|max:1000',
        ]);

        if (
            $validated['status'] === 'Ditolak' &&
            empty(trim($validated['catatan'] ?? ''))
        ) {
            return back()
                ->withErrors([
                    'catatan' => 'Komentar wajib diisi jika data ditolak.'
                ])
                ->withInput();
        }

        $verifikasi = VerifikasiHardware::firstOrCreate(
            [
                'hardware_id' => $hardware->id,
            ],
            [
                'status' => 'Menunggu Persetujuan',
            ]
        );

        $verifikasi->update([
            'status' => $validated['status'],
            'catatan' => $validated['catatan'] ?? null,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()
            ->route('hardware.index')
            ->with('success', 'Verifikasi hardware berhasil disimpan.');
    }
}