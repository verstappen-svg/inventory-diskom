@extends('layouts.app')

@section('title', 'SDM')
@section('page-title', 'SDM')

@section('content')

<style>
/* =========================================================
   SDM PAGE
========================================================= */

.sdm-page {
    width: 100%;
    min-height: calc(100vh - 80px);
    padding: 24px;
    background: #f8fafc;
}

/* =========================================================
   HEADER
========================================================= */

.sdm-page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 22px;
}

.sdm-page-header-left {
    min-width: 0;
}

.sdm-page-title {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #111827;
    line-height: 1.3;
}

.sdm-page-subtitle {
    margin: 6px 0 0;
    font-size: 13px;
    color: #64748b;
}

.sdm-add-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 11px 17px;
    border: none;
    border-radius: 8px;
    background: #071b88;
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(37, 99, 235, 0.18);
    transition: 0.2s ease;
    white-space: nowrap;
}

.sdm-add-button:hover {
    background: #050f63;
    transform: translateY(-1px);
}

.sdm-add-button i {
    font-size: 15px;
}

/* =========================================================
   ALERT
========================================================= */

.sdm-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    margin-bottom: 18px;
    border-radius: 8px;
    font-size: 13px;
}

.sdm-alert-success {
    color: #166534;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
}

.sdm-alert-error {
    color: #991b1b;
    background: #fef2f2;
    border: 1px solid #fecaca;
}

/* =========================================================
   STAT CARDS
========================================================= */

.sdm-stat-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 20px;
}

.sdm-stat-card {
    min-height: 100px;
    padding: 18px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: #ffffff;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
}

.sdm-stat-icon {
    width: 46px;
    height: 46px;
    flex-shrink: 0;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.sdm-stat-icon.blue {
    color: #2563eb;
    background: #eff6ff;
}

.sdm-stat-icon.green {
    color: #16a34a;
    background: #f0fdf4;
}

.sdm-stat-icon.red {
    color: #dc2626;
    background: #fef2f2;
}

.sdm-stat-label {
    margin: 0 0 4px;
    font-size: 12px;
    color: #64748b;
}

.sdm-stat-value {
    margin: 0;
    font-size: 24px;
    line-height: 1;
    font-weight: 700;
    color: #111827;
}

/* =========================================================
   TABLE CARD
========================================================= */

.sdm-table-card {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: #ffffff;
    overflow: hidden;
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
}

.sdm-toolbar {
    padding: 16px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}

.sdm-toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}

.sdm-search {
    width: 300px;
    position: relative;
}

.sdm-search i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
    pointer-events: none;
}

.sdm-search input {
    width: 100%;
    height: 38px;
    padding: 0 12px 0 36px;
    border: 1px solid #dbe2ea;
    border-radius: 8px;
    outline: none;
    color: #334155;
    font-size: 13px;
    background: #ffffff;
}

.sdm-search input:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
}

.sdm-show {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #64748b;
    font-size: 12px;
    white-space: nowrap;
}

.sdm-show select {
    height: 38px;
    padding: 0 32px 0 10px;
    border: 1px solid #dbe2ea;
    border-radius: 8px;
    background: #ffffff;
    color: #334155;
    font-size: 13px;
    outline: none;
}

.sdm-table-wrap {
    width: 100%;
    overflow-x: auto;
}

.sdm-table {
    width: 100%;
    min-width: 1100px;
    border-collapse: collapse;
}

.sdm-table thead th {
    padding: 13px 15px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    text-align: left;
    white-space: nowrap;
}

.sdm-table tbody td {
    padding: 14px 15px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13px;
    vertical-align: middle;
}

.sdm-table tbody tr:last-child td {
    border-bottom: none;
}

.sdm-table tbody tr:hover {
    background: #fafcff;
}

.sdm-number {
    color: #94a3b8;
    width: 50px;
}

.sdm-main-name {
    display: block;
    color: #111827;
    font-weight: 600;
    margin-bottom: 3px;
}

.sdm-secondary {
    display: block;
    color: #94a3b8;
    font-size: 11px;
}

.sdm-text-muted {
    color: #64748b;
}

.sdm-date {
    white-space: nowrap;
}

/* =========================================================
   BADGES
========================================================= */

.sdm-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    min-width: 84px;
    padding: 5px 9px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.sdm-badge-pending {
    color: #92400e;
    background: #fffbeb;
    border: 1px solid #fde68a;
}

.sdm-badge-approved {
    color: #166534;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
}

