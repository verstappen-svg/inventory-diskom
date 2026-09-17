<?php

namespace App\Http\Controllers;

use App\Exports\DataCenterTemplateExport;
use App\Imports\DataCenterImport;
use App\Models\DataCenter;
use App\Models\DataCenterMaster;
use App\Models\Notification;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DataCenterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DATA MASTER OPTIONS
    |--------------------------------------------------------------------------
    */

    private function masterOptions(string $jenis): array
    {
        return DataCenterMaster::query()
            ->where('jenis', $jenis)
            ->where('status', 'Active')
            ->orderBy('nama')
            ->pluck('nama')
            ->toArray();
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $status = $request->input('status');

        $verifikasi = $request->input('verifikasi');


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalDataCenter = DataCenter::count();

        $active = DataCenter::query()
            ->where('status', 'Active')
            ->count();

        $offline = DataCenter::query()
            ->where('status', 'Offline')
            ->count();


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
        */

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                // ID Data Center aplikasi
                $q->where(
                    'id_data_center',
                    'like',
                    "%{$search}%"
                )

                // ID dari Excel
                ->orWhere(
                    'id',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'tahun',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'status',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'tenant',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'site',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'rack',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'region',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'location',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'role',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'manufacturer',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'type',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'platform',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'serial_number',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'ip_address',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'ipv4_address',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'cpu',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'harddisk',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'ram',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'pic',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'position',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'rack_face',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'cluster',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'owner_group',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'owner',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'description',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'comments',
                    'like',
                    "%{$search}%"
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($status !== null && $status !== '') {

            $query->where(
                'status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER VERIFIKASI
        |--------------------------------------------------------------------------
        */

        if ($verifikasi !== null && $verifikasi !== '') {

            $query->where(
                'verifikasi',
                $verifikasi
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATA CENTER
        |--------------------------------------------------------------------------
        */

       $dataCenters = $query
    ->orderByDesc('created_at')
    ->paginate(15)
    ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | DATA MASTER
        |--------------------------------------------------------------------------
        */

        $tenants = collect(
            $this->masterOptions('tenant')
        );

        $sites = collect(
            $this->masterOptions('site')
        );

        $racks = collect(
            $this->masterOptions('rack')
        );

        $regions = collect(
            $this->masterOptions('region')
        );

        $locations = collect(
            $this->masterOptions('location')
        );

        $roles = collect(
            $this->masterOptions('role')
        );

        $manufacturers = collect(
            $this->masterOptions('manufacturer')
        );

        $pics = collect(
            $this->masterOptions('pic')
        );

        $platforms = collect(
            $this->masterOptions('platform')
        );


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        $statuses = [
            'Active',
            'Offline',
        ];


        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI
        |--------------------------------------------------------------------------
        */

        $verifikasiOptions = [
            'menunggu',
            'disetujui',
            'ditolak',
        ];


        /*
        |--------------------------------------------------------------------------
        | RAM
        |--------------------------------------------------------------------------
        */

        $rams = [
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


        /*
        |--------------------------------------------------------------------------
        | RACK FACE
        |--------------------------------------------------------------------------
        */

        $rackFaces = [
            'Front',
            'Rear',
        ];


        /*
        |--------------------------------------------------------------------------
        | CLUSTER
        |--------------------------------------------------------------------------
        */

        $clusters = [
            'DC-Diskominfo',
        ];


        /*
        |--------------------------------------------------------------------------
        | POSITION
        |--------------------------------------------------------------------------
        */

        $positions = [];

        for ($i = 1; $i <= 42; $i++) {

            $positions[] = str_pad(
                (string) $i,
                2,
                '0',
                STR_PAD_LEFT
            );
        }


        /*
        |--------------------------------------------------------------------------
        | U HEIGHT
        |--------------------------------------------------------------------------
        */

        $uHeights = range(1, 42);


        /*
        |--------------------------------------------------------------------------
        | NEXT ID DATA CENTER
        |--------------------------------------------------------------------------
        */

        $nextId = $this->generateNextId();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'infrastruktur.data-center.index',
            compact(
                'dataCenters',

                'search',
                'status',
                'verifikasi',

                'totalDataCenter',
                'active',
                'offline',

                'statuses',
                'verifikasiOptions',

                'tenants',
                'sites',
                'racks',
                'regions',
                'locations',
                'roles',
                'manufacturers',
                'pics',
                'platforms',

                'rams',
                'rackFaces',
                'clusters',
                'positions',
                'uHeights',

                'nextId'
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

            /*
            |--------------------------------------------------------------------------
            | IDENTITAS
            |--------------------------------------------------------------------------
            */

            'id' => [
                'nullable',
                'string',
                'max:50',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun' => [
                'nullable',
                'integer',
                'between:1900,' . (date('Y') + 1),
            ],


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                Rule::in([
                    'Active',
                    'Offline',
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | DATA MASTER
            |--------------------------------------------------------------------------
            */

            'tenant' => [
                'nullable',
                'string',
                Rule::in(
                    $this->masterOptions('tenant')
                ),
            ],

            'site' => [
                'nullable',
                'string',
                Rule::in(
                    $this->masterOptions('site')
                ),
            ],

            'rack' => [
                'nullable',
                'string',
                Rule::in(
                    $this->masterOptions('rack')
                ),
            ],

            'region' => [
                'nullable',
                'string',
                Rule::in(
                    $this->masterOptions('region')
                ),
            ],

            'location' => [
                'nullable',
                'string',
                Rule::in(
                    $this->masterOptions('location')
                ),
            ],

            'role' => [
                'nullable',
                'string',
                Rule::in(
                    $this->masterOptions('role')
                ),
            ],

            'manufacturer' => [
                'nullable',
                'string',
                Rule::in(
                    $this->masterOptions('manufacturer')
                ),
            ],

            'pic' => [
                'nullable',
                'string',
                Rule::in(
                    $this->masterOptions('pic')
                ),
            ],

            'platform' => [
                'nullable',
                'string',
                Rule::in(
                    $this->masterOptions('platform')
                ),
            ],


            /*
            |--------------------------------------------------------------------------
            | MANUAL FIELD
            |--------------------------------------------------------------------------
            */

            'type' => [
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

            'description' => [
                'nullable',
                'string',
            ],

            'comments' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | RAM
            |--------------------------------------------------------------------------
            */

            'ram' => [
                'nullable',
                Rule::in([
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
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | RACK FACE
            |--------------------------------------------------------------------------
            */

            'rack_face' => [
                'nullable',
                Rule::in([
                    'Front',
                    'Rear',
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | CLUSTER
            |--------------------------------------------------------------------------
            */

            'cluster' => [
                'nullable',
                Rule::in([
                    'DC-Diskominfo',
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | POSITION
            |--------------------------------------------------------------------------
            */

            'position' => [
                'nullable',
                Rule::in(
                    array_map(
                        fn ($value) => str_pad(
                            (string) $value,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ),
                        range(1, 42)
                    )
                ),
            ],


            /*
            |--------------------------------------------------------------------------
            | U HEIGHT
            |--------------------------------------------------------------------------
            */

            'u_height' => [
                'nullable',
                'integer',
                'between:1,42',
            ],
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
        $this->dataCenterValidationMessages()
    );

    /*
    |--------------------------------------------------------------------------
    | Generate ID Data Center aplikasi
    |--------------------------------------------------------------------------
    */

    $validated['id_data_center'] = $this->generateNextId();

    /*
    |--------------------------------------------------------------------------
    | Status verifikasi
    |--------------------------------------------------------------------------
    */

    $validated['verifikasi'] = 'menunggu';
    $validated['komentar'] = null;

    DB::transaction(function () use ($validated) {

        /*
        |--------------------------------------------------------------------------
        | JANGAN langsung create ke data_centers
        |--------------------------------------------------------------------------
        |
        | Data ditampung terlebih dahulu di verification_requests.
        |
        */

        VerificationRequest::create([
            'module' => 'data-center',

            'record_id' => $validated['id_data_center'],

            'action' => 'create',

            'data' => $validated,

            'status' => 'menunggu',

            'submitted_by' => auth()->id(),
        ]);
    });

    return redirect()
        ->route('data-center.index')
        ->with(
            'success',
            'Data Data Center berhasil diajukan dan menunggu persetujuan verifikator.'
        );
}


    /*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/

public function update(
    Request $request,
    string $id
) {
    $dataCenter = DataCenter::findOrFail($id);

    $validated = $request->validate(
        $this->dataCenterRules(),
        $this->dataCenterValidationMessages()
    );

    /*
    |--------------------------------------------------------------------------
    | Pertahankan ID Data Center
    |--------------------------------------------------------------------------
    */

    $validated['id_data_center'] =
        $dataCenter->id_data_center;

    /*
    |--------------------------------------------------------------------------
    | Status verifikasi
    |--------------------------------------------------------------------------
    */

    $validated['verifikasi'] = 'menunggu';
    $validated['komentar'] = null;

    DB::transaction(function () use (
        $dataCenter,
        $validated
    ) {

        /*
        |--------------------------------------------------------------------------
        | JANGAN langsung update data utama
        |--------------------------------------------------------------------------
        */

        VerificationRequest::create([
            'module' => 'data-center',

            'record_id' =>
                $dataCenter->id_data_center,

            'action' => 'update',

            /*
            | Simpan hasil edit yang diajukan
            */
            'data' => $validated,

            'status' => 'menunggu',

            'submitted_by' => auth()->id(),
        ]);
    });

    return redirect()
        ->route('data-center.index')
        ->with(
            'success',
            'Perubahan Data Center berhasil diajukan dan menunggu persetujuan verifikator.'
        );
}


    /*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

public function destroy(string $id)
{
    $dataCenter = DataCenter::findOrFail($id);

    DB::transaction(function () use ($dataCenter) {

        /*
        |--------------------------------------------------------------------------
        | Buat permintaan penghapusan
        |--------------------------------------------------------------------------
        |
        | Data asli TIDAK dihapus sekarang.
        |
        */

        VerificationRequest::create([
            'module' => 'data-center',

            'record_id' =>
                $dataCenter->id_data_center,

            'action' => 'delete',

            /*
            | Simpan snapshot data sebelum dihapus.
            */
            'data' => $dataCenter->toArray(),

            'status' => 'menunggu',

            'submitted_by' => auth()->id(),
        ]);
    });

    return redirect()
        ->route('data-center.index')
        ->with(
            'success',
            'Permintaan penghapusan Data Center berhasil diajukan dan menunggu persetujuan verifikator.'
        );
}


    /*
|--------------------------------------------------------------------------
| IMPORT EXCEL
|--------------------------------------------------------------------------
*/

public function import(Request $request)
{
    $request->validate([
        'file' => [
            'required',
            'file',
            'mimes:xlsx,xls,csv',
            'max:10240',
        ],
    ]);

    try {

        /*
        |--------------------------------------------------------------------------
        | BUAT INSTANCE IMPORTER
        |--------------------------------------------------------------------------
        |
        | Jangan langsung pakai:
        |
        | Excel::import(new DataCenterImport(), ...)
        |
        | karena kita perlu mengambil hasil import:
        | - berapa data baru
        | - berapa data yang sudah ada
        |
        */

        $importer = new DataCenterImport();


        DB::transaction(function () use (
            $request,
            $importer
        ) {

            /*
            |--------------------------------------------------------------------------
            | PROSES IMPORT
            |--------------------------------------------------------------------------
            */

            Excel::import(
                $importer,
                $request->file('file')
            );


            /*
            |--------------------------------------------------------------------------
            | CEK HASIL IMPORT
            |--------------------------------------------------------------------------
            |
            | Kalau tidak ada satu pun data baru yang masuk,
            | jangan dianggap berhasil.
            |
            */

            $importedRows = $importer->getImportedRows();
            $existingRows = $importer->getExistingRows();


            if ($importedRows <= 0) {

                throw new \RuntimeException(
                    'Tidak ada data baru yang dapat diimport. '
                    . 'Seluruh data dalam file Excel sudah terdaftar '
                    . 'di Data Center.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | NOTIFICATION
            |--------------------------------------------------------------------------
            */

            $notificationMessage =
                "Import Data Center berhasil. "
                . "{$importedRows} data baru berhasil ditambahkan.";


            if ($existingRows > 0) {

                $notificationMessage .=
                    " {$existingRows} data yang sudah terdaftar "
                    . "dilewati.";
            }


            Notification::create([
                'judul' => 'Import Data Center',

                'pesan' => $notificationMessage,

                'dibaca' => false,
            ]);
        });


        /*
        |--------------------------------------------------------------------------
        | SUCCESS MESSAGE
        |--------------------------------------------------------------------------
        */

        $importedRows = $importer->getImportedRows();
        $existingRows = $importer->getExistingRows();


        $successMessage =
            "Import Data Center berhasil. "
            . "{$importedRows} data baru berhasil ditambahkan.";


        if ($existingRows > 0) {

            $successMessage .=
                " {$existingRows} data yang sudah terdaftar "
                . "dilewati.";
        }


        return redirect()
            ->route('data-center.index')
            ->with(
                'success',
                $successMessage
            );


    } catch (\Throwable $e) {

        $message = $e->getMessage();


        /*
        |--------------------------------------------------------------------------
        | DATA MASTER ERROR
        |--------------------------------------------------------------------------
        */

        if (
            str_contains(
                $message,
                'belum terdaftar di Data Master'
            )
        ) {

            return redirect()
                ->route('data-center.index')
                ->with(
                    'error',
                    $message
                )
                ->with(
                    'show_data_master',
                    true
                );
        }


        /*
        |--------------------------------------------------------------------------
        | GENERAL ERROR
        |--------------------------------------------------------------------------
        |
        | Termasuk:
        |
        | - seluruh file sudah ada di DB
        | - duplikat di dalam Excel
        | - data tidak valid
        | - error lainnya
        |
        */

        return redirect()
            ->route('data-center.index')
            ->with(
                'error',
                'Import Excel gagal: ' . $message
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
            new DataCenterTemplateExport(),
            'template_data_center.xlsx'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION MESSAGES
    |--------------------------------------------------------------------------
    */

    private function dataCenterValidationMessages(): array
    {
        return [

            'id.string' =>
                'ID harus berupa teks.',

            'name.required' =>
                'Nama Data Center wajib diisi.',

            'tahun.integer' =>
                'Tahun harus berupa angka.',

            'tahun.between' =>
                'Tahun harus antara 1900 sampai ' .
                (date('Y') + 1) .
                '.',


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            'status.in' =>
                'Status tidak valid.',


            /*
            |--------------------------------------------------------------------------
            | DATA MASTER
            |--------------------------------------------------------------------------
            */

            'tenant.in' =>
                'Tenant tidak tersedia dalam Data Master.',

            'site.in' =>
                'Site tidak tersedia dalam Data Master.',

            'rack.in' =>
                'Rack tidak tersedia dalam Data Master.',

            'region.in' =>
                'Region tidak tersedia dalam Data Master.',

            'location.in' =>
                'Location tidak tersedia dalam Data Master.',

            'role.in' =>
                'Role tidak tersedia dalam Data Master.',

            'manufacturer.in' =>
                'Manufacturer tidak tersedia dalam Data Master.',

            'pic.in' =>
                'PIC tidak tersedia dalam Data Master.',

            'platform.in' =>
                'Platform tidak tersedia dalam Data Master.',


            /*
            |--------------------------------------------------------------------------
            | DROPDOWN
            |--------------------------------------------------------------------------
            */

            'ram.in' =>
                'RAM tidak tersedia dalam pilihan.',

            'rack_face.in' =>
                'Rack Face tidak tersedia dalam pilihan.',

            'cluster.in' =>
                'Cluster tidak tersedia dalam pilihan.',

            'position.in' =>
                'Position tidak tersedia dalam pilihan.',


            /*
            |--------------------------------------------------------------------------
            | U HEIGHT
            |--------------------------------------------------------------------------
            */

            'u_height.integer' =>
                'U Height harus berupa angka.',

            'u_height.between' =>
                'U Height harus antara 1 sampai 42.',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE NEXT ID DATA CENTER
    |--------------------------------------------------------------------------
    */

    private function generateNextId(): string
    {
        $prefix = 'INFDC-';


        $lastDataCenter = DataCenter::query()
            ->where(
                'id_data_center',
                'like',
                $prefix . '%'
            )
            ->orderByRaw(
                "CAST(SUBSTRING(id_data_center, 7) AS UNSIGNED) DESC"
            )
            ->first();


        if ($lastDataCenter) {

            $lastNumber = (int) substr(
                $lastDataCenter->id_data_center,
                strlen($prefix)
            );

            $newNumber = $lastNumber + 1;

        } else {

            $newNumber = 1;
        }


        return $prefix .
            str_pad(
                $newNumber,
                3,
                '0',
                STR_PAD_LEFT
            );
    }
}