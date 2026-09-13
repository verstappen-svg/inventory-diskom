@extends('layouts.app')

@section('title', 'Hardware')
@section('page-title', 'Hardware')

@section('content')

<style>
    .hardware-page {
        width: 100%;
        padding: 0;
    }

    .hardware-page-header {
        margin-bottom: 22px;
    }

    .hardware-page-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #202735;
    }

    .hardware-page-header p {
        margin: 6px 0 0;
        color: #8a93a3;
        font-size: 12px;
    }

    /* =========================
       ALERT
    ========================= */

    .hardware-alert {
        padding: 12px 16px;
        margin-bottom: 18px;
        border-radius: 8px;
        font-size: 12px;
    }

    .hardware-alert-success {
        background: #ecfdf3;
        color: #18794e;
        border: 1px solid #c7f0d8;
    }

    .hardware-alert-error {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
    }

    /* =========================
       SUMMARY CARD
    ========================= */

    .hardware-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }

    .hardware-summary-card {
        background: #fff;
        border: 1px solid #e8ebf0;
        border-radius: 10px;
        padding: 17px 18px;
        min-height: 92px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-sizing: border-box;
    }

    .hardware-summary-icon {
        width: 45px;
        height: 45px;
        min-width: 45px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .summary-icon-blue {
        background: #eaf2ff;
        color: #3b82f6;
    }

    .summary-icon-purple {
        background: #f1e8ff;
        color: #9333ea;
    }

    .summary-icon-orange {
        background: #fff4df;
        color: #f59e0b;
    }

    .summary-icon-red {
        background: #feecef;
        color: #dc2626;
    }

    .summary-icon-green {
        background: #e9f8ef;
        color: #16a34a;
    }

    .summary-icon-cyan {
        background: #e5f7fa;
        color: #0891b2;
    }

    .hardware-summary-content {
        min-width: 0;
    }

    .hardware-summary-label {
        font-size: 11px;
        color: #8992a3;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .hardware-summary-value {
        font-size: 22px;
        font-weight: 700;
        color: #252d3a;
        line-height: 1.15;
    }

    .hardware-summary-desc {
        margin-top: 4px;
        font-size: 10px;
        color: #a0a8b5;
    }

    /* =========================
       TOOLBAR
    ========================= */

    .hardware-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .hardware-toolbar-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 280px;
    }

    .hardware-search {
        position: relative;
        width: 320px;
        max-width: 100%;
    }

    .hardware-search input {
        width: 100%;
        height: 38px;
        padding: 0 14px 0 38px;
        border: 1px solid #dfe3e9;
        border-radius: 7px;
        outline: none;
        font-size: 12px;
        color: #374151;
        background: #fff;
        box-sizing: border-box;
    }

    .hardware-search input:focus {
        border-color: #aeb8c8;
    }

    .hardware-search i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #98a1b1;
        font-size: 14px;
    }

    .hardware-filter select {
        height: 38px;
        padding: 0 32px 0 12px;
        border: 1px solid #dfe3e9;
        border-radius: 7px;
        background: #fff;
        color: #4b5563;
        font-size: 12px;
        outline: none;
    }

    .hardware-btn-add {
        height: 38px;
        padding: 0 16px;
        border: none;
        border-radius: 7px;
        background: #2563eb;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .hardware-btn-add:hover {
        background: #1d4ed8;
    }

    /* =========================
       TABLE
    ========================= */

    .hardware-table-card {
        background: #fff;
        border: 1px solid #e8ebf0;
        border-radius: 10px;
        overflow: hidden;
    }

    /*
     * Tabel dibuat lebih lebar agar kolom tidak dempet.
     * Jika layar tidak cukup lebar, tabel bisa digeser horizontal.
     */
    .hardware-table-wrapper {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .hardware-table {
        width: 100%;
        min-width: 1550px;
        border-collapse: collapse;
        table-layout: auto;
    }

    .hardware-table thead th {
        height: 52px;
        padding: 0 14px;
        background: #fafbfc;
        border-bottom: 1px solid #e8ebf0;
        color: #697386;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        text-align: left;
        white-space: nowrap;
    }

    .hardware-table tbody td {
        padding: 14px;
        border-bottom: 1px solid #f0f2f5;
        color: #3f4859;
        font-size: 11px;
        vertical-align: middle;
    }

    .hardware-table tbody tr:last-child td {
        border-bottom: none;
    }

    .hardware-table tbody tr:hover {
        background: #fafcff;
    }

    /* =========================
       LEBAR KOLOM
    ========================= */

    .hardware-table th:nth-child(1),
    .hardware-table td:nth-child(1) {
        width: 120px;
        min-width: 120px;
    }

    .hardware-table th:nth-child(2),
    .hardware-table td:nth-child(2) {
        width: 190px;
        min-width: 190px;
    }

    .hardware-table th:nth-child(3),
    .hardware-table td:nth-child(3) {
        width: 350px;
        min-width: 350px;
        max-width: 350px;
    }

    .hardware-table th:nth-child(4),
    .hardware-table td:nth-child(4) {
        width: 140px;
        min-width: 140px;
    }

    .hardware-table th:nth-child(5),
    .hardware-table td:nth-child(5) {
        width: 190px;
        min-width: 190px;
    }

    .hardware-table th:nth-child(6),
    .hardware-table td:nth-child(6) {
        width: 160px;
        min-width: 160px;
    }

    .hardware-table th:nth-child(7),
    .hardware-table td:nth-child(7) {
        width: 130px;
        min-width: 130px;
    }

    .hardware-table th:nth-child(8),
    .hardware-table td:nth-child(8) {
        width: 160px;
        min-width: 160px;
    }

    .hardware-table th:nth-child(9),
    .hardware-table td:nth-child(9) {
        width: 130px;
        min-width: 130px;
    }

    .hardware-table th:nth-child(10),
    .hardware-table td:nth-child(10) {
        width: 130px;
        min-width: 130px;
    }

    .hardware-table th:nth-child(11),
    .hardware-table td:nth-child(11) {
        width: 110px;
        min-width: 110px;
    }

    .hardware-table th:nth-child(12),
    .hardware-table td:nth-child(12) {
        width: 110px;
        min-width: 110px;
    }

    /* =========================
       ISI TABEL
    ========================= */

    .asset-id {
        font-weight: 700;
        color: #2563eb;
        white-space: nowrap;
    }

    .hardware-name {
        font-weight: 600;
        color: #303847;
        line-height: 1.5;
    }

    /*
     * SPESIFIKASI:
     * Hanya 1 baris.
     * Kalau terlalu panjang otomatis menjadi ...
     */
    .hardware-spec {
        color: #687385;
        line-height: 1.5;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 350px;
    }

    .hardware-nowrap {
        white-space: nowrap;
    }

    .hardware-price {
        white-space: nowrap;
        font-weight: 600;
        color: #3d4655;
    }

    /* =========================
       BADGE
    ========================= */

    .hardware-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-baik {
        background: #ecfdf3;
        color: #15803d;
    }

    .badge-perbaikan {
        background: #fff7ed;
        color: #c2410c;
    }

    .badge-rusak {
        background: #fef2f2;
        color: #dc2626;
    }

    .badge-menunggu {
        background: #fff7ed;
        color: #c2410c;
    }

    .badge-disetujui {
        background: #ecfdf3;
        color: #15803d;
    }

    .badge-ditolak {
        background: #fef2f2;
        color: #dc2626;
    }

    /* =========================
       ACTION
    ========================= */

    .hardware-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .hardware-action-btn {
        width: 31px;
        height: 31px;
        border: 1px solid #e1e5eb;
        border-radius: 6px;
        background: #fff;
        color: #687385;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .hardware-action-btn:hover {
        background: #f8fafc;
    }

    .hardware-action-edit:hover {
        color: #2563eb;
        border-color: #bfdbfe;
    }

    .hardware-action-delete:hover {
        color: #dc2626;
        border-color: #fecaca;
    }

    .hardware-action-comment:hover {
        color: #7c3aed;
        border-color: #ddd6fe;
    }

    /* =========================
       EMPTY
    ========================= */

    .hardware-empty {
        text-align: center;
        padding: 45px 20px !important;
        color: #9aa3b2 !important;
    }

    /* =========================
       PAGINATION
    ========================= */

    .hardware-pagination {
        padding: 14px 18px;
        border-top: 1px solid #f0f2f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .hardware-pagination-info {
        font-size: 11px;
        color: #8a93a3;
    }

    .hardware-pagination-links {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .hardware-pagination-links a,
    .hardware-pagination-links span {
        min-width: 30px;
        height: 30px;
        padding: 0 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e6ec;
        border-radius: 6px;
        text-decoration: none;
        color: #697386;
        font-size: 11px;
        background: #fff;
    }

    .hardware-pagination-links .active span {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }

    .hardware-pagination-links .disabled span {
        color: #c1c7d0;
        background: #f9fafb;
    }

    /* =========================
       MODAL
    ========================= */

    .hardware-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, .48);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
}

