<?php

namespace App\Http\Controllers;

use App\Exports\DataCenterTemplateExport;
use App\Imports\DataCenterImport;
use App\Models\DataCenter;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DataCenterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PILIHAN DROPDOWN
    |--------------------------------------------------------------------------
    */

    private function allowedStatuses(): array
    {
        return [
            'Active',
            'Offline',
        ];
    }

    private function allowedTenants(): array
    {
        return [
            'Diskominfostandi',
            'Dinas Pendidikan',
            'Sekretariat Daerah',
            'SatpolPP',
            'DPMPTSP',
            'Dinas Tata Ruang',
            'Bappelitbangda',
            'Dinas Lingkungan Hidup',
            'Disdamkarmat',
            'BKPSDM',
            'BPKAD',
        ];
    }

    private function allowedSites(): array
    {
        return [
            'Data Center Pemerintah Kota Bekasi',
            'DRC-Batam',
        ];
    }

    private function allowedRacks(): array
    {
        return [
            'Rack A01',
            'Rack A02',
            'Rack DRC',
        ];
    }

    private function allowedRoles(): array
    {
        return [
            'Switch Manage',
            'Server Managed by Disdik',
            'Server Managed by Diskominfostandi',
            'Server Managed by DPMPTSP',
            'Server Managed by BPKAD',
            'NAS Managed by Diskominfo',
            'Router',
        ];
    }

    private function allowedManufacturers(): array
    {
        return [
            'Mikrotik',
            'Hewlett Packard Enterprise',
            'Lenovo',
            'Synology',
            'Supermicro',
        ];
    }

    private function allowedRams(): array
    {
        return [
            '4 GB',
            '8 GB',
            '16 GB',
            '32 GB',
            '40 GB',
            '64 GB',
            '96 GB',
            '128 GB',
            '192 GB',
            '256 GB',
            '512 GB',
            '1024 GB',
        ];
    }

    private function allowedRegions(): array
    {
        return [
            'Kota Bekasi',
            'Kota Batam',
        ];
    }

    private function allowedRackFaces(): array
    {
        return [
            'Front',
            'Rear',
        ];
    }

    private function allowedClusters(): array
    {
        return [
            'DC-Diskominfo',
        ];
    }

    private function allowedPositions(): array
    {
        return collect(range(1, 42))
            ->map(fn ($position) => str_pad(
                $position,
                2,
                '0',
                STR_PAD_LEFT
            ))
            ->toArray();
    }

    private function allowedUHeights(): array
{
    return collect(range(1, 42))
        ->map(fn ($height) => (string) $height)
        ->toArray();
}

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY DATA CENTER
        |--------------------------------------------------------------------------
        */

        $query = DataCenter::query();


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        |
        | Search dilakukan langsung ke database.
        | Jadi search tetap berlaku untuk seluruh data,
        | bukan hanya 25 data yang sedang tampil.
        |
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('platform', 'like', "%{$search}%")
                    ->orWhere('version', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('ipv4_address', 'like', "%{$search}%")
                    ->orWhere('cpu', 'like', "%{$search}%")
                    ->orWhere('harddisk', 'like', "%{$search}%")
                    ->orWhere('ram', 'like', "%{$search}%")
                    ->orWhere('tenant', 'like', "%{$search}%")
                    ->orWhere('tenant_group', 'like', "%{$search}%")
                    ->orWhere('site', 'like', "%{$search}%")
                    ->orWhere('rack', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('u_height', 'like', "%{$search}%")
                    ->orWhere('rack_face', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%")
                    ->orWhere('manufacturer', 'like', "%{$search}%")
                    ->orWhere('pic', 'like', "%{$search}%")
                    ->orWhere('region', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('cluster', 'like', "%{$search}%")
                    ->orWhere('owner_group', 'like', "%{$search}%")
                    ->orWhere('owner', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('verifikasi', 'like', "%{$search}%")
                    ->orWhere('komentar', 'like', "%{$search}%");
            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TENANT
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tenant')) {

            $query->where(
                'tenant',
                $request->tenant
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER SITE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('site')) {

            $query->where(
                'site',
                $request->site
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER MANUFACTURER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('manufacturer')) {

            $query->where(
                'manufacturer',
                $request->manufacturer
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER PLATFORM
        |--------------------------------------------------------------------------
        */

        if ($request->filled('platform')) {

            $query->where(
                'platform',
                $request->platform
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER VERIFIKASI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('verifikasi')) {

            $query->where(
                'verifikasi',
                $request->verifikasi
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATA + PAGINATION
        |--------------------------------------------------------------------------
        |
        | Maksimal 25 data per halaman.
        |
        | withQueryString() memastikan search dan filter tetap
        | terbawa ketika user pindah halaman.
        |
        */

        $dataCenters = $query
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        |
        | Tidak perlu mengambil seluruh data dengan ->get().
        | Langsung hitung melalui database supaya lebih ringan.
        |
        */

        $totalDataCenter = DataCenter::count();

        $active = DataCenter::where(
            'status',
            'Active'
        )->count();

        $offline = DataCenter::where(
            'status',
            'Offline'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | DROPDOWN
        |--------------------------------------------------------------------------
        */

        $statuses = collect(
            $this->allowedStatuses()
        );

        $tenants = collect(
            $this->allowedTenants()
        );

        $sites = collect(
            $this->allowedSites()
        );

        $racks = collect(
            $this->allowedRacks()
        );

        $roles = collect(
            $this->allowedRoles()
        );

        $manufacturers = collect(
            $this->allowedManufacturers()
        );

        $rams = collect(
            $this->allowedRams()
        );

        $regions = collect(
            $this->allowedRegions()
        );

        $rackFaces = collect(
            $this->allowedRackFaces()
        );

        $clusters = collect(
            $this->allowedClusters()
        );

        $positions = collect(
            $this->allowedPositions()
        );

        $uHeights = collect(
            $this->allowedUHeights()
        );


        /*
        |--------------------------------------------------------------------------
        | PLATFORM
        |--------------------------------------------------------------------------
        */

        $platforms = DataCenter::query()
            ->whereNotNull('platform')
            ->where('platform', '!=', '')
            ->select('platform')
            ->distinct()
            ->orderBy('platform')
            ->pluck('platform');


        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI
        |--------------------------------------------------------------------------
        */

        $verifikasis = DataCenter::query()
            ->whereNotNull('verifikasi')
            ->where('verifikasi', '!=', '')
            ->select('verifikasi')
            ->distinct()
            ->orderBy('verifikasi')
            ->pluck('verifikasi');


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'infrastruktur.data-center.index',
            compact(
                'dataCenters',
                'totalDataCenter',
                'active',
                'offline',
                'statuses',
                'tenants',
                'sites',
                'racks',
                'roles',
                'manufacturers',
                'rams',
                'regions',
                'rackFaces',
                'clusters',
                'positions',
                'uHeights',
                'platforms',
                'verifikasis'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION RULES
    |--------------------------------------------------------------------------
    */

    private function dataCenterRules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'string',
                Rule::in(
                    $this->allowedStatuses()
                ),
            ],

            'tenant' => [
                'nullable',
                'string',
                'max:255',
                Rule::in(
                    $this->allowedTenants()
                ),
            ],

            'site' => [
                'nullable',
                'string',
                'max:255',
                Rule::in(
                    $this->allowedSites()
                ),
            ],

            'rack' => [
                'nullable',
                'string',
                'max:255',
                Rule::in(
                    $this->allowedRacks()
                ),
            ],

            'role' => [
                'nullable',
                'string',
                'max:255',
                Rule::in(
                    $this->allowedRoles()
                ),
            ],

            'manufacturer' => [
                'nullable',
                'string',
                'max:255',
                Rule::in(
                    $this->allowedManufacturers()
                ),
            ],

            'ram' => [
                'nullable',
                'string',
                'max:100',
                Rule::in(
                    $this->allowedRams()
                ),
            ],

            'region' => [
                'nullable',
                'string',
                'max:255',
                Rule::in(
                    $this->allowedRegions()
                ),
            ],

            'position' => [
                'nullable',
                'string',
                'max:100',
                Rule::in(
                    $this->allowedPositions()
                ),
            ],

            'rack_face' => [
                'nullable',
                'string',
                'max:100',
                Rule::in(
                    $this->allowedRackFaces()
                ),
            ],

            'cluster' => [
                'nullable',
                'string',
                'max:255',
                Rule::in(
                    $this->allowedClusters()
                ),
            ],

            'u_height' => [
                'nullable',
                'string',
                'max:50',
                Rule::in(
                    $this->allowedUHeights()
                ),
            ],

            'type' => [
                'nullable',
                'string',
                'max:255',
            ],

            'platform' => [
                'nullable',
                'string',
                'max:255',
            ],

            'version' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pic' => [
                'nullable',
                'string',
                'max:255',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'owner_group' => [
                'nullable',
                'string',
                'max:255',
            ],

            'owner' => [
                'nullable',
                'string',
                'max:255',
            ],

            'serial_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'ip_address' => [
                'nullable',
                'string',
                'max:255',
            ],

            'ipv4_address' => [
                'nullable',
                'string',
                'max:255',
            ],

            'cpu' => [
                'nullable',
                'string',
            ],

            'harddisk' => [
                'nullable',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION MESSAGES
    |--------------------------------------------------------------------------
    */

    private function dataCenterMessages(): array
    {
        return [

            'name.required' =>
                'Nama perangkat wajib diisi.',

            'status.required' =>
                'Status wajib dipilih.',

            'status.in' =>
                'Status hanya boleh Active atau Offline.',

            'tenant.in' =>
                'Tenant tidak tersedia dalam pilihan.',

            'site.in' =>
                'Site tidak tersedia dalam pilihan.',

            'rack.in' =>
                'Rack tidak tersedia dalam pilihan.',

            'role.in' =>
                'Role tidak tersedia dalam pilihan.',

            'manufacturer.in' =>
                'Manufacturer tidak tersedia dalam pilihan.',

            'ram.in' =>
                'RAM tidak tersedia dalam pilihan.',

            'region.in' =>
                'Region tidak tersedia dalam pilihan.',

            'position.in' =>
                'Position harus berada pada 01 sampai 42.',

            'rack_face.in' =>
                'Rack Face hanya boleh Front atau Rear.',

            'cluster.in' =>
                'Cluster tidak tersedia dalam pilihan.',

            'u_height.in' =>
                'U Height harus berada pada 1U sampai 42U.',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->dataCenterRules(),
            $this->dataCenterMessages()
        );

        $newId = $this->generateNextId();

        $validated['id'] = $newId;

        $validated['tenant_group'] =
            'Pemerintah Kota Bekasi';

        $validated['verifikasi'] =
            'menunggu';

        $validated['komentar'] =
            null;

        DB::transaction(function () use (
            $validated
        ) {

            $dataCenter =
                DataCenter::create(
                    $validated
                );

            VerificationRequest::create([

                'module' =>
                    'data-center',

                'record_id' =>
                    $dataCenter->id,

                'action' =>
                    'create',

                'data' =>
                    $dataCenter->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);
        });

        return redirect()
            ->route('data-center.index')
            ->with(
                'success',
                'Data Data Center berhasil ditambahkan dan menunggu verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {
        $request->validate(

            [
                'file' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls',
                    'max:10240',
                ],
            ],

            [
                'file.required' =>
                    'File Excel wajib dipilih.',

                'file.file' =>
                    'File yang diupload tidak valid.',

                'file.mimes' =>
                    'File harus berupa Excel (.xlsx atau .xls).',

                'file.max' =>
                    'Ukuran file maksimal 10 MB.',
            ]
        );

        try {

            DB::transaction(function () use (
                $request
            ) {

                Excel::import(
                    new DataCenterImport(),
                    $request->file('file')
                );
            });

            return redirect()
                ->route('data-center.index')
                ->with(
                    'success',
                    'Data Data Center berhasil diimport dari Excel.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->route('data-center.index')
                ->with(
                    'error',
                    'Import Excel gagal: ' .
                    $e->getMessage()
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD TEMPLATE EXCEL
    |--------------------------------------------------------------------------
    */

    public function downloadTemplate()
    {
        return Excel::download(
            new DataCenterTemplateExport,
            'template-data-center.xlsx'
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
        $validated = $request->validate(
            $this->dataCenterRules(),
            $this->dataCenterMessages()
        );

        $dataCenter =
            DataCenter::findOrFail($id);

        $validated['tenant_group'] =
            'Pemerintah Kota Bekasi';

        DB::transaction(function () use (
            $dataCenter,
            $validated
        ) {

            $dataCenter->update([

                ...$validated,

                'verifikasi' =>
                    'menunggu',

                'komentar' =>
                    null,
            ]);

            $dataCenter->refresh();

            VerificationRequest::create([

                'module' =>
                    'data-center',

                'record_id' =>
                    $dataCenter->id,

                'action' =>
                    'update',

                'data' =>
                    $dataCenter->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);
        });

        return redirect()
            ->route('data-center.index')
            ->with(
                'success',
                'Perubahan Data Center berhasil disimpan dan menunggu verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $dataCenter =
            DataCenter::findOrFail($id);

        DB::transaction(function () use (
            $dataCenter
        ) {

            $dataCenter->update([

                'verifikasi' =>
                    'menunggu',

                'komentar' =>
                    null,
            ]);

            VerificationRequest::create([

                'module' =>
                    'data-center',

                'record_id' =>
                    $dataCenter->id,

                'action' =>
                    'delete',

                'data' =>
                    $dataCenter->toArray(),

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);
        });

        return redirect()
            ->route('data-center.index')
            ->with(
                'success',
                'Pengajuan penghapusan Data Center berhasil dikirim dan menunggu verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE ID
    |--------------------------------------------------------------------------
    */

    private function generateNextId(): string
    {
        $prefix = 'INFDC-';

        $lastDataCenter =
            DataCenter::query()
                ->where(
                    'id',
                    'like',
                    $prefix . '%'
                )
                ->orderByRaw(
                    "CAST(SUBSTRING(id, 7) AS UNSIGNED) DESC"
                )
                ->first();

        $newNumber =
            $lastDataCenter
                ? (
                    (int) substr(
                        $lastDataCenter->id,
                        strlen($prefix)
                    )
                ) + 1
                : 1;

        return $prefix .
            str_pad(
                $newNumber,
                3,
                '0',
                STR_PAD_LEFT
            );
    }
}