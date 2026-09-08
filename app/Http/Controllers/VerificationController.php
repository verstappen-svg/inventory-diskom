<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\DataCenter;
use App\Models\Hardware;
use App\Models\Jaringan;
use App\Models\Sdm;
use App\Models\SoftwareAsset;
use App\Models\Splp;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = VerificationRequest::query()
            ->with([
                'submitter',
                'verifier',
            ])
            ->latest();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {
                $q->where(
                    'module',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'action',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'status',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'record_id',
                    'like',
                    "%{$search}%"
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */
        $kategori = $request->get(
            'kategori'
        );

        if (
            $kategori &&
            in_array(
                $kategori,
                [
                    'software',
                    'hardware',
                    'jaringan',
                    'data-center',
                    'data_center',
                    'splp',
                    'data',
                    'sdm',
                ],
                true
            )
        ) {
            if ($kategori === 'data_center') {
                $query->whereIn(
                    'module',
                    [
                        'data-center',
                        'data_center',
                    ]
                );
            } else {
                $query->where(
                    'module',
                    $kategori
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS PENGAJUAN
        |--------------------------------------------------------------------------
        */
        $jenisPengajuan = $request->get(
            'jenis_pengajuan'
        );

        if (
            $jenisPengajuan &&
            in_array(
                $jenisPengajuan,
                [
                    'create',
                    'update',
                    'delete',
                ],
                true
            )
        ) {
            $query->where(
                'action',
                $jenisPengajuan
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */
        $status = $request->get(
            'status'
        );

        if (
            $status &&
            in_array(
                $status,
                [
                    'menunggu',
                    'disetujui',
                    'ditolak',
                ],
                true
            )
        ) {
            $query->where(
                'status',
                $status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */
        $requests = $query->get();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */
        $menunggu = VerificationRequest::where(
            'status',
            'menunggu'
        )->count();

        $disetujui = VerificationRequest::where(
            'status',
            'disetujui'
        )->count();

        $ditolak = VerificationRequest::where(
            'status',
            'ditolak'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | OPTIONS
        |--------------------------------------------------------------------------
        */
        $kategoriOptions = [
            'software' => 'Software',
            'hardware' => 'Hardware',
            'jaringan' => 'Jaringan',
            'data-center' => 'Data Center',
            'splp' => 'SPLP',
            'data' => 'Data',
            'sdm' => 'SDM',
        ];

        return view(
            'verifikasi.index',
            compact(
                'requests',
                'menunggu',
                'disetujui',
                'ditolak',
                'jenisPengajuan',
                'kategori',
                'status',
                'kategoriOptions'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */
    public function approve(
        Request $request,
        VerificationRequest $verificationRequest
    ) {
        if (
            !$verificationRequest->isPending()
        ) {
            return back()->with(
                'error',
                'Pengajuan ini sudah diproses sebelumnya.'
            );
        }

        try {
            DB::transaction(
                function () use (
                    $verificationRequest
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Cari model berdasarkan module
                    |--------------------------------------------------------------------------
                    */
                    $model = $this->findRecord(
                        $verificationRequest
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | DELETE
                    |--------------------------------------------------------------------------
                    */
                    if (
                        $verificationRequest->action === 'delete'
                    ) {

                        /*
                        | Jika data masih ada, hapus.
                        | Jika sudah tidak ada, request tetap bisa dianggap
                        | selesai.
                        */
                        if ($model) {
                            $model->delete();
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | CREATE / UPDATE
                    |--------------------------------------------------------------------------
                    */
                    elseif (
                        in_array(
                            $verificationRequest->action,
                            [
                                'create',
                                'update',
                            ],
                            true
                        )
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Untuk model yang punya kolom verifikasi
                        |--------------------------------------------------------------------------
                        */
                        if (
                            $model &&
                            $this->modelHasColumn(
                                $model,
                                'verifikasi'
                            )
                        ) {
                            $updates = [
                                'verifikasi' => 'disetujui',
                            ];

                            /*
                            | Software menggunakan komentar
                            */
                            if (
                                $this->modelHasColumn(
                                    $model,
                                    'komentar'
                                )
                            ) {
                                $updates['komentar'] = null;
                            }

                            /*
                            | Data menggunakan komentar_verifikasi
                            */
                            if (
                                $this->modelHasColumn(
                                    $model,
                                    'komentar_verifikasi'
                                )
                            ) {
                                $updates['komentar_verifikasi'] = null;
                            }

                            $model->update(
                                $updates
                            );
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE VERIFICATION REQUEST
                    |--------------------------------------------------------------------------
                    */
                    $verificationRequest->update([
                        'status' => 'disetujui',
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                        'rejection_reason' => null,
                    ]);
                }
            );

            return back()->with(
                'success',
                'Pengajuan berhasil disetujui.'
            );

        } catch (\Throwable $e) {

            return back()->with(
                'error',
                'Pengajuan gagal disetujui: ' .
                $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */
    public function reject(
        Request $request,
        VerificationRequest $verificationRequest
    ) {
        if (
            !$verificationRequest->isPending()
        ) {
            return back()->with(
                'error',
                'Pengajuan ini sudah diproses sebelumnya.'
            );
        }

        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ], [
            'rejection_reason.required' =>
                'Alasan penolakan wajib diisi.',
        ]);

        try {

            DB::transaction(
                function () use (
                    $verificationRequest,
                    $validated
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Cari record
                    |--------------------------------------------------------------------------
                    */
                    $model = $this->findRecord(
                        $verificationRequest
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Tandai record sebagai ditolak
                    |--------------------------------------------------------------------------
                    |
                    | Hanya model yang mempunyai kolom verifikasi.
                    |
                    */
                    if (
                        $model &&
                        $this->modelHasColumn(
                            $model,
                            'verifikasi'
                        )
                    ) {

                        $updates = [
                            'verifikasi' => 'ditolak',
                        ];

                        /*
                        | Software
                        */
                        if (
                            $this->modelHasColumn(
                                $model,
                                'komentar'
                            )
                        ) {
                            $updates['komentar'] =
                                $validated['rejection_reason'];
                        }

                        /*
                        | Data
                        */
                        if (
                            $this->modelHasColumn(
                                $model,
                                'komentar_verifikasi'
                            )
                        ) {
                            $updates['komentar_verifikasi'] =
                                $validated['rejection_reason'];
                        }

                        $model->update(
                            $updates
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Update request
                    |--------------------------------------------------------------------------
                    */
                    $verificationRequest->update([
                        'status' => 'ditolak',
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                        'rejection_reason' =>
                            $validated['rejection_reason'],
                    ]);
                }
            );

            return back()->with(
                'success',
                'Pengajuan berhasil ditolak.'
            );

        } catch (\Throwable $e) {

            return back()->with(
                'error',
                'Pengajuan gagal ditolak: ' .
                $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | FIND RECORD
    |--------------------------------------------------------------------------
    */
    private function findRecord(
        VerificationRequest $verificationRequest
    ) {
        $recordId =
            $verificationRequest->record_id;

        return match (
            $verificationRequest->module
        ) {

            'software' =>
                SoftwareAsset::find($recordId),

            'hardware' =>
                Hardware::find($recordId),

            'jaringan' =>
                Jaringan::find($recordId),

            'data-center',
            'data_center' =>
                DataCenter::find($recordId),

            'splp' =>
                Splp::find($recordId),

            'data' =>
                Data::find($recordId),

            'sdm' =>
                Sdm::find($recordId),

            default => null,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | CEK KOLOM MODEL
    |--------------------------------------------------------------------------
    */
    private function modelHasColumn(
        $model,
        string $column
    ): bool {
        return array_key_exists(
            $column,
            $model->getAttributes()
        ) || in_array(
            $column,
            $model->getFillable(),
            true
        );
    }
}