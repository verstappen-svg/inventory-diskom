@extends('layouts.app')

@section('title', 'Data')
@section('page-title', 'Data')

@section('content')

<style>
.data-page {
    width: 100%;
    padding-bottom: 30px;
    font-family: Arial, sans-serif;
}

.data-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 22px;
}

.data-title {
    margin: 0;
    color: #1f2937;
    font-size: 25px;
    font-weight: 700;
}

.data-subtitle {
    margin: 6px 0 0;
    color: #6b7280;
    font-size: 13px;
}

/* =========================================================
   ALERT
========================================================= */

.data-alert {
    padding: 12px 15px;
    border-radius: 10px;
    margin-bottom: 18px;
    font-size: 12px;
    font-weight: 600;
}

.data-alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.data-alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.data-alert ul {
    margin: 6px 0 0 18px;
    padding: 0;
}

/* =========================================================
   SUMMARY CARD
========================================================= */

.data-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}

.data-stat-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 13px;
    padding: 17px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
}

.data-stat-icon {
    width: 43px;
    height: 43px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 19px;
}

.data-stat-icon.blue {
    background: #e0f2fe;
    color: #0369a1;
}

.data-stat-icon.green {
    background: #dcfce7;
    color: #15803d;
}

.data-stat-icon.orange {
    background: #fef3c7;
    color: #b45309;
}

.data-stat-content {
    min-width: 0;
}

.data-stat-label {
    display: block;
    color: #6b7280;
    font-size: 10px;
    font-weight: 600;
    margin-bottom: 3px;
}

.data-stat-value {
    display: block;
    color: #1f2937;
    font-size: 22px;
    line-height: 1.1;
    font-weight: 700;
}

.data-stat-description {
    display: block;
    margin-top: 4px;
    color: #9ca3af;
    font-size: 10px;
}

/* =========================================================
   MAIN CARD
========================================================= */

.data-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: visible;
    box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
}

/* =========================================================
   TOOLBAR
========================================================= */

.data-toolbar {
    padding: 17px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    border-bottom: 1px solid #edf0f3;
}

.data-toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.data-toolbar-title {
    color: #1f2937;
    font-size: 14px;
    font-weight: 700;
}

.data-toolbar-right {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
    flex-wrap: wrap;
}

/* =========================================================
   SEARCH
========================================================= */

.data-search {
    position: relative;
    width: 235px;
}

.data-search i {
    position: absolute;
    left: 11px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 13px;
    pointer-events: none;
}

.data-search input {
    width: 100%;
    height: 37px;
    padding: 0 12px 0 33px;
    border: 1px solid #d1d5db;
    border-radius: 9px;
    outline: none;
    color: #374151;
    font-size: 11px;
    background: #ffffff;
    box-sizing: border-box;
}

.data-search input:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.08);
}

/* =========================================================
   BUTTON
========================================================= */

.data-button {
    height: 37px;
    padding: 0 13px;
    border-radius: 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    box-sizing: border-box;
    white-space: nowrap;
}

.data-button-primary {
    border: none;
    background: #071b88;
    color: #ffffff;
}

.data-button-primary:hover {
    background: #050f63;
}

.data-button-secondary {
    border: 1px solid #d1d5db;
    background: #ffffff;
    color: #374151;
}

.data-button-secondary:hover {
    background: #f8fafc;
}

/* =========================================================
   FILTER
========================================================= */

.data-filter-wrap {
    position: relative;
}

.data-filter-dropdown {
    position: absolute;
    top: calc(100% + 7px);
    right: 0;
    width: 260px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 11px;
    padding: 14px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.13);
    z-index: 50;
    display: none;
}

.data-filter-dropdown.show {
    display: block;
}

.data-filter-group {
    margin-bottom: 11px;
}

.data-filter-group:last-child {
    margin-bottom: 0;
}

.data-filter-label {
    display: block;
    margin-bottom: 5px;
    color: #475569;
    font-size: 10px;
    font-weight: 700;
}

.data-filter-group select {
    width: 100%;
    height: 34px;
    padding: 0 9px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    background: #ffffff;
    color: #374151;
    outline: none;
    font-size: 11px;
}

.data-filter-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 13px;
}

.data-filter-action {
    border: none;
    background: transparent;
    color: #075985;
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
}

/* =========================================================
   TABLE
========================================================= */

.data-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.data-table {
    width: 100%;
    min-width: 1100px;
    border-collapse: collapse;
}

