<?php

namespace App\Http\Controllers;

use App\Models\SoftwareAsset;
use App\Models\SoftwareCategory;
use App\Models\SoftwareHosting;
use App\Models\SoftwarePic;
use App\Models\SoftwareSsl;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SoftwareMasterController extends Controller
{
    public function index()
    {
        $kategori = SoftwareCategory::orderBy('nama')->get();
        $ssl = SoftwareSsl::orderBy('nama_ssl')->get();
        $hosting = SoftwareHosting::orderBy('nama')->get();
        $pic = SoftwarePic::orderBy('nama')->get();

        return view('software.master', compact(
            'kategori',
            'ssl',
            'hosting',
            'pic'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => [
                'required',
                Rule::in(['kategori', 'ssl', 'hosting', 'pic']),
            ],
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
            'tanggal_expire' => [
                'nullable',
                'date',
            ],
        ], [
            'type.required' => 'Jenis data master wajib dipilih.',
            'type.in' => 'Jenis data master tidak valid.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'tanggal_expire.date' => 'Tanggal expire tidak valid.',
        ]);

        switch ($request->type) {
            case 'kategori':
                if (
                    SoftwareCategory::where('nama', $request->nama)->exists()
                ) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'nama' => 'Kategori tersebut sudah ada.',
                        ]);
                }

                SoftwareCategory::create([
                    'nama' => $request->nama,
                    'status' => 'Aktif',
                ]);

                $message = 'Kategori berhasil ditambahkan.';
                break;

            case 'ssl':
                if (
                    SoftwareSsl::where('nama_ssl', $request->nama)->exists()
                ) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'nama' => 'SSL tersebut sudah ada.',
                        ]);
                }

                SoftwareSsl::create([
                    'nama_ssl' => $request->nama,
                    'tanggal_expire' => $request->tanggal_expire ?: null,
                    'status' => 'Aktif',
                ]);

                $message = 'SSL berhasil ditambahkan.';
                break;

            case 'hosting':
                if (
                    SoftwareHosting::where('nama', $request->nama)->exists()
                ) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'nama' => 'Hosting tersebut sudah ada.',
                        ]);
                }

                SoftwareHosting::create([
                    'nama' => $request->nama,
                    'status' => 'Aktif',
                ]);

                $message = 'Hosting berhasil ditambahkan.';
                break;

            case 'pic':
                if (
                    SoftwarePic::where('nama', $request->nama)->exists()
                ) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'nama' => 'PIC tersebut sudah ada.',
                        ]);
                }

                SoftwarePic::create([
                    'nama' => $request->nama,
                    'status' => 'Aktif',
                ]);

                $message = 'PIC berhasil ditambahkan.';
                break;

            default:
                abort(404);
        }

        return redirect()
            ->route('software.master.index')
            ->with('success', $message);
    }

    public function update(
        Request $request,
        string $type,
        int $id
    ) {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
            'tanggal_expire' => [
                'nullable',
                'date',
            ],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'tanggal_expire.date' => 'Tanggal expire tidak valid.',
        ]);

        switch ($type) {
            case 'kategori':
                $data = SoftwareCategory::findOrFail($id);

                $exists = SoftwareCategory::where('nama', $request->nama)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($exists) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'nama' => 'Kategori tersebut sudah ada.',
                        ]);
                }

                $data->update([
                    'nama' => $request->nama,
                ]);

                $message = 'Kategori berhasil diperbarui.';
                break;

            case 'ssl':
                $data = SoftwareSsl::findOrFail($id);

                $exists = SoftwareSsl::where('nama_ssl', $request->nama)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($exists) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'nama' => 'SSL tersebut sudah ada.',
                        ]);
                }

                $data->update([
                    'nama_ssl' => $request->nama,
                    'tanggal_expire' => $request->tanggal_expire ?: null,
                ]);

                $message = 'SSL berhasil diperbarui.';
                break;

            case 'hosting':
                $data = SoftwareHosting::findOrFail($id);

                $exists = SoftwareHosting::where('nama', $request->nama)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($exists) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'nama' => 'Hosting tersebut sudah ada.',
                        ]);
                }

                $data->update([
                    'nama' => $request->nama,
                ]);

                $message = 'Hosting berhasil diperbarui.';
                break;

            case 'pic':
                $data = SoftwarePic::findOrFail($id);

                $exists = SoftwarePic::where('nama', $request->nama)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($exists) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'nama' => 'PIC tersebut sudah ada.',
                        ]);
                }

                $data->update([
                    'nama' => $request->nama,
                ]);

                $message = 'PIC berhasil diperbarui.';
                break;

            default:
                abort(404);
        }

        return redirect()
            ->route('software.master.index')
            ->with('success', $message);
    }

    public function toggle(string $type, int $id)
    {
        switch ($type) {
            case 'kategori':
                $data = SoftwareCategory::findOrFail($id);
                break;

            case 'ssl':
                $data = SoftwareSsl::findOrFail($id);
                break;

            case 'hosting':
                $data = SoftwareHosting::findOrFail($id);
                break;

            case 'pic':
                $data = SoftwarePic::findOrFail($id);
                break;

            default:
                abort(404);
        }

        $data->status = $data->status === 'Aktif'
            ? 'Tidak Aktif'
            : 'Aktif';

        $data->save();

        return back()->with(
            'success',
            'Data master berhasil ' .
            ($data->status === 'Aktif'
                ? 'diaktifkan.'
                : 'dinonaktifkan.')
        );
    }

    public function destroy(string $type, int $id)
    {
        switch ($type) {
            case 'kategori':
                $data = SoftwareCategory::findOrFail($id);

                $dipakai = SoftwareAsset::where(
                    'kategori_id',
                    $id
                )->exists();

                if ($dipakai) {
                    return back()->with(
                        'error',
                        'Kategori tidak dapat dihapus karena masih digunakan oleh data Software.'
                    );
                }

                $data->delete();

                $message = 'Kategori berhasil dihapus.';
                break;

            case 'ssl':
                $data = SoftwareSsl::findOrFail($id);

                $dipakai = SoftwareAsset::where(
                    'ssl_id',
                    $id
                )->exists();

                if ($dipakai) {
                    return back()->with(
                        'error',
                        'SSL tidak dapat dihapus karena masih digunakan oleh data Software.'
                    );
                }

                $data->delete();

                $message = 'SSL berhasil dihapus.';
                break;

            case 'hosting':
                $data = SoftwareHosting::findOrFail($id);

                $dipakai = SoftwareAsset::where(
                    'hosting_id',
                    $id
                )->exists();

                if ($dipakai) {
                    return back()->with(
                        'error',
                        'Hosting tidak dapat dihapus karena masih digunakan oleh data Software.'
                    );
                }

                $data->delete();

                $message = 'Hosting berhasil dihapus.';
                break;

            case 'pic':
                $data = SoftwarePic::findOrFail($id);

                $dipakai = SoftwareAsset::where(
                    'pic_id',
                    $id
                )->exists();

                if ($dipakai) {
                    return back()->with(
                        'error',
                        'PIC tidak dapat dihapus karena masih digunakan oleh data Software.'
                    );
                }

                $data->delete();

                $message = 'PIC berhasil dihapus.';
                break;

            default:
                abort(404);
        }

        return back()->with('success', $message);
    }
}