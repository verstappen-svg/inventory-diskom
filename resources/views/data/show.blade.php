@extends('layouts.app')

@section('title', 'Detail Dataset')
@section('page-title', 'Detail Dataset')

@section('content')

<style>
.detail-page {
    width: 100%;
    padding-bottom: 30px;
}

.detail-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 18px;
}

.detail-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #475569;
    text-decoration: none;
    font-size: 11px;
    font-weight: 600;
}

.detail-back:hover {
    color: #071b88;
}

.detail-actions {
    display: flex;
    gap: 8px;
}

.detail-button {
    height: 36px;
    padding: 0 13px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    text-decoration: none;
    font-size: 10px;
    font-weight: 600;
}

.detail-button.download {
    background: #dcfce7;
    color: #166534;
}

.detail-button.edit {
    background: #e0f2fe;
    color: #0369a1;
}

.detail-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    margin-bottom: 18px;
    box-shadow: 0 2px 10px rgba(15,23,42,.04);
}

.detail-header {
    padding: 22px;
    border-bottom: 1px solid #edf0f3;
}

.detail-id {
    display: inline-flex;
    padding: 5px 9px;
    border-radius: 7px;
    background: #eef2ff;
    color: #3730a3;
    font-size: 10px;
    font-weight: 700;
    margin-bottom: 10px;
}

.detail-title {
    margin: 0;
    color: #1f2937;
    font-size: 23px;
    font-weight: 700;
}

.detail-subtitle {
    margin: 7px 0 0;
    color: #6b7280;
    font-size: 12px;
}

.detail-info {
    padding: 20px 22px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}

.detail-info-label {
    display: block;
    color: #9ca3af;
    font-size: 9px;
    margin-bottom: 4px;
    font-weight: 600;
}

.detail-info-value {
    color: #374151;
    font-size: 11px;
    font-weight: 600;
}

.detail-section-header {
    padding: 18px 22px;
    border-bottom: 1px solid #edf0f3;
}

.detail-section-title {
    margin: 0;
    color: #1f2937;
    font-size: 15px;
    font-weight: 700;
}

.detail-section-body {
    padding: 20px 22px;
}

.metadata-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
}

.metadata-item {
    padding: 12px 14px;
    border-bottom: 1px solid #edf0f3;
}

.metadata-item:nth-child(odd) {
    border-right: 1px solid #edf0f3;
}

.metadata-key {
    display: block;
    color: #64748b;
    font-size: 10px;
    font-weight: 700;
    margin-bottom: 4px;
}

.metadata-value {
    color: #374151;
    font-size: 11px;
    line-height: 1.5;
    word-break: break-word;
}

.dataset-wrapper {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
}

.dataset-table {
    width: max-content;
    min-width: 100%;
    border-collapse: collapse;
}

