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

    public function index(Request $request)
    {
        $query = Data::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where(
                    'nama_dataset',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'topik',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'tahun',
                    'like',
                    "%{$search}%"
                );
            });
        }

        if ($request->filled('topik')) {
            $query->where(
                'topik',
                $request->topik
            );
        }

        if ($request->filled('tahun')) {
            $query->where(
                'tahun',
                $request->tahun
            );
        }

        if ($request->filled('verifikasi')) {
            $query->where(
                'verifikasi',
                $request->verifikasi
            );
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

    public function store(Request $request)
    {
        $request->validate([
            'nama_dataset' => 'required|string|max:255',
            'topik' => 'required|in:' . implode(',', $this->topikOptions),
            'tahun' => 'required|integer|min:1900|max:2200',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_dataset.required' => 'Nama dataset wajib diisi.',
            'topik.required' => 'Topik wajib dipilih.',
            'tahun.required' => 'Tahun wajib diisi.',
        ]);

        DB::beginTransaction();

        try {
            $data = Data::create([
                'nama_dataset' => $request->nama_dataset,
                'topik' => $request->topik,
                'tahun' => $request->tahun,
                'deskripsi' => $request->deskripsi,
                'metadata' => null,
                'file_data' => null,
                'verifikasi' => 'Menunggu Disetujui',
                'tanggal_pengajuan' => now(),
            ]);

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

            return redirect()
                ->route('data.index')
                ->with(
                    'error',
                    'Data gagal ditambahkan: ' . $e->getMessage()
                );
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'nama_dataset' => 'required|string|max:255',
            'topik' => 'required|in:' . implode(',', $this->topikOptions),
            'tahun' => 'required|integer|min:1900|max:2200',
            'deskripsi' => 'nullable|string',
            'file_data' => 'required|file|mimes:xlsx,xls|max:10240',
        ], [
            'nama_dataset.required' => 'Nama dataset wajib diisi.',
            'topik.required' => 'Topik wajib dipilih.',
            'tahun.required' => 'Tahun wajib diisi.',
            'file_data.required' => 'File Excel wajib dipilih.',
            'file_data.file' => 'File yang dipilih tidak valid.',
            'file_data.mimes' => 'File harus berformat XLS atau XLSX.',
            'file_data.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        DB::beginTransaction();

        try {
            if (!class_exists('ZipArchive')) {
                throw new \Exception(
                    'Extension ZIP/ZipArchive belum tersedia pada PHP yang menjalankan Laravel.'
                );
            }

            $file = $request->file('file_data');

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

            $path = $file->store(
                'data',
                'public'
            );

            if (!$path) {
                throw new \Exception(
                    'File Excel gagal disimpan.'
                );
            }

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

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();

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

    public function update(Request $request, $id)
    {
        $data = Data::findOrFail($id);

        $request->validate([
            'nama_dataset' => 'required|string|max:255',
            'topik' => 'required|in:' . implode(',', $this->topikOptions),
            'tahun' => 'required|integer|min:1900|max:2200',
            'deskripsi' => 'nullable|string',
            'file_data' => 'nullable|file|mimes:xlsx,xls|max:10240',
        ], [
            'nama_dataset.required' => 'Nama dataset wajib diisi.',
            'topik.required' => 'Topik wajib dipilih.',
            'tahun.required' => 'Tahun wajib diisi.',
            'file_data.mimes' => 'File harus berformat XLS atau XLSX.',
            'file_data.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        DB::beginTransaction();

        try {
            $oldData = $this->dataSnapshot($data);

            $metadata = $data->metadata;
            $filePath = $data->file_data;
            $newRows = null;

            if ($request->hasFile('file_data')) {
                if (!class_exists('ZipArchive')) {
                    throw new \Exception(
                        'Extension ZIP/ZipArchive belum tersedia pada PHP yang menjalankan Laravel.'
                    );
                }

                $file = $request->file('file_data');

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

                $filePath = $file->store(
                    'data',
                    'public'
                );

                if (!$filePath) {
                    throw new \Exception(
                        'File Excel gagal disimpan.'
                    );
                }

                $newRows = $rows;
            }

            $data->update([
                'nama_dataset' => $request->nama_dataset,
                'topik' => $request->topik,
                'tahun' => $request->tahun,
                'deskripsi' => $request->deskripsi,
                'metadata' => $metadata,
                'file_data' => $filePath,
                'verifikasi' => 'Menunggu Disetujui',
                'tanggal_pengajuan' => now(),
            ]);

            if ($newRows !== null) {
                DatasetRow::where(
                    'data_id',
                    $data->id
                )->delete();

                $datasetRows = [];

                foreach ($newRows as $row) {
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
            }

            $this->createVerificationAndNotification(
                $data,
                'update',
                $oldData
            );

            DB::commit();

            return redirect()
                ->route('data.index')
                ->with(
                    'success',
                    'Data berhasil diperbarui dan menunggu verifikasi.'
                );
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('data.edit', $id)
                ->withInput()
                ->with(
                    'error',
                    'Data gagal diperbarui: ' . $e->getMessage()
                );
        }
    }

    public function preview($id)
    {
        $data = Data::findOrFail($id);

        if (!$data->file_data) {
            return redirect()
                ->route('data.show', $id)
                ->with(
                    'error',
                    'Dataset ini tidak memiliki file Excel.'
                );
        }

        if (
            !Storage::disk('public')->exists(
                $data->file_data
            )
        ) {
            return redirect()
                ->route('data.show', $id)
                ->with(
                    'error',
                    'File Excel tidak ditemukan.'
                );
        }

        return response()->file(
            Storage::disk('public')->path(
                $data->file_data
            )
        );
    }

    public function download($id)
    {
        $data = Data::findOrFail($id);

        if (!$data->file_data) {
            return redirect()
                ->route('data.show', $id)
                ->with(
                    'error',
                    'Dataset ini tidak memiliki file Excel.'
                );
        }

        if (
            !Storage::disk('public')->exists(
                $data->file_data
            )
        ) {
            return redirect()
                ->route('data.show', $id)
                ->with(
                    'error',
                    'File Excel tidak ditemukan.'
                );
        }

        $filename = basename(
            $data->file_data
        );

        return Storage::disk('public')->download(
            $data->file_data,
            $filename
        );
    }

    public function destroy($id)
    {
        $data = Data::findOrFail($id);

        DB::beginTransaction();

        try {
            $snapshot = $this->dataSnapshot($data);

            VerificationRequest::create([
                'module' => 'data',
                'record_id' => $data->id,
                'action' => 'delete',
                'data' => $snapshot,
                'status' => 'Menunggu',
                'submitted_by' => auth()->id(),
            ]);

            Notification::create([
                'judul' => 'Pengajuan Penghapusan Dataset',
                'pesan' =>
                    'Dataset "' .
                    $data->nama_dataset .
                    '" menunggu verifikasi penghapusan.',
                'dibaca' => false,
            ]);

            DB::commit();

            return redirect()
                ->route('data.index')
                ->with(
                    'success',
                    'Penghapusan dataset diajukan dan menunggu verifikasi.'
                );
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('data.index')
                ->with(
                    'error',
                    'Penghapusan gagal diajukan: ' .
                    $e->getMessage()
                );
        }
    }

    private function formatDatasetId($id): string
    {
        return 'DS-' . str_pad(
            (string) $id,
            4,
            '0',
            STR_PAD_LEFT
        );
    }

    private function dataSnapshot(Data $data): array
    {
        return [
            'id' => $data->id,
            'dataset_id' => $this->formatDatasetId(
                $data->id
            ),
            'nama_dataset' => $data->nama_dataset,
            'topik' => $data->topik,
            'tahun' => $data->tahun,
            'deskripsi' => $data->deskripsi,
            'metadata' => $data->metadata,
            'file_data' => $data->file_data,
            'verifikasi' => $data->verifikasi,
            'tanggal_pengajuan' =>
                optional(
                    $data->tanggal_pengajuan
                )->format('Y-m-d H:i:s'),
            'komentar_verifikasi' =>
                $data->komentar_verifikasi,
        ];
    }

    private function createVerificationAndNotification(
        Data $data,
        string $action = 'create',
        ?array $oldData = null
    ): void {
        $verificationData = [
            'new' => $this->dataSnapshot($data),
        ];

        if ($oldData !== null) {
            $verificationData['old'] = $oldData;
        }

        VerificationRequest::create([
            'module' => 'data',
            'record_id' => $data->id,
            'action' => $action,
            'data' => $verificationData,
            'status' => 'Menunggu',
            'submitted_by' => auth()->id(),
        ]);

        $actionText = match ($action) {
            'create' => 'penambahan',
            'update' => 'perubahan',
            'delete' => 'penghapusan',
            default => 'perubahan',
        };

        Notification::create([
            'judul' => 'Pengajuan Data',
            'pesan' =>
                'Dataset "' .
                $data->nama_dataset .
                '" mengajukan ' .
                $actionText .
                ' dan menunggu verifikasi.',
            'dibaca' => false,
        ]);
    }
}