.sdm-badge-rejected {
    color: #991b1b;
    background: #fef2f2;
    border: 1px solid #fecaca;
}

.sdm-badge-active {
    color: #166534;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
}

.sdm-badge-expired {
    color: #991b1b;
    background: #fef2f2;
    border: 1px solid #fecaca;
}

/* =========================================================
   ACTION
========================================================= */

.sdm-actions {
    display: flex;
    align-items: center;
    gap: 6px;
}

.sdm-action-button {
    width: 32px;
    height: 32px;
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    background: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.2s ease;
    text-decoration: none;
}

.sdm-action-button i {
    font-size: 14px;
}

.sdm-action-edit {
    color: #2563eb;
}

.sdm-action-edit:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
}

.sdm-action-delete {
    color: #dc2626;
}

.sdm-action-delete:hover {
    background: #fef2f2;
    border-color: #fecaca;
}

.sdm-action-document {
    color: #7c3aed;
}

.sdm-action-document:hover {
    background: #f5f3ff;
    border-color: #ddd6fe;
}

/* =========================================================
   EMPTY
========================================================= */

.sdm-empty {
    padding: 55px 20px !important;
    text-align: center;
    color: #94a3b8 !important;
}

.sdm-empty i {
    display: block;
    margin-bottom: 10px;
    font-size: 34px;
}

.sdm-empty-text {
    font-size: 13px;
}

/* =========================================================
   TABLE FOOTER
========================================================= */

.sdm-table-footer {
    padding: 14px 16px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.sdm-footer-info {
    color: #64748b;
    font-size: 12px;
}

.sdm-pagination {
    display: flex;
    align-items: center;
    gap: 4px;
}

.sdm-page-button {
    min-width: 32px;
    height: 32px;
    padding: 0 8px;
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    background: #ffffff;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 12px;
    cursor: pointer;
}

.sdm-page-button:hover {
    background: #f8fafc;
}

.sdm-page-button.active {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
}

.sdm-page-button.disabled {
    color: #cbd5e1;
    cursor: not-allowed;
    pointer-events: none;
}

/* =========================================================
   MODAL OVERLAY
========================================================= */

.sdm-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: rgba(15, 23, 42, 0.58);
    overflow-y: auto;
}

.sdm-modal-overlay.show {
    display: flex;
}

/* =========================================================
   FORM MODAL
========================================================= */