.data-table th {
    padding: 13px 14px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    color: #475569;
    font-size: 10px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.data-table td {
    padding: 13px 14px;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    font-size: 11px;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: #f8fafc;
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

/* =========================================================
   ID
========================================================= */

.data-id {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 7px;
    background: #eef2ff;
    color: #3730a3;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}

/* =========================================================
   NAME
========================================================= */

.data-name {
    display: block;
    max-width: 250px;
    color: #1f2937;
    font-weight: 600;
    line-height: 1.35;
}

/* =========================================================
   TOPIK
========================================================= */

.data-topic {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 20px;
    background: #e0f2fe;
    color: #075985;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

/* =========================================================
   YEAR
========================================================= */

.data-year {
    font-weight: 600;
    color: #374151;
    white-space: nowrap;
}

/* =========================================================
   FILE
========================================================= */

.data-file {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #475569;
    text-decoration: none;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.data-file:hover {
    color: #075985;
}

.data-file i {
    color: #15803d;
    font-size: 13px;
}

.data-no-file {
    color: #9ca3af;
    font-size: 10px;
}

/* =========================================================
   DATE
========================================================= */

.data-date {
    color: #4b5563;
    white-space: nowrap;
}

/* =========================================================
   VERIFICATION
========================================================= */

.data-verification {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.data-verification.pending {
    background: #fef3c7;
    color: #92400e;
}

.data-verification.approved {
    background: #dcfce7;
    color: #166534;
}

.data-verification.rejected {
    background: #fee2e2;
    color: #991b1b;
}

/* =========================================================
   ACTION
========================================================= */

.data-action-buttons {
    display: flex;
    align-items: center;
    gap: 6px;
}

.data-action-button {
    width: 29px;
    height: 29px;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: 0.2s ease;
    font-size: 11px;
    text-decoration: none;
    box-sizing: border-box;
}

.data-detail-button {
    background: #f1f5f9;
    color: #475569;
}

.data-detail-button:hover {
    background: #e2e8f0;
}

.data-edit-button {
    background: #e0f2fe;
    color: #0369a1;
}

.data-edit-button:hover {
    background: #bae6fd;
}

.data-delete-button {
    background: #fee2e2;
    color: #dc2626;
}

.data-delete-button:hover {
    background: #fecaca;
}

.data-comment-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 29px;
    height: 29px;
    border: none;
    border-radius: 7px;
    background: #fef3c7;
    color: #92400e;
    cursor: pointer;
}

/* =========================================================
   EMPTY
========================================================= */

.data-empty {
    padding: 55px 20px;
    text-align: center;
}

.data-empty-icon {
    width: 54px;
    height: 54px;
    margin: 0 auto 12px;
    border-radius: 14px;
    background: #e0f2fe;
    color: #0284c7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.data-empty h3 {
    margin: 0 0 5px;
    color: #374151;
    font-size: 14px;
}

.data-empty p {
    margin: 0;
    color: #9ca3af;
    font-size: 11px;
}

/* =========================================================
   FOOTER / PAGINATION
========================================================= */

.data-table-footer {
    min-height: 59px;
    padding: 12px 17px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    border-top: 1px solid #edf0f3;
}

.data-showing-text {
    color: #9ca3af;
    font-size: 10px;
}

.data-pagination {
    display: flex;
    align-items: center;
    gap: 5px;
}

.data-page-link {
    min-width: 29px;
    height: 29px;
    padding: 0 7px;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    background: #ffffff;
    color: #64748b;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 10px;
    font-weight: 600;
}

.data-page-link:hover {
    background: #f8fafc;
}

.data-page-link.active {
    background: #071b88;
    border-color: #071b88;
    color: #ffffff;
}

.data-page-link.disabled {
    opacity: 0.45;
    pointer-events: none;
}

/* =========================================================
   MODAL
========================================================= */

.data-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.58);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    z-index: 9999;
    box-sizing: border-box;
}

.data-modal-overlay.show {
    display: flex;
}

body.data-modal-open {
    overflow: hidden;
}

.data-modal {
    width: min(1000px, 100%);
    height: min(92vh, 900px);
    max-height: 92vh;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-height: 0;
}

.data-modal-small {
    width: min(700px, 100%);
}

.data-modal-header {
    flex-shrink: 0;
    padding: 19px 21px;
    border-bottom: 1px solid #edf0f3;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.data-modal-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}

.data-modal-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #e0f2fe;
    color: #0369a1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
}

.data-modal-title {
    margin: 0;
    color: #1f2937;
    font-size: 17px;
    font-weight: 700;
}

.data-modal-subtitle {
    margin: 4px 0 0;
    color: #9ca3af;
    font-size: 10px;
}

.data-modal-close {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 8px;
    background: #f8fafc;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.data-modal-close:hover {
    background: #fee2e2;
    color: #dc2626;
}

/* =========================================================
   FORM DALAM MODAL
========================================================= */

.data-modal > form {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    min-height: 0;
    overflow: hidden;
}

/* =========================================================
   MODAL BODY - BISA SCROLL
========================================================= */

.data-modal-body {
    flex: 1 1 auto;
    min-height: 0;
    padding: 19px 21px;
    overflow-y: auto;
    overflow-x: hidden;
    box-sizing: border-box;
}

.data-modal-body::-webkit-scrollbar {
    width: 6px;
}

.data-modal-body::-webkit-scrollbar-track {
    background: transparent;
}

.data-modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.data-modal-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.data-section-title {
    margin: 4px 0 14px;
    padding-bottom: 8px;
    border-bottom: 1px solid #edf0f3;
    color: #1f2937;
    font-size: 12px;
    font-weight: 700;
}

.data-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px 16px;
}

.data-form-group {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.data-form-group.full {
    grid-column: 1 / -1;
}

.data-form-label {
    margin-bottom: 6px;
    color: #374151;
    font-size: 11px;
    font-weight: 700;
}

.data-form-label span {
    color: #ef4444;
}

.data-form-control {
    width: 100%;
    min-height: 39px;
    padding: 9px 11px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    outline: none;
    background: #ffffff;
    color: #374151;
    font-family: inherit;
    font-size: 11px;
    box-sizing: border-box;
}

.data-form-control:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.08);
}

textarea.data-form-control {
    min-height: 85px;
    resize: vertical;
}

.data-form-help {
    margin-top: 5px;
    color: #9ca3af;
    font-size: 9px;
    line-height: 1.5;
}

.metadata-note {
    padding: 10px 12px;
    margin-bottom: 16px;
    border: 1px solid #dbeafe;
    background: #eff6ff;
    border-radius: 8px;
    color: #1e40af;
    font-size: 10px;
    line-height: 1.5;
}

.data-current-file {
    margin-top: 8px;
    padding: 8px 10px;
    background: #f8fafc;
    border-radius: 7px;
    color: #64748b;
    font-size: 10px;
    display: none;
}

.data-current-file a {
    color: #0369a1;
    font-weight: 600;
    text-decoration: none;
}

/* =========================================================
   MODAL FOOTER
========================================================= */

.data-modal-footer {
    flex-shrink: 0;
    padding: 13px 21px;
    border-top: 1px solid #edf0f3;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
    position: relative;
    z-index: 2;
}

.data-modal-cancel {
    height: 37px;
    padding: 0 15px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: #ffffff;
    color: #4b5563;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

.data-modal-cancel:hover {
    background: #f8fafc;
}

.data-modal-save {
    height: 37px;
    padding: 0 16px;
    border: none;
    border-radius: 8px;
    background: #071b88;
    color: #ffffff;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

.data-modal-save:hover {
    background: #050f63;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1000px) {

    .data-stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .data-toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .data-toolbar-right {
        justify-content: flex-start;
    }

}

@media (max-width: 700px) {

    .data-stats {
        grid-template-columns: 1fr;
    }

    .data-search {
        width: 100%;
    }

    .data-toolbar-right {
        flex-direction: column;
        align-items: stretch;
    }

    .data-button {
        width: 100%;
    }

    .data-form-grid {
        grid-template-columns: 1fr;
    }

    .data-form-group.full {
        grid-column: auto;
    }

    .data-modal-overlay {
        padding: 10px;
        align-items: center;
    }

    .data-modal {
        width: 100%;
        height: 95vh;
        max-height: 95vh;
        border-radius: 12px;
    }

    .data-modal-header {
        padding: 15px;
    }

    .data-modal-body {
        padding: 16px;
    }

    .data-modal-footer {
        padding: 12px 16px;
    }

    .data-table-footer {
        flex-direction: column;
        align-items: flex-start;
    }

}
</style>


<div class="data-page">

    {{-- HEADER --}}

    <div class="data-header">

        <div>

            <h1 class="data-title">
                Data
            </h1>

            <p class="data-subtitle">
                Kelola dataset dan metadata yang tersimpan dalam inventory.
            </p>

        </div>

    </div>


    {{-- ALERT --}}

    @if(session('success'))

        <div class="data-alert data-alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="data-alert data-alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>

    @endif


    @if($errors->any())

        <div class="data-alert data-alert-error">

            <strong>
                Data gagal disimpan.
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- SUMMARY CARD --}}

    <div class="data-stats">

        <div class="data-stat-card">

            <div class="data-stat-icon blue">
                <i class="bi bi-database-fill"></i>
            </div>

            <div class="data-stat-content">

                <span class="data-stat-label">
                    Total Dataset
                </span>

                <span class="data-stat-value">
                    {{ $totalDataset ?? 0 }}
                </span>

                <span class="data-stat-description">
                    Dataset terdaftar
                </span>

            </div>

        </div>


        <div class="data-stat-card">

            <div class="data-stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="data-stat-content">

                <span class="data-stat-label">
                    Disetujui
                </span>

                <span class="data-stat-value">
                    {{ $totalDisetujui ?? 0 }}
                </span>

                <span class="data-stat-description">
                    Data telah diverifikasi
                </span>

            </div>

        </div>


        <div class="data-stat-card">

            <div class="data-stat-icon orange">
                <i class="bi bi-clock-history"></i>
            </div>

            <div class="data-stat-content">

                <span class="data-stat-label">
                    Menunggu
                </span>

                <span class="data-stat-value">
                    {{ $totalMenunggu ?? 0 }}
                </span>

                <span class="data-stat-description">
                    Menunggu verifikasi
                </span>

            </div>

        </div>

    </div>


    {{-- MAIN CARD --}}

    <div class="data-card">

        <div class="data-toolbar">

            <div class="data-toolbar-left">

                <span class="data-toolbar-title">
                    Daftar Dataset
                </span>

            </div>


            <div class="data-toolbar-right">

                {{-- SEARCH --}}

                <form
                    method="GET"
                    action="{{ route('data.index') }}"
                    class="data-search"
                >

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari dataset..."
                        autocomplete="off"
                    >

                </form>


                {{-- FILTER --}}

                <div class="data-filter-wrap">

                    <button
                        type="button"
                        class="data-button data-button-secondary"
                        onclick="toggleDataFilter(event)"
                    >
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>


                    <div
                        id="dataFilterDropdown"
                        class="data-filter-dropdown"
                    >

                        <form
                            method="GET"
                            action="{{ route('data.index') }}"
                        >

                            <input
                                type="hidden"
                                name="search"
                                value="{{ request('search') }}"
                            >


                            <div class="data-filter-group">

                                <label class="data-filter-label">
                                    Topik
                                </label>

                                <select name="topik">

                                    <option value="">
                                        Semua Topik
                                    </option>

                                    @foreach($topikData as $topik)

                                        <option
                                            value="{{ $topik }}"
                                            {{ request('topik') === $topik ? 'selected' : '' }}
                                        >
                                            {{ $topik }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="data-filter-group">

                                <label class="data-filter-label">
                                    Tahun
                                </label>

                                <select name="tahun">

                                    <option value="">
                                        Semua Tahun
                                    </option>

                                    @foreach($tahunData as $tahun)

                                        <option
                                            value="{{ $tahun }}"
                                            {{ request('tahun') == $tahun ? 'selected' : '' }}
                                        >
                                            {{ $tahun }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="data-filter-group">

                                <label class="data-filter-label">
                                    Status Verifikasi
                                </label>

                                <select name="verifikasi">

                                    <option value="">
                                        Semua Status
                                    </option>

                                    <option
                                        value="Menunggu Disetujui"
                                        {{ request('verifikasi') === 'Menunggu Disetujui' ? 'selected' : '' }}
                                    >
                                        Menunggu Disetujui
                                    </option>

                                    <option
                                        value="Disetujui"
                                        {{ request('verifikasi') === 'Disetujui' ? 'selected' : '' }}
                                    >
                                        Disetujui
                                    </option>

                                    <option
                                        value="Ditolak"
                                        {{ request('verifikasi') === 'Ditolak' ? 'selected' : '' }}
                                    >
                                        Ditolak
                                    </option>

                                </select>

                            </div>


                            <div class="data-filter-group">

                                <label class="data-filter-label">
                                    Tampilkan
                                </label>

                                <select name="show">

                                    @foreach([10, 25, 50, 100] as $jumlah)

                                        <option
                                            value="{{ $jumlah }}"
                                            {{ (int) request('show', 10) === $jumlah ? 'selected' : '' }}
                                        >
                                            {{ $jumlah }} data
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="data-filter-actions">

                                <button
                                    type="button"
                                    class="data-filter-action"
                                    onclick="resetDataFilter()"
                                >
                                    Reset
                                </button>

                                <button
                                    type="submit"
                                    class="data-filter-action"
                                >
                                    Terapkan
                                </button>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- TEMPLATE --}}

                <a
                    href="{{ route('data.template.download') }}"
                    class="data-button data-button-secondary"
                >
                    <i class="bi bi-download"></i>
                    Template
                </a>


                {{-- IMPORT EXCEL --}}

                <button
                    type="button"
                    class="data-button data-button-secondary"
                    onclick="openImportModal()"
                >
                    <i class="bi bi-file-earmark-excel"></i>
                    Import Excel
                </button>


                {{-- TAMBAH MANUAL --}}

                <button
                    type="button"
                    class="data-button data-button-primary"
                    onclick="openAddModal()"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Data
                </button>

            </div>

        </div>


        {{-- TABLE --}}

        <div class="data-table-wrapper">

            @if($data->count() > 0)

                <table class="data-table">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>ID Dataset</th>
                            <th>Nama Dataset</th>
                            <th>Topik</th>
                            <th>Tahun</th>
                            <th>File</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Verifikasi</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($data as $row)

                            @php

                                $status =
                                    trim(
                                        $row->verifikasi ?? ''
                                    );

                                $statusClass = match(
                                    $status
                                ) {

                                    'Disetujui' =>
                                        'approved',

                                    'Ditolak' =>
                                        'rejected',

                                    default =>
                                        'pending',

                                };

                                $datasetId =
                                    'DS-' .
                                    str_pad(
                                        $row->id,
                                        4,
                                        '0',
                                        STR_PAD_LEFT
                                    );

                            @endphp


                            <tr>

                                <td>
                                    {{ $data->firstItem() + $loop->index }}
                                </td>


                                <td>

                                    <span class="data-id">
                                        {{ $datasetId }}
                                    </span>

                                </td>


                                <td>

                                    <span class="data-name">
                                        {{ $row->nama_dataset }}
                                    </span>

                                </td>


                                <td>

                                    <span class="data-topic">
                                        {{ $row->topik }}
                                    </span>

                                </td>


                                <td>

                                    <span class="data-year">
                                        {{ $row->tahun }}
                                    </span>

                                </td>


                                <td>

                                    @if($row->file_data)

                                        <a
                                            href="{{ route('data.download', $row->id) }}"
                                            class="data-file"
                                        >

                                            <i class="bi bi-file-earmark-excel-fill"></i>

                                            File Excel

                                        </a>

                                    @else

                                        <span class="data-no-file">
                                            Manual
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <span class="data-date">

                                        @if($row->tanggal_pengajuan)

                                            {{ \Carbon\Carbon::parse(
                                                $row->tanggal_pengajuan
                                            )->format('d/m/Y H:i') }}

                                        @else
                                            -
                                        @endif

                                    </span>

                                </td>


                                <td>

                                    <span
                                        class="data-verification {{ $statusClass }}"
                                    >
                                        {{ $status ?: 'Menunggu Disetujui' }}
                                    </span>

                                </td>


                                <td>

                                    <div class="data-action-buttons">

                                        <a
                                            href="{{ route('data.show', $row->id) }}"
                                            class="data-action-button data-detail-button"
                                            title="Detail"
                                        >
                                            <i class="bi bi-eye-fill"></i>
                                        </a>


                                        <button
                                            type="button"
                                            class="data-action-button data-edit-button"
                                            title="Edit"
                                            onclick="openEditModal({{ $row->id }})"
                                        >
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>


                                        <form
                                            action="{{ route('data.destroy', $row->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin mengajukan penghapusan dataset ini?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="data-action-button data-delete-button"
                                                title="Hapus"
                                            >
                                                <i class="bi bi-trash-fill"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="data-empty">

                    <div class="data-empty-icon">
                        <i class="bi bi-database"></i>
                    </div>

                    <h3>

                        @if(
                            request('search') ||
                            request('topik') ||
                            request('tahun') ||
                            request('verifikasi')
                        )

                            Data tidak ditemukan

                        @else

                            Belum ada dataset

                        @endif

                    </h3>


                    <p>

                        @if(
                            request('search') ||
                            request('topik') ||
                            request('tahun') ||
                            request('verifikasi')
                        )

                            Coba ubah kata pencarian atau filter.

                        @else

                            Dataset yang ditambahkan akan tampil di sini.

                        @endif

                    </p>

                </div>

            @endif

        </div>


        {{-- PAGINATION --}}

        @if($data->total() > 0)

            <div class="data-table-footer">

                <span class="data-showing-text">

                    Showing
                    {{ $data->firstItem() }}
                    to
                    {{ $data->lastItem() }}
                    of
                    {{ $data->total() }}
                    entries

                </span>


                <div class="data-pagination">

                    @if($data->onFirstPage())

                        <span class="data-page-link disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>

                    @else

                        <a
                            href="{{ $data->previousPageUrl() }}"
                            class="data-page-link"
                        >
                            <i class="bi bi-chevron-left"></i>
                        </a>

                    @endif


                    @foreach(
                        $data->getUrlRange(
                            max(
                                1,
                                $data->currentPage() - 2
                            ),
                            min(
                                $data->lastPage(),
                                $data->currentPage() + 2
                            )
                        )
                        as $page => $url
                    )

                        <a
                            href="{{ $url }}"
                            class="data-page-link {{ $page == $data->currentPage() ? 'active' : '' }}"
                        >
                            {{ $page }}
                        </a>

                    @endforeach


                    @if($data->hasMorePages())

                        <a
                            href="{{ $data->nextPageUrl() }}"
                            class="data-page-link"
                        >
                            <i class="bi bi-chevron-right"></i>
                        </a>

                    @else

                        <span class="data-page-link disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>

                    @endif

                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH DATA
========================================================= --}}

