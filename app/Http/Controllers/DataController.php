<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Models\Data;
use App\Models\DatasetRow;
use App\Models\Notification;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Throwable;

class DataController extends Controller
{
    private array $topikOptions = [
        'Ekonomi',
        'Infrastruktur',
        'Kemiskinan',
        'Kependudukan',
        'Kesehatan',
        'Lingkungan Hidup',
        'Pariwisata & Kebudayaan',
        'Pemerintah & Desa',
        'Pendidikan',
        'Sosial',
    ];

    /**
     * =========================================================
     * INDEX
     * =========================================================
     */
    public function index(Request $request)
    {
        $query = Data::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_dataset', 'like', "%{$search}%")
                    ->orWhere('jenis_data', 'like', "%{$search}%")
                    ->orWhere('tahun', 'like', "%{$search}%")
                    ->orWhere('topik', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS DATA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('jenis_data')) {
            $query->where(
                'jenis_data',
                $request->jenis_data
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TAHUN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tahun')) {
            $query->where(
                'tahun',
                $request->tahun
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER VERIFIKASI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('verifikasi')) {

            $verifikasi = strtolower(
                trim($request->verifikasi)
            );

            if ($verifikasi === 'menunggu') {
                $verifikasi = 'Menunggu Disetujui';
            }

            $allowedStatuses = [
                'Menunggu Disetujui',
                'Disetujui',
                'Ditolak',
            ];

            if (in_array($verifikasi, $allowedStatuses, true)) {
                $query->where(
                    'verifikasi',
                    $verifikasi
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $show = (int) $request->input('show', 10);

        if (!in_array($show, [10, 25, 50, 100], true)) {
            $show = 10;
        }

        $data = $query
            ->latest('id')
            ->paginate($show)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | DATA JENIS UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $jenisData = Data::query()
            ->select('jenis_data')
            ->whereNotNull('jenis_data')
            ->where('jenis_data', '!=', '')
            ->distinct()
            ->orderBy('jenis_data')
            ->pluck('jenis_data');

        /*
        |--------------------------------------------------------------------------
        | DATA TAHUN UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $tahunData = Data::query()
            ->select('tahun')
            ->whereNotNull('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalData = Data::count();

        $totalJenis = Data::query()
            ->whereNotNull('jenis_data')
            ->where('jenis_data', '!=', '')
            ->distinct('jenis_data')
            ->count('jenis_data');

        $totalPending = Data::where(
            'verifikasi',
            'Menunggu Disetujui'
        )->count();

        $totalDisetujui = Data::where(
            'verifikasi',
            'Disetujui'
        )->count();

        $totalMenunggu = Data::where(
            'verifikasi',
            'Menunggu Disetujui'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'data.index',
            compact(
                'data',
                'jenisData',
                'tahunData',
                'totalData',
                'totalJenis',
                'totalPending',
                'totalDisetujui',
                'totalMenunggu'
            )
        );
    }

    /**
     * =========================================================
     * IMPORT EXCEL
     * =========================================================
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xls,xlsx',
                'max:10240',
            ],
        ]);

        DB::beginTransaction();

        try {

            if (!class_exists('ZipArchive')) {
                throw new \Exception(
                    'Extension ZIP/ZipArchive belum tersedia pada PHP yang menjalankan Laravel.'
                );
            }

            $file = $request->file('file');

            if (!$file || !$file->isValid()) {
                throw new \Exception(
                    'File Excel tidak valid atau gagal diupload.'
                );
            }

            $import = new DataImport();

            $import->import(
                $file->getRealPath()
            );

            $metadata = $import->getMetadata();
            $headers = $import->getHeaders();
            $rows = $import->getRows();

            if (empty($headers)) {
                throw new \Exception(
                    'Sheet Dataset tidak memiliki header.'
                );
            }

            if (empty($rows)) {
                throw new \Exception(
                    'Sheet Dataset tidak memiliki data.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN FILE EXCEL
            |--------------------------------------------------------------------------
            */

            $path = $file->store(
                'data',
                'public'
            );

            if (!$path) {
                throw new \Exception(
                    'File Excel gagal disimpan.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | BUAT DATA DATASET
            |--------------------------------------------------------------------------
            */

            $firstRow = $rows[0] ?? [];

            $namaDataset = $firstRow['nama_dataset']
                ?? $firstRow['Nama Dataset']
                ?? $firstRow['nama']
                ?? 'Dataset Import Excel';

            $jenisData = $firstRow['jenis_data']
                ?? $firstRow['Jenis Data']
                ?? $firstRow['jenis']
                ?? null;

            $tahun = $firstRow['tahun']
                ?? $firstRow['Tahun']
                ?? null;

            $data = Data::create([
                'nama_dataset' => $namaDataset,
                'jenis_data' => $jenisData,
                'tahun' => $tahun,
                'deskripsi' => $metadata['Deskripsi'] ?? null,
                'metadata' => $metadata,
                'file_data' => $path,
                'verifikasi' => 'Menunggu Disetujui',
                'tanggal_pengajuan' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | SIMPAN BARIS DATASET
            |--------------------------------------------------------------------------
            */

            $datasetRows = [];

            foreach ($rows as $row) {

                $datasetRows[] = [
                    'data_id' => $data->id,
                    'row_data' => json_encode(
                        $row,
                        JSON_UNESCAPED_UNICODE
                    ),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($datasetRows) >= 500) {
                    DatasetRow::insert($datasetRows);
                    $datasetRows = [];
                }
            }

            if (!empty($datasetRows)) {
                DatasetRow::insert($datasetRows);
            }

            /*
            |--------------------------------------------------------------------------
            | VERIFICATION
            |--------------------------------------------------------------------------
            */

            $this->createVerificationAndNotification(
                $data,
                'create'
            );

            DB::commit();

            return redirect()
                ->route('data.index')
                ->with(
                    'success',
                    'Dataset berhasil diimport dan menunggu verifikasi.'
                );

        } catch (Throwable $e) {

            DB::rollBack();

            return redirect()
                ->route('data.index')
                ->with(
                    'error',
                    'File Excel gagal dibaca: ' . $e->getMessage()
                );
        }
    }

    /**
     * =========================================================
     * CREATE VERIFICATION + NOTIFICATION
     * =========================================================
     */
    private function createVerificationAndNotification(
        Data $data,
        string $action = 'create'
    ): void {

        VerificationRequest::create([
            'module' => 'data',
            'record_id' => $data->id,
            'action' => $action,
            'data' => $data->toArray(),
            'status' => 'menunggu',
            'submitted_by' => auth()->id(),
        ]);

        $datasetId =
            'DS-' .
            str_pad(
                $data->id,
                5,
                '0',
                STR_PAD_LEFT
            );

        $username = auth()->user()?->username
            ?? 'Pengguna';

        $judul = match ($action) {
            'create' => 'Pengajuan Dataset Baru',
            'update' => 'Perubahan Dataset Diajukan',
            'delete' => 'Penghapusan Dataset Diajukan',
            default => 'Pengajuan Dataset',
        };

        $pesan = match ($action) {
            'create' =>
                $username .
                ' menambahkan dataset "' .
                $data->nama_dataset .
                '" dengan ID ' .
                $datasetId .
                ' dan mengajukannya untuk persetujuan.',

            'update' =>
                $username .
                ' memperbarui dataset "' .
                $data->nama_dataset .
                '" dengan ID ' .
                $datasetId .
                ' dan mengajukannya kembali untuk persetujuan.',

            'delete' =>
                $username .
                ' mengajukan penghapusan dataset "' .
                $data->nama_dataset .
                '" dengan ID ' .
                $datasetId .
                ' untuk persetujuan verifikator.',

            default =>
                $username .
                ' mengajukan dataset "' .
                $data->nama_dataset .
                '" untuk persetujuan.',
        };

        Notification::create([
            'judul' => $judul,
            'pesan' => $pesan,
            'dibaca' => false,
        ]);
    }

    /**
     * =========================================================
     * DOWNLOAD TEMPLATE
     * =========================================================
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();

        /*
        |--------------------------------------------------------------------------
        | SHEET METADATA
        |--------------------------------------------------------------------------
        */

        $metadataSheet = $spreadsheet->getActiveSheet();

        $metadataSheet->setTitle('Metadata');

        $metadataRows = [
            ['Metadata', 'Nilai'],
            ['Dataset Dibuat', ''],
            ['Dataset Diperbarui', ''],
            ['Pengukuran Dataset', ''],
            ['Tingkat Penyajian Dataset', ''],
            ['Cakupan Dataset', ''],
            ['Produsen', ''],
            ['Kontak Produsen', ''],
            ['Kode Indikator', ''],
            ['Satuan Dataset', ''],
            ['Frekuensi Dataset', ''],
            ['Sumber Eksternal', ''],
            ['Dimensi Dataset', ''],
            ['Deskripsi', ''],
        ];

        foreach ($metadataRows as $rowIndex => $row) {
            $metadataSheet->fromArray(
                $row,
                null,
                'A' . ($rowIndex + 1)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SHEET DATASET
        |--------------------------------------------------------------------------
        */

        $datasetSheet = $spreadsheet->createSheet();

        $datasetSheet->setTitle('Dataset');

        $datasetSheet->fromArray(
            [
                'Kolom 1',
                'Kolom 2',
                'Kolom 3',
                'Kolom 4',
                'Kolom 5',
            ],
            null,
            'A1'
        );

        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        $filename = 'template_dataset.xlsx';

        $tempPath = storage_path(
            'app/' . $filename
        );

        $writer = new Xlsx($spreadsheet);

        $writer->save($tempPath);

        return response()
            ->download(
                $tempPath,
                $filename
            )
            ->deleteFileAfterSend(true);
    }

    /**
     * =========================================================
     * SHOW
     * =========================================================
     */
    public function show($id)
    {
        $data = Data::with([
            'datasetRows',
        ])->findOrFail($id);

        return view(
            'data.show',
            compact('data')
        );
    }

    /**
     * =========================================================
     * STORE - TAMBAH BANYAK DATA SEKALIGUS
     * =========================================================
     */
    public function store(Request $request)
    {
        $request->validate([

            'nama_dataset' => [
                'required',
                'array',
                'min:1',
            ],

            'nama_dataset.*' => [
                'required',
                'string',
                'max:255',
            ],

            'jenis_data' => [
                'required',
                'array',
                'min:1',
            ],

            'jenis_data.*' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun' => [
                'required',
                'array',
                'min:1',
            ],

            'tahun.*' => [
                'required',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'file_data' => [
                'required',
                'array',
                'min:1',
            ],

            'file_data.*' => [
                'required',
                'file',
                'mimes:csv,xls,xlsx,pdf,zip',
                'max:10240',
            ],
        ]);

        $namaDataset = $request->input(
            'nama_dataset',
            []
        );

        $jenisData = $request->input(
            'jenis_data',
            []
        );

        $tahun = $request->input(
            'tahun',
            []
        );

        $files = $request->file(
            'file_data',
            []
        );

        $jumlahData = count($namaDataset);

        /*
        |--------------------------------------------------------------------------
        | CEK JUMLAH BARIS
        |--------------------------------------------------------------------------
        */

        if (
            count($jenisData) !== $jumlahData ||
            count($tahun) !== $jumlahData ||
            count($files) !== $jumlahData
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data yang dikirim tidak lengkap. Silakan periksa kembali setiap baris.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $namaDataset,
            $jenisData,
            $tahun,
            $files
        ) {

            foreach ($namaDataset as $index => $nama) {

                /*
                |--------------------------------------------------------------------------
                | UPLOAD FILE
                |--------------------------------------------------------------------------
                */

                $filePath = null;

                if (
                    isset($files[$index]) &&
                    $files[$index] instanceof \Illuminate\Http\UploadedFile
                ) {
                    $filePath = $files[$index]->store(
                        'data',
                        'public'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | CREATE DATA
                |--------------------------------------------------------------------------
                */

                $data = Data::create([

                    'nama_dataset' =>
                        $nama,

                    'jenis_data' =>
                        $jenisData[$index],

                    'tahun' =>
                        $tahun[$index],

                    'file_data' =>
                        $filePath,

                    'verifikasi' =>
                        'Menunggu Disetujui',

                    'tanggal_pengajuan' =>
                        now(),

                    'komentar_verifikasi' =>
                        null,
                ]);

                /*
                |--------------------------------------------------------------------------
                | VERIFICATION + NOTIFICATION
                |--------------------------------------------------------------------------
                */

                $this->createVerificationAndNotification(
                    $data,
                    'create'
                );
            }
        });

        return redirect()
            ->route('data.index')
            ->with(
                'success',
                $jumlahData .
                ' dataset berhasil ditambahkan dan menunggu verifikasi.'
            );
    }

    /**
     * =========================================================
     * EDIT
     * =========================================================
     */
    public function edit($id)
    {
        $data = Data::findOrFail($id);

        return view(
            'data.edit',
            [
                'data' => $data,
                'topikData' => $this->topikOptions,
            ]
        );
    }

    /**
     * =========================================================
     * UPDATE
     * =========================================================
     */
    public function update(
        Request $request,
        $id
    ) {
        $data = Data::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'nama_dataset' => [
                'required',
                'string',
                'max:255',
            ],

            'jenis_data' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun' => [
                'required',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'file_data' => [
                'nullable',
                'file',
                'mimes:csv,xls,xlsx,pdf,zip',
                'max:10240',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | DATA LAMA
        |--------------------------------------------------------------------------
        */

        $dataLama = $data->toArray();

        /*
        |--------------------------------------------------------------------------
        | FILE
        |--------------------------------------------------------------------------
        */

        $filePath = $data->file_data;

        if ($request->hasFile('file_data')) {

            $file = $request->file('file_data');

            if (!$file || !$file->isValid()) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'File tidak valid atau gagal diupload.'
                    );
            }

            $filePath = $file->store(
                'data',
                'public'
            );

            if (!$filePath) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'File gagal disimpan.'
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FORMAT ID
        |--------------------------------------------------------------------------
        */

        $datasetId =
            'DS-' .
            str_pad(
                $data->id,
                5,
                '0',
                STR_PAD_LEFT
            );

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $data,
            $request,
            $filePath,
            $dataLama,
            $datasetId
        ) {

            $data->update([

                'nama_dataset' =>
                    $request->nama_dataset,

                'jenis_data' =>
                    $request->jenis_data,

                'tahun' =>
                    $request->tahun,

                'file_data' =>
                    $filePath,

                'verifikasi' =>
                    'Menunggu Disetujui',

                'komentar_verifikasi' =>
                    null,

                'tanggal_pengajuan' =>
                    now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | VERIFICATION REQUEST
            |--------------------------------------------------------------------------
            */

            VerificationRequest::create([

                'module' =>
                    'data',

                'record_id' =>
                    $data->id,

                'action' =>
                    'update',

                'data' => [

                    'data_lama' =>
                        $dataLama,

                    'data_baru' =>
                        $data->fresh()->toArray(),
                ],

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | NOTIFICATION
            |--------------------------------------------------------------------------
            */

            $username = auth()->user()?->username
                ?? 'Pengguna';

            Notification::create([

                'judul' =>
                    'Perubahan Dataset Diajukan',

                'pesan' =>
                    $username .
                    ' memperbarui dataset "' .
                    $data->nama_dataset .
                    '" dengan ID ' .
                    $datasetId .
                    ' dan mengajukannya kembali untuk persetujuan.',

                'dibaca' =>
                    false,
            ]);
        });

        return redirect()
            ->route('data.index')
            ->with(
                'success',
                'Perubahan data berhasil disimpan dan menunggu verifikasi.'
            );
    }

    /**
     * =========================================================
     * PREVIEW
     * =========================================================
     */
    public function preview($id)
    {
        $data = Data::findOrFail($id);

        if (!$data->file_data) {
            return redirect()
                ->route('data.show', $id)
                ->with(
                    'error',
                    'Dataset ini tidak memiliki file.'
                );
        }

        $path = storage_path(
            'app/public/' .
            $data->file_data
        );

        if (!file_exists($path)) {
            return redirect()
                ->route('data.show', $id)
                ->with(
                    'error',
                    'File dataset tidak ditemukan.'
                );
        }

        return response()->file($path);
    }

    /**
     * =========================================================
     * DESTROY
     * =========================================================
     */
    public function destroy(
        Request $request,
        $id
    ) {
        $data = Data::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | DATA LAMA
        |--------------------------------------------------------------------------
        */

        $dataLama = $data->toArray();

        /*
        |--------------------------------------------------------------------------
        | FORMAT ID
        |--------------------------------------------------------------------------
        */

        $datasetId =
            'DS-' .
            str_pad(
                $data->id,
                5,
                '0',
                STR_PAD_LEFT
            );

        /*
        |--------------------------------------------------------------------------
        | AJUKAN PENGHAPUSAN
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $data,
            $request,
            $dataLama,
            $datasetId
        ) {

            VerificationRequest::create([

                'module' =>
                    'data',

                'record_id' =>
                    $data->id,

                'action' =>
                    'delete',

                'data' =>
                    $dataLama,

                'status' =>
                    'menunggu',

                'submitted_by' =>
                    auth()->id(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | DATA TETAP ADA SAMPAI DISETUJUI
            |--------------------------------------------------------------------------
            */

            $data->update([

                'verifikasi' =>
                    'Menunggu Disetujui',

                'komentar_verifikasi' =>
                    null,

                'tanggal_pengajuan' =>
                    now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | NOTIFICATION
            |--------------------------------------------------------------------------
            */

            $username = auth()->user()?->username
                ?? 'Pengguna';

            Notification::create([

                'judul' =>
                    'Penghapusan Dataset Diajukan',

                'pesan' =>
                    $username .
                    ' mengajukan penghapusan dataset "' .
                    $data->nama_dataset .
                    '" dengan ID ' .
                    $datasetId .
                    ' untuk persetujuan verifikator.',

                'dibaca' =>
                    false,
            ]);
        });

        return redirect()
            ->route('data.index')
            ->with(
                'success',
                'Pengajuan penghapusan data berhasil dikirim dan menunggu verifikasi.'
            );
    }
}