.sdm-modal {
    width: 100%;
    max-width: 720px;
    max-height: calc(100vh - 48px);
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 25px 70px rgba(15, 23, 42, 0.25);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.sdm-modal-header {
    flex-shrink: 0;
    padding: 18px 22px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.sdm-modal-header-left {
    min-width: 0;
}

.sdm-modal-title {
    margin: 0;
    font-size: 17px;
    font-weight: 700;
    color: #111827;
}

.sdm-modal-subtitle {
    margin: 4px 0 0;
    color: #94a3b8;
    font-size: 12px;
}

.sdm-modal-close {
    width: 34px;
    height: 34px;
    flex-shrink: 0;
    border: none;
    border-radius: 8px;
    background: #f3f4f6;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sdm-modal-close:hover {
    background: #e5e7eb;
    color: #111827;
}

.sdm-modal-form {
    min-height: 0;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.sdm-modal-body {
    flex: 1 1 auto;
    min-height: 0;
    padding: 22px;
    overflow-y: auto;
}

.sdm-modal-body::-webkit-scrollbar {
    width: 7px;
}

.sdm-modal-body::-webkit-scrollbar-track {
    background: #f8fafc;
}

.sdm-modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.sdm-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 17px;
}

.sdm-form-group {
    min-width: 0;
}

.sdm-form-group.full {
    grid-column: 1 / -1;
}

.sdm-form-label {
    display: block;
    margin-bottom: 7px;
    color: #334155;
    font-size: 12px;
    font-weight: 600;
}

.sdm-required {
    color: #ef4444;
}

.sdm-form-control {
    width: 100%;
    height: 40px;
    padding: 0 11px;
    border: 1px solid #dbe2ea;
    border-radius: 8px;
    background: #ffffff;
    color: #334155;
    font-size: 13px;
    outline: none;
    transition: 0.2s ease;
}

.sdm-form-control:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
}

textarea.sdm-form-control {
    height: 90px;
    padding-top: 10px;
    resize: vertical;
}

.sdm-form-help {
    margin-top: 5px;
    color: #94a3b8;
    font-size: 11px;
}

.sdm-existing-file {
    margin-top: 7px;
    padding: 8px 10px;
    border-radius: 7px;
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
}

.sdm-existing-file a {
    color: #2563eb;
    text-decoration: none;
}

.sdm-existing-file a:hover {
    text-decoration: underline;
}

.sdm-modal-footer {
    flex-shrink: 0;
    padding: 14px 22px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 9px;
    background: #ffffff;
}

.sdm-footer-button {
    min-width: 95px;
    height: 38px;
    padding: 0 15px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
}

.sdm-cancel-button {
    border: 1px solid #dbe2ea;
    background: #ffffff;
    color: #475569;
}

.sdm-cancel-button:hover {
    background: #f8fafc;
}

.sdm-submit-button {
    border: 1px solid #2563eb;
    background: #2563eb;
    color: #ffffff;
}

.sdm-submit-button:hover {
    background: #1d4ed8;
}

/* =========================================================
   DELETE MODAL
========================================================= */

.sdm-delete-modal {
    width: 100%;
    max-width: 430px;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 25px 70px rgba(15, 23, 42, 0.25);
    overflow: hidden;
}

.sdm-delete-content {
    padding: 25px;
    text-align: center;
}

.sdm-delete-icon {
    width: 52px;
    height: 52px;
    margin: 0 auto 14px;
    border-radius: 50%;
    background: #fef2f2;
    color: #dc2626;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.sdm-delete-title {
    margin: 0;
    color: #111827;
    font-size: 17px;
    font-weight: 700;
}

.sdm-delete-text {
    margin: 8px 0 0;
    color: #64748b;
    font-size: 12px;
    line-height: 1.6;
}

.sdm-delete-name {
    color: #111827;
    font-weight: 600;
}

.sdm-delete-footer {
    padding: 14px 20px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 9px;
}

.sdm-delete-confirm {
    border: 1px solid #dc2626;
    background: #dc2626;
    color: #ffffff;
}

.sdm-delete-confirm:hover {
    background: #b91c1c;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {
    .sdm-stat-grid {
        grid-template-columns: 1fr;
    }

    .sdm-toolbar {
        align-items: stretch;
        flex-direction: column;
    }

    .sdm-toolbar-left {
        width: 100%;
    }

    .sdm-search {
        width: 100%;
    }

    .sdm-table-footer {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media (max-width: 700px) {
    .sdm-page {
        padding: 16px;
    }

    .sdm-page-header {
        flex-direction: column;
    }

    .sdm-add-button {
        width: 100%;
    }

    .sdm-form-grid {
        grid-template-columns: 1fr;
    }

    .sdm-form-group.full {
        grid-column: auto;
    }

    .sdm-modal-overlay {
        padding: 12px;
        align-items: flex-start;
    }

    .sdm-modal {
        max-height: calc(100vh - 24px);
        margin-top: 12px;
    }
}
</style>


<div class="sdm-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}
    <div class="sdm-page-header">

        <div class="sdm-page-header-left">
            <h1 class="sdm-page-title">
                Sumber Daya Manusia
            </h1>

            <p class="sdm-page-subtitle">
                Kelola data sumber daya manusia pada sistem.
            </p>
        </div>

        <button
            type="button"
            class="sdm-add-button"
            onclick="openCreateModal()"
        >
            <i class="bi bi-plus-lg"></i>
            Tambah SDM
        </button>

    </div>


    {{-- =====================================================
         ALERT SUCCESS
    ====================================================== --}}
    @if(session('success'))
        <div class="sdm-alert sdm-alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif


    {{-- =====================================================
         ALERT ERROR
    ====================================================== --}}
    @if(session('error'))
        <div class="sdm-alert sdm-alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif


    {{-- =====================================================
         VALIDATION ERROR
    ====================================================== --}}
    @if($errors->any())
        <div class="sdm-alert sdm-alert-error">
            <i class="bi bi-exclamation-triangle-fill"></i>

            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}
    <div class="sdm-stat-grid">

        <div class="sdm-stat-card">

            <div class="sdm-stat-icon blue">
                <i class="bi bi-people"></i>
            </div>

            <div>
                <p class="sdm-stat-label">
                    Total SDM
                </p>

                <p class="sdm-stat-value">
                    {{ $totalData ?? ($sdm->total() ?? $sdm->count()) }}
                </p>
            </div>

        </div>


        <div class="sdm-stat-card">

            <div class="sdm-stat-icon green">
                <i class="bi bi-person-check"></i>
            </div>

            <div>
                <p class="sdm-stat-label">
                    Aktif
                </p>

                <p class="sdm-stat-value">
                    {{ $aktif ?? 0 }}
                </p>
            </div>

        </div>


        <div class="sdm-stat-card">

            <div class="sdm-stat-icon red">
                <i class="bi bi-person-x"></i>
            </div>

            <div>
                <p class="sdm-stat-label">
                    Masa Berlaku Berakhir
                </p>

                <p class="sdm-stat-value">
                    {{ $berakhir ?? 0 }}
                </p>
            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE CARD
    ====================================================== --}}
    <div class="sdm-table-card">

        {{-- TOOLBAR --}}
        <div class="sdm-toolbar">

            <div class="sdm-toolbar-left">

                <form
                    method="GET"
                    action="{{ route('sdm.index') }}"
                    id="sdmSearchForm"
                >

                    <div class="sdm-search">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari NIP, nama, jabatan..."
                            autocomplete="off"
                        >

                    </div>

                </form>

            </div>


            <div class="sdm-show">

                <span>
                    Tampilkan
                </span>

                <form
                    method="GET"
                    action="{{ route('sdm.index') }}"
                    id="sdmShowForm"
                >

                    @if(request('search'))
                        <input
                            type="hidden"
                            name="search"
                            value="{{ request('search') }}"
                        >
                    @endif

                    <select
                        name="show"
                        onchange="document.getElementById('sdmShowForm').submit()"
                    >
                        <option
                            value="10"
                            {{ (int) request('show', 10) === 10 ? 'selected' : '' }}
                        >
                            10
                        </option>

                        <option
                            value="25"
                            {{ (int) request('show', 10) === 25 ? 'selected' : '' }}
                        >
                            25
                        </option>

                        <option
                            value="50"
                            {{ (int) request('show', 10) === 50 ? 'selected' : '' }}
                        >
                            50
                        </option>

                        <option
                            value="100"
                            {{ (int) request('show', 10) === 100 ? 'selected' : '' }}
                        >
                            100
                        </option>
                    </select>

                </form>

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}
        <div class="sdm-table-wrap">

            <table class="sdm-table">

                <thead>

                    <tr>

                        <th style="width: 55px;">
                            No
                        </th>

                        <th>
                            NIP
                        </th>

                        <th>
                            Kode DK
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            Jabatan
                        </th>

                        <th>
                            Kompetensi
                        </th>

                        <th>
                            Masa Berlaku
                        </th>

                        <th>
                            Verifikasi
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

                    @forelse($sdm as $row)

                        @php
                            $tanggalBerlaku = null;

                            if (!empty($row->masa_berlaku)) {
                                try {
                                    $tanggalBerlaku = \Carbon\Carbon::parse($row->masa_berlaku);
                                } catch (\Throwable $e) {
                                    $tanggalBerlaku = null;
                                }
                            }

                            $statusVerifikasi = 'menunggu';
                            $catatanVerifikasi = null;

                            try {
                                $latestVerification = \App\Models\VerificationRequest::where(
                                    'module',
                                    'sdm'
                                )
                                ->where(
                                    'record_id',
                                    $row->id
                                )
                                ->latest('id')
                                ->first();

                                if ($latestVerification) {
                                    $statusVerifikasi = $latestVerification->status ?? 'menunggu';
                                    $catatanVerifikasi = $latestVerification->rejection_reason ?? null;
                                }
                            } catch (\Throwable $e) {
                                $statusVerifikasi = 'menunggu';
                            }
                        @endphp


                        <tr>

                            {{-- NO --}}
                            <td class="sdm-number">
                                {{ ($sdm->currentPage() - 1) * $sdm->perPage() + $loop->iteration }}
                            </td>


                            {{-- NIP --}}
                            <td>

                                @if(!empty($row->nip))
                                    <span class="sdm-main-name">
                                        {{ $row->nip }}
                                    </span>
                                @else
                                    <span class="sdm-text-muted">
                                        -
                                    </span>
                                @endif

                            </td>


                            {{-- KODE DK --}}
                            <td>

                                @if(!empty($row->kode_dk))
                                    <span class="sdm-secondary">
                                        {{ $row->kode_dk }}
                                    </span>
                                @else
                                    <span class="sdm-text-muted">
                                        -
                                    </span>
                                @endif

                            </td>


                            {{-- NAMA --}}
                            <td>

                                <span class="sdm-main-name">
                                    {{ $row->nama ?? '-' }}
                                </span>

                            </td>


                            {{-- JABATAN --}}
                            <td>

                                @if(!empty($row->jabatan))
                                    {{ $row->jabatan }}
                                @else
                                    <span class="sdm-text-muted">
                                        -
                                    </span>
                                @endif

                            </td>


                            {{-- KOMPETENSI --}}
                            <td>

                                @if(!empty($row->kompetensi))

                                    <span title="{{ $row->kompetensi }}">
                                        {{ \Illuminate\Support\Str::limit($row->kompetensi, 45) }}
                                    </span>

                                @else

                                    <span class="sdm-text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- MASA BERLAKU --}}
                            <td class="sdm-date">

                                @if($tanggalBerlaku)

                                    {{ $tanggalBerlaku->format('d M Y') }}

                                @else

                                    <span class="sdm-text-muted">
                                        Tidak ada
                                    </span>

                                @endif

                            </td>


                            {{-- VERIFIKASI --}}
                            <td>

                                @if($statusVerifikasi === 'disetujui')

                                    <span class="sdm-badge sdm-badge-approved">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Disetujui
                                    </span>

                                @elseif($statusVerifikasi === 'ditolak')

                                    <span
                                        class="sdm-badge sdm-badge-rejected"
                                        title="{{ $catatanVerifikasi ?? 'Pengajuan ditolak' }}"
                                    >
                                        <i class="bi bi-x-circle-fill"></i>
                                        Ditolak
                                    </span>

                                @else

                                    <span class="sdm-badge sdm-badge-pending">
                                        <i class="bi bi-clock-fill"></i>
                                        Menunggu
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS MASA BERLAKU --}}
                            <td>

                                @if($tanggalBerlaku)

                                    @if($tanggalBerlaku->startOfDay()->lt(now()->startOfDay()))

                                        <span class="sdm-badge sdm-badge-expired">
                                            <i class="bi bi-x-circle"></i>
                                            Berakhir
                                        </span>

                                    @else

                                        <span class="sdm-badge sdm-badge-active">
                                            <i class="bi bi-check-circle"></i>
                                            Aktif
                                        </span>

                                    @endif

                                @else

                                    <span class="sdm-text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <div class="sdm-actions">

                                    {{-- EDIT --}}
                                    <button
                                        type="button"
                                        class="sdm-action-button sdm-action-edit"
                                        title="Edit"
                                        onclick="openEditModal({{ $row->id }})"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </button>


                                    {{-- DOKUMEN --}}
                                    @if(!empty($row->dokumen))

                                        <a
                                            href="{{ asset('storage/' . $row->dokumen) }}"
                                            target="_blank"
                                            class="sdm-action-button sdm-action-document"
                                            title="Lihat Dokumen"
                                        >
                                            <i class="bi bi-file-earmark-text"></i>
                                        </a>

                                    @endif


                                    {{-- DELETE --}}
                                    <button
                                        type="button"
                                        class="sdm-action-button sdm-action-delete"
                                        title="Hapus"
                                        onclick="openDeleteModal({{ $row->id }})"
                                    >
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="10"
                                class="sdm-empty"
                            >

                                <i class="bi bi-people"></i>

                                <div class="sdm-empty-text">
                                    Belum ada data SDM.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             FOOTER
        ================================================== --}}
        <div class="sdm-table-footer">

            <div class="sdm-footer-info">

                @if($sdm->total() > 0)

                    Menampilkan
                    <strong>{{ $sdm->firstItem() }}</strong>
                    -
                    <strong>{{ $sdm->lastItem() }}</strong>
                    dari
                    <strong>{{ $sdm->total() }}</strong>
                    data

                @else

                    Tidak ada data

                @endif

            </div>


            @if($sdm->lastPage() > 1)

                <div class="sdm-pagination">

                    {{-- PREVIOUS --}}
                    @if($sdm->onFirstPage())

                        <span class="sdm-page-button disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>

                    @else

                        <a
                            href="{{ $sdm->previousPageUrl() }}"
                            class="sdm-page-button"
                        >
                            <i class="bi bi-chevron-left"></i>
                        </a>

                    @endif


                    {{-- PAGE NUMBERS --}}
                    @foreach($sdm->getUrlRange(1, $sdm->lastPage()) as $page => $url)

                        @if($page == $sdm->currentPage())

                            <span class="sdm-page-button active">
                                {{ $page }}
                            </span>

                        @else

                            <a
                                href="{{ $url }}"
                                class="sdm-page-button"
                            >
                                {{ $page }}
                            </a>

                        @endif

                    @endforeach


                    {{-- NEXT --}}
                    @if($sdm->hasMorePages())

                        <a
                            href="{{ $sdm->nextPageUrl() }}"
                            class="sdm-page-button"
                        >
                            <i class="bi bi-chevron-right"></i>
                        </a>

                    @else

                        <span class="sdm-page-button disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>

                    @endif

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
     CREATE / EDIT MODAL