<div
    id="addModal"
    class="data-modal-overlay"
    aria-hidden="true"
>

    <div class="data-modal">

        <div class="data-modal-header">

            <div class="data-modal-header-left">

                <div class="data-modal-icon">
                    <i class="bi bi-database-fill-add"></i>
                </div>

                <div>

                    <h2 class="data-modal-title">
                        Tambah Data
                    </h2>

                    <p class="data-modal-subtitle">
                        Isi dataset dan metadata secara manual.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="data-modal-close"
                onclick="closeModal('addModal')"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        <form
            action="{{ route('data.store') }}"
            method="POST"
        >

            @csrf

            <div class="data-modal-body">

                <div class="data-section-title">
                    Informasi Dataset
                </div>


                <div class="data-form-grid">

                    <div class="data-form-group full">

                        <label class="data-form-label">
                            Nama Dataset <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_dataset"
                            class="data-form-control"
                            placeholder="Contoh: Data Penduduk Kota Bekasi"
                            value="{{ old('nama_dataset') }}"
                            required
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Topik <span>*</span>
                        </label>

                        <select
                            name="topik"
                            class="data-form-control"
                            required
                        >

                            <option value="">
                                Pilih Topik
                            </option>

                            @foreach($topikData as $topik)

                                <option
                                    value="{{ $topik }}"
                                    {{ old('topik') === $topik ? 'selected' : '' }}
                                >
                                    {{ $topik }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Tahun <span>*</span>
                        </label>

                        <input
                            type="number"
                            name="tahun"
                            class="data-form-control"
                            min="1900"
                            max="2200"
                            placeholder="Contoh: 2026"
                            value="{{ old('tahun') }}"
                            required
                        >

                    </div>


                    <div class="data-form-group full">

                        <label class="data-form-label">
                            Deskripsi Dataset
                        </label>

                        <textarea
                            name="deskripsi"
                            class="data-form-control"
                            placeholder="Deskripsi singkat dataset..."
                        >{{ old('deskripsi') }}</textarea>

                    </div>

                </div>


                <div
                    class="data-section-title"
                    style="margin-top:25px;"
                >
                    Metadata Dataset
                </div>


                <div class="metadata-note">

                    Isi metadata secara manual pada form berikut.
                    Untuk import Excel, metadata akan diambil otomatis
                    dari Sheet <strong>Metadata</strong>.

                </div>


                <div class="data-form-grid">

                    <div class="data-form-group">

                        <label class="data-form-label">
                            Dataset Dibuat
                        </label>

                        <input
                            type="text"
                            name="dataset_dibuat"
                            class="data-form-control"
                            placeholder="Contoh: 15 September 2026"
                            value="{{ old('dataset_dibuat') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Dataset Diperbarui
                        </label>

                        <input
                            type="text"
                            name="dataset_diperbarui"
                            class="data-form-control"
                            placeholder="Contoh: 15 September 2026"
                            value="{{ old('dataset_diperbarui') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Pengukuran Dataset
                        </label>

                        <input
                            type="text"
                            name="pengukuran_dataset"
                            class="data-form-control"
                            placeholder="Contoh: Jumlah Penduduk"
                            value="{{ old('pengukuran_dataset') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Tingkat Penyajian Dataset
                        </label>

                        <input
                            type="text"
                            name="tingkat_penyajian_dataset"
                            class="data-form-control"
                            placeholder="Contoh: Kota Bekasi"
                            value="{{ old('tingkat_penyajian_dataset') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Cakupan Dataset
                        </label>

                        <input
                            type="text"
                            name="cakupan_dataset"
                            class="data-form-control"
                            placeholder="Contoh: Seluruh kecamatan"
                            value="{{ old('cakupan_dataset') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Produsen
                        </label>

                        <input
                            type="text"
                            name="produsen"
                            class="data-form-control"
                            placeholder="Contoh: Diskominfostandi Kota Bekasi"
                            value="{{ old('produsen') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Kontak Produsen
                        </label>

                        <input
                            type="text"
                            name="kontak_produsen"
                            class="data-form-control"
                            placeholder="Contoh: diskominfo@bekasikota.go.id"
                            value="{{ old('kontak_produsen') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Kode Indikator
                        </label>

                        <input
                            type="text"
                            name="kode_indikator"
                            class="data-form-control"
                            placeholder="Contoh: PEND-001"
                            value="{{ old('kode_indikator') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Satuan Dataset
                        </label>

                        <input
                            type="text"
                            name="satuan_dataset"
                            class="data-form-control"
                            placeholder="Contoh: Jiwa"
                            value="{{ old('satuan_dataset') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Frekuensi Dataset
                        </label>

                        <input
                            type="text"
                            name="frekuensi_dataset"
                            class="data-form-control"
                            placeholder="Contoh: Tahunan"
                            value="{{ old('frekuensi_dataset') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Sumber Eksternal
                        </label>

                        <input
                            type="text"
                            name="sumber_eksternal"
                            class="data-form-control"
                            placeholder="Contoh: BPS / -"
                            value="{{ old('sumber_eksternal') }}"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Dimensi Dataset
                        </label>

                        <input
                            type="text"
                            name="dimensi_dataset"
                            class="data-form-control"
                            placeholder="Contoh: Kecamatan dan Tahun"
                            value="{{ old('dimensi_dataset') }}"
                        >

                    </div>


                    <div class="data-form-group full">

                        <label class="data-form-label">
                            Deskripsi Metadata
                        </label>

                        <textarea
                            name="deskripsi_metadata"
                            class="data-form-control"
                            placeholder="Deskripsi metadata dataset..."
                        >{{ old('deskripsi_metadata') }}</textarea>

                    </div>

                </div>

            </div>


            <div class="data-modal-footer">

                <button
                    type="button"
                    class="data-modal-cancel"
                    onclick="closeModal('addModal')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="data-modal-save"
                >
                    <i class="bi bi-check-lg"></i>
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     MODAL IMPORT EXCEL
========================================================= --}}