.hardware-modal-overlay.show {
    display: flex;
}

    .hardware-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, .48);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
}

.hardware-modal-overlay.show {
    display: flex;
}

.hardware-modal {
    width: 100%;
    max-width: 1050px;
    height: 88vh;
    max-height: 88vh;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, .18);
    display: flex;
    flex-direction: column;
    min-height: 0;
}

/* PENTING */
.hardware-modal > form {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    min-height: 0;
    overflow: hidden;
}

.hardware-modal-header {
    padding: 18px 22px;
    border-bottom: 1px solid #edf0f4;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

.hardware-modal-header h3 {
    margin: 0;
    font-size: 16px;
    color: #252d3a;
}

.hardware-modal-close {
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    color: #8992a3;
    font-size: 20px;
    cursor: pointer;
    border-radius: 6px;
}

.hardware-modal-close:hover {
    background: #f3f4f6;
    color: #374151;
}

/* PENTING: BAGIAN INI YANG SCROLL */
.hardware-modal-body {
    padding: 20px 22px;
    overflow-y: auto;
    overflow-x: hidden;
    flex: 1 1 auto;
    min-height: 0;
    box-sizing: border-box;
    scrollbar-width: thin;
}

/* FOOTER TIDAK IKUT SCROLL */
.hardware-modal-footer {
    flex-shrink: 0;
    padding: 14px 22px;
    border-top: 1px solid #edf0f4;
    display: flex;
    justify-content: flex-end;
    gap: 9px;
    background: #fff;
}

    .hardware-form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .hardware-form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .hardware-form-group.full {
        grid-column: 1 / -1;
    }

    .hardware-form-section {
        border: 1px solid #e8ebf0;
        border-radius: 10px;
        padding: 18px;
        margin-bottom: 16px;
        background: #fff;
    }

    .hardware-form-section:last-child {
        margin-bottom: 0;
    }

    .hardware-form-section-title {
        margin: 0 0 16px;
        font-size: 13px;
        font-weight: 700;
        color: #374151;
    }

    .hardware-form-section-title span {
        display: block;
        margin-top: 3px;
        font-size: 10px;
        font-weight: 400;
        color: #a0a8b5;
    }

    .hardware-form-group input[readonly] {
        background: #f7f8fa;
        color: #8b95a5;
        cursor: not-allowed;
    }

    .hardware-required {
        color: #dc2626;
    }

    .hardware-form-group label {
        font-size: 11px;
        font-weight: 600;
        color: #4b5563;
    }

    .hardware-form-group input,
    .hardware-form-group select,
    .hardware-form-group textarea {
        width: 100%;
        border: 1px solid #dfe3e9;
        border-radius: 7px;
        padding: 10px 11px;
        font-size: 12px;
        color: #374151;
        outline: none;
        background: #fff;
        box-sizing: border-box;
    }

    .hardware-form-group input,
    .hardware-form-group select {
        height: 39px;
    }

    .hardware-form-group textarea {
        min-height: 90px;
        resize: vertical;
    }

    .hardware-form-group input:focus,
    .hardware-form-group select:focus,
    .hardware-form-group textarea:focus {
        border-color: #93b4f5;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
    }

    .hardware-form-error {
        color: #dc2626;
        font-size: 10px;
    }

    .hardware-modal-footer {
        padding: 14px 22px;
        border-top: 1px solid #edf0f4;
        display: flex;
        justify-content: flex-end;
        gap: 9px;
    }

    .hardware-btn-cancel,
    .hardware-btn-save {
        height: 37px;
        padding: 0 15px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .hardware-btn-cancel {
        background: #fff;
        border: 1px solid #dfe3e9;
        color: #697386;
    }

    .hardware-btn-save {
        background: #2563eb;
        border: 1px solid #2563eb;
        color: #fff;
    }

    .hardware-btn-save:hover {
        background: #1d4ed8;
    }

    /* =========================
       COMMENT MODAL
    ========================= */

    .comment-modal {
        max-width: 520px;
    }

    .comment-content {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 13px;
        font-size: 12px;
        color: #4b5563;
        line-height: 1.6;
        white-space: pre-wrap;
        word-break: break-word;
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 900px) {

        .hardware-summary {
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media (max-width: 650px) {

        .hardware-summary {
            grid-template-columns: 1fr;
        }

        .hardware-toolbar-left {
            flex-direction: column;
            align-items: stretch;
        }

        .hardware-search {
            width: 100%;
        }

        .hardware-filter {
            width: 100%;
        }

        .hardware-filter select {
            width: 100%;
        }

        .hardware-form-grid {
            grid-template-columns: 1fr;
        }

        .hardware-form-group.full {
            grid-column: auto;
        }

    }
</style>


<div class="hardware-page">

    {{-- HEADER --}}
    <div class="hardware-page-header">

        <h2>Hardware</h2>

        <p>
            Kelola data inventaris hardware perangkat
        </p>

    </div>


    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="hardware-alert hardware-alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- ALERT ERROR --}}
    @if(session('error'))

        <div class="hardware-alert hardware-alert-error">
            {{ session('error') }}
        </div>

    @endif


    {{-- VALIDATION ERROR --}}
    @if($errors->any())

        <div class="hardware-alert hardware-alert-error">

            <strong>Terjadi kesalahan:</strong>

            <ul style="margin: 6px 0 0 18px; padding: 0;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- SUMMARY --}}
    @php

        $hardwareData = $hardwares->getCollection();

        $jumlahBarang = $hardwareData->count();

        $totalHarga = $hardwareData->sum(
            fn($item) => (float) $item->harga
        );

        $jumlahPerbaikan =
            $hardwareData
                ->where('kondisi', 'Perlu Perbaikan')
                ->count();

        $jumlahRusak =
            $hardwareData
                ->where('kondisi', 'Rusak')
                ->count();

    @endphp


    <div class="hardware-summary">

        <div class="hardware-summary-card">
            <div class="hardware-summary-icon summary-icon-blue">
                <i class="bi bi-pc-display"></i>
            </div>
            <div class="hardware-summary-content">
                <div class="hardware-summary-label">Jumlah Barang</div>
                <div class="hardware-summary-value">{{ $jumlahBarang }}</div>
                <div class="hardware-summary-desc">Total aset hardware</div>
            </div>
        </div>

        <div class="hardware-summary-card">
            <div class="hardware-summary-icon summary-icon-purple">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="hardware-summary-content">
                <div class="hardware-summary-label">Harga Barang</div>
                <div class="hardware-summary-value">Rp {{ number_format($totalHarga, 0, ',', '.') }}</div>
                <div class="hardware-summary-desc">Total nilai hardware</div>
            </div>
        </div>

        <div class="hardware-summary-card">
            <div class="hardware-summary-icon summary-icon-orange">
                <i class="bi bi-tools"></i>
            </div>
            <div class="hardware-summary-content">
                <div class="hardware-summary-label">Perlu Perbaikan</div>
                <div class="hardware-summary-value">{{ $jumlahPerbaikan }}</div>
                <div class="hardware-summary-desc">Hardware perlu diperbaiki</div>
            </div>
        </div>

        <div class="hardware-summary-card">
            <div class="hardware-summary-icon summary-icon-red">
                <i class="bi bi-x-octagon-fill"></i>
            </div>
            <div class="hardware-summary-content">
                <div class="hardware-summary-label">Rusak</div>
                <div class="hardware-summary-value">{{ $jumlahRusak }}</div>
                <div class="hardware-summary-desc">Hardware dalam kondisi rusak</div>
            </div>
        </div>

        <div class="hardware-summary-card">
            <div class="hardware-summary-icon summary-icon-green">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="hardware-summary-content">
                <div class="hardware-summary-label">Tersedia</div>
                <div class="hardware-summary-value">{{ $jumlahBarang - $jumlahRusak }}</div>
                <div class="hardware-summary-desc">Hardware siap digunakan</div>
            </div>
        </div>

        <div class="hardware-summary-card">
            <div class="hardware-summary-icon summary-icon-cyan">
                <i class="bi bi-calendar3"></i>
            </div>
            <div class="hardware-summary-content">
                <div class="hardware-summary-label">Tahun Pembelian Terbaru</div>
                <div class="hardware-summary-value">
                    {{ $hardwareData->max('tahun_pembelian') ?? '-' }}
                </div>
                <div class="hardware-summary-desc">Tahun pembelian terakhir</div>
            </div>
        </div>

    </div>


    {{-- TOOLBAR --}}
    <div class="hardware-toolbar">

        <div class="hardware-toolbar-left">

            {{-- SEARCH --}}
            <form
                method="GET"
                action="{{ route('hardware.index') }}"
                class="hardware-search"
            >

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari hardware..."
                >

            </form>


            {{-- FILTER --}}
            <div class="hardware-filter">

                <select id="conditionFilter">

                    <option value="">
                        Semua Kondisi
                    </option>

                    <option value="Baik">
                        Baik
                    </option>

                    <option value="Perlu Perbaikan">
                        Perlu Perbaikan
                    </option>

                    <option value="Rusak">
                        Rusak
                    </option>

                </select>

            </div>

        </div>


        {{-- AKSI --}}
<div style="display:flex; gap:8px; align-items:center;">

    {{-- IMPORT --}}
    <button
        type="button"
        class="hardware-btn-add"
        onclick="openImportModal()"
        style="background:#16a34a;"
    >
        <i class="bi bi-file-earmark-excel"></i>
        Import Data
    </button>

    {{-- TAMBAH --}}
    <button
        type="button"
        class="hardware-btn-add"
        onclick="openHardwareModal()"
    >
        <i class="bi bi-plus-lg"></i>
        Tambah Hardware
    </button>

</div>

    </div>


    {{-- TABLE --}}
    <div class="hardware-table-card">

        <div class="hardware-table-wrapper">

            <table class="hardware-table">

                <thead>

                    <tr>

                        <th>Asset ID</th>

                        <th>Nama Barang</th>

                        <th>Spesifikasi</th>

                        <th>Jenis Barang</th>

                        <th>Lokasi</th>

                        <th>Sistem Operasi</th>

                        <th>Tahun Pembelian</th>

                        <th>Harga</th>

                        <th>Kondisi</th>

                        <th>Verifikasi</th>

                        <th>Komentar</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($hardwares as $hardware)

                        @php

                            $verification =
                                $hardware->latestVerificationRequest;

                            $verificationStatus =
                                $verification->status ?? 'menunggu';

                            $statusClass = match(
                                strtolower($verificationStatus)
                            ) {

                                'disetujui' =>
                                    'badge-disetujui',

                                'ditolak' =>
                                    'badge-ditolak',

                                default =>
                                    'badge-menunggu',

                            };


                            $conditionClass = match(
                                $hardware->kondisi
                            ) {

                                'Baik' =>
                                    'badge-baik',

                                'Perlu Perbaikan' =>
                                    'badge-perbaikan',

                                'Rusak' =>
                                    'badge-rusak',

                                default =>
                                    '',

                            };

                        @endphp


                        <tr
                            data-condition="{{ $hardware->kondisi }}"
                            data-search="{{ strtolower(
                                $hardware->asset_id . ' ' .
                                $hardware->nama_barang . ' ' .
                                $hardware->spesifikasi . ' ' .
                                $hardware->jenis_barang . ' ' .
                                ($hardware->lokasi->nama_lokasi ?? '') . ' ' .
                                ($hardware->sistem_operasi ?? '') . ' ' .
                                $hardware->tahun_pembelian . ' ' .
                                $hardware->kondisi
                            ) }}"
                        >

                            {{-- ASSET ID --}}
                            <td>

                                <span class="asset-id">
                                    {{ $hardware->asset_id }}
                                </span>

                            </td>


                            {{-- NAMA --}}
                            <td>

                                <div class="hardware-name">
                                    {{ $hardware->nama_barang }}
                                </div>

                            </td>


                            {{-- SPESIFIKASI --}}
                            <td>

                                <div
                                    class="hardware-spec"
                                    title="{{ $hardware->spesifikasi }}"
                                >
                                    {{ $hardware->spesifikasi }}
                                </div>

                            </td>


                            {{-- JENIS --}}
                            <td>

                                <span class="hardware-nowrap">
                                    {{ $hardware->jenis_barang }}
                                </span>

                            </td>


                            {{-- LOKASI --}}
                            <td>

                                <span class="hardware-nowrap">
                                    {{ $hardware->lokasi->nama_lokasi ?? '-' }}
                                </span>

                            </td>


                            {{-- SISTEM OPERASI --}}
                            <td>

                                <span class="hardware-nowrap">
                                    {{ $hardware->sistem_operasi ?? 'N/A' }}
                                </span>

                            </td>


                            {{-- TAHUN --}}
                            <td>

                                <span class="hardware-nowrap">
                                    {{ $hardware->tahun_pembelian }}
                                </span>

                            </td>


                            {{-- HARGA --}}
                            <td>

                                <span class="hardware-price">
                                    Rp {{ number_format($hardware->harga, 0, ',', '.') }}
                                </span>

                            </td>


                            {{-- KONDISI --}}
                            <td>

                                <span
                                    class="hardware-badge {{ $conditionClass }}"
                                >
                                    {{ $hardware->kondisi }}
                                </span>

                            </td>


                            {{-- VERIFIKASI --}}
                            <td>

                                <span
                                    class="hardware-badge {{ $statusClass }}"
                                >
                                    {{ ucfirst($verificationStatus) }}
                                </span>

                            </td>


                            {{-- KOMENTAR --}}
                            <td>

                                @if(
                                    $verification &&
                                    (
                                        $verification->catatan ||
                                        $verification->rejection_reason
                                    )
                                )

                                    <button
                                        type="button"
                                        class="hardware-action-btn hardware-action-comment"
                                        title="Lihat komentar"
                                        onclick="openCommentModal(
                                            @js($hardware->asset_id),
                                            @js(
                                                $verification->rejection_reason
                                                ?? $verification->catatan
                                            )
                                        )"
                                    >

                                        <i class="bi bi-chat-left-text"></i>

                                    </button>

                                @else

                                    <span style="color:#b5bdc9;">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <div class="hardware-actions">

                                    {{-- EDIT --}}
                                    <button
                                        type="button"
                                        class="hardware-action-btn hardware-action-edit"
                                        title="Edit"
                                        onclick="openEditModal(
                                            @js($hardware->asset_id),
                                            @js($hardware->nama_barang),
                                            @js($hardware->spesifikasi),
                                            @js($hardware->jenis_barang),
                                            @js($hardware->lokasi_id),
                                            @js($hardware->sistem_operasi),
                                            @js($hardware->tahun_pembelian),
                                            @js($hardware->harga),
                                            @js($hardware->kondisi)
                                        )"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </button>


                                    {{-- DELETE --}}
                                    <form
                                        method="POST"
                                        action="{{ route('hardware.destroy', $hardware->asset_id) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus hardware ini?')"
                                        style="display:inline;"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="hardware-action-btn hardware-action-delete"
                                            title="Hapus"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="12"
                                class="hardware-empty"
                            >

                                <i
                                    class="bi bi-inbox"
                                    style="
                                        font-size:30px;
                                        display:block;
                                        margin-bottom:10px;
                                    "
                                ></i>

                                Belum ada data hardware.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if(
            $hardwares->hasPages() ||
            $hardwares->total() > 0
        )

            <div class="hardware-pagination">

                <div class="hardware-pagination-info">

                    Menampilkan
                    {{ $hardwares->firstItem() ?? 0 }}
                    -
                    {{ $hardwares->lastItem() ?? 0 }}
                    dari
                    {{ $hardwares->total() }}
                    data

                </div>


                <div class="hardware-pagination-links">

                    {!! $hardwares->onEachSide(1)->links() !!}

                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH HARDWARE