========================================================= --}}

<div
    id="sdmFormOverlay"
    class="sdm-modal-overlay"
    onclick="closeSdmFormOutside(event)"
>

    <div
        class="sdm-modal"
        onclick="event.stopPropagation()"
    >

        {{-- HEADER --}}
        <div class="sdm-modal-header">

            <div class="sdm-modal-header-left">

                <h2
                    id="sdmFormTitle"
                    class="sdm-modal-title"
                >
                    Tambah SDM
                </h2>

                <p
                    id="sdmFormSubtitle"
                    class="sdm-modal-subtitle"
                >
                    Masukkan data sumber daya manusia baru.
                </p>

            </div>


            <button
                type="button"
                class="sdm-modal-close"
                onclick="closeSdmForm()"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        {{-- FORM --}}
        <form
            id="sdmForm"
            class="sdm-modal-form"
            method="POST"
            action="{{ route('sdm.store') }}"
            enctype="multipart/form-data"
        >

            @csrf

            <input
                type="hidden"
                id="sdmMethod"
                name="_method"
                value="POST"
            >


            {{-- BODY --}}
            <div class="sdm-modal-body">

                <div class="sdm-form-grid">


                    {{-- NIP --}}
                    <div class="sdm-form-group">

                        <label
                            for="sdm_nip"
                            class="sdm-form-label"
                        >
                            NIP
                            <span class="sdm-required">*</span>
                        </label>

                        <input
                            type="text"
                            id="sdm_nip"
                            name="nip"
                            class="sdm-form-control"
                            value="{{ old('nip') }}"
                            placeholder="Masukkan NIP"
                            required
                        >

                    </div>


                    {{-- KODE DK --}}
                    <div class="sdm-form-group">

                        <label
                            for="sdm_kode_dk"
                            class="sdm-form-label"
                        >
                            Kode DK
                            <span class="sdm-required">*</span>
                        </label>

                        <input
                            type="text"
                            id="sdm_kode_dk"
                            name="kode_dk"
                            class="sdm-form-control"
                            value="{{ old('kode_dk') }}"
                            placeholder="Masukkan kode DK"
                            required
                        >

                    </div>


                    {{-- NAMA --}}
                    <div class="sdm-form-group full">

                        <label
                            for="sdm_nama"
                            class="sdm-form-label"
                        >
                            Nama Lengkap
                            <span class="sdm-required">*</span>
                        </label>

                        <input
                            type="text"
                            id="sdm_nama"
                            name="nama"
                            class="sdm-form-control"
                            value="{{ old('nama') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                        >

                    </div>


                    {{-- JABATAN --}}
                    <div class="sdm-form-group">

                        <label
                            for="sdm_jabatan"
                            class="sdm-form-label"
                        >
                            Jabatan
                            <span class="sdm-required">*</span>
                        </label>

                        <input
                            type="text"
                            id="sdm_jabatan"
                            name="jabatan"
                            class="sdm-form-control"
                            value="{{ old('jabatan') }}"
                            placeholder="Masukkan jabatan"
                            required
                        >

                    </div>


                    {{-- KOMPETENSI --}}
                    <div class="sdm-form-group">

                        <label
                            for="sdm_kompetensi"
                            class="sdm-form-label"
                        >
                            Kompetensi
                            <span class="sdm-required">*</span>
                        </label>

                        <input
                            type="text"
                            id="sdm_kompetensi"
                            name="kompetensi"
                            class="sdm-form-control"
                            value="{{ old('kompetensi') }}"
                            placeholder="Masukkan kompetensi"
                            required
                        >

                    </div>


                    {{-- MASA BERLAKU --}}
                    <div class="sdm-form-group">

                        <label
                            for="sdm_masa_berlaku"
                            class="sdm-form-label"
                        >
                            Masa Berlaku
                            <span class="sdm-required">*</span>
                        </label>

                        <input
                            type="date"
                            id="sdm_masa_berlaku"
                            name="masa_berlaku"
                            class="sdm-form-control"
                            value="{{ old('masa_berlaku') }}"
                            required
                        >

                    </div>


                    {{-- DOKUMEN --}}
                    <div class="sdm-form-group">

                        <label
                            for="sdm_dokumen"
                            class="sdm-form-label"
                        >
                            Dokumen
                        </label>

                        <input
                            type="file"
                            id="sdm_dokumen"
                            name="dokumen"
                            class="sdm-form-control"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        >

                        <div
                            id="sdmExistingFile"
                            class="sdm-existing-file"
                            style="display:none;"
                        ></div>

                        <div class="sdm-form-help">
                            Format: PDF, DOC, DOCX, JPG, JPEG, PNG.
                        </div>

                    </div>


                </div>

            </div>


            {{-- FOOTER --}}
            <div class="sdm-modal-footer">

                <button
                    type="button"
                    class="sdm-footer-button sdm-cancel-button"
                    onclick="closeSdmForm()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="sdm-footer-button sdm-submit-button"
                >
                    <i class="bi bi-check-lg"></i>

                    <span id="sdmSubmitText">
                        Simpan
                    </span>

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     DELETE MODAL
========================================================= --}}