<div
    id="importModal"
    class="data-modal-overlay"
    aria-hidden="true"
>

    <div class="data-modal data-modal-small">

        <div class="data-modal-header">

            <div class="data-modal-header-left">

                <div class="data-modal-icon">
                    <i class="bi bi-file-earmark-excel-fill"></i>
                </div>

                <div>

                    <h2 class="data-modal-title">
                        Import Excel
                    </h2>

                    <p class="data-modal-subtitle">
                        Import metadata dan isi dataset dari Excel.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="data-modal-close"
                onclick="closeModal('importModal')"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        <form
            action="{{ route('data.import') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="data-modal-body">

                <div class="metadata-note">

                    Gunakan template Excel.
                    Sheet pertama bernama
                    <strong>Metadata</strong>
                    dan sheet kedua bernama
                    <strong>Dataset</strong>.

                    Metadata akan dibaca otomatis dari Sheet Metadata.

                </div>


                <div class="data-form-grid">

                    <div class="data-form-group full">

                        <label class="data-form-label">
                            Nama Dataset <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_dataset"
                            class="data-form-control"
                            placeholder="Contoh: Data Penduduk Kota Bekasi"
                            required
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Topik <span>*</span>
                        </label>

                        <select
                            name="topik"
                            class="data-form-control"
                            required
                        >

                            <option value="">
                                Pilih Topik
                            </option>

                            @foreach($topikData as $topik)

                                <option value="{{ $topik }}">
                                    {{ $topik }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Tahun <span>*</span>
                        </label>

                        <input
                            type="number"
                            name="tahun"
                            class="data-form-control"
                            min="1900"
                            max="2200"
                            placeholder="Contoh: 2026"
                            required
                        >

                    </div>


                    <div class="data-form-group full">

                        <label class="data-form-label">
                            Deskripsi Dataset
                        </label>

                        <textarea
                            name="deskripsi"
                            class="data-form-control"
                            placeholder="Boleh dikosongkan. Deskripsi dari metadata akan digunakan."
                        ></textarea>

                    </div>


                    <div class="data-form-group full">

                        <label class="data-form-label">
                            File Excel <span>*</span>
                        </label>

                        <input
                            type="file"
                            name="file_data"
                            class="data-form-control"
                            accept=".xlsx,.xls"
                            required
                        >

                        <small class="data-form-help">
                            Format XLS/XLSX. Maksimal 10 MB.
                        </small>

                    </div>

                </div>

            </div>


            <div class="data-modal-footer">

                <button
                    type="button"
                    class="data-modal-cancel"
                    onclick="closeModal('importModal')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="data-modal-save"
                >
                    <i class="bi bi-upload"></i>
                    Import Dataset
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     MODAL EDIT
========================================================= --}}

