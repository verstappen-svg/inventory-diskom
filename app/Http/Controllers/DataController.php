<?php

namespace App\Http\Controllers;

use App\Exports\DataTemplateExport;
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

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Data::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_dataset', 'like', "%{$search}%")
                    ->orWhere('topik', 'like', "%{$search}%")
                    ->orWhere('tahun', 'like', "%{$search}%");
            });
        }

        if ($request->filled('topik')) {
            $query->where('topik', $request->topik);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('verifikasi')) {
            $query->where('verifikasi', $request->verifikasi);
        }

        $data = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $tahunData = Data::query()
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $totalDataset = Data::count();

        $totalDisetujui = Data::where(
            'verifikasi',
            'Disetujui'
        )->count();

        $totalMenunggu = Data::where(
            'verifikasi',
            'Menunggu Disetujui'
        )->count();

        return view('data.index', [
            'data' => $data,
            'topikData' => $this->topikOptions,
            'tahunData' => $tahunData,
            'totalDataset' => $totalDataset,
            'totalDisetujui' => $totalDisetujui,
            'totalMenunggu' => $totalMenunggu,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE - TAMBAH DATA MANUAL
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'nama_dataset' => 'required|string|max:255',

            'topik' => 'required|in:' . implode(',', $this->topikOptions),

            'tahun' => 'required|integer|min:1900|max:2200',

            'deskripsi' => 'nullable|string',

            'file_data' => 'required|file|mimes:xlsx,xls|max:10240',

            'dataset_dibuat' => 'nullable|string|max:255',
            'dataset_diperbarui' => 'nullable|string|max:255',
            'pengukuran_dataset' => 'nullable|string|max:255',
            'tingkat_penyajian_dataset' => 'nullable|string|max:255',
            'cakupan_dataset' => 'nullable|string|max:255',
            'produsen' => 'nullable|string|max:255',
            'kontak_produsen' => 'nullable|string|max:255',
            'kode_indikator' => 'nullable|string|max:255',
            'satuan_dataset' => 'nullable|string|max:255',
            'frekuensi_dataset' => 'nullable|string|max:255',
            'sumber_eksternal' => 'nullable|string|max:255',
            'dimensi_dataset' => 'nullable|string|max:255',
            'deskripsi_metadata' => 'nullable|string',
        ], [
            'nama_dataset.required' => 'Nama dataset wajib diisi.',
            'topik.required' => 'Topik wajib dipilih.',
            'topik.in' => 'Topik yang dipilih tidak valid.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'file_data.required' => 'File Excel wajib diupload.',
            'file_data.file' => 'File yang dipilih tidak valid.',
            'file_data.mimes' => 'File harus berformat XLS atau XLSX.',
            'file_data.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        DB::beginTransaction();

        $path = null;

        try {
            $this->checkExcelSupport();

            $file = $request->file('file_data');

            if (!$file || !$file->isValid()) {
                throw new \Exception(
                    'File Excel tidak valid atau gagal diupload.'
                );
            }

            /*
             * Untuk Tambah Data Manual,
             * hanya sheet Dataset yang dibaca.
             */

            $import = new DataImport();

            $import->importDatasetOnly(
                $file->getRealPath()
            );

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

            $path = $file->store(
                'datasets',
                'public'
            );

            $metadata = $this->buildManualMetadata($request);

            $data = Data::create([
                'nama_dataset' => $request->nama_dataset,
                'topik' => $request->topik,
                'tahun' => $request->tahun,
                'deskripsi' => $request->deskripsi,
                'metadata' => $metadata,
                'file_data' => $path,
                'verifikasi' => 'Menunggu Disetujui',
                'tanggal_pengajuan' => now(),
            ]);

            $this->saveDatasetRows(
                $data->id,
                $headers,
                $rows
            );

            $this->createVerificationAndNotification(
                $data,
                'create'
            );

            DB::commit();

            return redirect()
                ->route('data.index')
                ->with(
                    'success',
                    'Data berhasil ditambahkan dan menunggu verifikasi.'
                );

        } catch (Throwable $e) {
            DB::rollBack();

            if ($path) {
                Storage::disk('public')->delete($path);
            }

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data gagal ditambahkan: ' . $e->getMessage()
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL
    |--------------------------------------------------------------------------
    |
    | Format file:
    |
    | Sheet Metadata
    | Sheet Dataset
    |
    */

    public function importExcel(Request $request)
    {
        $request->validate([
            'nama_dataset' => 'required|string|max:255',

            'topik' => 'required|in:' . implode(',', $this->topikOptions),

            'tahun' => 'required|integer|min:1900|max:2200',

            'file_data' => 'required|file|mimes:xlsx,xls|max:10240',
        ], [
            'nama_dataset.required' => 'Nama dataset wajib diisi.',
            'topik.required' => 'Topik wajib dipilih.',
            'topik.in' => 'Topik yang dipilih tidak valid.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'file_data.required' => 'File Excel wajib diupload.',
            'file_data.file' => 'File Excel tidak valid.',
            'file_data.mimes' => 'File harus berformat XLS atau XLSX.',
            'file_data.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        DB::beginTransaction();

        $path = null;

        try {
            $this->checkExcelSupport();

            $file = $request->file('file_data');

            if (!$file || !$file->isValid()) {
                throw new \Exception(
                    'File Excel tidak valid atau gagal diupload.'
                );
            }

            /*
             * Baca Metadata + Dataset.
             */

            $import = new DataImport();

            $import->import(
                $file->getRealPath()
            );

            $excelMetadata = $import->getMetadata();

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
             * Simpan file asli.
             */

            $path = $file->store(
                'datasets',
                'public'
            );

            /*
             * Bersihkan metadata dari Excel.
             */

            $metadata = $this->cleanMetadata(
                $excelMetadata
            );

            /*
             * Simpan data utama.
             */

            $data = Data::create([
                'nama_dataset' => $request->nama_dataset,
                'topik' => $request->topik,
                'tahun' => $request->tahun,
                'deskripsi' => $request->input('deskripsi'),
                'metadata' => $metadata,
                'file_data' => $path,
                'verifikasi' => 'Menunggu Disetujui',
                'tanggal_pengajuan' => now(),
            ]);

            /*
             * Simpan seluruh baris Dataset.
             */

            $this->saveDatasetRows(
                $data->id,
                $headers,
                $rows
            );

            /*
             * Buat pengajuan verifikasi.
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
                    'Excel berhasil diimport dan menunggu verifikasi.'
                );

        } catch (Throwable $e) {
            DB::rollBack();

            if ($path) {
                Storage::disk('public')->delete($path);
            }

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Import Excel gagal: ' . $e->getMessage()
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATASET ROW
    |--------------------------------------------------------------------------
    */

   private function saveDatasetRows(
    int $dataId,
    array $headers,
    array $rows
): void {
    $insertData = [];

    foreach ($rows as $row) {
        $rowData = [];

        foreach ($headers as $header) {
            $rowData[$header] = $row[$header] ?? null;
        }

        $insertData[] = [
            'data_id' => $dataId,
            'row_data' => json_encode(
                $rowData,
                JSON_UNESCAPED_UNICODE
            ),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (count($insertData) >= 500) {
            DatasetRow::insert($insertData);
            $insertData = [];
        }
    }

    if (!empty($insertData)) {
        DatasetRow::insert($insertData);
    }
}
    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI + NOTIFIKASI
    |--------------------------------------------------------------------------
    */

    private function createVerificationAndNotification(
        Data $data,
        string $action = 'create'
    ): void {
        VerificationRequest::create([
            'module' => 'data',
            'record_id' => $data->id,
            'action' => $action,
            'data' => [
                'nama_dataset' => $data->nama_dataset,
                'topik' => $data->topik,
                'tahun' => $data->tahun,
            ],
            'status' => 'menunggu',
            'submitted_by' => auth()->id(),
        ]);

        $judul = $action === 'update'
            ? 'Dataset Diperbarui'
            : 'Pengajuan Dataset Baru';

        $pesan = $action === 'update'
            ? 'Dataset "' . $data->nama_dataset .
              '" diperbarui dan menunggu verifikasi.'
            : 'Dataset "' . $data->nama_dataset .
              '" menunggu verifikasi.';

        Notification::create([
            'judul' => $judul,
            'pesan' => $pesan,
            'dibaca' => false,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BUILD METADATA MANUAL
    |--------------------------------------------------------------------------
    */

    private function buildManualMetadata(
        Request $request
    ): array {
        $metadata = [
            'Dataset Dibuat' =>
                $request->input('dataset_dibuat'),

            'Dataset Diperbarui' =>
                $request->input('dataset_diperbarui'),

            'Pengukuran Dataset' =>
                $request->input('pengukuran_dataset'),

            'Tingkat Penyajian Dataset' =>
                $request->input('tingkat_penyajian_dataset'),

            'Cakupan Dataset' =>
                $request->input('cakupan_dataset'),

            'Produsen' =>
                $request->input('produsen'),

            'Kontak Produsen' =>
                $request->input('kontak_produsen'),

            'Kode Indikator' =>
                $request->input('kode_indikator'),

            'Satuan Dataset' =>
                $request->input('satuan_dataset'),

            'Frekuensi Dataset' =>
                $request->input('frekuensi_dataset'),

            'Sumber Eksternal' =>
                $request->input('sumber_eksternal'),

            'Dimensi Dataset' =>
                $request->input('dimensi_dataset'),

            'Deskripsi Metadata' =>
                $request->input('deskripsi_metadata'),
        ];

        return $this->cleanMetadata($metadata);
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAN METADATA
    |--------------------------------------------------------------------------
    */

    private function cleanMetadata(
        $metadata
    ): array {
        if (!is_array($metadata)) {
            return [];
        }

        $result = [];

        foreach ($metadata as $key => $value) {
            if (is_array($value)) {
                $value = json_encode(
                    $value,
                    JSON_UNESCAPED_UNICODE
                );
            }

            if (
                $value !== null &&
                trim((string) $value) !== ''
            ) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /*
    |--------------------------------------------------------------------------
    | CEK ZIP / PHP EXCEL
    |--------------------------------------------------------------------------
    */

    private function checkExcelSupport(): void
    {
        if (!class_exists('ZipArchive')) {
            throw new \Exception(
                'Extension ZIP/ZipArchive belum tersedia pada PHP yang menjalankan Laravel.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $data = Data::findOrFail($id);

        $datasetRows = DatasetRow::where(
            'data_id',
            $data->id
        )
            ->latest('id')
            ->paginate(25);

        return view('data.show', [
            'data' => $data,
            'datasetRows' => $datasetRows,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $data = Data::findOrFail($id);

        return view('data.edit', [
            'data' => $data,
            'topikData' => $this->topikOptions,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PREVIEW
    |--------------------------------------------------------------------------
    */

    public function preview($id)
    {
        $data = Data::findOrFail($id);

        $datasetRows = DatasetRow::where(
            'data_id',
            $data->id
        )
            ->latest('id')
            ->paginate(50);

        return view('data.preview', [
            'data' => $data,
            'datasetRows' => $datasetRows,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD FILE
    |--------------------------------------------------------------------------
    */

    public function download($id)
    {
        $data = Data::findOrFail($id);

        if (!$data->file_data) {
            return back()->with(
                'error',
                'File dataset tidak tersedia.'
            );
        }

        if (!Storage::disk('public')->exists($data->file_data)) {
            return back()->with(
                'error',
                'File dataset tidak ditemukan di storage.'
            );
        }

        return Storage::disk('public')->download(
            $data->file_data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();

        /*
         * Sheet Metadata
         */

        $metadataSheet = $spreadsheet->getActiveSheet();

        $metadataSheet->setTitle('Metadata');

        $metadataHeaders = [
            'Nama Metadata',
            'Nilai',
        ];

        $metadataSheet->fromArray(
            $metadataHeaders,
            null,
            'A1'
        );

        $metadataRows = [
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
            ['Deskripsi Metadata', ''],
        ];

        $metadataSheet->fromArray(
            $metadataRows,
            null,
            'A2'
        );

        $metadataSheet->getColumnDimension('A')
            ->setWidth(35);

        $metadataSheet->getColumnDimension('B')
            ->setWidth(60);

        /*
         * Sheet Dataset
         */

        $datasetSheet = $spreadsheet->createSheet();

        $datasetSheet->setTitle('Dataset');

        $datasetSheet->setCellValue(
            'A1',
            'Contoh Kolom Dataset'
        );

        $datasetSheet->setCellValue(
            'B1',
            'Contoh Data'
        );

        $datasetSheet->getColumnDimension('A')
            ->setWidth(35);

        $datasetSheet->getColumnDimension('B')
            ->setWidth(35);

        /*
         * Download langsung.
         */

        $writer = new Xlsx($spreadsheet);

        $filename = 'template-data-dataset.xlsx';

        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $filename,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
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
        $data = Data::findOrFail($id);

        $request->validate([
            'nama_dataset' =>
                'required|string|max:255',

            'topik' =>
                'required|in:' .
                implode(',', $this->topikOptions),

            'tahun' =>
                'required|integer|min:1900|max:2200',

            'deskripsi' =>
                'nullable|string',

            'file_data' =>
                'nullable|file|mimes:xlsx,xls|max:10240',

            'dataset_dibuat' =>
                'nullable|string|max:255',

            'dataset_diperbarui' =>
                'nullable|string|max:255',

            'pengukuran_dataset' =>
                'nullable|string|max:255',

            'tingkat_penyajian_dataset' =>
                'nullable|string|max:255',

            'cakupan_dataset' =>
                'nullable|string|max:255',

            'produsen' =>
                'nullable|string|max:255',

            'kontak_produsen' =>
                'nullable|string|max:255',

            'kode_indikator' =>
                'nullable|string|max:255',

            'satuan_dataset' =>
                'nullable|string|max:255',

            'frekuensi_dataset' =>
                'nullable|string|max:255',

            'sumber_eksternal' =>
                'nullable|string|max:255',

            'dimensi_dataset' =>
                'nullable|string|max:255',

            'deskripsi_metadata' =>
                'nullable|string',
        ]);

        DB::beginTransaction();

        $newPath = null;

        try {
            $metadata = $this->buildManualMetadata($request);

            /*
             * Update informasi utama.
             */

            $data->nama_dataset =
                $request->nama_dataset;

            $data->topik =
                $request->topik;

            $data->tahun =
                $request->tahun;

            $data->deskripsi =
                $request->deskripsi;

            $data->metadata =
                $metadata;

            /*
             * Jika upload file baru,
             * baca dan replace DatasetRow.
             */

            if ($request->hasFile('file_data')) {
                $this->checkExcelSupport();

                $file = $request->file('file_data');

                if (!$file || !$file->isValid()) {
                    throw new \Exception(
                        'File Excel baru tidak valid.'
                    );
                }

                $import = new DataImport();

                $import->importDatasetOnly(
                    $file->getRealPath()
                );

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

                $newPath = $file->store(
                    'datasets',
                    'public'
                );

                $oldPath = $data->file_data;

                $data->file_data =
                    $newPath;

                $data->save();

                /*
                 * Hapus row dataset lama.
                 */

                DatasetRow::where(
                    'data_id',
                    $data->id
                )->delete();

                /*
                 * Simpan row dataset baru.
                 */

                $this->saveDatasetRows(
                    $data->id,
                    $headers,
                    $rows
                );

                /*
                 * Hapus file lama setelah data baru
                 * berhasil diproses.
                 */

                if (
                    $oldPath &&
                    Storage::disk('public')->exists($oldPath)
                ) {
                    Storage::disk('public')
                        ->delete($oldPath);
                }

                $newPath = null;
            } else {
                $data->save();
            }

            /*
             * Reset status verifikasi.
             */

            $data->verifikasi =
                'Menunggu Disetujui';

            $data->tanggal_pengajuan =
                now();

            $data->komentar_verifikasi =
                null;

            $data->save();

            /*
             * Cari request verifikasi terakhir.
             */

            $verification = VerificationRequest::where(
                'module',
                'data'
            )
                ->where(
                    'record_id',
                    $data->id
                )
                ->latest('id')
                ->first();

            $verificationData = [
                'nama_dataset' =>
                    $data->nama_dataset,

                'topik' =>
                    $data->topik,

                'tahun' =>
                    $data->tahun,
            ];

            if ($verification) {
                $verification->update([
                    'status' =>
                        'menunggu',

                    'action' =>
                        'update',

                    'data' =>
                        $verificationData,

                    'submitted_by' =>
                        auth()->id(),

                    'verified_by' =>
                        null,

                    'verified_at' =>
                        null,

                    'rejection_reason' =>
                        null,
                ]);
            } else {
                VerificationRequest::create([
                    'module' =>
                        'data',

                    'record_id' =>
                        $data->id,

                    'action' =>
                        'update',

                    'data' =>
                        $verificationData,

                    'status' =>
                        'menunggu',

                    'submitted_by' =>
                        auth()->id(),
                ]);
            }

            /*
             * Notifikasi.
             */

            Notification::create([
                'judul' =>
                    'Dataset Diperbarui',

                'pesan' =>
                    'Dataset "' .
                    $data->nama_dataset .
                    '" diperbarui dan menunggu verifikasi.',

                'dibaca' =>
                    false,
            ]);

            DB::commit();

            return redirect()
                ->route('data.index')
                ->with(
                    'success',
                    'Data berhasil diperbarui dan menunggu verifikasi.'
                );

        } catch (Throwable $e) {
            DB::rollBack();

            if ($newPath) {
                Storage::disk('public')
                    ->delete($newPath);
            }

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data gagal diperbarui: ' .
                    $e->getMessage()
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $data = Data::findOrFail($id);

            /*
             * Hapus dataset rows.
             */

            DatasetRow::where(
                'data_id',
                $data->id
            )->delete();

            /*
             * Hapus verification request.
             */

            VerificationRequest::where(
                'module',
                'data'
            )
                ->where(
                    'record_id',
                    $data->id
                )
                ->delete();

            /*
             * Hapus file.
             */

            if (
                $data->file_data &&
                Storage::disk('public')->exists(
                    $data->file_data
                )
            ) {
                Storage::disk('public')->delete(
                    $data->file_data
                );
            }

            /*
             * Hapus data utama.
             */

            $data->delete();

            DB::commit();

            return redirect()
                ->route('data.index')
                ->with(
                    'success',
                    'Dataset berhasil dihapus.'
                );

        } catch (Throwable $e) {
            DB::rollBack();

            return back()->with(
                'error',
                'Dataset gagal dihapus: ' .
                $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DATA SNAPSHOT
    |--------------------------------------------------------------------------
    */

    public function dataSnapshot($id)
    {
        $data = Data::findOrFail($id);

        $rows = DatasetRow::where(
            'data_id',
            $data->id
        )
            ->latest('id')
            ->limit(100)
            ->get();

        $result = [];

        foreach ($rows as $row) {
            $rowData = $row->row_data;

            if (is_string($rowData)) {
                $decoded = json_decode(
                    $rowData,
                    true
                );

                $result[] =
                    is_array($decoded)
                    ? $decoded
                    : [];
            } elseif (is_array($rowData)) {
                $result[] = $rowData;
            } else {
                $result[] = [];
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' =>
                    $data->id,

                'nama_dataset' =>
                    $data->nama_dataset,

                'topik' =>
                    $data->topik,

                'tahun' =>
                    $data->tahun,

                'deskripsi' =>
                    $data->deskripsi,

                'metadata' =>
                    $data->metadata,

                'rows' =>
                    $result,
            ],
        ]);
    }
}