<div
    id="sdmDeleteOverlay"
    class="sdm-modal-overlay"
    onclick="closeDeleteModalOutside(event)"
>

    <div
        class="sdm-delete-modal"
        onclick="event.stopPropagation()"
    >

        <div class="sdm-delete-content">

            <div class="sdm-delete-icon">
                <i class="bi bi-trash3"></i>
            </div>

            <h3 class="sdm-delete-title">
                Hapus Data SDM?
            </h3>

            <p class="sdm-delete-text">
                Data
                <span
                    id="sdmDeleteName"
                    class="sdm-delete-name"
                >
                    ini
                </span>
                akan diajukan untuk penghapusan dan menunggu verifikasi.
            </p>

        </div>


        <div class="sdm-delete-footer">

            <button
                type="button"
                class="sdm-footer-button sdm-cancel-button"
                onclick="closeDeleteModal()"
            >
                Batal
            </button>


            <form
                id="sdmDeleteForm"
                method="POST"
                action=""
            >

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="sdm-footer-button sdm-delete-confirm"
                >
                    <i class="bi bi-trash3"></i>
                    Hapus
                </button>

            </form>

        </div>

    </div>

</div>


<script>
/* =========================================================
   DATA SDM UNTUK JAVASCRIPT
========================================================= */

const sdmRecords = @json($sdm->items());


