<?php

namespace App\Http\Controllers;

use App\Models\DataCenterMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DataCenterMasterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | JENIS DATA MASTER
    |--------------------------------------------------------------------------
    */

    private function allowedJenis(): array
    {
        return [
            'tenant',
            'site',
            'rack',
            'region',
            'location',
            'role',
            'manufacturer',
            'pic',
            'platform',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | LABEL JENIS
    |--------------------------------------------------------------------------
    */

    private function jenisLabels(): array
    {
        return [
            'tenant'       => 'Tenant',
            'site'         => 'Site',
            'rack'         => 'Rack',
            'region'       => 'Region',
            'location'     => 'Location',
            'role'         => 'Role',
            'manufacturer' => 'Manufacturer',
            'pic'          => 'PIC',
            'platform'     => 'Platform',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $allowedJenis = $this->allowedJenis();
        $jenisLabels = $this->jenisLabels();

        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = DataCenterMaster::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");

            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('jenis') &&
            in_array($request->jenis, $allowedJenis)
        ) {

            $query->where(
                'jenis',
                $request->jenis
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status') &&
            in_array(
                $request->status,
                ['Active', 'Inactive']
            )
        ) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA DATA
        |--------------------------------------------------------------------------
        |
        | TIDAK MENGGUNAKAN paginate().
        |
        | Data akan dikelompokkan berdasarkan jenis sehingga:
        | - 9 PIC langsung muncul
        | - Platform langsung muncul
        | - Tidak ada data yang "terlempar" ke halaman kedua
        |
        */

        $masters = $query
            ->orderBy('jenis')
            ->orderBy('nama')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | KELOMPOKKAN BERDASARKAN JENIS
        |--------------------------------------------------------------------------
        */

        $mastersByJenis = [];

        foreach ($allowedJenis as $jenis) {

            $mastersByJenis[$jenis] = $masters
                ->where('jenis', $jenis)
                ->values();

        }


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $total = DataCenterMaster::count();

        $active = DataCenterMaster::where(
            'status',
            'Active'
        )->count();

        $inactive = DataCenterMaster::where(
            'status',
            'Inactive'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH PER JENIS
        |--------------------------------------------------------------------------
        */

        $counts = [];

        foreach ($allowedJenis as $jenis) {

            $counts[$jenis] = DataCenterMaster::where(
                'jenis',
                $jenis
            )->count();

        }


        /*
        |--------------------------------------------------------------------------
        | JENIS LIST
        |--------------------------------------------------------------------------
        */

        $jenisList = collect($allowedJenis);


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'infrastruktur.data-center.master',
            compact(
                'masters',
                'mastersByJenis',
                'total',
                'active',
                'inactive',
                'counts',
                'jenisList',
                'jenisLabels'
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
        $validated = $request->validate(
            [
                'jenis' => [
                    'required',
                    'string',
                    Rule::in(
                        $this->allowedJenis()
                    ),
                ],

                'nama' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'status' => [
                    'required',
                    Rule::in([
                        'Active',
                        'Inactive',
                    ]),
                ],
            ],
            [
                'jenis.required' =>
                    'Jenis master wajib dipilih.',

                'jenis.in' =>
                    'Jenis master tidak valid.',

                'nama.required' =>
                    'Nama master wajib diisi.',

                'nama.max' =>
                    'Nama master maksimal 255 karakter.',

                'status.required' =>
                    'Status wajib dipilih.',

                'status.in' =>
                    'Status hanya boleh Active atau Inactive.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI NAMA
        |--------------------------------------------------------------------------
        */

        $nama = trim(
            preg_replace(
                '/\s+/',
                ' ',
                $validated['nama']
            )
        );


        /*
        |--------------------------------------------------------------------------
        | CEK DUPLIKAT
        |--------------------------------------------------------------------------
        |
        | Tidak membedakan:
        | VMware
        | vmware
        | VMWARE
        |
        | Selama jenisnya sama, dianggap data yang sama.
        |
        */

        $exists = DataCenterMaster::query()
            ->where(
                'jenis',
                $validated['jenis']
            )
            ->whereRaw(
                'LOWER(TRIM(nama)) = ?',
                [
                    strtolower($nama),
                ]
            )
            ->exists();


        if ($exists) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Data "' .
                    $nama .
                    '" sudah ada pada jenis ' .
                    $this->jenisLabels()[
                        $validated['jenis']
                    ] .
                    '.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        DataCenterMaster::create([
            'jenis' => $validated['jenis'],
            'nama' => $nama,
            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('data-center.master')
            ->with(
                'success',
                'Data master berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {

        $master =
            DataCenterMaster::findOrFail($id);


        $validated = $request->validate(
            [
                'jenis' => [
                    'required',
                    'string',
                    Rule::in(
                        $this->allowedJenis()
                    ),
                ],

                'nama' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'status' => [
                    'required',
                    Rule::in([
                        'Active',
                        'Inactive',
                    ]),
                ],
            ],
            [
                'jenis.required' =>
                    'Jenis master wajib dipilih.',

                'jenis.in' =>
                    'Jenis master tidak valid.',

                'nama.required' =>
                    'Nama master wajib diisi.',

                'nama.max' =>
                    'Nama master maksimal 255 karakter.',

                'status.required' =>
                    'Status wajib dipilih.',

                'status.in' =>
                    'Status hanya boleh Active atau Inactive.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI
        |--------------------------------------------------------------------------
        */

        $nama = trim(
            preg_replace(
                '/\s+/',
                ' ',
                $validated['nama']
            )
        );


        /*
        |--------------------------------------------------------------------------
        | CEK DUPLIKAT
        |--------------------------------------------------------------------------
        */

        $exists = DataCenterMaster::query()
            ->where(
                'jenis',
                $validated['jenis']
            )
            ->whereRaw(
                'LOWER(TRIM(nama)) = ?',
                [
                    strtolower($nama),
                ]
            )
            ->where(
                'id',
                '!=',
                $master->id
            )
            ->exists();


        if ($exists) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Data "' .
                    $nama .
                    '" sudah ada pada jenis tersebut.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $master->update([
            'jenis' => $validated['jenis'],
            'nama' => $nama,
            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('data-center.master')
            ->with(
                'success',
                'Data master berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | TOGGLE STATUS
    |--------------------------------------------------------------------------
    */

    public function toggleStatus($id)
    {
        $master =
            DataCenterMaster::findOrFail($id);


        $master->update([
            'status' =>
                $master->status === 'Active'
                    ? 'Inactive'
                    : 'Active',
        ]);


        return redirect()
            ->route('data-center.master')
            ->with(
                'success',
                'Status data master berhasil diubah.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $master =
            DataCenterMaster::findOrFail($id);


        $master->delete();


        return redirect()
            ->route('data-center.master')
            ->with(
                'success',
                'Data master berhasil dihapus.'
            );
    }
}