========================================================= --}}

<div
    id="hardwareFormOverlay"
    class="hardware-modal-overlay"
>

    <div class="hardware-modal">

        <div class="hardware-modal-header">

            <div style="display:flex; align-items:center; gap:12px;">
                <div style="
                    width:40px;
                    height:40px;
                    border-radius:10px;
                    background:#eaf2ff;
                    color:#3b82f6;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:18px;
                    flex-shrink:0;
                ">
                    <i class="bi bi-pc-display"></i>
                </div>

                <div>
                    <h3>Tambah Hardware</h3>
                    <div style="
                        margin-top:4px;
                        font-size:10px;
                        color:#a0a8b5;
                    ">
                        Tambahkan data hardware baru.
                    </div>
                </div>
            </div>

            <button
                type="button"
                class="hardware-modal-close"
                onclick="closeHardwareModal()"
            >
                &times;
            </button>

        </div>


        <form
            id="hardwareForm"
            method="POST"
            action="{{ route('hardware.store') }}"
        >

            @csrf

            <div class="hardware-modal-body">

                {{-- INFORMASI HARDWARE --}}
                <div class="hardware-form-section">
                    <h4 class="hardware-form-section-title">
                        Informasi Hardware
                    </h4>

                    <div class="hardware-form-grid">

                        {{-- ASSET ID --}}
                        <div class="hardware-form-group">
                            <label for="asset_id">
                                Asset ID
                            </label>

                            <input
                                type="text"
                                id="asset_id"
                                value="Otomatis dibuat oleh sistem"
                                readonly
                            >

                            <div style="font-size:10px; color:#a0a8b5;">
                                Asset ID akan dibuat otomatis saat data disimpan.
                            </div>
                        </div>

                        {{-- NAMA --}}
                        <div class="hardware-form-group">
                            <label for="nama_barang">
                                Nama Barang <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="text"
                                id="nama_barang"
                                name="nama_barang"
                                value="{{ old('nama_barang') }}"
                                placeholder="Contoh: Laptop"
                                required
                            >
                        </div>

                        {{-- JENIS --}}
                        <div class="hardware-form-group">
                            <label for="jenis_barang">
                                Jenis Barang <span class="hardware-required">*</span>
                            </label>

                            <select
                                id="jenis_barang"
                                name="jenis_barang"
                                required
                            >
                            <option value="PC All in One">PC All in One</option>
                            <option value="PC Desktop">PC Desktop</option>
                            <option value="Laptop">Laptop</option>
                            <option value="NoteBook">NoteBook</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Smartphone">Smartphone</option>
                            <option value="Printer">Printer</option>
                            <option value="Scanner">Scanner</option>
                            <option value="Monitor">Monitor</option>
                            <option value="CCTV">CCTV</option>
                            <option value="Kamera">Kamera</option>
                            <option value="Perangkat Audio">Perangkat Audio</option>
                            <option value="Perangkat Video">Perangkat Video</option>
                            <option value="Perangkat Komunikasi">Perangkat Komunikasi</option>
                            <option value="Perangkat Pendukung">Perangkat Pendukung</option>
                            <option value="Lainnya">Lainnya</option>
                            </select>

                            <input
                                type="text"
                                id="jenis_barang_lainnya"
                                placeholder="Masukkan jenis barang"
                                style="display:none;"
                            >
                        </div>

                        {{-- KONDISI --}}
                        <div class="hardware-form-group">
                            <label for="kondisi">
                                Kondisi <span class="hardware-required">*</span>
                            </label>

                            <select
                                id="kondisi"
                                name="kondisi"
                                required
                            >
                                <option value="">Pilih Kondisi</option>
                                <option value="Baik" {{ old('kondisi') === 'Baik' ? 'selected' : '' }}>
                                    Baik
                                </option>
                                <option value="Perlu Perbaikan" {{ old('kondisi') === 'Perlu Perbaikan' ? 'selected' : '' }}>
                                    Perlu Perbaikan
                                </option>
                                <option value="Rusak" {{ old('kondisi') === 'Rusak' ? 'selected' : '' }}>
                                    Rusak
                                </option>
                            </select>
                        </div>

                        {{-- LOKASI --}}
                        <div class="hardware-form-group">
                            <label for="lokasi_id">
                                Lokasi <span class="hardware-required">*</span>
                            </label>

                            <select
                                id="lokasi_id"
                                name="lokasi_id"
                                required
                            >
                                <option value="">Pilih Lokasi</option>

                                @foreach($lokasis as $lokasi)
                                    <option
                                        value="{{ $lokasi->id }}"
                                        {{ old('lokasi_id') == $lokasi->id ? 'selected' : '' }}
                                    >
                                        {{ $lokasi->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- SISTEM OPERASI --}}