<div
    id="editModal"
    class="data-modal-overlay"
    aria-hidden="true"
>

    <div class="data-modal">

        <div class="data-modal-header">

            <div class="data-modal-header-left">

                <div class="data-modal-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>

                <div>

                    <h2 class="data-modal-title">
                        Edit Dataset
                    </h2>

                    <p class="data-modal-subtitle">
                        Perbarui informasi dan metadata dataset.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="data-modal-close"
                onclick="closeModal('editModal')"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        <form
            id="editForm"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="data-modal-body">

                <div class="data-section-title">
                    Informasi Dataset
                </div>


                <div class="data-form-grid">

                    <div class="data-form-group full">

                        <label class="data-form-label">
                            Nama Dataset <span>*</span>
                        </label>

                        <input
                            type="text"
                            id="edit_nama_dataset"
                            name="nama_dataset"
                            class="data-form-control"
                            required
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Topik <span>*</span>
                        </label>

                        <select
                            id="edit_topik"
                            name="topik"
                            class="data-form-control"
                            required
                        >

                            @foreach($topikData as $topik)

                                <option value="{{ $topik }}">
                                    {{ $topik }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Tahun <span>*</span>
                        </label>

                        <input
                            type="number"
                            id="edit_tahun"
                            name="tahun"
                            class="data-form-control"
                            min="1900"
                            max="2200"
                            required
                        >

                    </div>


                    <div class="data-form-group full">

                        <label class="data-form-label">
                            Deskripsi Dataset
                        </label>

                        <textarea
                            id="edit_deskripsi"
                            name="deskripsi"
                            class="data-form-control"
                        ></textarea>

                    </div>

                </div>


                <div
                    class="data-section-title"
                    style="margin-top:25px;"
                >
                    Metadata Dataset
                </div>


                <div class="data-form-grid">

                    <div class="data-form-group">

                        <label class="data-form-label">
                            Dataset Dibuat
                        </label>

                        <input
                            type="text"
                            id="edit_dataset_dibuat"
                            name="dataset_dibuat"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Dataset Diperbarui
                        </label>

                        <input
                            type="text"
                            id="edit_dataset_diperbarui"
                            name="dataset_diperbarui"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Pengukuran Dataset
                        </label>

                        <input
                            type="text"
                            id="edit_pengukuran_dataset"
                            name="pengukuran_dataset"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Tingkat Penyajian Dataset
                        </label>

                        <input
                            type="text"
                            id="edit_tingkat_penyajian_dataset"
                            name="tingkat_penyajian_dataset"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Cakupan Dataset
                        </label>

                        <input
                            type="text"
                            id="edit_cakupan_dataset"
                            name="cakupan_dataset"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Produsen
                        </label>

                        <input
                            type="text"
                            id="edit_produsen"
                            name="produsen"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Kontak Produsen
                        </label>

                        <input
                            type="text"
                            id="edit_kontak_produsen"
                            name="kontak_produsen"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Kode Indikator
                        </label>

                        <input
                            type="text"
                            id="edit_kode_indikator"
                            name="kode_indikator"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Satuan Dataset
                        </label>

                        <input
                            type="text"
                            id="edit_satuan_dataset"
                            name="satuan_dataset"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Frekuensi Dataset
                        </label>

                        <input
                            type="text"
                            id="edit_frekuensi_dataset"
                            name="frekuensi_dataset"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Sumber Eksternal
                        </label>

                        <input
                            type="text"
                            id="edit_sumber_eksternal"
                            name="sumber_eksternal"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group">

                        <label class="data-form-label">
                            Dimensi Dataset
                        </label>

                        <input
                            type="text"
                            id="edit_dimensi_dataset"
                            name="dimensi_dataset"
                            class="data-form-control"
                        >

                    </div>


                    <div class="data-form-group full">

                        <label class="data-form-label">
                            Deskripsi Metadata
                        </label>

                        <textarea
                            id="edit_deskripsi_metadata"
                            name="deskripsi_metadata"
                            class="data-form-control"
                        ></textarea>

                    </div>


                    <div class="data-form-group full">

                        <label class="data-form-label">
                            Ganti File Excel
                        </label>

                        <input
                            type="file"
                            name="file_data"
                            class="data-form-control"
                            accept=".xlsx,.xls"
                        >

                        <small class="data-form-help">
                            Kosongkan jika tidak ingin mengganti file Excel.
                        </small>


                        <div
                            id="editCurrentFile"
                            class="data-current-file"
                        >

                            File saat ini:

                            <a
                                id="editCurrentFileLink"
                                href="#"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Lihat File
                            </a>

                        </div>

                    </div>

                </div>

            </div>


            <div class="data-modal-footer">

                <button
                    type="button"
                    class="data-modal-cancel"
                    onclick="closeModal('editModal')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="data-modal-save"
                >
                    <i class="bi bi-check-lg"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>


<script>

const dataRecords =
    @json($data->items());


/* =========================================================
   FILTER
========================================================= */

function toggleDataFilter(event)
{
    if (event) {
        event.stopPropagation();
    }

    const dropdown =
        document.getElementById(
            'dataFilterDropdown'
        );

    if (!dropdown) {
        return;
    }

    dropdown.classList.toggle(
        'show'
    );
}


function resetDataFilter()
{
    window.location.href =
        "{{ route('data.index') }}";
}


/* =========================================================
   MODAL
========================================================= */

function openModal(id)
{
    const modal =
        document.getElementById(id);

    if (!modal) {
        return;
    }

    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'data-modal-open'
    );
}