/* =========================================================
   CREATE MODAL
========================================================= */

function openCreateModal() {

    const overlay = document.getElementById('sdmFormOverlay');
    const form = document.getElementById('sdmForm');

    if (!overlay || !form) {
        return;
    }

    form.action = "{{ route('sdm.store') }}";

    document.getElementById('sdmMethod').value = 'POST';

    document.getElementById('sdmFormTitle').textContent =
        'Tambah SDM';

    document.getElementById('sdmFormSubtitle').textContent =
        'Masukkan data sumber daya manusia baru.';

    document.getElementById('sdmSubmitText').textContent =
        'Simpan';

    document.getElementById('sdm_nip').value = '';
    document.getElementById('sdm_kode_dk').value = '';
    document.getElementById('sdm_nama').value = '';
    document.getElementById('sdm_jabatan').value = '';
    document.getElementById('sdm_kompetensi').value = '';
    document.getElementById('sdm_masa_berlaku').value = '';
    document.getElementById('sdm_dokumen').value = '';

    const existingFile =
        document.getElementById('sdmExistingFile');

    existingFile.style.display = 'none';
    existingFile.innerHTML = '';

    overlay.classList.add('show');

    document.body.style.overflow = 'hidden';

    setTimeout(function () {

        const input =
            document.getElementById('sdm_nip');

        if (input) {
            input.focus();
        }

    }, 100);
}


