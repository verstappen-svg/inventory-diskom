@extends('layouts.app')

@section('title', 'Verifikasi')

@section('page-title', 'Verifikasi')

@section('content')

<style>
    /* =========================================================
       VERIFIKASI PAGE
    ========================================================= */

    .verification-page {
        width: 100%;
    }

    /* =========================================================
       HEADER
    ========================================================= */

    .verification-header {
        margin-bottom: 24px;
    }

    .verification-title {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #111827;
    }

    .verification-subtitle {
        margin: 6px 0 0;
        font-size: 14px;
        color: #6b7280;
    }

    /* =========================================================
       STAT CARDS
    ========================================================= */

    .verification-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .verification-stat-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .verification-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .verification-stat-icon.orange {
        background: #fff7ed;
        color: #f97316;
    }

    .verification-stat-icon.green {
        background: #ecfdf5;
        color: #10b981;
    }

    .verification-stat-icon.red {
        background: #fef2f2;
        color: #ef4444;
    }

    .verification-stat-label {
        display: block;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 3px;
    }

    .verification-stat-value {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: #111827;
    }

    /* =========================================================
       FILTER
    ========================================================= */

    .verification-filter-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .verification-filter-title {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 16px;
    }

    .verification-filter-form {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto auto;
        gap: 12px;
        align-items: end;
    }

    .verification-filter-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .verification-filter-group label {
        font-size: 12px;
        font-weight: 600;
        color: #374151;
    }

    .verification-filter-group select {
        width: 100%;
        height: 42px;
        padding: 0 13px;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        background: #ffffff;
        color: #374151;
        font-size: 13px;
        outline: none;
    }

    .verification-filter-group select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
    }

    .verification-filter-button {
        height: 42px;
        border: none;
        border-radius: 9px;
        padding: 0 18px;
        background: #2563eb;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .verification-filter-button:hover {
        background: #1d4ed8;
    }

    .verification-reset-button {
        height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        padding: 0 18px;
        background: #ffffff;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .verification-reset-button:hover {
        background: #f9fafb;
    }

    /* =========================================================
       TABLE CARD
    ========================================================= */

    .verification-table-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .verification-table-header {
        padding: 20px 22px;
        border-bottom: 1px solid #e5e7eb;
    }

    .verification-table-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }

    .verification-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .verification-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
    }

    .verification-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .verification-table tbody td {
        padding: 15px 16px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #374151;
        vertical-align: middle;
    }

    .verification-table tbody tr:last-child td {
        border-bottom: none;
    }

    .verification-table tbody tr:hover {
        background: #fafafa;
    }

    .verification-data-name {
        font-weight: 600;
        color: #111827;
    }

    .verification-data-code {
        display: block;
        margin-top: 3px;
        font-size: 11px;
        color: #94a3b8;
    }

    /* =========================================================
       BADGES
    ========================================================= */

    .verification-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .verification-badge.pending {
        background: #fff7ed;
        color: #ea580c;
    }

    .verification-badge.approved {
        background: #ecfdf5;
        color: #059669;
    }

    .verification-badge.rejected {
        background: #fef2f2;
        color: #dc2626;
    }

    .verification-badge.create {
        background: #eff6ff;
        color: #2563eb;
    }

    .verification-badge.update {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .verification-badge.delete {
        background: #fef2f2;
        color: #dc2626;
    }

    /* =========================================================
       ACTION
    ========================================================= */

    .verification-actions {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
    }

    .verification-action-button {
        height: 34px;
        padding: 0 11px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-decoration: none;
    }

    .verification-detail-button {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }

    .verification-detail-button:hover {
        background: #dbeafe;
    }

    .verification-approve-button {
        background: #10b981;
        color: #ffffff;
    }

    .verification-approve-button:hover {
        background: #059669;
    }

    .verification-reject-button {
        background: #ffffff;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .verification-reject-button:hover {
        background: #fef2f2;
    }

    /* =========================================================
       EMPTY
    ========================================================= */

    .verification-empty {
        text-align: center;
        padding: 55px 20px;
        color: #94a3b8;
    }

    .verification-empty i {
        font-size: 36px;
        display: block;
        margin-bottom: 10px;
    }

    .verification-empty-text {
        font-size: 14px;
    }

    /* =========================================================
       MODAL OVERLAY
    ========================================================= */

    .verification-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(15, 23, 42, 0.58);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 25px;
    }

    .verification-modal-overlay.show {
        display: flex;
    }

    .verification-modal {
        width: min(760px, 100%);
        max-height: 90vh;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 25px 70px rgba(15, 23, 42, 0.25);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .verification-modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-shrink: 0;
    }

    .verification-modal-header-left {
        min-width: 0;
    }

    .verification-modal-title {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #111827;
    }

    .verification-modal-subtitle {
        margin: 4px 0 0;
        font-size: 12px;
        color: #94a3b8;
    }

    .verification-modal-close {
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 8px;
        background: #f3f4f6;
        color: #64748b;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .verification-modal-close:hover {
        background: #e5e7eb;
        color: #111827;
    }

    .verification-modal-body {
        padding: 22px;
        overflow-y: auto;
        min-height: 0;
    }

    /* =========================================================
       DETAIL META
    ========================================================= */

    .verification-detail-meta {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }

    .verification-detail-meta-item {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 14px;
    }

    .verification-detail-meta-label {
        display: block;
        font-size: 10px;
        text-transform: uppercase;
        font-weight: 700;
        color: #94a3b8;
        margin-bottom: 5px;
    }

    .verification-detail-meta-value {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }

    /* =========================================================
       DETAIL SECTION
    ========================================================= */

    .verification-detail-section {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .verification-detail-section:last-child {
        margin-bottom: 0;
    }

    .verification-detail-section-title {
        padding: 13px 15px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }

    .verification-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    .verification-detail-item {
        padding: 13px 15px;
        border-bottom: 1px solid #f1f5f9;
    }

    .verification-detail-item:nth-child(odd) {
        border-right: 1px solid #f1f5f9;
    }

    .verification-detail-item.full {
        grid-column: 1 / -1;
        border-right: none;
    }

    .verification-detail-label {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .verification-detail-value {
        display: block;
        font-size: 13px;
        color: #334155;
        font-weight: 500;
        word-break: break-word;
    }

    .verification-detail-value.strong {
        font-weight: 700;
        color: #111827;
    }

    .verification-detail-value.price {
        font-weight: 700;
        color: #111827;
    }

    .verification-detail-reason {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 14px;
        color: #991b1b;
        font-size: 13px;
        line-height: 1.6;
    }

    /* =========================================================
       MODAL FOOTER
    ========================================================= */

    .verification-modal-footer {
        padding: 15px 22px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 9px;
        flex-shrink: 0;
        background: #ffffff;
    }

    .verification-modal-footer-button {
        height: 38px;
        padding: 0 16px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .verification-modal-cancel {
        background: #ffffff;
        border: 1px solid #d1d5db;
        color: #374151;
    }

    .verification-modal-cancel:hover {
        background: #f9fafb;
    }

    .verification-modal-approve {
        background: #10b981;
        border: 1px solid #10b981;
        color: #ffffff;
    }

    .verification-modal-approve:hover {
        background: #059669;
    }

    /* =========================================================
       REJECT MODAL
    ========================================================= */

    .verification-reject-textarea {
        width: 100%;
        min-height: 130px;
        resize: vertical;
        padding: 12px 13px;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        outline: none;
        font-family: inherit;
        font-size: 13px;
        color: #374151;
    }

    .verification-reject-textarea:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.08);
    }

    .verification-reject-help {
        margin: 0 0 10px;
        font-size: 12px;
        color: #6b7280;
    }

    .verification-modal-reject-submit {
        background: #dc2626;
        border: 1px solid #dc2626;
        color: #ffffff;
    }

    .verification-modal-reject-submit:hover {
        background: #b91c1c;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1000px) {
        .verification-filter-form {
            grid-template-columns: repeat(2, 1fr);
        }

        .verification-filter-button,
        .verification-reset-button {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .verification-stats {
            grid-template-columns: 1fr;
        }

        .verification-filter-form {
            grid-template-columns: 1fr;
        }

        .verification-detail-meta {
            grid-template-columns: 1fr;
        }

        .verification-detail-grid {
            grid-template-columns: 1fr;
        }

        .verification-detail-item:nth-child(odd) {
            border-right: none;
        }

        .verification-detail-item.full {
            grid-column: auto;
        }

        .verification-modal-overlay {
            padding: 12px;
        }

        .verification-modal {
            max-height: 94vh;
        }
    }
</style>


<div class="verification-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="verification-header">
        <h1 class="verification-title">
            Verifikasi Pengajuan
        </h1>

        <p class="verification-subtitle">
            Periksa dan proses pengajuan perubahan data aset.
        </p>
    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="verification-stats">

        {{-- MENUNGGU --}}
        <div class="verification-stat-card">

            <div class="verification-stat-icon orange">
                <i class="bi bi-clock-history"></i>
            </div>

            <div>
                <span class="verification-stat-label">
                    Menunggu Verifikasi
                </span>

                <span class="verification-stat-value">
                    {{ $menunggu }}
                </span>
            </div>

        </div>


        {{-- DISETUJUI --}}
        <div class="verification-stat-card">

            <div class="verification-stat-icon green">
                <i class="bi bi-check-circle"></i>
            </div>

            <div>
                <span class="verification-stat-label">
                    Disetujui
                </span>

                <span class="verification-stat-value">
                    {{ $disetujui }}
                </span>
            </div>

        </div>


        {{-- DITOLAK --}}
        <div class="verification-stat-card">

            <div class="verification-stat-icon red">
                <i class="bi bi-x-circle"></i>
            </div>

            <div>
                <span class="verification-stat-label">
                    Ditolak
                </span>

                <span class="verification-stat-value">
                    {{ $ditolak }}
                </span>
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTER
    ====================================================== --}}

    <div class="verification-filter-card">

        <div class="verification-filter-title">
            Filter Pengajuan
        </div>

        <form
            action="{{ route('verifikasi.index') }}"
            method="GET"
            class="verification-filter-form"
        >

            {{-- JENIS PENGAJUAN --}}
            <div class="verification-filter-group">

                <label for="jenis_pengajuan">
                    Jenis Pengajuan
                </label>

                <select
                    name="jenis_pengajuan"
                    id="jenis_pengajuan"
                >

                    <option value="">
                        Semua Jenis
                    </option>

                    <option
                        value="create"
                        {{ $jenisPengajuan === 'create' ? 'selected' : '' }}
                    >
                        Penambahan
                    </option>

                    <option
                        value="update"
                        {{ $jenisPengajuan === 'update' ? 'selected' : '' }}
                    >
                        Perubahan
                    </option>

                    <option
                        value="delete"
                        {{ $jenisPengajuan === 'delete' ? 'selected' : '' }}
                    >
                        Penghapusan
                    </option>

                </select>

            </div>


            {{-- KATEGORI --}}
            <div class="verification-filter-group">

                <label for="kategori">
                    Kategori
                </label>

                <select
                    name="kategori"
                    id="kategori"
                >

                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach($kategoriOptions as $value => $label)

                        <option
                            value="{{ $value }}"
                            {{ $kategori === $value ? 'selected' : '' }}
                        >
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- STATUS --}}
            <div class="verification-filter-group">

                <label for="status">
                    Status
                </label>

                <select
                    name="status"
                    id="status"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="menunggu"
                        {{ $status === 'menunggu' ? 'selected' : '' }}
                    >
                        Menunggu
                    </option>

                    <option
                        value="disetujui"
                        {{ $status === 'disetujui' ? 'selected' : '' }}
                    >
                        Disetujui
                    </option>

                    <option
                        value="ditolak"
                        {{ $status === 'ditolak' ? 'selected' : '' }}
                    >
                        Ditolak
                    </option>

                </select>

            </div>


            {{-- TERAPKAN --}}
            <button
                type="submit"
                class="verification-filter-button"
            >
                <i class="bi bi-funnel"></i>
                Terapkan
            </button>


            {{-- RESET --}}
            <a
                href="{{ route('verifikasi.index') }}"
                class="verification-reset-button"
            >
                Reset
            </a>

        </form>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="verification-table-card">

        <div class="verification-table-header">

            <h2 class="verification-table-title">
                Daftar Pengajuan
            </h2>

        </div>


        <div class="verification-table-wrapper">

            @if($requests->count() > 0)

                <table class="verification-table">

                    <thead>

                        <tr>

                            <th>
                                Nama Data
                            </th>

                            <th>
                                Kategori
                            </th>

                            <th>
                                Jenis Pengajuan
                            </th>

                            <th>
                                Diajukan Oleh
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($requests as $verificationRequest)

                            @php

                                $data = $verificationRequest->data ?? [];

                                $module = $verificationRequest->module ?? '-';

                                $action = $verificationRequest->action ?? '-';

                                $statusRequest = $verificationRequest->status ?? 'menunggu';

                                $moduleLabel = match ($module) {
                                    'software' => 'Software',
                                    'hardware' => 'Hardware',
                                    'jaringan' => 'Jaringan',
                                    'data-center',
                                    'data_center' => 'Data Center',
                                    'splp' => 'SPLP',
                                    'data' => 'Data',
                                    'sdm' => 'SDM',
                                    default => ucwords(str_replace(['-', '_'], ' ', $module)),
                                };

                                $actionLabel = match ($action) {
                                    'create' => 'Penambahan',
                                    'update' => 'Perubahan',
                                    'delete' => 'Penghapusan',
                                    default => ucfirst($action),
                                };

                                $statusLabel = match ($statusRequest) {
                                    'menunggu' => 'Menunggu',
                                    'disetujui' => 'Disetujui',
                                    'ditolak' => 'Ditolak',
                                    default => ucfirst($statusRequest),
                                };

                                $namaData = $data['jenis']
                                    ?? $data['nama']
                                    ?? $data['nama_data']
                                    ?? $data['nama_barang']
                                    ?? $data['kode']
                                    ?? 'Data ' . $verificationRequest->id;

                                $kodeData = $data['kode'] ?? null;

                            @endphp


                            <tr>

                                {{-- NAMA DATA --}}
                                <td>

                                    <span class="verification-data-name">
                                        {{ $namaData }}
                                    </span>

                                    @if($kodeData)

                                        <span class="verification-data-code">
                                            {{ $kodeData }}
                                        </span>

                                    @endif

                                </td>


                                {{-- KATEGORI --}}
                                <td>
                                    {{ $moduleLabel }}
                                </td>


                                {{-- JENIS --}}
                                <td>

                                    <span
                                        class="verification-badge {{ $action }}"
                                    >
                                        {{ $actionLabel }}
                                    </span>

                                </td>


                                {{-- DIAJUKAN OLEH --}}
                                <td>

                                    {{ $verificationRequest->submitter->name
                                        ?? $verificationRequest->submitter->username
                                        ?? '-' }}

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($statusRequest === 'menunggu')

                                        <span class="verification-badge pending">
                                            {{ $statusLabel }}
                                        </span>

                                    @elseif($statusRequest === 'disetujui')

                                        <span class="verification-badge approved">
                                            {{ $statusLabel }}
                                        </span>

                                    @else

                                        <span class="verification-badge rejected">
                                            {{ $statusLabel }}
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <div class="verification-actions">

                                        {{-- DETAIL --}}
                                        <button
                                            type="button"
                                            class="verification-action-button verification-detail-button"
                                            onclick="openVerificationDetail('{{ $verificationRequest->id }}')"
                                        >
                                            <i class="bi bi-eye"></i>
                                            Detail
                                        </button>


                                        {{-- HANYA MENUNGGU YANG BISA DIPROSES --}}
                                        @if($statusRequest === 'menunggu')

                                            {{-- APPROVE --}}
                                            <form
                                                action="{{ route('verifikasi.approve', $verificationRequest) }}"
                                                method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('Yakin ingin menyetujui pengajuan ini?');"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="verification-action-button verification-approve-button"
                                                >
                                                    <i class="bi bi-check-lg"></i>
                                                    Setujui
                                                </button>

                                            </form>


                                            {{-- REJECT --}}
                                            <button
                                                type="button"
                                                class="verification-action-button verification-reject-button"
                                                onclick="openRejectModal('{{ $verificationRequest->id }}')"
                                            >
                                                <i class="bi bi-x-lg"></i>
                                                Tolak
                                            </button>

                                        @endif

                                    </div>

                                </td>

                            </tr>


                            {{-- =================================================
                                 DETAIL MODAL PER REQUEST
                            ================================================== --}}

                            <div
                                id="verification-detail-{{ $verificationRequest->id }}"
                                class="verification-modal-overlay"
                                onclick="closeVerificationDetailOutside(event, '{{ $verificationRequest->id }}')"
                            >

                                <div
                                    class="verification-modal"
                                    onclick="event.stopPropagation()"
                                >

                                    <div class="verification-modal-header">

                                        <div class="verification-modal-header-left">

                                            <h3 class="verification-modal-title">
                                                Detail Pengajuan
                                            </h3>

                                            <p class="verification-modal-subtitle">
                                                ID Pengajuan #{{ $verificationRequest->id }}
                                            </p>

                                        </div>


                                        <button
                                            type="button"
                                            class="verification-modal-close"
                                            onclick="closeVerificationDetail('{{ $verificationRequest->id }}')"
                                        >
                                            <i class="bi bi-x-lg"></i>
                                        </button>

                                    </div>


                                    <div class="verification-modal-body">

                                        {{-- META PENGAJUAN --}}
                                        <div class="verification-detail-meta">

                                            <div class="verification-detail-meta-item">

                                                <span class="verification-detail-meta-label">
                                                    Kategori
                                                </span>

                                                <span class="verification-detail-meta-value">
                                                    {{ $moduleLabel }}
                                                </span>

                                            </div>


                                            <div class="verification-detail-meta-item">

                                                <span class="verification-detail-meta-label">
                                                    Jenis Pengajuan
                                                </span>

                                                <span class="verification-detail-meta-value">
                                                    {{ $actionLabel }}
                                                </span>

                                            </div>


                                            <div class="verification-detail-meta-item">

                                                <span class="verification-detail-meta-label">
                                                    Diajukan Oleh
                                                </span>

                                                <span class="verification-detail-meta-value">

                                                    {{ $verificationRequest->submitter->name
                                                        ?? $verificationRequest->submitter->username
                                                        ?? '-' }}

                                                </span>

                                            </div>


                                            <div class="verification-detail-meta-item">

                                                <span class="verification-detail-meta-label">
                                                    Status
                                                </span>

                                                <span class="verification-detail-meta-value">

                                                    @if($statusRequest === 'menunggu')

                                                        <span class="verification-badge pending">
                                                            Menunggu
                                                        </span>

                                                    @elseif($statusRequest === 'disetujui')

                                                        <span class="verification-badge approved">
                                                            Disetujui
                                                        </span>

                                                    @else

                                                        <span class="verification-badge rejected">
                                                            Ditolak
                                                        </span>

                                                    @endif

                                                </span>

                                            </div>

                                        </div>


                                        {{-- =================================================
                                             DETAIL DATA SOFTWARE
                                        ================================================== --}}

                                        @if($module === 'software')

                                            <div class="verification-detail-section">

                                                <div class="verification-detail-section-title">
                                                    Data Software
                                                </div>


                                                <div class="verification-detail-grid">

                                                    {{-- KODE --}}
                                                    <div class="verification-detail-item">

                                                        <span class="verification-detail-label">
                                                            Kode
                                                        </span>

                                                        <span class="verification-detail-value strong">
                                                            {{ $data['kode'] ?? '-' }}
                                                        </span>

                                                    </div>


                                                    {{-- JENIS SOFTWARE --}}
                                                    <div class="verification-detail-item">

                                                        <span class="verification-detail-label">
                                                            Jenis Software
                                                        </span>

                                                        <span class="verification-detail-value strong">
                                                            {{ $data['jenis'] ?? '-' }}
                                                        </span>

                                                    </div>


                                                    {{-- SPESIFIKASI --}}
                                                    <div class="verification-detail-item full">

                                                        <span class="verification-detail-label">
                                                            Spesifikasi
                                                        </span>

                                                        <span class="verification-detail-value">
                                                            {{ $data['spesifikasi'] ?? '-' }}
                                                        </span>

                                                    </div>


                                                    {{-- JUMLAH LISENSI --}}
                                                    <div class="verification-detail-item">

                                                        <span class="verification-detail-label">
                                                            Jumlah Lisensi
                                                        </span>

                                                        <span class="verification-detail-value">
                                                            {{ $data['jumlah_lisensi'] ?? '-' }}
                                                        </span>

                                                    </div>


                                                    {{-- PENGADAAN --}}
                                                    <div class="verification-detail-item">

                                                        <span class="verification-detail-label">
                                                            Pengadaan
                                                        </span>

                                                        <span class="verification-detail-value">
                                                            {{ $data['pengadaan'] ?? '-' }}
                                                        </span>

                                                    </div>


                                                    {{-- PERIODE SEWA --}}
                                                    <div class="verification-detail-item">

                                                        <span class="verification-detail-label">
                                                            Periode Sewa
                                                        </span>

                                                        <span class="verification-detail-value">

                                                            @if(!empty($data['periode_sewa']))

                                                                {{ $data['periode_sewa'] }}

                                                            @else

                                                                -

                                                            @endif

                                                        </span>

                                                    </div>


                                                    {{-- HARGA --}}
                                                    <div class="verification-detail-item">

                                                        <span class="verification-detail-label">
                                                            Harga
                                                        </span>

                                                        <span class="verification-detail-value price">

                                                            @if(isset($data['harga']) && $data['harga'] !== '' && $data['harga'] !== null)

                                                                Rp {{ number_format((float) $data['harga'], 0, ',', '.') }}

                                                            @else

                                                                -

                                                            @endif

                                                        </span>

                                                    </div>


                                                    {{-- TANGGAL PENGADAAN --}}
                                                    <div class="verification-detail-item">

                                                        <span class="verification-detail-label">
                                                            Tanggal Pengadaan
                                                        </span>

                                                        <span class="verification-detail-value">

                                                            @if(!empty($data['tanggal_pengadaan']))

                                                                @php
                                                                    try {
                                                                        $tanggalPengadaan = \Carbon\Carbon::parse($data['tanggal_pengadaan'])->format('d/m/Y');
                                                                    } catch (\Throwable $e) {
                                                                        $tanggalPengadaan = $data['tanggal_pengadaan'];
                                                                    }
                                                                @endphp

                                                                {{ $tanggalPengadaan }}

                                                            @else

                                                                -

                                                            @endif

                                                        </span>

                                                    </div>


                                                    {{-- TANGGAL BERAKHIR --}}
                                                    <div class="verification-detail-item">

                                                        <span class="verification-detail-label">
                                                            Tanggal Berakhir
                                                        </span>

                                                        <span class="verification-detail-value">

                                                            @if(!empty($data['tanggal_berakhir']))

                                                                @php
                                                                    try {
                                                                        $tanggalBerakhir = \Carbon\Carbon::parse($data['tanggal_berakhir'])->format('d/m/Y');
                                                                    } catch (\Throwable $e) {
                                                                        $tanggalBerakhir = $data['tanggal_berakhir'];
                                                                    }
                                                                @endphp

                                                                {{ $tanggalBerakhir }}

                                                            @else

                                                                @if(($data['pengadaan'] ?? '') === 'Beli')

                                                                    Perpetual / Tidak Berakhir

                                                                @else

                                                                    -

                                                                @endif

                                                            @endif

                                                        </span>

                                                    </div>


                                                    {{-- VERIFIKASI DATA --}}
                                                    <div class="verification-detail-item">

                                                        <span class="verification-detail-label">
                                                            Verifikasi Data
                                                        </span>

                                                        <span class="verification-detail-value">

                                                            {{ ucfirst($data['verifikasi'] ?? $statusRequest) }}

                                                        </span>

                                                    </div>


                                                    {{-- KOMENTAR --}}
                                                    @if(!empty($data['komentar']))

                                                        <div class="verification-detail-item full">

                                                            <span class="verification-detail-label">
                                                                Komentar
                                                            </span>

                                                            <span class="verification-detail-value">
                                                                {{ $data['komentar'] }}
                                                            </span>

                                                        </div>

                                                    @endif

                                                </div>

                                            </div>


                                        {{-- =================================================
                                             MODULE LAIN
                                        ================================================== --}}

                                        @elseif(!empty($data))

                                            <div class="verification-detail-section">

                                                <div class="verification-detail-section-title">
                                                    Data Pengajuan
                                                </div>


                                                <div class="verification-detail-grid">

                                                    @foreach($data as $field => $value)

                                                        @if(!in_array($field, [
                                                            'created_at',
                                                            'updated_at'
                                                        ]))

                                                            @php

                                                                $label = ucwords(
                                                                    str_replace(
                                                                        ['_', '-'],
                                                                        ' ',
                                                                        $field
                                                                    )
                                                                );

                                                                if (
                                                                    is_array($value) ||
                                                                    is_object($value)
                                                                ) {
                                                                    $displayValue = json_encode(
                                                                        $value,
                                                                        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                                                                    );
                                                                } else {
                                                                    $displayValue = $value;
                                                                }

                                                            @endphp


                                                            <div class="verification-detail-item">

                                                                <span class="verification-detail-label">
                                                                    {{ $label }}
                                                                </span>

                                                                <span class="verification-detail-value">

                                                                    {{ $displayValue !== null && $displayValue !== '' ? $displayValue : '-' }}

                                                                </span>

                                                            </div>

                                                        @endif

                                                    @endforeach

                                                </div>

                                            </div>

                                        @else

                                            <div class="verification-detail-section">

                                                <div class="verification-detail-section-title">
                                                    Data Pengajuan
                                                </div>

                                                <div style="padding:20px; color:#94a3b8; font-size:13px;">
                                                    Tidak ada detail data yang tersimpan.
                                                </div>

                                            </div>

                                        @endif


                                        {{-- =================================================
                                             ALASAN PENOLAKAN
                                        ================================================== --}}

                                        @if($verificationRequest->status === 'ditolak' && $verificationRequest->rejection_reason)

                                            <div class="verification-detail-section">

                                                <div class="verification-detail-section-title">
                                                    Alasan Penolakan
                                                </div>

                                                <div style="padding:15px;">

                                                    <div class="verification-detail-reason">
                                                        {{ $verificationRequest->rejection_reason }}
                                                    </div>

                                                </div>

                                            </div>

                                        @endif


                                        {{-- =================================================
                                             INFORMASI WAKTU
                                        ================================================== --}}

                                        <div class="verification-detail-section">

                                            <div class="verification-detail-section-title">
                                                Informasi Pengajuan
                                            </div>

                                            <div class="verification-detail-grid">

                                                <div class="verification-detail-item">

                                                    <span class="verification-detail-label">
                                                        Dibuat
                                                    </span>

                                                    <span class="verification-detail-value">

                                                        {{ $verificationRequest->created_at
                                                            ? $verificationRequest->created_at->format('d/m/Y H:i')
                                                            : '-' }}

                                                    </span>

                                                </div>


                                                <div class="verification-detail-item">

                                                    <span class="verification-detail-label">
                                                        Diverifikasi
                                                    </span>

                                                    <span class="verification-detail-value">

                                                        {{ $verificationRequest->verified_at
                                                            ? $verificationRequest->verified_at->format('d/m/Y H:i')
                                                            : '-' }}

                                                    </span>

                                                </div>


                                                <div class="verification-detail-item full">

                                                    <span class="verification-detail-label">
                                                        Diverifikasi Oleh
                                                    </span>

                                                    <span class="verification-detail-value">

                                                        {{ $verificationRequest->verifier->name
                                                            ?? $verificationRequest->verifier->username
                                                            ?? '-' }}

                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="verification-modal-footer">

                                        <button
                                            type="button"
                                            class="verification-modal-footer-button verification-modal-cancel"
                                            onclick="closeVerificationDetail('{{ $verificationRequest->id }}')"
                                        >
                                            Tutup
                                        </button>


                                        @if($statusRequest === 'menunggu')

                                            <form
                                                action="{{ route('verifikasi.approve', $verificationRequest) }}"
                                                method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('Yakin ingin menyetujui pengajuan ini?');"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="verification-modal-footer-button verification-modal-approve"
                                                >
                                                    <i class="bi bi-check-lg"></i>
                                                    Setujui Pengajuan
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </div>

                            </div>


                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="verification-empty">

                    <i class="bi bi-inbox"></i>

                    <div class="verification-empty-text">
                        Belum ada pengajuan verifikasi.
                    </div>

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
     REJECT MODAL