<div class="hardware-form-group">

    <label for="edit_sistem_operasi">
        Sistem Operasi
    </label>

    <select
        id="edit_sistem_operasi"
        name="sistem_operasi"
    >
        <option value="">Pilih Sistem Operasi</option>

        <option value="Windows 11">
            Windows 11
        </option>

        <option value="Windows 10">
            Windows 10
        </option>

        <option value="Windows 7">
            Windows 7
        </option>

        <option value="Linux">
            Linux
        </option>

        <option value="Ubuntu">
            Ubuntu
        </option>

        <option value="macOS">
            macOS
        </option>

        <option value="Android">
            Android
        </option>

        <option value="iOS">
            iOS
        </option>

        <option value="N/A">
            N/A
        </option>
    </select>

</div>

</div> {{-- tutup hardware-form-grid --}}

</div> {{-- tutup hardware-form-section Informasi Hardware --}}


{{-- DETAIL PEMBELIAN --}}
                {{-- DETAIL PEMBELIAN --}}
                <div class="hardware-form-section">
                    <h4 class="hardware-form-section-title">
                        Detail Pembelian
                    </h4>

                    <div class="hardware-form-grid">

                        {{-- TAHUN --}}
                        <div class="hardware-form-group">
                            <label for="tahun_pembelian">
                                Tahun Pembelian <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="number"
                                id="tahun_pembelian"
                                name="tahun_pembelian"
                                value="{{ old('tahun_pembelian') }}"
                                min="1900"
                                max="2100"
                                placeholder="Contoh: 2025"
                                required
                            >
                        </div>

                        {{-- HARGA --}}
                        <div class="hardware-form-group">
                            <label for="harga">
                                Harga <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="number"
                                id="harga"
                                name="harga"
                                value="{{ old('harga') }}"
                                min="0"
                                step="0.01"
                                placeholder="Contoh: 10000000"
                                required
                            >
                        </div>

                    </div>
                </div>

                {{-- SPESIFIKASI --}}
                <div class="hardware-form-section">
                    <h4 class="hardware-form-section-title">
                        Spesifikasi
                    </h4>

                    <div class="hardware-form-group">
                        <label for="spesifikasi">
                            Spesifikasi <span class="hardware-required">*</span>
                        </label>

                        <textarea
                            id="spesifikasi"
                            name="spesifikasi"
                            placeholder="Contoh: Intel Core i5, RAM 8GB, SSD 512GB, Lenovo ThinkPad..."
                            required
                        >{{ old('spesifikasi') }}</textarea>
                    </div>
                </div>

            </div>

            <div class="hardware-modal-footer">

                <button
                    type="button"
                    class="hardware-btn-cancel"
                    onclick="closeHardwareModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="hardware-btn-save"
                >
                    <i class="bi bi-check-lg"></i>
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     MODAL IMPORT HARDWARE
========================================================= --}}