function closeModal(id)
{
    const modal =
        document.getElementById(id);

    if (!modal) {
        return;
    }

    modal.classList.remove(
        'show'
    );

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.classList.remove(
        'data-modal-open'
    );
}


/* =========================================================
   TAMBAH
========================================================= */

function openAddModal()
{
    openModal(
        'addModal'
    );
}


/* =========================================================
   IMPORT
========================================================= */

function openImportModal()
{
    openModal(
        'importModal'
    );
}


/* =========================================================
   EDIT
========================================================= */

function openEditModal(id)
{
    const data =
        dataRecords.find(
            function(item)
            {
                return String(item.id)
                    === String(id);
            }
        );

    if (!data) {
        alert(
            'Dataset tidak ditemukan.'
        );

        return;
    }


    const form =
        document.getElementById(
            'editForm'
        );

    form.action =
        "{{ url('/data') }}/" + id;


    document.getElementById(
        'edit_nama_dataset'
    ).value =
        data.nama_dataset ?? '';


    document.getElementById(
        'edit_topik'
    ).value =
        data.topik ?? '';


    document.getElementById(
        'edit_tahun'
    ).value =
        data.tahun ?? '';


    document.getElementById(
        'edit_deskripsi'
    ).value =
        data.deskripsi ?? '';


    const metadata =
        data.metadata || {};


    document.getElementById(
        'edit_dataset_dibuat'
    ).value =
        metadata['Dataset Dibuat']
        ?? '';


    document.getElementById(
        'edit_dataset_diperbarui'
    ).value =
        metadata['Dataset Diperbarui']
        ?? '';


    document.getElementById(
        'edit_pengukuran_dataset'
    ).value =
        metadata['Pengukuran Dataset']
        ?? '';


    document.getElementById(
        'edit_tingkat_penyajian_dataset'
    ).value =
        metadata['Tingkat Penyajian Dataset']
        ?? '';


    document.getElementById(
        'edit_cakupan_dataset'
    ).value =
        metadata['Cakupan Dataset']
        ?? '';


    document.getElementById(
        'edit_produsen'
    ).value =
        metadata['Produsen']
        ?? '';


    document.getElementById(
        'edit_kontak_produsen'
    ).value =
        metadata['Kontak Produsen']
        ?? '';


    document.getElementById(
        'edit_kode_indikator'
    ).value =
        metadata['Kode Indikator']
        ?? '';


    document.getElementById(
        'edit_satuan_dataset'
    ).value =
        metadata['Satuan Dataset']
        ?? '';


    document.getElementById(
        'edit_frekuensi_dataset'
    ).value =
        metadata['Frekuensi Dataset']
        ?? '';


    document.getElementById(
        'edit_sumber_eksternal'
    ).value =
        metadata['Sumber Eksternal']
        ?? '';


    document.getElementById(
        'edit_dimensi_dataset'
    ).value =
        metadata['Dimensi Dataset']
        ?? '';


    document.getElementById(
        'edit_deskripsi_metadata'
    ).value =
        metadata['Deskripsi']
        ?? '';


    const currentFile =
        document.getElementById(
            'editCurrentFile'
        );

    const currentFileLink =
        document.getElementById(
            'editCurrentFileLink'
        );


    if (
        data.file_data &&
        currentFile &&
        currentFileLink
    ) {

        currentFileLink.href =
            "{{ asset('storage') }}/" +
            data.file_data;

        currentFile.style.display =
            'block';

    } else if (currentFile) {

        currentFile.style.display =
            'none';
    }


    openModal(
        'editModal'
    );
}