========================================================= --}}

<div
    id="verification-reject-modal"
    class="verification-modal-overlay"
    onclick="closeRejectModalOutside(event)"
>

    <div
        class="verification-modal"
        onclick="event.stopPropagation()"
    >

        <div class="verification-modal-header">

            <div class="verification-modal-header-left">

                <h3 class="verification-modal-title">
                    Tolak Pengajuan
                </h3>

                <p class="verification-modal-subtitle">
                    Berikan alasan mengapa pengajuan ditolak.
                </p>

            </div>


            <button
                type="button"
                class="verification-modal-close"
                onclick="closeRejectModal()"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        <form
            id="verification-reject-form"
            method="POST"
        >

            @csrf


            <div class="verification-modal-body">

                <p class="verification-reject-help">
                    Alasan penolakan wajib diisi agar operator mengetahui apa yang harus diperbaiki.
                </p>

                <textarea
                    name="rejection_reason"
                    class="verification-reject-textarea"
                    placeholder="Masukkan alasan penolakan..."
                    required
                ></textarea>

            </div>


            <div class="verification-modal-footer">

                <button
                    type="button"
                    class="verification-modal-footer-button verification-modal-cancel"
                    onclick="closeRejectModal()"
                >
                    Batal
                </button>


                <button
                    type="submit"
                    class="verification-modal-footer-button verification-modal-reject-submit"
                >
                    <i class="bi bi-x-lg"></i>
                    Tolak Pengajuan
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    /* =========================================================
       DETAIL MODAL
    ========================================================= */

    function openVerificationDetail(id) {

        const modal = document.getElementById(
            'verification-detail-' + id
        );

        if (!modal) {
            return;
        }

        modal.classList.add('show');

        document.body.style.overflow = 'hidden';
    }


    function closeVerificationDetail(id) {

        const modal = document.getElementById(
            'verification-detail-' + id
        );

        if (!modal) {
            return;
        }

        modal.classList.remove('show');

        document.body.style.overflow = '';
    }


    function closeVerificationDetailOutside(event, id) {

        if (event.target === event.currentTarget) {
            closeVerificationDetail(id);
        }
    }


    /* =========================================================
       REJECT MODAL
    ========================================================= */

    function openRejectModal(id) {

        const modal = document.getElementById(
            'verification-reject-modal'
        );

        const form = document.getElementById(
            'verification-reject-form'
        );

        if (!modal || !form) {
            return;
        }

        form.action =
            "{{ url('/verifikasi') }}/" +
            id +
            "/reject";

        form.querySelector(
            'textarea[name="rejection_reason"]'
        ).value = '';

        modal.classList.add('show');

        document.body.style.overflow = 'hidden';

        setTimeout(function () {

            const textarea = form.querySelector(
                'textarea[name="rejection_reason"]'
            );

            if (textarea) {
                textarea.focus();
            }

        }, 100);
    }


    function closeRejectModal() {

        const modal = document.getElementById(
            'verification-reject-modal'
        );

        if (!modal) {
            return;
        }

        modal.classList.remove('show');

        document.body.style.overflow = '';
    }


    function closeRejectModalOutside(event) {

        if (event.target === event.currentTarget) {
            closeRejectModal();
        }
    }


    /* =========================================================
       ESC KEY
    ========================================================= */

    document.addEventListener('keydown', function(event) {

        if (event.key !== 'Escape') {
            return;
        }

        const detailModals = document.querySelectorAll(
            '.verification-modal-overlay.show'
        );

        detailModals.forEach(function(modal) {

            if (
                modal.id === 'verification-reject-modal'
            ) {
                closeRejectModal();
            }

        });

    });

</script>

@endsection