<div
    id="importHardwareOverlay"
    class="hardware-modal-overlay"
>

    <div
        class="hardware-modal"
        style="max-width:650px; height:auto; max-height:90vh;"
    >

        <div class="hardware-modal-header">

            <div style="display:flex; align-items:center; gap:12px;">

                <div style="
                    width:40px;
                    height:40px;
                    border-radius:10px;
                    background:#ecfdf3;
                    color:#16a34a;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:18px;
                    flex-shrink:0;
                ">
                    <i class="bi bi-file-earmark-excel"></i>
                </div>

                <div>

                    <h3>Import Data Hardware</h3>

                    <div style="
                        margin-top:4px;
                        font-size:10px;
                        color:#a0a8b5;
                    ">
                        Import data hardware secara massal melalui Excel atau CSV.
                    </div>

                </div>

            </div>


            <button
                type="button"
                class="hardware-modal-close"
                onclick="closeImportModal()"
            >
                &times;
            </button>

        </div>


        <form
            method="POST"
            action="{{ route('hardware.import') }}"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="hardware-modal-body">

                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Pilih File
                        <span>
                            Gunakan file Excel (.xlsx) atau CSV (.csv).
                        </span>
                    </h4>


                    <div class="hardware-form-group">

                        <label for="import_file">
                            File Data Hardware
                            <span class="hardware-required">*</span>
                        </label>

                        <input
                            type="file"
                            id="import_file"
                            name="file"
                            accept=".xlsx,.csv"
                            required
                        >

                        <div style="
                            margin-top:6px;
                            font-size:10px;
                            color:#8a93a3;
                            line-height:1.6;
                        ">
                            Maksimal ukuran file 10 MB.
                        </div>

                    </div>

                </div>


                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Format Kolom
                        <span>
                            Urutan kolom harus mengikuti format berikut.
                        </span>
                    </h4>


                    <div style="
                        background:#f8fafc;
                        border:1px solid #e5e7eb;
                        border-radius:8px;
                        padding:13px;
                        font-size:11px;
                        color:#4b5563;
                        line-height:1.8;
                    ">

                        <strong>Kolom yang diperlukan:</strong>

                        <ol style="
                            margin:7px 0 0 18px;
                            padding:0;
                        ">

                            <li>Nama Barang</li>
                            <li>Lokasi</li>
                            <li>Spesifikasi</li>
                            <li>Jenis barang</li>
                            <li>Sistem Operasi</li>
                            <li>Tahun Perolehan</li>
                            <li>Harga (Rp)</li>
                            <li>Kondisi</li>

                        </ol>

                    </div>

                </div>


                <div
                    style="
                        background:#eff6ff;
                        border:1px solid #dbeafe;
                        border-radius:8px;
                        padding:12px 13px;
                        font-size:11px;
                        color:#1e40af;
                        line-height:1.6;
                    "
                >

                    <i class="bi bi-info-circle"></i>

                    Asset ID akan dibuat otomatis oleh sistem.
                    Data hasil import juga akan masuk ke proses
                    <strong>menunggu verifikasi</strong>.

                </div>

            </div>


            <div class="hardware-modal-footer">

                <button
                    type="button"
                    class="hardware-btn-cancel"
                    onclick="closeImportModal()"
                >
                    Batal
                </button>


                <button
                    type="submit"
                    class="hardware-btn-save"
                    style="
                        background:#16a34a;
                        border-color:#16a34a;
                    "
                >
                    <i class="bi bi-upload"></i>
                    Import Data
                </button>

            </div>

        </form>

    </div>