/* =========================================================
   CLICK OUTSIDE FILTER
========================================================= */

document.addEventListener(
    'click',
    function(event)
    {
        const wrap =
            document.querySelector(
                '.data-filter-wrap'
            );

        const dropdown =
            document.getElementById(
                'dataFilterDropdown'
            );

        if (
            dropdown &&
            wrap &&
            !wrap.contains(
                event.target
            )
        ) {

            dropdown.classList.remove(
                'show'
            );
        }
    }
);


/* =========================================================
   CLICK OUTSIDE MODAL
========================================================= */

document.querySelectorAll(
    '.data-modal-overlay'
).forEach(
    function(modal)
    {
        modal.addEventListener(
            'click',
            function(event)
            {
                if (
                    event.target ===
                    modal
                ) {

                    closeModal(
                        modal.id
                    );
                }
            }
        );
    }
);


/* =========================================================
   ESC
========================================================= */

document.addEventListener(
    'keydown',
    function(event)
    {
        if (
            event.key !==
            'Escape'
        ) {
            return;
        }

        document
            .querySelectorAll(
                '.data-modal-overlay.show'
            )
            .forEach(
                function(modal)
                {
                    closeModal(
                        modal.id
                    );
                }
            );
    }
);


/* =========================================================
   VALIDATION ERROR
========================================================= */

@if($errors->any())

document.addEventListener(
    'DOMContentLoaded',
    function()
    {
        openAddModal();
    }
);

@endif

</script>

@endsection