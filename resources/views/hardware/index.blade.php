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
        font-size: 24px;
        font-weight: 700;
        color: #172033;
        line-height: 1.25;
    }

    .hardware-page-header p {
        margin: 6px 0 0;
        font-size: 13px;
        color: #7b8495;
    }

    .hardware-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
    }

    .hardware-alert-success {
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .hardware-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .hardware-alert i {
        margin-top: 1px;
        font-size: 16px;
    }

    /* =========================
       STATISTICS
    ========================= */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .stat-card {
        min-height: 135px;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #e7eaf0;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(16, 24, 40, 0.04);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(16, 24, 40, 0.07);
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        min-width: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-icon.blue {
        background: #eaf2ff;
        color: #2563eb;
    }

    .stat-icon.purple {
        background: #f2eaff;
        color: #7c3aed;
    }

    .stat-icon.orange {
        background: #fff3df;
        color: #f59e0b;
    }

    .stat-icon.red {
        background: #feecec;
        color: #dc2626;
    }

    .stat-icon.green {
        background: #eaf9f0;
        color: #16a34a;
    }

    .stat-icon.cyan {
        background: #e7f8fb;
        color: #0891b2;
    }

    .stat-content {
        min-width: 0;
    }

    .stat-label {
        display: block;
        margin-bottom: 5px;
        font-size: 12px;
        font-weight: 600;
        color: #7b8495;
    }

    .stat-value {
        display: block;
        font-size: 21px;
        font-weight: 700;
        color: #172033;
        line-height: 1.2;
    }

    .stat-value.currency {
        font-size: 18px;
    }

    .stat-description {
        display: block;
        margin-top: 5px;
        font-size: 11px;
        color: #98a1b2;
    }

    /* =========================
       TABLE
    ========================= */

    .hardware-table-card {
        background: #ffffff;
        border: 1px solid #e7eaf0;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(16, 24, 40, 0.04);
        overflow: hidden;
    }

    .hardware-table-header {
        min-height: 70px;
        padding: 16px 18px;
        border-bottom: 1px solid #edf0f4;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .hardware-table-title {
        min-width: 0;
    }

    .hardware-table-title h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #172033;
    }

    .hardware-table-title p {
        margin: 4px 0 0;
        font-size: 11px;
        color: #8a93a3;
    }

    .hardware-table-toolbar {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .hardware-search {
        position: relative;
        width: 230px;
    }

    .hardware-search i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa3b2;
        font-size: 13px;
        pointer-events: none;
    }

    .hardware-search input {
        width: 100%;
        height: 36px;
        padding: 0 12px 0 34px;
        border: 1px solid #dfe3ea;
        border-radius: 8px;
        outline: none;
        background: #ffffff;
        color: #30394b;
        font-size: 11px;
        box-sizing: border-box;
    }

    .hardware-search input:focus {
        border-color: #26364f;
        box-shadow: 0 0 0 3px rgba(38, 54, 79, 0.08);
    }

    .hardware-toolbar-button {
        height: 36px;
        padding: 0 12px;
        border-radius: 8px;
        border: 1px solid #dfe3ea;
        background: #ffffff;
        color: #465166;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
    }

    .hardware-toolbar-button:hover {
        background: #f7f8fa;
    }

    .hardware-add-button {
        border-color: #071b88;
        background: #071b88;
        color: #ffffff;
    }

    .hardware-add-button:hover {
        background: #050f63;
    }

    /* =========================
       FILTER
    ========================= */

    .hardware-filter-wrapper {
        position: relative;
    }

    .hardware-filter-menu {
        position: absolute;
        right: 0;
        top: calc(100% + 7px);
        width: 220px;
        padding: 12px;
        background: #ffffff;
        border: 1px solid #e5e8ee;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(16, 24, 40, 0.12);
        display: none;
        z-index: 100;
    }

    .hardware-filter-menu.active {
        display: block;
    }

    .hardware-filter-menu label {
        display: block;
        margin-bottom: 6px;
        font-size: 11px;
        font-weight: 600;
        color: #596274;
    }

    .hardware-filter-menu select {
        width: 100%;
        height: 34px;
        padding: 0 8px;
        border: 1px solid #dfe3ea;
        border-radius: 7px;
        background: #ffffff;
        color: #374151;
        font-size: 11px;
    }

    .hardware-filter-reset {
        width: 100%;
        height: 32px;
        margin-top: 10px;
        border: 0;
        border-radius: 7px;
        background: #f1f3f6;
        color: #4b5563;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }

    /* =========================
       TABLE
    ========================= */

    .hardware-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .hardware-table {
        width: 100%;
        min-width: 1250px;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .hardware-table thead th {
        height: 52px;
        padding: 0 12px;
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
        padding: 13px 12px;
        border-bottom: 1px solid #f0f2f5;
        color: #3f4859;
        font-size: 11px;
        vertical-align: middle;
    }

    .hardware-table tbody tr:hover {
        background: #fafbfd;
    }

    .hardware-asset-id {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-weight: 700;
        color: #26364f;
        white-space: nowrap;
    }

    .hardware-name {
        font-weight: 600;
        color: #30394b;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .hardware-spec {
        color: #687386;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .hardware-type,
    .hardware-year {
        color: #596274;
    }

    .hardware-price {
        white-space: nowrap;
        font-weight: 600;
    }

    /* =========================
       BADGES
    ========================= */

    .hardware-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        max-width: 100%;
        min-height: 25px;
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    .hardware-condition-baru,
    .hardware-verification-disetujui {
        background: #eaf9f0;
        color: #15803d;
    }

    .hardware-condition-baik {
        background: #eaf2ff;
        color: #2563eb;
    }

    .hardware-condition-perbaikan,
    .hardware-verification-menunggu {
        background: #fff3df;
        color: #b45309;
    }

    .hardware-condition-rusak,
    .hardware-verification-ditolak {
        background: #feecec;
        color: #dc2626;
    }

    .hardware-condition-default,
    .hardware-verification-default {
        background: #f1f3f6;
        color: #667085;
    }

    /* =========================
       COMMENT
    ========================= */

    .comment-button {
        width: 30px;
        height: 30px;
        border: 1px solid #e0e4ea;
        border-radius: 7px;
        background: #ffffff;
        cursor: pointer;
    }

    .comment-button:hover {
        background: #eef4ff;
        border-color: #c8d8ff;
    }

    .no-comment {
        color: #b0b7c3;
    }

    .comment-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        padding: 20px;
    }

    .comment-modal-overlay.active {
        display: flex;
    }

    .comment-modal {
        width: min(500px, 100%);
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 25px 60px rgba(15, 23, 42, 0.2);
        overflow: hidden;
    }

    .comment-modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid #edf0f4;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .comment-modal-header h3 {
        margin: 0;
        font-size: 16px;
        color: #172033;
    }

    .comment-modal-close {
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 7px;
        background: #f3f4f6;
        cursor: pointer;
        font-size: 20px;
    }

    .comment-modal-body {
        padding: 20px;
    }

    .comment-box {
        padding: 15px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .comment-box p {
        margin: 0;
        color: #475569;
        font-size: 13px;
        line-height: 1.6;
        white-space: pre-wrap;
    }

    .comment-modal-footer {
        padding: 13px 20px;
        border-top: 1px solid #edf0f4;
        display: flex;
        justify-content: flex-end;
    }

    .comment-close-btn {
        padding: 9px 15px;
        border: 1px solid #dfe3ea;
        border-radius: 8px;
        background: #ffffff;
        cursor: pointer;
    }

    /* =========================
       ACTION
    ========================= */

    .hardware-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .hardware-action-button {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: 1px solid #e0e4ea;
        background: #ffffff;
        color: #5f697a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .hardware-edit-button:hover {
        background: #eef4ff;
        color: #2563eb;
    }

    .hardware-delete-button:hover {
        background: #fff0f0;
        color: #dc2626;
    }

    /* =========================
       EMPTY
    ========================= */

    .hardware-empty {
        padding: 55px 20px !important;
        text-align: center;
    }

    .hardware-empty-icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: #f2f4f7;
        color: #98a2b3;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .hardware-empty-title {
        margin: 0;
        font-size: 13px;
        font-weight: 700;
        color: #4b5563;
    }

    .hardware-empty-text {
        margin: 5px 0 0;
        font-size: 11px;
        color: #98a2b3;
    }

    /* =========================
       PAGINATION
    ========================= */

    .hardware-pagination {
        padding: 14px 18px;
        border-top: 1px solid #edf0f4;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .hardware-pagination-info {
        font-size: 10px;
        color: #8a93a3;
    }

    /* =========================
       MODAL
    ========================= */

    .hardware-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 9999;
    }

    .hardware-modal-overlay.active {
        display: flex;
    }

    .hardware-modal {
        width: min(1050px, 100%);
        height: min(720px, calc(100vh - 40px));
        max-height: calc(100vh - 40px);
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 25px 60px rgba(15, 23, 42, 0.2);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .hardware-modal > form {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-height: 0;
        overflow: hidden;
    }

    .hardware-modal-header {
        min-height: 70px;
        padding: 15px 20px;
        border-bottom: 1px solid #edf0f4;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .hardware-modal-title-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .hardware-modal-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #eaf2ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hardware-modal-title h3 {
        margin: 0;
        font-size: 17px;
        color: #172033;
    }

    .hardware-modal-title p {
        margin: 4px 0 0;
        font-size: 11px;
        color: #8a93a3;
    }

    .hardware-modal-close {
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 7px;
        background: #f3f4f6;
        cursor: pointer;
    }

    .hardware-modal-body {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 20px;
    }

    .hardware-form-section {
        padding: 17px;
        margin-bottom: 15px;
        background: #ffffff;
        border: 1px solid #e7eaf0;
        border-radius: 14px;
    }

    .hardware-form-section:last-child {
        margin-bottom: 0;
    }

    .hardware-form-section-title {
        margin: 0 0 14px;
        font-size: 13px;
        font-weight: 700;
        color: #26364f;
    }

    .hardware-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .hardware-form-group.full {
        grid-column: 1 / -1;
    }

    .hardware-form-label {
        display: block;
        margin-bottom: 7px;
        font-size: 11px;
        font-weight: 700;
        color: #4b5563;
    }

    .hardware-required {
        color: #dc2626;
    }

    .hardware-form-control {
        width: 100%;
        height: 40px;
        padding: 0 11px;
        border: 1px solid #dfe3ea;
        border-radius: 8px;
        outline: none;
        box-sizing: border-box;
        font-size: 11px;
    }

    textarea.hardware-form-control {
        height: 100px;
        padding-top: 10px;
        resize: vertical;
    }

    .hardware-form-control:focus {
        border-color: #26364f;
        box-shadow: 0 0 0 3px rgba(38, 54, 79, 0.08);
    }

    .hardware-auto-id {
        width: 100%;
        height: 40px;
        padding: 0 11px;
        box-sizing: border-box;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #f8fafc;
        color: #8a93a3;
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 11px;
    }

    .hardware-modal-footer {
        min-height: 66px;
        padding: 13px 20px;
        border-top: 1px solid #edf0f4;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .hardware-modal-button {
        height: 36px;
        padding: 0 15px;
        border-radius: 8px;
        border: 1px solid #dfe3ea;
        background: #ffffff;
        cursor: pointer;
        font-size: 11px;
    }

    .hardware-modal-submit {
        border-color: #071b88;
        background: #071b88;
        color: #ffffff;
    }

    @media (max-width: 800px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .hardware-table-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .hardware-table-toolbar {
            width: 100%;
            flex-wrap: wrap;
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
            Kelola dan pantau seluruh aset hardware yang tersedia.
        </p>
    </div>


    {{-- ALERT --}}
    @if(session('success'))
        <div class="hardware-alert hardware-alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="hardware-alert hardware-alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="hardware-alert hardware-alert-error">
            <i class="bi bi-exclamation-triangle-fill"></i>

            <div>
                <strong>Terjadi kesalahan.</strong>

                <ul style="margin:4px 0 0 18px;padding:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    {{-- SUMMARY --}}
    @php
        $hardwareData = $hardwares->getCollection();

        $jumlahBarang = $hardwares->total();

        $hargaBarang = $hardwareData->sum(function ($hardware) {
            return (float) ($hardware->harga ?? 0);
        });

        $perluPerbaikan = $hardwareData->filter(function ($hardware) {
            return strtolower(trim($hardware->kondisi ?? '')) === 'perlu perbaikan';
        })->count();

        $rusak = $hardwareData->filter(function ($hardware) {
            return strtolower(trim($hardware->kondisi ?? '')) === 'rusak';
        })->count();

        $tersedia = $hardwareData->filter(function ($hardware) {
            $kondisi = strtolower(trim($hardware->kondisi ?? ''));

            return in_array($kondisi, ['baru', 'baik']);
        })->count();

        $tahunTerbaru = $hardwareData
            ->pluck('tahun_pembelian')
            ->filter()
            ->max();
    @endphp


    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-pc-display"></i>
            </div>

            <div class="stat-content">
                <span class="stat-label">Jumlah Barang</span>
                <span class="stat-value">{{ $jumlahBarang }}</span>
                <span class="stat-description">
                    Total aset hardware
                </span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div class="stat-content">
                <span class="stat-label">Harga Barang</span>

                <span class="stat-value currency">
                    Rp {{ number_format($hargaBarang, 0, ',', '.') }}
                </span>

                <span class="stat-description">
                    Total nilai hardware
                </span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="bi bi-tools"></i>
            </div>

            <div class="stat-content">
                <span class="stat-label">Perlu Perbaikan</span>
                <span class="stat-value">{{ $perluPerbaikan }}</span>

                <span class="stat-description">
                    Hardware perlu diperbaiki
                </span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon red">
                <i class="bi bi-x-octagon-fill"></i>
            </div>

            <div class="stat-content">
                <span class="stat-label">Rusak</span>
                <span class="stat-value">{{ $rusak }}</span>

                <span class="stat-description">
                    Hardware dalam kondisi rusak
                </span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="stat-content">
                <span class="stat-label">Tersedia</span>
                <span class="stat-value">{{ $tersedia }}</span>

                <span class="stat-description">
                    Hardware siap digunakan
                </span>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon cyan">
                <i class="bi bi-calendar3"></i>
            </div>

            <div class="stat-content">
                <span class="stat-label">
                    Tahun Pembelian Terbaru
                </span>

                <span class="stat-value">
                    {{ $tahunTerbaru ?: '-' }}
                </span>

                <span class="stat-description">
                    Tahun pembelian terakhir
                </span>
            </div>
        </div>

    </div>


    {{-- TABLE --}}
    <div class="hardware-table-card">

        <div class="hardware-table-header">

            <div class="hardware-table-title">
                <h3>Daftar Hardware</h3>

                <p>
                    Menampilkan
                    <strong>{{ $hardwares->count() }}</strong>
                    dari
                    <strong>{{ $hardwares->total() }}</strong>
                    data hardware
                </p>
            </div>


            <div class="hardware-table-toolbar">

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
                        autocomplete="off"
                    >
                </form>


                {{-- FILTER --}}
                <div class="hardware-filter-wrapper">

                    <button
                        type="button"
                        class="hardware-toolbar-button"
                        onclick="toggleHardwareFilter(event)"
                    >
                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>

                    <div
                        class="hardware-filter-menu"
                        id="hardwareFilterMenu"
                    >
                        <label for="hardwareConditionFilter">
                            Kondisi
                        </label>

                        <select id="hardwareConditionFilter">
                            <option value="">
                                Semua Kondisi
                            </option>

                            <option value="baru">
                                Baru
                            </option>

                            <option value="baik">
                                Baik
                            </option>

                            <option value="perlu perbaikan">
                                Perlu Perbaikan
                            </option>

                            <option value="rusak">
                                Rusak
                            </option>
                        </select>

                        <button
                            type="button"
                            class="hardware-filter-reset"
                            onclick="resetHardwareFilter()"
                        >
                            Reset Filter
                        </button>
                    </div>

                </div>


                {{-- ADD --}}
                <button
                    type="button"
                    class="hardware-toolbar-button hardware-add-button"
                    onclick="openCreateHardwareModal()"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Hardware
                </button>

            </div>

        </div>


        <div class="hardware-table-wrapper">

            <table class="hardware-table">

                <thead>
                    <tr>
                        <th>Asset ID</th>
                        <th>Nama Barang</th>
                        <th>Spesifikasi</th>
                        <th>Jenis Barang</th>
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
                            $kondisi = strtolower(
                                trim($hardware->kondisi ?? '')
                            );

                            $verificationRequest =
                                $hardware->latestVerificationRequest;

                            $verifikasi = strtolower(
                                trim(
                                    $verificationRequest?->status
                                    ?? 'menunggu'
                                )
                            );

                            $komentar =
                                $verificationRequest?->rejection_reason
                                ?? $verificationRequest?->catatan
                                ?? null;

                            $conditionClass = match ($kondisi) {
                                'baru' => 'hardware-condition-baru',
                                'baik' => 'hardware-condition-baik',
                                'perlu perbaikan' => 'hardware-condition-perbaikan',
                                'rusak' => 'hardware-condition-rusak',
                                default => 'hardware-condition-default',
                            };

                            $verificationClass = match ($verifikasi) {
                                'menunggu',
                                'menunggu persetujuan'
                                    => 'hardware-verification-menunggu',

                                'disetujui'
                                    => 'hardware-verification-disetujui',

                                'ditolak'
                                    => 'hardware-verification-ditolak',

                                default
                                    => 'hardware-verification-default',
                            };
                        @endphp


                        <tr
                            data-hardware-condition="{{ $kondisi }}"
                        >

                            {{-- ASSET ID --}}
                            <td>
                                <span class="hardware-asset-id">
                                    <i class="bi bi-hash"></i>
                                    {{ $hardware->asset_id }}
                                </span>
                            </td>


                            {{-- NAMA --}}
                            <td>
                                <div
                                    class="hardware-name"
                                    title="{{ $hardware->nama_barang }}"
                                >
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
                                <span class="hardware-type">
                                    {{ $hardware->jenis_barang }}
                                </span>
                            </td>


                            {{-- TAHUN --}}
                            <td>
                                <span class="hardware-year">
                                    {{ $hardware->tahun_pembelian }}
                                </span>
                            </td>


                            {{-- HARGA --}}
                            <td>
                                <span class="hardware-price">
                                    Rp
                                    {{ number_format((float) ($hardware->harga ?? 0), 0, ',', '.') }}
                                </span>
                            </td>


                            {{-- KONDISI --}}
                            <td>
                                <span class="hardware-badge {{ $conditionClass }}">
                                    {{ $hardware->kondisi }}
                                </span>
                            </td>


                            {{-- VERIFIKASI --}}
                            <td>
                                <span class="hardware-badge {{ $verificationClass }}">
                                    {{ ucfirst($verifikasi) }}
                                </span>
                            </td>


                            {{-- KOMENTAR --}}
                            <td>

                                @if($komentar)

                                    <button
                                        type="button"
                                        class="comment-button"
                                        onclick="showComment(@js($komentar))"
                                        title="Lihat komentar"
                                    >
                                        💬
                                    </button>

                                @else

                                    <span class="no-comment">
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
                                        class="hardware-action-button hardware-edit-button"
                                        title="Edit"

                                        data-asset-id="{{ $hardware->asset_id }}"
                                        data-nama-barang="{{ $hardware->nama_barang }}"
                                        data-spesifikasi="{{ $hardware->spesifikasi }}"
                                        data-jenis-barang="{{ $hardware->jenis_barang }}"
                                        data-tahun-pembelian="{{ $hardware->tahun_pembelian }}"
                                        data-harga="{{ $hardware->harga }}"
                                        data-kondisi="{{ $hardware->kondisi }}"

                                        onclick="openEditHardwareModal(this)"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>


                                    {{-- DELETE --}}
                                    <form
                                        method="POST"
                                        action="{{ route('hardware.destroy', $hardware->asset_id) }}"
                                        onsubmit="return confirm('Yakin ingin mengajukan penghapusan hardware ini?');"
                                        style="margin:0;"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="hardware-action-button hardware-delete-button"
                                            title="Hapus"
                                        >
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="10"
                                class="hardware-empty"
                            >
                                <div class="hardware-empty-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>

                                <p class="hardware-empty-title">
                                    Belum ada data hardware
                                </p>

                                <p class="hardware-empty-text">
                                    Silakan tambahkan hardware baru untuk mulai mengelola aset.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($hardwares->hasPages())

            <div class="hardware-pagination">

                <div class="hardware-pagination-info">
                    Menampilkan
                    <strong>{{ $hardwares->firstItem() }}</strong>
                    -
                    <strong>{{ $hardwares->lastItem() }}</strong>
                    dari
                    <strong>{{ $hardwares->total() }}</strong>
                    data
                </div>

                <div>
                    {{ $hardwares->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     COMMENT MODAL
========================================================= --}}

<div
    id="commentModal"
    class="comment-modal-overlay"
>
    <div
        class="comment-modal"
        onclick="event.stopPropagation()"
    >

        <div class="comment-modal-header">

            <h3>
                Komentar Verifikator
            </h3>

            <button
                type="button"
                class="comment-modal-close"
                onclick="closeCommentModal()"
            >
                ×
            </button>

        </div>


        <div class="comment-modal-body">

            <div class="comment-box">
                <p id="commentText"></p>
            </div>

        </div>


        <div class="comment-modal-footer">

            <button
                type="button"
                class="comment-close-btn"
                onclick="closeCommentModal()"
            >
                Tutup
            </button>

        </div>

    </div>
</div>


{{-- =========================================================
     CREATE MODAL
========================================================= --}}

<div
    class="hardware-modal-overlay"
    id="createHardwareModal"
>

    <div
        class="hardware-modal"
        onclick="event.stopPropagation()"
    >

        <div class="hardware-modal-header">

            <div class="hardware-modal-title-wrapper">

                <div class="hardware-modal-icon">
                    <i class="bi bi-pc-display"></i>
                </div>

                <div class="hardware-modal-title">

                    <h3>
                        Tambah Hardware
                    </h3>

                    <p>
                        Tambahkan data hardware baru.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="hardware-modal-close"
                onclick="closeCreateHardwareModal()"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        <form
            method="POST"
            action="{{ route('hardware.store') }}"
            id="createHardwareForm"
        >

            @csrf

            <div class="hardware-modal-body">

                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Informasi Hardware
                    </h4>

                    <div class="hardware-form-grid">

                        <div class="hardware-form-group">

                            <label class="hardware-form-label">
                                Asset ID
                            </label>

                            <div class="hardware-auto-id">
                                <i class="bi bi-magic"></i>

                                <span>
                                    Otomatis dibuat oleh sistem
                                </span>
                            </div>

                            <small>
                                Asset ID akan dibuat otomatis saat data disimpan.
                            </small>

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="create_nama_barang"
                                class="hardware-form-label"
                            >
                                Nama Barang
                                <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="text"
                                id="create_nama_barang"
                                name="nama_barang"
                                class="hardware-form-control"
                                value="{{ old('nama_barang') }}"
                                placeholder="Contoh: Laptop"
                                required
                            >

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="create_jenis_barang"
                                class="hardware-form-label"
                            >
                                Jenis Barang
                                <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="text"
                                id="create_jenis_barang"
                                name="jenis_barang"
                                class="hardware-form-control"
                                value="{{ old('jenis_barang') }}"
                                placeholder="Contoh: Laptop"
                                required
                            >

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="create_kondisi"
                                class="hardware-form-label"
                            >
                                Kondisi
                                <span class="hardware-required">*</span>
                            </label>

                            <select
                                id="create_kondisi"
                                name="kondisi"
                                class="hardware-form-control"
                                required
                            >

                                <option value="">
                                    Pilih kondisi
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


                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Detail Pembelian
                    </h4>

                    <div class="hardware-form-grid">

                        <div class="hardware-form-group">

                            <label
                                for="create_tahun_pembelian"
                                class="hardware-form-label"
                            >
                                Tahun Pembelian
                                <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="number"
                                id="create_tahun_pembelian"
                                name="tahun_pembelian"
                                class="hardware-form-control"
                                value="{{ old('tahun_pembelian') }}"
                                min="1900"
                                max="2100"
                                required
                            >

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="create_harga"
                                class="hardware-form-label"
                            >
                                Harga
                                <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="number"
                                id="create_harga"
                                name="harga"
                                class="hardware-form-control"
                                value="{{ old('harga') }}"
                                min="0"
                                step="0.01"
                                required
                            >

                        </div>

                    </div>

                </div>


                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Spesifikasi
                    </h4>

                    <div class="hardware-form-grid">

                        <div class="hardware-form-group full">

                            <label
                                for="create_spesifikasi"
                                class="hardware-form-label"
                            >
                                Spesifikasi
                                <span class="hardware-required">*</span>
                            </label>

                            <textarea
                                id="create_spesifikasi"
                                name="spesifikasi"
                                class="hardware-form-control"
                                placeholder="Masukkan spesifikasi hardware..."
                                required
                            >{{ old('spesifikasi') }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            <div class="hardware-modal-footer">

                <button
                    type="button"
                    class="hardware-modal-button"
                    onclick="closeCreateHardwareModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="hardware-modal-button hardware-modal-submit"
                >
                    <i class="bi bi-check2"></i>
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     EDIT MODAL
========================================================= --}}

<div
    class="hardware-modal-overlay"
    id="editHardwareModal"
>

    <div
        class="hardware-modal"
        onclick="event.stopPropagation()"
    >

        <div class="hardware-modal-header">

            <div class="hardware-modal-title-wrapper">

                <div class="hardware-modal-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>

                <div class="hardware-modal-title">

                    <h3>
                        Edit Hardware
                    </h3>

                    <p>
                        Perbarui informasi hardware.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="hardware-modal-close"
                onclick="closeEditHardwareModal()"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        <form
            method="POST"
            action=""
            id="editHardwareForm"
        >

            @csrf
            @method('PUT')

            <div class="hardware-modal-body">

                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Informasi Hardware
                    </h4>

                    <div class="hardware-form-grid">

                        <div class="hardware-form-group">

                            <label
                                for="edit_asset_id"
                                class="hardware-form-label"
                            >
                                Asset ID
                            </label>

                            <input
                                type="text"
                                id="edit_asset_id"
                                class="hardware-form-control"
                                readonly
                            >

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="edit_nama_barang"
                                class="hardware-form-label"
                            >
                                Nama Barang
                                <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="text"
                                id="edit_nama_barang"
                                name="nama_barang"
                                class="hardware-form-control"
                                required
                            >

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="edit_jenis_barang"
                                class="hardware-form-label"
                            >
                                Jenis Barang
                                <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="text"
                                id="edit_jenis_barang"
                                name="jenis_barang"
                                class="hardware-form-control"
                                required
                            >

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="edit_kondisi"
                                class="hardware-form-label"
                            >
                                Kondisi
                                <span class="hardware-required">*</span>
                            </label>

                            <select
                                id="edit_kondisi"
                                name="kondisi"
                                class="hardware-form-control"
                                required
                            >

                                <option value="">
                                    Pilih kondisi
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


                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Detail Pembelian
                    </h4>

                    <div class="hardware-form-grid">

                        <div class="hardware-form-group">

                            <label
                                for="edit_tahun_pembelian"
                                class="hardware-form-label"
                            >
                                Tahun Pembelian
                                <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="number"
                                id="edit_tahun_pembelian"
                                name="tahun_pembelian"
                                class="hardware-form-control"
                                min="1900"
                                max="2100"
                                required
                            >

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="edit_harga"
                                class="hardware-form-label"
                            >
                                Harga
                                <span class="hardware-required">*</span>
                            </label>

                            <input
                                type="number"
                                id="edit_harga"
                                name="harga"
                                class="hardware-form-control"
                                min="0"
                                step="0.01"
                                required
                            >

                        </div>

                    </div>

                </div>


                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Spesifikasi
                    </h4>

                    <div class="hardware-form-grid">

                        <div class="hardware-form-group full">

                            <label
                                for="edit_spesifikasi"
                                class="hardware-form-label"
                            >
                                Spesifikasi
                                <span class="hardware-required">*</span>
                            </label>

                            <textarea
                                id="edit_spesifikasi"
                                name="spesifikasi"
                                class="hardware-form-control"
                                placeholder="Masukkan spesifikasi hardware..."
                                required
                            ></textarea>

                        </div>

                    </div>

                </div>

            </div>


            <div class="hardware-modal-footer">

                <button
                    type="button"
                    class="hardware-modal-button"
                    onclick="closeEditHardwareModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="hardware-modal-button hardware-modal-submit"
                >
                    <i class="bi bi-check2"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    /* =====================================================
       CREATE MODAL
    ===================================================== */

    function openCreateHardwareModal() {

        const modal =
            document.getElementById('createHardwareModal');

        if (!modal) {
            return;
        }

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';

        setTimeout(() => {

            const input =
                document.getElementById('create_nama_barang');

            if (input) {
                input.focus();
            }

        }, 100);
    }


    function closeCreateHardwareModal() {

        const modal =
            document.getElementById('createHardwareModal');

        if (!modal) {
            return;
        }

        modal.classList.remove('active');

        document.body.style.overflow = '';
    }


    /* =====================================================
       EDIT MODAL
    ===================================================== */

    function openEditHardwareModal(button) {

        if (!button) {
            return;
        }

        const modal =
            document.getElementById('editHardwareModal');

        const form =
            document.getElementById('editHardwareForm');

        if (!modal || !form) {
            return;
        }

        const assetId =
            button.dataset.assetId || '';

        const namaBarang =
            button.dataset.namaBarang || '';

        const spesifikasi =
            button.dataset.spesifikasi || '';

        const jenisBarang =
            button.dataset.jenisBarang || '';

        const tahunPembelian =
            button.dataset.tahunPembelian || '';

        const harga =
            button.dataset.harga || '';

        const kondisi =
            button.dataset.kondisi || '';


        document.getElementById('edit_asset_id').value =
            assetId;

        document.getElementById('edit_nama_barang').value =
            namaBarang;

        document.getElementById('edit_spesifikasi').value =
            spesifikasi;

        document.getElementById('edit_jenis_barang').value =
            jenisBarang;

        document.getElementById('edit_tahun_pembelian').value =
            tahunPembelian;

        document.getElementById('edit_harga').value =
            harga;

        document.getElementById('edit_kondisi').value =
            kondisi;


        form.action =
            "{{ url('/hardware') }}/" +
            encodeURIComponent(assetId);


        modal.classList.add('active');

        document.body.style.overflow = 'hidden';

    }


    function closeEditHardwareModal() {

        const modal =
            document.getElementById('editHardwareModal');

        if (!modal) {
            return;
        }

        modal.classList.remove('active');

        document.body.style.overflow = '';
    }


    /* =====================================================
       FILTER
    ===================================================== */

    function toggleHardwareFilter(event) {

        if (event) {
            event.stopPropagation();
        }

        const menu =
            document.getElementById('hardwareFilterMenu');

        if (!menu) {
            return;
        }

        menu.classList.toggle('active');
    }


    function filterHardwareRows() {

        const select =
            document.getElementById(
                'hardwareConditionFilter'
            );

        const selected =
            select
                ? select.value.toLowerCase().trim()
                : '';


        const rows =
            document.querySelectorAll(
                '.hardware-table tbody tr[data-hardware-condition]'
            );


        rows.forEach(row => {

            const condition =
                (row.dataset.hardwareCondition || '')
                    .toLowerCase()
                    .trim();


            if (!selected || condition === selected) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }

        });

    }


    function resetHardwareFilter() {

        const select =
            document.getElementById(
                'hardwareConditionFilter'
            );

        if (select) {
            select.value = '';
        }

        filterHardwareRows();
    }


    /* =====================================================
       COMMENT
    ===================================================== */

    function showComment(comment) {

        const text =
            document.getElementById('commentText');

        const modal =
            document.getElementById('commentModal');

        if (!text || !modal) {
            return;
        }

        text.textContent = comment;

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';
    }


    function closeCommentModal() {

        const modal =
            document.getElementById('commentModal');

        if (!modal) {
            return;
        }

        modal.classList.remove('active');

        document.body.style.overflow = '';
    }


    /* =====================================================
       EVENT LISTENER
    ===================================================== */

    const hardwareConditionFilter =
        document.getElementById(
            'hardwareConditionFilter'
        );

    if (hardwareConditionFilter) {

        hardwareConditionFilter.addEventListener(
            'change',
            filterHardwareRows
        );

    }


    const createModal =
        document.getElementById(
            'createHardwareModal'
        );

    if (createModal) {

        createModal.addEventListener(
            'click',
            function(event) {

                if (event.target === createModal) {
                    closeCreateHardwareModal();
                }

            }
        );

    }


    const editModal =
        document.getElementById(
            'editHardwareModal'
        );

    if (editModal) {

        editModal.addEventListener(
            'click',
            function(event) {

                if (event.target === editModal) {
                    closeEditHardwareModal();
                }

            }
        );

    }


    const commentModal =
        document.getElementById(
            'commentModal'
        );

    if (commentModal) {

        commentModal.addEventListener(
            'click',
            function(event) {

                if (event.target === commentModal) {
                    closeCommentModal();
                }

            }
        );

    }


    document.addEventListener(
        'click',
        function(event) {

            const wrapper =
                document.querySelector(
                    '.hardware-filter-wrapper'
                );

            const menu =
                document.getElementById(
                    'hardwareFilterMenu'
                );

            if (!wrapper || !menu) {
                return;
            }

            if (!wrapper.contains(event.target)) {
                menu.classList.remove('active');
            }

        }
    );


    document.addEventListener(
        'keydown',
        function(event) {

            if (event.key !== 'Escape') {
                return;
            }

            closeCreateHardwareModal();
            closeEditHardwareModal();
            closeCommentModal();

            const filterMenu =
                document.getElementById(
                    'hardwareFilterMenu'
                );

            if (filterMenu) {
                filterMenu.classList.remove('active');
            }

        }
    );


    /* =====================================================
       AUTO OPEN CREATE MODAL AFTER VALIDATION ERROR
    ===================================================== */

    @if($errors->any() && old('_token') && !old('_method'))

        document.addEventListener(
            'DOMContentLoaded',
            function() {
                openCreateHardwareModal();
            }
        );

    @endif

</script>

@endsection