</div>

{{-- =========================================================
     MODAL EDIT HARDWARE
========================================================= --}}

<div
    id="editHardwareOverlay"
    class="hardware-modal-overlay"
>

    <div class="hardware-modal">

        <div class="hardware-modal-header">

            <h3>
                Edit Hardware
            </h3>

            <button
                type="button"
                class="hardware-modal-close"
                onclick="closeEditModal()"
            >
                &times;
            </button>

        </div>


        <form
            id="editHardwareForm"
            method="POST"
        >

            @csrf

            @method('PUT')

            <div class="hardware-modal-body">

                <div class="hardware-form-grid">

                    {{-- NAMA --}}
                    <div class="hardware-form-group">

                        <label for="edit_nama_barang">
                            Nama Barang
                        </label>

                        <input
                            type="text"
                            id="edit_nama_barang"
                            name="nama_barang"
                            required
                        >

                    </div>


                    {{-- JENIS --}}
                    <div class="hardware-form-group">

                        <label for="edit_jenis_barang">
                            Jenis Barang
                        </label>

                        <select
                            id="edit_jenis_barang"
                            name="jenis_barang"
                            required
                        >

                            <option value="">
                                Pilih Jenis Barang
                            </option>

                            <option value="PC All in One">PC All in One</option>
                            <option value="PC Desktop">PC Desktop</option>
                            <option value="Laptop">Laptop</option>
                            <option value="NoteBook">NoteBok</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Smartphone">Smartphone</option>
                            <option value="Printer">Printer</option>
                            <option value="Scanner">Scanner</option>
                            <option value="Monitor">Monitor</option>
                            <option value="CCTV">CCTV</option>
                            <option value="Kamera">Kamera</option>
                            <option value="Perangkat Audio">Perangkat Audio</option>
                            <option value="Perangkat Video">Perangkat Video</option>
                            <option value="Perangkat Komunikasi">Perangkat Komunikasi</option>
                            <option value="Perangkat Pendukung">Perangkat Pendukung</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>


                        <input
                            type="text"
                            id="edit_jenis_barang_lainnya"
                            placeholder="Masukkan jenis barang"
                            style="display:none;"
                        >

                    </div>


                    {{-- SPESIFIKASI --}}
                    <div class="hardware-form-group full">

                        <label for="edit_spesifikasi">
                            Spesifikasi
                        </label>

                        <textarea
                            id="edit_spesifikasi"
                            name="spesifikasi"
                            required
                        ></textarea>

                    </div>


                    {{-- LOKASI --}}
                    <div class="hardware-form-group">

                        <label for="edit_lokasi_id">
                            Lokasi
                        </label>

                        <select
                            id="edit_lokasi_id"
                            name="lokasi_id"
                            required
                        >

                            <option value="">
                                Pilih Lokasi
                            </option>

                            @foreach($lokasis as $lokasi)

                                <option value="{{ $lokasi->id }}">
                                    {{ $lokasi->nama_lokasi }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- SISTEM OPERASI --}}
                    <div class="hardware-form-group">

                        <label for="edit_sistem_operasi">
                            Sistem Operasi
                        </label>

                        <input
                            type="text"
                            id="edit_sistem_operasi"
                            name="sistem_operasi"
                            placeholder="Contoh: Windows 11 / Linux / N/A"
                        >

                    </div>


                    {{-- TAHUN --}}
                    <div class="hardware-form-group">

                        <label for="edit_tahun_pembelian">
                            Tahun Pembelian
                        </label>

                        <input
                            type="number"
                            id="edit_tahun_pembelian"
                            name="tahun_pembelian"
                            min="1900"
                            max="2100"
                            required
                        >

                    </div>


                    {{-- HARGA --}}
                    <div class="hardware-form-group">

                        <label for="edit_harga">
                            Harga
                        </label>

                        <input
                            type="number"
                            id="edit_harga"
                            name="harga"
                            min="0"
                            step="0.01"
                            required
                        >

                    </div>


                    {{-- KONDISI --}}
                    <div class="hardware-form-group">

                        <label for="edit_kondisi">
                            Kondisi
                        </label>

                        <select
                            id="edit_kondisi"
                            name="kondisi"
                            required
                        >

                            <option value="">
                                Pilih Kondisi
                            </option>

                            <option value="Baik">
                                Baik
                            </option>

                            <option value="Perlu Perbaikan">
                                Perlu Perbaikan
                            </option>

                            <option value="Rusak">
                                Rusak
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            <div class="hardware-modal-footer">

                <button
                    type="button"
                    class="hardware-btn-cancel"
                    onclick="closeEditModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="hardware-btn-save"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     MODAL KOMENTAR
