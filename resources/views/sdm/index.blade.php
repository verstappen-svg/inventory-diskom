@extends('layouts.app')

@section('title', 'Sumber Daya Manusia')
@section('page-title', 'Sumber Daya Manusia')

@section('content')

<style>
    .sdm-page {
        padding: 10px 0 30px;
    }

    .sdm-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .sdm-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .sdm-header p {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .btn-add-sdm {
        border: none;
        background: #0d6efd;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-add-sdm:hover {
        background: #0b5ed7;
    }

    /* =========================
       STATISTIC
    ========================== */

    .sdm-statistics {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .sdm-stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        border: 1px solid #eef0f4;
    }

    .sdm-stat-title {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .sdm-stat-number {
        font-size: 25px;
        font-weight: 700;
        color: #111827;
    }

    /* =========================
       SEARCH & FILTER
    ========================== */

    .sdm-filter-box {
        background: #fff;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        border: 1px solid #eef0f4;
    }

    .sdm-filter-form {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .sdm-search {
        flex: 1;
        min-width: 220px;
        position: relative;
    }

    .sdm-search input {
        width: 100%;
        height: 42px;
        padding: 0 14px 0 40px;
        border: 1px solid #dfe3e8;
        border-radius: 8px;
        outline: none;
        box-sizing: border-box;
    }

    .sdm-search input:focus {
        border-color: #0d6efd;
    }

    .sdm-search i {
        position: absolute;
        left: 14px;
        top: 13px;
        color: #6b7280;
    }

    .sdm-filter-select {
        height: 42px;
        min-width: 180px;
        padding: 0 12px;
        border: 1px solid #dfe3e8;
        border-radius: 8px;
        outline: none;
        background: white;
    }

    .btn-filter {
        height: 42px;
        border: none;
        background: #0d6efd;
        color: #fff;
        padding: 0 18px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-reset {
        height: 42px;
        border: 1px solid #dfe3e8;
        background: white;
        color: #374151;
        padding: 0 18px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    /* =========================
       TABLE
    ========================== */

    .sdm-table-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        border: 1px solid #eef0f4;
        overflow: hidden;
    }

    .sdm-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .sdm-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1250px;
    }

    .sdm-table th {
        background: #f8f9fa;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        padding: 13px 12px;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
        text-align: left;
    }

    .sdm-table td {
        padding: 13px 12px;
        border-bottom: 1px solid #f0f1f3;
        color: #374151;
        font-size: 13px;
        vertical-align: middle;
    }

    .sdm-table tbody tr:hover {
        background: #fafafa;
    }

    .sdm-id {
        font-weight: 700;
        color: #0d6efd;
        white-space: nowrap;
    }

    .sdm-nama {
        font-weight: 600;
        color: #111827;
        min-width: 160px;
    }

    .sdm-dokumen a {
        color: #0d6efd;
        text-decoration: none;
        font-weight: 600;
        white-space: nowrap;
    }

    .sdm-dokumen a:hover {
        text-decoration: underline;
    }

    /* =========================
       BADGE
    ========================== */

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-menunggu {
        background: #fff3cd;
        color: #856404;
    }

    .badge-disetujui {
        background: #d1e7dd;
        color: #0f5132;
    }

    .badge-ditolak {
        background: #f8d7da;
        color: #842029;
    }

    .badge-aktif {
        background: #d1e7dd;
        color: #0f5132;
    }

    .badge-berakhir {
        background: #f8d7da;
        color: #842029;
    }

    /* =========================
       ACTION
    ========================== */

    .sdm-actions {
        display: flex;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-action {
        border: none;
        width: 34px;
        height: 34px;
        border-radius: 7px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-edit {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .btn-delete {
        background: #fde8e8;
        color: #dc3545;
    }

    .btn-action:hover {
        opacity: .8;
    }

    /* =========================
       PAGINATION
    ========================== */

    .sdm-pagination {
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .sdm-pagination-info {
        color: #6b7280;
        font-size: 13px;
    }

    .sdm-pagination nav {
        display: flex;
        align-items: center;
    }

    /* =========================
       MODAL
    ========================== */

    .sdm-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .sdm-modal-overlay.active {
        display: flex;
    }

    .sdm-modal {
        width: 100%;
        max-width: 850px;
        max-height: 90vh;
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, .2);
    }

    .sdm-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 22px;
        border-bottom: 1px solid #e5e7eb;
    }

    .sdm-modal-header h3 {
        margin: 0;
        font-size: 18px;
        color: #111827;
    }

    .sdm-modal-close {
        border: none;
        background: transparent;
        font-size: 24px;
        color: #6b7280;
        cursor: pointer;
        line-height: 1;
    }

    .sdm-modal-body {
        padding: 22px;
        max-height: calc(90vh - 130px);
        overflow-y: auto;
    }

    .sdm-form-group {
        margin-bottom: 15px;
    }

    .sdm-form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .sdm-form-control {
        width: 100%;
        height: 42px;
        border: 1px solid #dfe3e8;
        border-radius: 8px;
        padding: 0 12px;
        outline: none;
        box-sizing: border-box;
        font-size: 14px;
    }

    textarea.sdm-form-control {
        height: 90px;
        padding-top: 10px;
        resize: vertical;
    }

    .sdm-form-control:focus {
        border-color: #0d6efd;
    }

    .sdm-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    /* =========================
       BATCH ROW
    ========================== */

    .batch-row {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 12px;
        background: #fafafa;
        position: relative;
    }

    .batch-row-number {
        font-size: 13px;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 12px;
    }

    .batch-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .batch-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        background: #fde8e8;
        color: #dc3545;
        cursor: pointer;
    }

    .btn-add-row {
        border: 1px dashed #0d6efd;
        color: #0d6efd;
        background: #f8fbff;
        padding: 9px 14px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .modal-footer {
        padding: 15px 22px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-cancel {
        border: 1px solid #dfe3e8;
        background: white;
        color: #374151;
        padding: 9px 17px;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-save {
        border: none;
        background: #0d6efd;
        color: white;
        padding: 9px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-save:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    .current-file {
        margin-top: 7px;
        font-size: 12px;
        color: #6b7280;
    }

    .current-file a {
        color: #0d6efd;
        text-decoration: none;
    }

    /* =========================
       ALERT
    ========================== */

    .sdm-alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 13px;
    }

    .sdm-alert-success {
        background: #d1e7dd;
        color: #0f5132;
    }

    .sdm-alert-error {
        background: #f8d7da;
        color: #842029;
    }

    .sdm-error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .sdm-statistics {
            grid-template-columns: 1fr;
        }

        .sdm-row,
        .batch-grid {
            grid-template-columns: 1fr;
        }

        .sdm-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="sdm-page">

    {{-- =========================
         HEADER
    ========================== --}}
    <div class="sdm-header">
        <div>
            <h2>Sumber Daya Manusia</h2>
            <p>Kelola data sumber daya manusia dan dokumen pendukung.</p>
        </div>

        <button type="button"
                class="btn-add-sdm"
                onclick="openSdmModal()">
            <i class="bi bi-plus-lg"></i>
            Tambah SDM
        </button>
    </div>

    {{-- =========================
         ALERT
    ========================== --}}
    @if(session('success'))
        <div class="sdm-alert sdm-alert-success">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="sdm-alert sdm-alert-error">
            <i class="bi bi-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="sdm-alert sdm-alert-error">
            <strong>Data belum dapat disimpan.</strong>
            <ul style="margin: 7px 0 0 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- =========================
         STATISTIC
    ========================== --}}
    <div class="sdm-statistics">

        <div class="sdm-stat-card">
            <div class="sdm-stat-title">Total SDM</div>
            <div class="sdm-stat-number">
                {{ $totalData ?? 0 }}
            </div>
        </div>

        <div class="sdm-stat-card">
            <div class="sdm-stat-title">Aktif</div>
            <div class="sdm-stat-number">
                {{ $aktif ?? 0 }}
            </div>
        </div>

        <div class="sdm-stat-card">
            <div class="sdm-stat-title">Masa Berlaku Berakhir</div>
            <div class="sdm-stat-number">
                {{ $berakhir ?? 0 }}
            </div>
        </div>

    </div>

    {{-- =========================
         SEARCH & FILTER
    ========================== --}}
    <div class="sdm-filter-box">

        <form action="{{ route('sdm.index') }}"
              method="GET"
              class="sdm-filter-form">

            <div class="sdm-search">
                <i class="bi bi-search"></i>

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari NIP, nama, jabatan, kompetensi...">
            </div>

            <select name="verifikasi"
                    class="sdm-filter-select">

                <option value="">Semua Verifikasi</option>

                <option value="menunggu"
                    {{ request('verifikasi') == 'menunggu' ? 'selected' : '' }}>
                    Menunggu Disetujui
                </option>

                <option value="disetujui"
                    {{ request('verifikasi') == 'disetujui' ? 'selected' : '' }}>
                    Disetujui
                </option>

                <option value="ditolak"
                    {{ request('verifikasi') == 'ditolak' ? 'selected' : '' }}>
                    Ditolak
                </option>

            </select>

            <button type="submit" class="btn-filter">
                <i class="bi bi-funnel"></i>
                Filter
            </button>

            <a href="{{ route('sdm.index') }}"
               class="btn-reset">
                Reset
            </a>

        </form>

    </div>

    {{-- =========================
         TABLE
    ========================== --}}
    <div class="sdm-table-card">

        <div class="sdm-table-wrapper">

            <table class="sdm-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Kompetensi</th>
                        <th>Masa Berlaku</th>
                        <th>Dokumen</th>
                        <th>Verifikasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($sdm as $index => $row)

                        @php
                            $displayId = 'SDM-' . str_pad($row->id, 5, '0', STR_PAD_LEFT);

                            $verification = \App\Models\VerificationRequest::where(
                                'module',
                                'sdm'
                            )
                            ->where('record_id', $row->id)
                            ->latest()
                            ->first();

                            $verificationStatus = $verification->status ?? null;

                            $verifikasi = strtolower(trim($row->verifikasi ?? ''));

                            if ($verifikasi === 'menunggu') {
                                $verifikasi = 'Menunggu Disetujui';
                            } elseif ($verifikasi === 'disetujui') {
                                $verifikasi = 'Disetujui';
                            } elseif ($verifikasi === 'ditolak') {
                                $verifikasi = 'Ditolak';
                            }

                            $masaBerlaku = $row->masa_berlaku
                                ? \Carbon\Carbon::parse($row->masa_berlaku)
                                : null;

                            $statusMasaBerlaku = $masaBerlaku && $masaBerlaku->isPast()
                                ? 'Berakhir'
                                : 'Aktif';
                        @endphp

                        <tr>

                            {{-- NO --}}
                            <td>
                                {{ ($sdm->currentPage() - 1) * $sdm->perPage() + $index + 1 }}
                            </td>

                            {{-- ID --}}
                            <td>
                                <span class="sdm-id">
                                    {{ $displayId }}
                                </span>
                            </td>

                            {{-- NIP --}}
                            <td>
                                {{ $row->nip ?? '-' }}
                            </td>

                            {{-- NAMA --}}
                            <td>
                                <div class="sdm-nama">
                                    {{ $row->nama ?? '-' }}
                                </div>
                            </td>

                            {{-- JABATAN --}}
                            <td>
                                {{ $row->jabatan ?? '-' }}
                            </td>

                            {{-- KOMPETENSI --}}
                            <td>
                                {{ $row->kompetensi ?? '-' }}
                            </td>

                            {{-- MASA BERLAKU --}}
                            <td>
                                @if($masaBerlaku)
                                    {{ $masaBerlaku->format('d-m-Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- DOKUMEN --}}
                            <td class="sdm-dokumen">

                                @if($row->dokumen)

                                    <a href="{{ asset('storage/' . $row->dokumen) }}"
                                       target="_blank">
                                        <i class="bi bi-file-earmark-text"></i>
                                        Lihat
                                    </a>

                                @else
                                    -
                                @endif

                            </td>

                            {{-- VERIFIKASI --}}
                            <td>

                                @if($verifikasi === 'Disetujui')

                                    <span class="badge badge-disetujui">
                                        Disetujui
                                    </span>

                                @elseif($verifikasi === 'Ditolak')

                                    <span class="badge badge-ditolak">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge badge-menunggu">
                                        Menunggu Disetujui
                                    </span>

                                @endif

                            </td>

                            {{-- STATUS --}}
                            <td>

                                @if($statusMasaBerlaku === 'Aktif')

                                    <span class="badge badge-aktif">
                                        Aktif
                                    </span>

                                @else

                                    <span class="badge badge-berakhir">
                                        Berakhir
                                    </span>

                                @endif

                            </td>

                            {{-- AKSI --}}
                            <td>

                                <div class="sdm-actions">

                                    <button type="button"
                                            class="btn-action btn-edit"
                                            title="Edit"
                                            onclick="openEditSdmModal({{ $row->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <form action="{{ route('sdm.destroy', $row->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data SDM ini?');"
                                          style="display:inline;">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn-action btn-delete"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="11"
                                style="text-align:center; padding:40px; color:#6b7280;">

                                <i class="bi bi-inbox"
                                   style="font-size:30px; display:block; margin-bottom:8px;">
                                </i>

                                Belum ada data SDM.

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if($sdm->hasPages() || $sdm->total() > 0)

            <div class="sdm-pagination">

                <div class="sdm-pagination-info">
                    Menampilkan
                    {{ $sdm->firstItem() ?? 0 }}
                    -
                    {{ $sdm->lastItem() ?? 0 }}
                    dari
                    {{ $sdm->total() }}
                    data
                </div>

                <div>
                    {{ $sdm->links() }}
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =====================================================
     MODAL TAMBAH / EDIT SDM
====================================================== --}}

<div id="sdmModal"
     class="sdm-modal-overlay"
     onclick="handleSdmOverlayClick(event)">

    <div class="sdm-modal">

        <div class="sdm-modal-header">

            <h3 id="sdmModalTitle">
                Tambah SDM
            </h3>

            <button type="button"
                    class="sdm-modal-close"
                    onclick="closeSdmModal()">
                &times;
            </button>

        </div>

        <form id="sdmForm"
              action="{{ route('sdm.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <input type="hidden"
                   name="_method"
                   id="sdmMethod"
                   value="POST">

            <div class="sdm-modal-body">

                {{-- =================================================
                     BATCH ADD
                ================================================== --}}
                <div id="sdmBatchSection">

                    <div id="sdmRowsContainer"></div>

                    <button type="button"
                            class="btn-add-row"
                            onclick="addSdmRow()">

                        <i class="bi bi-plus-circle"></i>
                        Tambah Baris

                    </button>

                </div>

                {{-- =================================================
                     EDIT
                ================================================== --}}
                <div id="sdmEditSection"
                     style="display:none;">

                    <div class="sdm-row">

                        {{-- NIP --}}
                        <div class="sdm-form-group">

                            <label>
                                NIP <span style="color:red">*</span>
                            </label>

                            <input type="text"
                                   id="edit_nip"
                                   class="sdm-form-control"
                                   autocomplete="off">

                        </div>

                        {{-- NAMA --}}
                        <div class="sdm-form-group">

                            <label>
                                Nama <span style="color:red">*</span>
                            </label>

                            <input type="text"
                                   id="edit_nama"
                                   class="sdm-form-control"
                                   autocomplete="off">

                        </div>

                    </div>

                    <div class="sdm-row">

                        {{-- JABATAN --}}
                        <div class="sdm-form-group">

                            <label>
                                Jabatan <span style="color:red">*</span>
                            </label>

                            <input type="text"
                                   id="edit_jabatan"
                                   class="sdm-form-control"
                                   autocomplete="off">

                        </div>

                        {{-- KOMPETENSI --}}
                        <div class="sdm-form-group">

                            <label>
                                Kompetensi <span style="color:red">*</span>
                            </label>

                            <input type="text"
                                   id="edit_kompetensi"
                                   class="sdm-form-control"
                                   autocomplete="off">

                        </div>

                    </div>

                    {{-- MASA BERLAKU --}}
                    <div class="sdm-form-group">

                        <label>
                            Masa Berlaku <span style="color:red">*</span>
                        </label>

                        <input type="date"
                               id="edit_masa_berlaku"
                               class="sdm-form-control">

                    </div>

                    {{-- DOKUMEN --}}
                    <div class="sdm-form-group">

                        <label>
                            Dokumen
                        </label>

                        <input type="file"
                               id="edit_dokumen"
                               class="sdm-form-control"
                               accept=".pdf,.jpg,.jpeg,.png">

                        <div id="currentSdmFile"
                             class="current-file">
                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn-cancel"
                        onclick="closeSdmModal()">
                    Batal
                </button>

                <button type="submit"
                        class="btn-save"
                        id="sdmSubmitButton">

                    <i class="bi bi-check-lg"></i>
                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>


<script>

    /* =========================================================
       DATA SDM UNTUK JAVASCRIPT
    ========================================================== */

    const sdmRecords = @json($sdm->items());

    const sdmModal = document.getElementById('sdmModal');
    const sdmForm = document.getElementById('sdmForm');
    const sdmMethod = document.getElementById('sdmMethod');

    const sdmBatchSection = document.getElementById('sdmBatchSection');
    const sdmEditSection = document.getElementById('sdmEditSection');

    const sdmRowsContainer = document.getElementById('sdmRowsContainer');

    const sdmModalTitle = document.getElementById('sdmModalTitle');
    const sdmSubmitButton = document.getElementById('sdmSubmitButton');


    /* =========================================================
       INPUT EDIT
       Awalnya TANPA name agar tidak bentrok dengan input batch.
    ========================================================== */

    const editInputs = {
        nip: document.getElementById('edit_nip'),
        nama: document.getElementById('edit_nama'),
        jabatan: document.getElementById('edit_jabatan'),
        kompetensi: document.getElementById('edit_kompetensi'),
        masa_berlaku: document.getElementById('edit_masa_berlaku'),
        dokumen: document.getElementById('edit_dokumen')
    };


    /* =========================================================
       ENABLE EDIT INPUT
    ========================================================== */

    function enableSdmEditInputs() {

        editInputs.nip.name = 'nip';
        editInputs.nama.name = 'nama';
        editInputs.jabatan.name = 'jabatan';
        editInputs.kompetensi.name = 'kompetensi';
        editInputs.masa_berlaku.name = 'masa_berlaku';
        editInputs.dokumen.name = 'dokumen';
    }


    /* =========================================================
       DISABLE EDIT INPUT
    ========================================================== */

    function disableSdmEditInputs() {

        Object.values(editInputs).forEach(input => {
            input.removeAttribute('name');
        });
    }


    /* =========================================================
       OPEN TAMBAH MODAL
    ========================================================== */

    function openSdmModal() {

        sdmForm.action = "{{ route('sdm.store') }}";

        sdmMethod.value = 'POST';

        sdmModalTitle.textContent = 'Tambah SDM';

        sdmBatchSection.style.display = 'block';

        sdmEditSection.style.display = 'none';

        disableSdmEditInputs();

        sdmForm.reset();

        sdmRowsContainer.innerHTML = '';

        addSdmRow();

        sdmModal.classList.add('active');

        document.body.style.overflow = 'hidden';
    }


    /* =========================================================
       OPEN EDIT MODAL
    ========================================================== */

    function openEditSdmModal(id) {

        const record = sdmRecords.find(
            item => Number(item.id) === Number(id)
        );

        if (!record) {
            alert('Data SDM tidak ditemukan.');
            return;
        }

        sdmForm.action = "{{ url('/sdm') }}/" + id;

        sdmMethod.value = 'PUT';

        sdmModalTitle.textContent = 'Edit SDM';

        sdmBatchSection.style.display = 'none';

        sdmEditSection.style.display = 'block';

        enableSdmEditInputs();

        editInputs.nip.value = record.nip ?? '';

        editInputs.nama.value = record.nama ?? '';

        editInputs.jabatan.value = record.jabatan ?? '';

        editInputs.kompetensi.value = record.kompetensi ?? '';

        editInputs.masa_berlaku.value =
            record.masa_berlaku
                ? String(record.masa_berlaku).substring(0, 10)
                : '';

        editInputs.dokumen.value = '';

        const currentFile =
            document.getElementById('currentSdmFile');

        if (record.dokumen) {

            currentFile.innerHTML =
                'Dokumen saat ini: ' +
                '<a href="{{ asset('storage') }}/' +
                record.dokumen +
                '" target="_blank">Lihat dokumen</a>';

        } else {

            currentFile.innerHTML =
                'Belum ada dokumen.';

        }

        sdmModal.classList.add('active');

        document.body.style.overflow = 'hidden';
    }


    /* =========================================================
       TAMBAH BARIS BATCH
    ========================================================== */

    function addSdmRow() {

        const rowCount =
            sdmRowsContainer.querySelectorAll('.batch-row').length + 1;

        const row = document.createElement('div');

        row.className = 'batch-row';

        row.innerHTML = `

            <div class="batch-row-number">
                Data SDM ${rowCount}
            </div>

            <button type="button"
                    class="batch-remove"
                    onclick="removeSdmRow(this)"
                    title="Hapus baris">

                <i class="bi bi-x-lg"></i>

            </button>

            <div class="batch-grid">

                <div class="sdm-form-group">

                    <label>
                        NIP <span style="color:red">*</span>
                    </label>

                    <input type="text"
                           name="nip[]"
                           class="sdm-form-control"
                           required>

                </div>

                <div class="sdm-form-group">

                    <label>
                        Nama <span style="color:red">*</span>
                    </label>

                    <input type="text"
                           name="nama[]"
                           class="sdm-form-control"
                           required>

                </div>

                <div class="sdm-form-group">

                    <label>
                        Jabatan <span style="color:red">*</span>
                    </label>

                    <input type="text"
                           name="jabatan[]"
                           class="sdm-form-control"
                           required>

                </div>

                <div class="sdm-form-group">

                    <label>
                        Kompetensi <span style="color:red">*</span>
                    </label>

                    <input type="text"
                           name="kompetensi[]"
                           class="sdm-form-control"
                           required>

                </div>

                <div class="sdm-form-group">

                    <label>
                        Masa Berlaku <span style="color:red">*</span>
                    </label>

                    <input type="date"
                           name="masa_berlaku[]"
                           class="sdm-form-control"
                           required>

                </div>

                <div class="sdm-form-group">

                    <label>
                        Dokumen <span style="color:red">*</span>
                    </label>

                    <input type="file"
                           name="dokumen[]"
                           class="sdm-form-control"
                           accept=".pdf,.jpg,.jpeg,.png"
                           required>

                </div>

            </div>
        `;

        sdmRowsContainer.appendChild(row);

        updateSdmRowNumbers();
    }


    /* =========================================================
       HAPUS BARIS
    ========================================================== */

    function removeSdmRow(button) {

        const rows =
            sdmRowsContainer.querySelectorAll('.batch-row');

        if (rows.length <= 1) {
            alert('Minimal harus ada satu data SDM.');
            return;
        }

        button.closest('.batch-row').remove();

        updateSdmRowNumbers();
    }


    /* =========================================================
       UPDATE NOMOR BARIS
    ========================================================== */

    function updateSdmRowNumbers() {

        const rows =
            sdmRowsContainer.querySelectorAll('.batch-row');

        rows.forEach((row, index) => {

            const number =
                row.querySelector('.batch-row-number');

            number.textContent =
                'Data SDM ' + (index + 1);

        });
    }


    /* =========================================================
       CLOSE MODAL
    ========================================================== */

    function closeSdmModal() {

        sdmModal.classList.remove('active');

        document.body.style.overflow = '';

        disableSdmEditInputs();
    }


    /* =========================================================
       CLICK OUTSIDE MODAL
    ========================================================== */

    function handleSdmOverlayClick(event) {

        if (event.target === sdmModal) {
            closeSdmModal();
        }
    }


    /* =========================================================
       ESCAPE
    ========================================================== */

    document.addEventListener('keydown', function(event) {

        if (
            event.key === 'Escape' &&
            sdmModal.classList.contains('active')
        ) {
            closeSdmModal();
        }

    });


    /* =========================================================
       DOUBLE SUBMIT
    ========================================================== */

    sdmForm.addEventListener('submit', function() {

        sdmSubmitButton.disabled = true;

        sdmSubmitButton.innerHTML =
            '<i class="bi bi-hourglass-split"></i> Menyimpan...';

    });


    /* =========================================================
       VALIDATION ERROR
       Buka kembali modal tambah jika validasi gagal.
    ========================================================== */

    @if($errors->any())

        document.addEventListener('DOMContentLoaded', function() {

            openSdmModal();

        });

    @endif

</script>

@endsection