.dataset-table th {
    padding: 11px 13px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    color: #475569;
    font-size: 10px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.dataset-table td {
    padding: 10px 13px;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    font-size: 10px;
    white-space: nowrap;
}

.dataset-table tbody tr:hover {
    background: #f8fafc;
}

.detail-empty {
    padding: 45px 20px;
    text-align: center;
    color: #9ca3af;
    font-size: 11px;
}

.detail-description {
    color: #475569;
    font-size: 11px;
    line-height: 1.7;
}

.detail-status {
    display: inline-flex;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
}

.detail-status.approved {
    background: #dcfce7;
    color: #166534;
}

.detail-status.pending {
    background: #fef3c7;
    color: #92400e;
}

.detail-status.rejected {
    background: #fee2e2;
    color: #991b1b;
}

@media(max-width:800px) {
    .detail-top {
        flex-direction: column;
        align-items: flex-start;
    }

    .detail-info {
        grid-template-columns: 1fr;
    }

    .metadata-grid {
        grid-template-columns: 1fr;
    }

    .metadata-item:nth-child(odd) {
        border-right: none;
    }
}
</style>

@php
    $datasetId = 'DS-' . str_pad(
        $data->id,
        5,
        '0',
        STR_PAD_LEFT
    );

    $verifikasi = strtolower(
        trim($data->verifikasi ?? '')
    );

    $statusClass = match($verifikasi) {
        'disetujui' => 'approved',
        'ditolak' => 'rejected',
        default => 'pending',
    };

    $statusLabel = match($verifikasi) {
        'disetujui' => 'Disetujui',
        'ditolak' => 'Ditolak',
        default => 'Menunggu Disetujui',
    };

    $metadata = $data->metadata ?? [];

    $rows = $data->datasetRows ?? collect();

    $headers = [];

    if ($rows->count() > 0) {
        $firstRow = $rows->first();

        $headers = array_keys(
            $firstRow->row_data ?? []
        );
    }
@endphp

<div class="detail-page">

    <div class="detail-top">

        <a
            href="{{ route('data.index') }}"
            class="detail-back"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke Data
        </a>

        <div class="detail-actions">

            @if($data->file_data)
                <a
                    href="{{ route('data.download', $data->id) }}"
                    class="detail-button download"
                >
                    <i class="bi bi-download"></i>
                    Download Excel
                </a>
            @endif

            <a
                href="{{ route('data.edit', $data->id) }}"
                class="detail-button edit"
            >
                <i class="bi bi-pencil"></i>
                Edit
            </a>

        </div>

    </div>

    <div class="detail-card">

        <div class="detail-header">

            <span class="detail-id">
                {{ $datasetId }}
            </span>

            <h1 class="detail-title">
                {{ $data->nama_dataset }}
            </h1>

            <p class="detail-subtitle">
                {{ $data->topik ?: 'Tanpa topik' }}
            </p>

        </div>

        <div class="detail-info">

            <div>
                <span class="detail-info-label">
                    Topik
                </span>

                <span class="detail-info-value">
                    {{ $data->topik ?: '-' }}
                </span>
            </div>

            <div>
                <span class="detail-info-label">
                    Tahun
                </span>

                <span class="detail-info-value">
                    {{ $data->tahun ?: '-' }}
                </span>
            </div>

            <div>
                <span class="detail-info-label">
                    Status Verifikasi
                </span>

                <span class="detail-status {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
            </div>

            <div>
                <span class="detail-info-label">
                    Tanggal Pengajuan
                </span>

                <span class="detail-info-value">
                    {{ $data->tanggal_pengajuan
                        ? $data->tanggal_pengajuan->format('d/m/Y H:i')
                        : '-' }}
                </span>
            </div>

            <div>
                <span class="detail-info-label">
                    Jumlah Baris Dataset
                </span>

                <span class="detail-info-value">
                    {{ $rows->count() }}
                </span>
            </div>

            <div>
                <span class="detail-info-label">
                    File
                </span>

                <span class="detail-info-value">
                    {{ $data->file_data ? basename($data->file_data) : '-' }}
                </span>
            </div>

        </div>

    </div>

    @if($data->deskripsi)

        <div class="detail-card">

            <div class="detail-section-header">
                <h2 class="detail-section-title">
                    Deskripsi
                </h2>
            </div>

            <div class="detail-section-body">

                <div class="detail-description">
                    {{ $data->deskripsi }}
                </div>

            </div>

        </div>

    @endif

    <div class="detail-card">

        <div class="detail-section-header">
            <h2 class="detail-section-title">
                Metadata
            </h2>
        </div>

        <div class="detail-section-body">

            @if(!empty($metadata))

                <div class="metadata-grid">

                    @foreach($metadata as $key => $value)

                        <div class="metadata-item">

                            <span class="metadata-key">
                                {{ $key }}
                            </span>

                            <div class="metadata-value">
                                {{ $value !== null && $value !== ''
                                    ? $value
                                    : '-' }}
                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="detail-empty">
                    Metadata belum tersedia.
                </div>

            @endif

        </div>

    </div>

    <div class="detail-card">

        <div class="detail-section-header">
            <h2 class="detail-section-title">
                Dataset
            </h2>
        </div>

        <div class="detail-section-body">

            @if($rows->count() > 0 && !empty($headers))

                <div class="dataset-wrapper">

                    <table class="dataset-table">

                        <thead>

                            <tr>

                                <th>No</th>

                                @foreach($headers as $header)
                                    <th>
                                        {{ $header }}
                                    </th>
                                @endforeach

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($rows as $row)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    @foreach($headers as $header)

                                        <td>
                                            {{ $row->row_data[$header] ?? '' }}
                                        </td>

                                    @endforeach

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="detail-empty">
                    Belum ada data dataset.
                </div>

            @endif

        </div>

    </div>

</div>

@endsection