========================================================= --}}

<div
    id="commentModalOverlay"
    class="hardware-modal-overlay"
>

    <div class="hardware-modal comment-modal">

        <div class="hardware-modal-header">

            <h3>
                Komentar Verifikasi
            </h3>

            <button
                type="button"
                class="hardware-modal-close"
                onclick="closeCommentModal()"
            >
                &times;
            </button>

        </div>


        <div class="hardware-modal-body">

            <div
                style="
                    font-size:11px;
                    color:#8a93a3;
                    margin-bottom:8px;
                "
            >
                Asset ID
            </div>


            <div
                id="commentAssetId"
                style="
                    font-size:13px;
                    font-weight:700;
                    color:#2563eb;
                    margin-bottom:16px;
                "
            >
            </div>


            <div
                class="comment-content"
                id="commentContent"
            >
            </div>

        </div>


        <div class="hardware-modal-footer">

            <button
                type="button"
                class="hardware-btn-cancel"
                onclick="closeCommentModal()"
            >
                Tutup
            </button>

        </div>

    </div>

</div>


<script>

    /* =====================================================
   IMPORT HARDWARE
===================================================== */

function openImportModal() {

    const overlay =
        document.getElementById(
            'importHardwareOverlay'
        );

    if (overlay) {

        overlay.classList.add('show');

        document.body.style.overflow =
            'hidden';

    }

}


