@extends('layouts.app')

@section('title', 'Data - Inventory IT Assets')

@section('page-title', 'DATA')


@push('styles')

<style>

/* =========================================================
   DATA PAGE
========================================================= */

.data-page {
    width: 100%;
}


/* =========================================================
   ALERT
========================================================= */

.alert-success,
.alert-error {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 14px 18px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-success {
    background: #ecfdf3;
    color: #15803d;
    border: 1px solid #bbf7d0;
}

.alert-error {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.alert-error ul {
    margin: 6px 0 0 20px;
    padding: 0;
}


/* =========================================================
   SUMMARY CARD
========================================================= */

.summary-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.summary-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 22px 24px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.summary-label {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 8px;
}

.summary-value {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
}


/* =========================================================
   TABLE CONTAINER
========================================================= */

.data-table-container {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}


/* =========================================================
   TOOLBAR
========================================================= */

.table-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.table-toolbar-left {
    display: flex;
    align-items: center;
}

.table-search {
    width: 280px;
    height: 40px;
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 0 13px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    background: #ffffff;
}

.table-search i {
    color: #9ca3af;
}

.table-search input {
    width: 100%;
    border: none;
    outline: none;
    font-size: 14px;
}

.table-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-button,
.add-button {
    height: 40px;
    padding: 0 15px;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 7px;
}

.filter-button {
    background: #ffffff;
    color: #374151;
    border: 1px solid #d1d5db;
}

.filter-button:hover {
    background: #f9fafb;
}

.add-button {
    background: #2563eb;
    color: #ffffff;
    border: none;
}

.add-button:hover {
    background: #1d4ed8;
}


/* =========================================================
   FILTER
========================================================= */

.filter-box {
    display: none;
    padding: 18px 20px;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.filter-box.show {
    display: block;
}

.filter-form {
    display: flex;
    align-items: flex-end;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.filter-group label {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
}

.filter-group select {
    min-width: 180px;
    height: 38px;
    padding: 0 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: #ffffff;
    outline: none;
}

.filter-submit,
.filter-reset {
    height: 38px;
    padding: 0 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    text-decoration: none;
}

.filter-submit {
    border: none;
    background: #2563eb;
    color: #ffffff;
}

.filter-reset {
    border: 1px solid #d1d5db;
    background: #ffffff;
    color: #374151;
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
    border-collapse: collapse;
    min-width: 1100px;
}

.data-table th {
    background: #f9fafb;
    color: #374151;
    font-size: 12px;
    font-weight: 700;
    text-align: left;
    padding: 14px 15px;
    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
}

.data-table td {
    padding: 15px;
    font-size: 13px;
    color: #374151;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: #fafafa;
}


/* =========================================================
   VERIFIKASI
========================================================= */

.verifikasi {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.verifikasi-approved {
    background: #dcfce7;
    color: #15803d;
}

.verifikasi-pending {
    background: #fef3c7;
    color: #b45309;
}

.verifikasi-rejected {
    background: #fee2e2;
    color: #dc2626;
}


/* =========================================================
   FILE
========================================================= */

.file-button {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 6px;
    background: #eff6ff;
    color: #2563eb;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.file-button:hover {
    background: #dbeafe;
}

.no-file {
    color: #9ca3af;
    font-size: 12px;
    white-space: nowrap;
}


/* =========================================================
   COMMENT
========================================================= */

.comment-button {
    border: none;
    background: transparent;
    color: #2563eb;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.comment-button:hover {
    text-decoration: underline;
}

.no-comment {
    color: #9ca3af;
    font-size: 12px;
}


/* =========================================================
   ACTION
========================================================= */

.action-buttons {
    display: flex;
    align-items: center;
    gap: 7px;
}

.action-buttons form {
    margin: 0;
}

.action-button {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-decoration: none;
}

.action-button.edit {
    background: #eff6ff;
    color: #2563eb;
}

.action-button.edit:hover {
    background: #dbeafe;
}

.action-button.delete {
    background: #fef2f2;
    color: #dc2626;
}

.action-button.delete:hover {
    background: #fee2e2;
}


/* =========================================================
   EMPTY
========================================================= */

.empty-data {
    text-align: center !important;
    padding: 50px !important;
    color: #9ca3af !important;
}

.empty-data i {
    display: block;
    font-size: 35px;
    margin-bottom: 10px;
}


/* =========================================================
   FOOTER
========================================================= */

.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    font-size: 12px;
    color: #6b7280;
}

.show-data {
    display: flex;
    align-items: center;
    gap: 7px;
}

.show-data form {
    margin: 0;
}

.show-data select {
    height: 32px;
    border: 1px solid #d1d5db;
    border-radius: 5px;
    padding: 0 8px;
    outline: none;
}

.pagination {
    display: flex;
    align-items: center;
    gap: 4px;
}

.page-link {
    min-width: 30px;
    height: 30px;
    padding: 0 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #e5e7eb;
    border-radius: 5px;
    color: #374151;
    text-decoration: none;
    background: #ffffff;
}

.page-link:hover {
    background: #f3f4f6;
}

.page-link.active {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
}


/* =========================================================
   MODAL
========================================================= */

.data-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.data-modal.show {
    display: flex;
}

.data-modal-content {
    width: 100%;
    max-width: 520px;
    max-height: 90vh;
    overflow-y: auto;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

.comment-modal-content {
    max-width: 500px;
}

.data-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.data-modal-header h2 {
    margin: 0;
    font-size: 19px;
    color: #111827;
}

.modal-close {
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    font-size: 25px;
    color: #6b7280;
    cursor: pointer;
    border-radius: 5px;
}

.modal-close:hover {
    background: #f3f4f6;
}


/* =========================================================
   FORM
========================================================= */

.data-modal-content form {
    padding: 20px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 7px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

.form-control-data {
    width: 100%;
    height: 42px;
    padding: 0 12px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    outline: none;
    font-size: 13px;
    box-sizing: border-box;
}

.form-control-data:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
}

input[type="file"].form-control-data {
    height: auto;
    padding: 9px 10px;
    cursor: pointer;
}

.form-help {
    display: block;
    margin-top: 6px;
    color: #6b7280;
    font-size: 11px;
}


/* =========================================================
   STATUS INFO
========================================================= */

.status-info {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    padding: 12px;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: 7px;
    color: #1d4ed8;
    font-size: 12px;
    line-height: 1.5;
    margin-bottom: 20px;
}

.status-info i {
    margin-top: 2px;
}


/* =========================================================
   FORM ACTION
========================================================= */

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 5px;
}

.cancel-btn,
.save-btn {
    height: 40px;
    padding: 0 16px;
    border-radius: 7px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.cancel-btn {
    border: 1px solid #d1d5db;
    background: #ffffff;
    color: #374151;
}

.cancel-btn:hover {
    background: #f9fafb;
}

.save-btn {
    border: none;
    background: #2563eb;
    color: #ffffff;
}

.save-btn:hover {
    background: #1d4ed8;
}


/* =========================================================
   COMMENT MODAL
========================================================= */

.comment-box {
    margin: 20px;
    padding: 16px;
    border-radius: 8px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.comment-box i {
    color: #2563eb;
    margin-top: 3px;
}

.comment-box p {
    margin: 0;
    color: #374151;
    font-size: 13px;
    line-height: 1.6;
    white-space: pre-wrap;
}

.comment-modal-content .form-actions {
    padding: 0 20px 20px;
}


/* =========================================================
   CURRENT FILE
========================================================= */

.current-file {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    padding: 9px 11px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    font-size: 12px;
    color: #374151;
}

.current-file i {
    color: #2563eb;
}

.current-file a {
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
}

.current-file a:hover {
    text-decoration: underline;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .summary-cards {
        grid-template-columns: 1fr;
    }

    .table-toolbar {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }

    .table-search {
        width: 100%;
    }

    .table-actions {
        justify-content: flex-end;
    }

    .table-footer {
        flex-wrap: wrap;
        gap: 15px;
    }

}

</style>

@endpush


@section('content')

<div class="data-page">


    {{-- =================================================
         ALERT SUCCESS
    ================================================== --}}

    @if(session('success'))

        <div class="alert-success">

            <i class="bi bi-check-circle"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- =================================================
         ALERT ERROR
    ================================================== --}}

    @if(session('error'))

        <div class="alert-error">

            <i class="bi bi-exclamation-circle"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =================================================
         VALIDATION ERROR
    ================================================== --}}

    @if($errors->any())

        <div class="alert-error">

            <i class="bi bi-exclamation-circle"></i>

            <div>

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

        </div>

    @endif


    {{-- =================================================
         SUMMARY
    ================================================== --}}

    <div class="summary-cards">


        <div class="summary-card">

            <div class="summary-label">
                TOTAL DATASET
            </div>

            <div class="summary-value">
                {{ $totalData }}
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-label">
                JENIS DATA
            </div>

            <div class="summary-value">
                {{ $totalJenis }}
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-label">
                MENUNGGU DISETUJUI
            </div>

            <div class="summary-value">
                {{ $totalPending }}
            </div>

        </div>


    </div>


    {{-- =================================================
         TABLE
    ================================================== --}}

    <div class="data-table-container">


        {{-- TOOLBAR --}}

        <div class="table-toolbar">


            <div class="table-toolbar-left">

                <form
                    method="GET"
                    action="{{ route('data.index') }}">

                    <div class="table-search">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search..."
                            autocomplete="off">

                    </div>

                </form>

            </div>


            <div class="table-actions">


                <button
                    type="button"
                    class="filter-button"
                    onclick="toggleFilter()">

                    <i class="bi bi-filter"></i>

                    Filter

                </button>


                <button
                    type="button"
                    class="add-button"
                    onclick="openAddModal()">

                    <i class="bi bi-plus-lg"></i>

                    Ajukan Data

                </button>


            </div>

        </div>


        {{-- =================================================
             FILTER
        ================================================== --}}

        <div
            class="filter-box
            {{ request('jenis_data') || request('tahun') || request('verifikasi') ? 'show' : '' }}"
            id="filterBox">


            <form
                method="GET"
                action="{{ route('data.index') }}"
                class="filter-form">


                <input
                    type="hidden"
                    name="search"
                    value="{{ request('search') }}">


                <div class="filter-group">

                    <label>
                        Jenis Data
                    </label>

                    <select name="jenis_data">

                        <option value="">
                            Semua Jenis Data
                        </option>

                        @foreach($jenisData as $jenis)

                            <option
                                value="{{ $jenis }}"
                                {{ request('jenis_data') == $jenis ? 'selected' : '' }}>

                                {{ $jenis }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="filter-group">

                    <label>
                        Tahun
                    </label>

                    <select name="tahun">

                        <option value="">
                            Semua Tahun
                        </option>

                        @foreach($tahunData as $tahun)

                            <option
                                value="{{ $tahun }}"
                                {{ request('tahun') == $tahun ? 'selected' : '' }}>

                                {{ $tahun }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="filter-group">

                    <label>
                        Status Verifikasi
                    </label>

                    <select name="verifikasi">

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="Menunggu Disetujui"
                            {{ request('verifikasi') == 'Menunggu Disetujui' ? 'selected' : '' }}>

                            Menunggu Disetujui

                        </option>

                        <option
                            value="Disetujui"
                            {{ request('verifikasi') == 'Disetujui' ? 'selected' : '' }}>

                            Disetujui

                        </option>

                        <option
                            value="Ditolak"
                            {{ request('verifikasi') == 'Ditolak' ? 'selected' : '' }}>

                            Ditolak

                        </option>

                    </select>

                </div>


                <button
                    type="submit"
                    class="filter-submit">

                    <i class="bi bi-check-lg"></i>

                    Terapkan

                </button>


                <a
                    href="{{ route('data.index') }}"
                    class="filter-reset">

                    <i class="bi bi-arrow-counterclockwise"></i>

                    Reset

                </a>


            </form>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="data-table-wrapper">

            <table class="data-table">

                <thead>

                    <tr>

                        <th width="7%">
                            ID
                        </th>

                        <th width="18%">
                            NAMA DATASET
                        </th>

                        <th width="14%">
                            JENIS DATA
                        </th>

                        <th width="8%">
                            TAHUN
                        </th>

                        <th width="13%">
                            TANGGAL PENGAJUAN
                        </th>

                        <th width="13%">
                            FILE DATA
                        </th>

                        <th width="13%">
                            VERIFIKASI
                        </th>

                        <th width="14%">
                            KOMENTAR
                        </th>

                        <th width="10%">
                            AKSI
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($data as $item)

                        <tr>


                            <td>

                                DS-{{
                                    str_pad(
                                        $item->id,
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    )
                                }}

                            </td>


                            <td>

                                {{ $item->nama_dataset }}

                            </td>


                            <td>

                                {{ $item->jenis_data }}

                            </td>


                            <td>

                                {{ $item->tahun }}

                            </td>


                            <td>

                                @if($item->tanggal_pengajuan)

                                    {{ \Carbon\Carbon::parse(
                                        $item->tanggal_pengajuan
                                    )->format('d/m/Y H:i') }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- FILE DATA --}}

                            <td>

                                @if($item->file_data)

                                    <a
                                        href="{{ asset('storage/' . $item->file_data) }}"
                                        rel="noopener noreferrer"
                                        class="file-button"> 

                                        <i class="bi bi-eye"></i>

                                        Lihat File

                                    </a>

                                @else

                                    <span class="no-file">

                                        <i class="bi bi-file-earmark-x"></i>

                                        Tidak ada file

                                    </span>

                                @endif

                            </td>


                            {{-- VERIFIKASI --}}

                            <td>

                                @if($item->verifikasi == 'Disetujui')

                                    <span class="verifikasi verifikasi-approved">

                                        <i class="bi bi-check-circle"></i>

                                        Disetujui

                                    </span>

                                @elseif($item->verifikasi == 'Menunggu Disetujui')

                                    <span class="verifikasi verifikasi-pending">

                                        <i class="bi bi-clock"></i>

                                        Menunggu Disetujui

                                    </span>

                                @elseif($item->verifikasi == 'Ditolak')

                                    <span class="verifikasi verifikasi-rejected">

                                        <i class="bi bi-x-circle"></i>

                                        Ditolak

                                    </span>

                                @else

                                    <span class="verifikasi">

                                        -

                                    </span>

                                @endif

                            </td>


                            {{-- KOMENTAR --}}

                            <td>

                                @if(
                                    $item->verifikasi == 'Ditolak' &&
                                    $item->komentar_verifikasi
                                )

                                    <button
                                        type="button"
                                        class="comment-button"
                                        onclick="showComment(
                                            @js($item->komentar_verifikasi)
                                        )">

                                        <i class="bi bi-chat-left-text"></i>

                                        Lihat Komentar

                                    </button>

                                @elseif($item->verifikasi == 'Ditolak')

                                    <span class="no-comment">

                                        Tidak ada komentar

                                    </span>

                                @else

                                    <span class="no-comment">

                                        -

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td>

                                <div class="action-buttons">


                                    {{-- EDIT POPUP --}}

                                    <button
                                        type="button"
                                        class="action-button edit"
                                        title="Edit"
                                        onclick='openEditModal(
                                            @json($item->id),
                                            @json($item->nama_dataset),
                                            @json($item->jenis_data),
                                            @json($item->tahun),
                                            @json($item->file_data)
                                        )'>

                                        <i class="bi bi-pencil-fill"></i>

                                    </button>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route('data.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm(
                                            'Yakin ingin menghapus data ini?'
                                        )">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-button delete"
                                            title="Hapus">

                                            <i class="bi bi-trash-fill"></i>

                                        </button>

                                    </form>


                                </div>

                            </td>


                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="empty-data">

                                <i class="bi bi-database-x"></i>

                                Tidak ada data ditemukan.

                            </td>

                        </tr>

                    @endforelse


                </tbody>

            </table>

        </div>


        {{-- =================================================
             FOOTER
        ================================================== --}}

        <div class="table-footer">


            <div class="show-data">

                <span>
                    Show
                </span>

                <form
                    method="GET"
                    action="{{ route('data.index') }}"
                    id="showForm">

                    <input
                        type="hidden"
                        name="search"
                        value="{{ request('search') }}">

                    <input
                        type="hidden"
                        name="jenis_data"
                        value="{{ request('jenis_data') }}">

                    <input
                        type="hidden"
                        name="tahun"
                        value="{{ request('tahun') }}">

                    <input
                        type="hidden"
                        name="verifikasi"
                        value="{{ request('verifikasi') }}">

                    <select
                        name="show"
                        onchange="
                            document
                            .getElementById('showForm')
                            .submit()
                        ">

                        <option
                            value="10"
                            {{ request('show', 10) == 10 ? 'selected' : '' }}>

                            10

                        </option>

                        <option
                            value="25"
                            {{ request('show') == 25 ? 'selected' : '' }}>

                            25

                        </option>

                        <option
                            value="50"
                            {{ request('show') == 50 ? 'selected' : '' }}>

                            50

                        </option>

                        <option
                            value="100"
                            {{ request('show') == 100 ? 'selected' : '' }}>

                            100

                        </option>

                    </select>

                </form>

                <span>
                    entries
                </span>

            </div>


            <span>

                Showing

                {{ $data->firstItem() ?? 0 }}

                to

                {{ $data->lastItem() ?? 0 }}

                of

                {{ $data->total() }}

                entries

            </span>


            <div class="pagination">

                @if($data->onFirstPage())

                    <span class="page-link">

                        <i class="bi bi-chevron-left"></i>

                    </span>

                @else

                    <a
                        href="{{ $data->previousPageUrl() }}"
                        class="page-link">

                        <i class="bi bi-chevron-left"></i>

                    </a>

                @endif


                @foreach(
                    $data->getUrlRange(
                        1,
                        $data->lastPage()
                    )
                    as $page => $url
                )

                    @if($page == $data->currentPage())

                        <span class="page-link active">

                            {{ $page }}

                        </span>

                    @else

                        <a
                            href="{{ $url }}"
                            class="page-link">

                            {{ $page }}

                        </a>

                    @endif

                @endforeach


                @if($data->hasMorePages())

                    <a
                        href="{{ $data->nextPageUrl() }}"
                        class="page-link">

                        <i class="bi bi-chevron-right"></i>

                    </a>

                @else

                    <span class="page-link">

                        <i class="bi bi-chevron-right"></i>

                    </span>

                @endif

            </div>


        </div>


    </div>


</div>



{{-- =========================================================
     MODAL AJUKAN DATA
========================================================= --}}

<div
    class="data-modal"
    id="addDataModal">

    <div class="data-modal-content">


        <div class="data-modal-header">

            <h2>
                Ajukan Data
            </h2>

            <button
                type="button"
                class="modal-close"
                onclick="closeAddModal()">

                &times;

            </button>

        </div>


        <form
            action="{{ route('data.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf


            <div class="form-group">

                <label>
                    Nama Dataset
                </label>

                <input
                    type="text"
                    name="nama_dataset"
                    class="form-control-data"
                    value="{{ old('nama_dataset') }}"
                    placeholder="Masukkan nama dataset"
                    required>

            </div>


            <div class="form-group">

                <label>
                    Jenis Data
                </label>

                <input
                    type="text"
                    name="jenis_data"
                    class="form-control-data"
                    value="{{ old('jenis_data') }}"
                    placeholder="Contoh: Data Kepegawaian"
                    required>

            </div>


            <div class="form-group">

                <label>
                    Tahun
                </label>

                <select
                    name="tahun"
                    class="form-control-data"
                    required>

                    <option value="">
                        Pilih Tahun
                    </option>

                    @for(
                        $tahun = date('Y');
                        $tahun >= 1900;
                        $tahun--
                    )

                        <option
                            value="{{ $tahun }}"
                            {{ old('tahun') == $tahun ? 'selected' : '' }}>

                            {{ $tahun }}

                        </option>

                    @endfor

                </select>

            </div>


            <div class="form-group">

                <label>
                    File Data
                </label>

                <input
                    type="file"
                    name="file_data"
                    class="form-control-data"
                    accept=".csv,.xls,.xlsx,.pdf,.zip"
                    required>

                <small class="form-help">

                    Format file: CSV, XLS, XLSX, PDF, ZIP.
                    Maksimal 10 MB.

                </small>

            </div>


            <div class="status-info">

                <i class="bi bi-info-circle"></i>

                <span>

                    Setelah dikirim, data akan otomatis berstatus

                    <strong>
                        Menunggu Disetujui
                    </strong>

                    dan akan diperiksa oleh Verifikator.

                </span>

            </div>


            <div class="form-actions">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeAddModal()">

                    Batal

                </button>

                <button
                    type="submit"
                    class="save-btn">

                    <i class="bi bi-send"></i>

                    Ajukan Data

                </button>

            </div>


        </form>

    </div>

</div>



{{-- =========================================================
     MODAL EDIT DATA
========================================================= --}}

<div
    class="data-modal"
    id="editDataModal">

    <div class="data-modal-content">


        <div class="data-modal-header">

            <h2>
                Edit Data
            </h2>

            <button
                type="button"
                class="modal-close"
                onclick="closeEditModal()">

                &times;

            </button>

        </div>


        <form
            id="editDataForm"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            @method('PUT')


            {{-- NAMA DATASET --}}

            <div class="form-group">

                <label>
                    Nama Dataset
                </label>

                <input
                    type="text"
                    id="edit_nama_dataset"
                    name="nama_dataset"
                    class="form-control-data"
                    required>

            </div>


            {{-- JENIS DATA --}}

            <div class="form-group">

                <label>
                    Jenis Data
                </label>

                <input
                    type="text"
                    id="edit_jenis_data"
                    name="jenis_data"
                    class="form-control-data"
                    required>

            </div>


            {{-- TAHUN --}}

            <div class="form-group">

                <label>
                    Tahun
                </label>

                <select
                    id="edit_tahun"
                    name="tahun"
                    class="form-control-data"
                    required>

                    <option value="">
                        Pilih Tahun
                    </option>

                    @for(
                        $tahun = date('Y');
                        $tahun >= 1900;
                        $tahun--
                    )

                        <option value="{{ $tahun }}">
                            {{ $tahun }}
                        </option>

                    @endfor

                </select>

            </div>


            {{-- FILE DATA --}}

            <div class="form-group">

                <label>
                    File Data
                </label>


                <div
                    id="edit_current_file"
                    class="current-file"
                    style="display:none;">

                    <i class="bi bi-file-earmark"></i>

                    <span>
                        File saat ini:
                    </span>

                    <a
                        id="edit_file_link"
                        href="#"
                        target="_blank">

                        Lihat File

                    </a>

                </div>


                <input
                    type="file"
                    name="file_data"
                    class="form-control-data"
                    accept=".csv,.xls,.xlsx,.pdf,.zip">


                <small class="form-help">

                    Kosongkan jika tidak ingin mengganti file.
                    Format: CSV, XLS, XLSX, PDF, ZIP. Maksimal 10 MB.

                </small>

            </div>


            {{-- INFO --}}

            <div class="status-info">

                <i class="bi bi-info-circle"></i>

                <span>

                    Data yang sudah ada akan diperbarui.
                    Status verifikasi tetap

                    <strong>
                        Menunggu Disetujui
                    </strong>

                    jika masih dalam proses pengajuan.

                </span>

            </div>


            {{-- BUTTON --}}

            <div class="form-actions">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeEditModal()">

                    Batal

                </button>


                <button
                    type="submit"
                    class="save-btn">

                    <i class="bi bi-save"></i>

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
    class="data-modal"
    id="commentModal">

    <div class="data-modal-content comment-modal-content">


        <div class="data-modal-header">

            <h2>
                Komentar Verifikator
            </h2>

            <button
                type="button"
                class="modal-close"
                onclick="closeCommentModal()">

                &times;

            </button>

        </div>


        <div class="comment-box">

            <i class="bi bi-chat-left-text"></i>

            <p id="commentText"></p>

        </div>


        <div class="form-actions">

            <button
                type="button"
                class="cancel-btn"
                onclick="closeCommentModal()">

                Tutup

            </button>

        </div>


    </div>

</div>


@endsection



@push('scripts')

<script>

/* =========================================================
   FILTER
========================================================= */

function toggleFilter()
{
    const filterBox =
        document.getElementById('filterBox');

    filterBox.classList.toggle('show');
}


/* =========================================================
   ADD MODAL
========================================================= */

function openAddModal()
{
    const modal =
        document.getElementById('addDataModal');

    modal.classList.add('show');

    document.body.style.overflow = 'hidden';
}


function closeAddModal()
{
    const modal =
        document.getElementById('addDataModal');

    modal.classList.remove('show');

    document.body.style.overflow = '';
}


/* =========================================================
   EDIT MODAL
========================================================= */

function openEditModal(
    id,
    namaDataset,
    jenisData,
    tahun,
    fileData
)
{

    const modal =
        document.getElementById('editDataModal');


    const form =
        document.getElementById('editDataForm');


    const nama =
        document.getElementById('edit_nama_dataset');


    const jenis =
        document.getElementById('edit_jenis_data');


    const tahunInput =
        document.getElementById('edit_tahun');


    const currentFile =
        document.getElementById('edit_current_file');


    const fileLink =
        document.getElementById('edit_file_link');


    /*
     * ROUTE UPDATE
     *
     * Karena form edit berada di index,
     * action dibuat menggunakan URL data/{id}
     */

    form.action =
        "{{ url('/data') }}/" + id;


    nama.value =
        namaDataset;


    jenis.value =
        jenisData;


    tahunInput.value =
        tahun;


    /*
     * FILE LAMA
     */

    if(fileData)
    {

        currentFile.style.display =
            'flex';


        fileLink.href =
            "{{ asset('storage') }}/" + fileData;

    }
    else
    {

        currentFile.style.display =
            'none';

        fileLink.href =
            '#';

    }


    modal.classList.add('show');

    document.body.style.overflow =
        'hidden';
}


function closeEditModal()
{
    const modal =
        document.getElementById('editDataModal');

    modal.classList.remove('show');

    document.body.style.overflow = '';
}


/* =========================================================
   COMMENT
========================================================= */

function showComment(comment)
{

    const modal =
        document.getElementById('commentModal');


    const text =
        document.getElementById('commentText');


    text.textContent =
        comment;


    modal.classList.add('show');

    document.body.style.overflow =
        'hidden';
}


function closeCommentModal()
{

    const modal =
        document.getElementById('commentModal');


    modal.classList.remove('show');

    document.body.style.overflow =
        '';
}


/* =========================================================
   CLICK OUTSIDE MODAL
========================================================= */

window.addEventListener(
    'click',
    function(event)
    {

        const addModal =
            document.getElementById('addDataModal');


        const editModal =
            document.getElementById('editDataModal');


        const commentModal =
            document.getElementById('commentModal');


        if(event.target === addModal)
        {

            closeAddModal();

        }


        if(event.target === editModal)
        {

            closeEditModal();

        }


        if(event.target === commentModal)
        {

            closeCommentModal();

        }

    }
);


/* =========================================================
   ESC
========================================================= */

window.addEventListener(
    'keydown',
    function(event)
    {

        if(event.key === 'Escape')
        {

            closeAddModal();

            closeEditModal();

            closeCommentModal();

        }

    }
);

</script>

@endpush