/* =========================================================
   EDIT MODAL
========================================================= */

function openEditModal(id) {

    const overlay = document.getElementById('sdmFormOverlay');
    const form = document.getElementById('sdmForm');

    if (!overlay || !form) {
        return;
    }

    const record = sdmRecords.find(function (item) {

        return Number(item.id) === Number(id);

    });

    if (!record) {
        alert('Data SDM tidak ditemukan.');

        return;
    }

    form.action =
        "{{ url('/sdm') }}/" + id;

    document.getElementById('sdmMethod').value = 'PUT';

    document.getElementById('sdmFormTitle').textContent =
        'Edit SDM';

    document.getElementById('sdmFormSubtitle').textContent =
        'Perbarui data sumber daya manusia.';

    document.getElementById('sdmSubmitText').textContent =
        'Simpan Perubahan';


    document.getElementById('sdm_nip').value =
        record.nip ?? '';

    document.getElementById('sdm_kode_dk').value =
        record.kode_dk ?? '';

    document.getElementById('sdm_nama').value =
        record.nama ?? '';

    document.getElementById('sdm_jabatan').value =
        record.jabatan ?? '';

    document.getElementById('sdm_kompetensi').value =
        record.kompetensi ?? '';


    let masaBerlaku = '';

    if (record.masa_berlaku) {

        masaBerlaku =
            String(record.masa_berlaku).substring(0, 10);

    }

    document.getElementById('sdm_masa_berlaku').value =
        masaBerlaku;


    document.getElementById('sdm_dokumen').value = '';


    const existingFile =
        document.getElementById('sdmExistingFile');

    if (record.dokumen) {

        existingFile.style.display = 'block';

        existingFile.innerHTML =
            'Dokumen saat ini: ' +
            '<a href="/storage/' +
            encodeURIComponent(record.dokumen)
            .replace(/%2F/g, '/') +
            '" target="_blank">' +
            'Lihat dokumen' +
            '</a>';

    } else {

        existingFile.style.display = 'none';

        existingFile.innerHTML = '';

    }


    overlay.classList.add('show');

    document.body.style.overflow = 'hidden';

    setTimeout(function () {

        const input =
            document.getElementById('sdm_nama');

        if (input) {
            input.focus();
        }

    }, 100);
}


