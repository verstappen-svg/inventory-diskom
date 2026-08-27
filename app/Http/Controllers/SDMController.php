<?php

namespace App\Http\Controllers;

use App\Models\Sdm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SDMController extends Controller
{
    public function index()
    {
        $sdm = Sdm::latest()->paginate(10);
        $aktif = Sdm::where('masa_berlaku', '>=', now())->count();
        $berakhir = Sdm::where('masa_berlaku', '<', now())->count();

        return view('sdm.index', compact('sdm', 'aktif', 'berakhir'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip'          => 'required|string|max:20|unique:sdms,nip',
            'nama'         => 'required|string|max:100',
            'jabatan'      => 'required|string|max:100',
            'kompetensi'   => 'required|string|max:150',
            'masa_berlaku' => 'required|date',
            'dokumen'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dokumenPath = null;
        if ($request->hasFile('dokumen')) {
            $dokumenPath = $request->file('dokumen')->store('sdm/dokumen', 'public');
        }

        $kodeBk = 'BK-' . str_pad(Sdm::count() + 1, 4, '0', STR_PAD_LEFT);

        Sdm::create([
            'nip'          => $request->nip,
            'kode_dk'      => $kodeBk,
            'nama'         => $request->nama,
            'jabatan'      => $request->jabatan,
            'kompetensi'   => $request->kompetensi,
            'masa_berlaku' => $request->masa_berlaku,
            'dokumen'      => $dokumenPath,
        ]);

        return redirect()->route('sdm.index')->with('success', 'Data SDM berhasil ditambahkan.');
    }

    public function update(Request $request, Sdm $sdm)
    {
        $validator = Validator::make($request->all(), [
            'nip'          => 'required|string|max:20|unique:sdms,nip,' . $sdm->id,
            'nama'         => 'required|string|max:100',
            'jabatan'      => 'required|string|max:100',
            'kompetensi'   => 'required|string|max:150',
            'masa_berlaku' => 'required|date',
            'dokumen'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dokumenPath = $sdm->dokumen;
        if ($request->hasFile('dokumen')) {
            if ($sdm->dokumen) {
                Storage::disk('public')->delete($sdm->dokumen);
            }
            $dokumenPath = $request->file('dokumen')->store('sdm/dokumen', 'public');
        }

        $sdm->update([
            'nip'          => $request->nip,
            'nama'         => $request->nama,
            'jabatan'      => $request->jabatan,
            'kompetensi'   => $request->kompetensi,
            'masa_berlaku' => $request->masa_berlaku,
            'dokumen'      => $dokumenPath,
        ]);

        return redirect()->route('sdm.index')->with('success', 'Data SDM berhasil diperbarui.');
    }

    public function destroy(Sdm $sdm)
    {
        if ($sdm->dokumen) {
            Storage::disk('public')->delete($sdm->dokumen);
        }
        $sdm->delete();

        return redirect()->route('sdm.index')->with('success', 'Data SDM berhasil dihapus.');
    }

    public function approve(Sdm $sdm)
    {
        $sdm->update(['status_verifikasi' => 'disetujui']);
        return redirect()->route('sdm.index')->with('success', 'Data berhasil disetujui.');
    }

    public function reject(Sdm $sdm)
    {
        $sdm->update(['status_verifikasi' => 'ditolak']);
        return redirect()->route('sdm.index')->with('success', 'Data ditolak.');
    }
}