function closeImportModal() {

    const overlay =
        document.getElementById(
            'importHardwareOverlay'
        );

    if (overlay) {

        overlay.classList.remove('show');

        document.body.style.overflow =
            '';

    }

}

    /* =====================================================
       TAMBAH HARDWARE
    ===================================================== */

    function openHardwareModal() {

        const overlay =
            document.getElementById(
                'hardwareFormOverlay'
            );

        if (overlay) {

            overlay.classList.add('show');

            document.body.style.overflow =
                'hidden';

        }

    }


    function closeHardwareModal() {

        const overlay =
            document.getElementById(
                'hardwareFormOverlay'
            );

        if (overlay) {

            overlay.classList.remove('show');

            document.body.style.overflow =
                '';

        }

    }


    /* =====================================================
       EDIT HARDWARE
    ===================================================== */

    function openEditModal(
        assetId,
        namaBarang,
        spesifikasi,
        jenisBarang,
        lokasiId,
        sistemOperasi,
        tahunPembelian,
        harga,
        kondisi
    ) {

        const overlay =
            document.getElementById(
                'editHardwareOverlay'
            );

        const form =
            document.getElementById(
                'editHardwareForm'
            );


        document.getElementById(
            'edit_nama_barang'
        ).value = namaBarang ?? '';


        document.getElementById(
            'edit_spesifikasi'
        ).value = spesifikasi ?? '';


        document.getElementById(
            'edit_jenis_barang'
        ).value = jenisBarang ?? '';


        document.getElementById(
            'edit_lokasi_id'
        ).value = lokasiId ?? '';


        document.getElementById(
            'edit_sistem_operasi'
        ).value = sistemOperasi ?? '';


        document.getElementById(
            'edit_tahun_pembelian'
        ).value = tahunPembelian ?? '';


        document.getElementById(
            'edit_harga'
        ).value = harga ?? '';


        document.getElementById(
            'edit_kondisi'
        ).value = kondisi ?? '';


        if (form) {

            form.action =
                "{{ url('/hardware') }}/" +
                encodeURIComponent(assetId);

        }


        handleEditJenisBarang();


        if (overlay) {

            overlay.classList.add('show');

            document.body.style.overflow =
                'hidden';

        }

    }


    function closeEditModal() {

        const overlay =
            document.getElementById(
                'editHardwareOverlay'
            );

        if (overlay) {

            overlay.classList.remove('show');

            document.body.style.overflow =
                '';

        }

    }


    /* =====================================================
       JENIS BARANG
    ===================================================== */

    function handleJenisBarang() {

        const select =
            document.getElementById(
                'jenis_barang'
            );

        const lainnya =
            document.getElementById(
                'jenis_barang_lainnya'
            );


        if (!select || !lainnya) return;


        if (select.value === 'Lainnya') {

            lainnya.style.display =
                'block';

            lainnya.name =
                'jenis_barang';

            select.removeAttribute(
                'name'
            );

            lainnya.required =
                true;

        } else {

            lainnya.style.display =
                'none';

            lainnya.removeAttribute(
                'name'
            );

            lainnya.required =
                false;

            select.name =
                'jenis_barang';

        }

    }


    function handleEditJenisBarang() {

        const select =
            document.getElementById(
                'edit_jenis_barang'
            );

        const lainnya =
            document.getElementById(
                'edit_jenis_barang_lainnya'
            );


        if (!select || !lainnya) return;


        if (select.value === 'Lainnya') {

            lainnya.style.display =
                'block';

            lainnya.name =
                'jenis_barang';

            select.removeAttribute(
                'name'
            );

            lainnya.required =
                true;

        } else {

            lainnya.style.display =
                'none';

            lainnya.removeAttribute(
                'name'
            );

            lainnya.required =
                false;

            select.name =
                'jenis_barang';

        }

    }


    const jenisBarang =
        document.getElementById(
            'jenis_barang'
        );


    if (jenisBarang) {

        jenisBarang.addEventListener(
            'change',
            handleJenisBarang
        );

    }


    const editJenisBarang =
        document.getElementById(
            'edit_jenis_barang'
        );


    if (editJenisBarang) {

        editJenisBarang.addEventListener(
            'change',
            handleEditJenisBarang
        );

    }


    /* =====================================================
       FILTER KONDISI
    ===================================================== */

    const conditionFilter =
        document.getElementById(
            'conditionFilter'
        );


    if (conditionFilter) {

        conditionFilter.addEventListener(
            'change',
            function () {

                const selected =
                    this.value.toLowerCase();


                document
                    .querySelectorAll(
                        '.hardware-table tbody tr'
                    )
                    .forEach(
                        function (row) {

                            const condition =
                                (
                                    row.dataset.condition ||
                                    ''
                                ).toLowerCase();


                            if (
                                !selected ||
                                condition === selected
                            ) {

                                row.style.display =
                                    '';

                            } else {

                                row.style.display =
                                    'none';

                            }

                        }
                    );

            }
        );

    }


    /* =====================================================
       COMMENT MODAL
    ===================================================== */

    function openCommentModal(
        assetId,
        comment
    ) {

        const overlay =
            document.getElementById(
                'commentModalOverlay'
            );

        const assetElement =
            document.getElementById(
                'commentAssetId'
            );

        const commentElement =
            document.getElementById(
                'commentContent'
            );


        if (assetElement) {

            assetElement.textContent =
                assetId;

        }


        if (commentElement) {

            commentElement.textContent =
                comment ||
                'Tidak ada komentar.';

        }


        if (overlay) {

            overlay.classList.add('show');

            document.body.style.overflow =
                'hidden';

        }

    }


    function closeCommentModal() {

        const overlay =
            document.getElementById(
                'commentModalOverlay'
            );


        if (overlay) {

            overlay.classList.remove(
                'show'
            );

            document.body.style.overflow =
                '';

        }

    }


    /* =====================================================
       CLICK OUTSIDE MODAL
    ===================================================== */

    document.addEventListener(
        'click',
        function (event) {

            const addOverlay =
                document.getElementById(
                    'hardwareFormOverlay'
                );

            const importOverlay =
            document.getElementById(
                'importHardwareOverlay'
            );

            const editOverlay =
                document.getElementById(
                    'editHardwareOverlay'
                );

            const commentOverlay =
                document.getElementById(
                    'commentModalOverlay'
                );


            if (
                event.target === addOverlay
            ) {

                closeHardwareModal();

            }

            if (
                event.target === importOverlay
            ) {
                closeImportModal();
            
            }

            if (
                event.target === editOverlay
            ) {

                closeEditModal();

            }


            if (
                event.target === commentOverlay
            ) {

                closeCommentModal();

            }

        }
    );


    /* =====================================================
       ESC CLOSE MODAL
    ===================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key !== 'Escape'
            ) return;


            closeHardwareModal();

            closeImportModal();

            closeEditModal();

            closeCommentModal();

        }
    );


    /* =====================================================
       AUTO OPEN MODAL JIKA VALIDATION ERROR
    ===================================================== */

    @if($errors->any())

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                openHardwareModal();

            }
        );

    @endif

</script>

@endsection