/* =========================================================
   CLOSE FORM MODAL
========================================================= */

function closeSdmForm() {

    const overlay =
        document.getElementById('sdmFormOverlay');

    if (!overlay) {
        return;
    }

    overlay.classList.remove('show');

    document.body.style.overflow = '';

}


function closeSdmFormOutside(event) {

    if (event.target === event.currentTarget) {

        closeSdmForm();

    }

}


/* =========================================================
   DELETE MODAL
========================================================= */

function openDeleteModal(id) {

    const overlay =
        document.getElementById('sdmDeleteOverlay');

    const form =
        document.getElementById('sdmDeleteForm');

    const nameElement =
        document.getElementById('sdmDeleteName');


    if (!overlay || !form) {
        return;
    }


    const record = sdmRecords.find(function (item) {

        return Number(item.id) === Number(id);

    });


    let name = 'data SDM ini';

    if (record && record.nama) {
        name = record.nama;
    }


    if (nameElement) {

        nameElement.textContent =
            name;

    }


    form.action =
        "{{ url('/sdm') }}/" + id;


    overlay.classList.add('show');

    document.body.style.overflow = 'hidden';

}


function closeDeleteModal() {

    const overlay =
        document.getElementById('sdmDeleteOverlay');

    if (!overlay) {
        return;
    }

    overlay.classList.remove('show');

    document.body.style.overflow = '';

}


function closeDeleteModalOutside(event) {

    if (event.target === event.currentTarget) {

        closeDeleteModal();

    }

}


/* =========================================================
   ESC KEY
========================================================= */

document.addEventListener('keydown', function(event) {

    if (event.key !== 'Escape') {
        return;
    }


    const formOverlay =
        document.getElementById('sdmFormOverlay');

    const deleteOverlay =
        document.getElementById('sdmDeleteOverlay');


    if (
        formOverlay &&
        formOverlay.classList.contains('show')
    ) {

        closeSdmForm();

        return;

    }


    if (
        deleteOverlay &&
        deleteOverlay.classList.contains('show')
    ) {

        closeDeleteModal();

    }

});


/* =========================================================
   SEARCH
========================================================= */

const searchInput =
    document.querySelector(
        '#sdmSearchForm input[name="search"]'
    );


if (searchInput) {

    let searchTimer = null;

    searchInput.addEventListener('input', function() {

        clearTimeout(searchTimer);

        searchTimer = setTimeout(function() {

            const form =
                document.getElementById('sdmSearchForm');

            if (form) {

                form.submit();

            }

        }, 500);

    });

}


/* =========================================================
   PREVENT BODY SCROLL WHEN MODAL OPEN
========================================================= */

window.addEventListener('beforeunload', function() {

    document.body.style.overflow = '';

});
</script>

@endsection