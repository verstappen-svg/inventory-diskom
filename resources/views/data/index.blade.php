@extends('layouts.app')

@section('title', 'Data - Inventory IT Assets')

@section('page-title', 'DATA')


{{-- =========================================================
     CSS
========================================================= --}}
@push('styles')
    @include('data.style')
@endpush


@section('content')

<div class="data-page">


    {{-- =====================================================
         ALERT SUCCESS
    ====================================================== --}}

    @if(session('success'))

        <div class="alert-success">

            <i class="bi bi-check-circle"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         ALERT ERROR
    ====================================================== --}}

    @if(session('error'))

        <div class="alert-error">

            <i class="bi bi-exclamation-circle"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         VALIDATION ERROR
    ====================================================== --}}

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


    {{-- =====================================================
         SUMMARY CARDS
    ====================================================== --}}

    <div class="summary-cards">


        {{-- TOTAL DATASET --}}

        <div class="summary-card">

            <div class="summary-label">
                TOTAL DATASET
            </div>

            <div class="summary-value">
                {{ $totalData }}
            </div>

        </div>


        {{-- JENIS DATA --}}

        <div class="summary-card">

            <div class="summary-label">
                JENIS DATA
            </div>

            <div class="summary-value">
                {{ $totalJenis }}
            </div>

        </div>


        {{-- MENUNGGU DISETUJUI --}}

        <div class="summary-card">

            <div class="summary-label">
                MENUNGGU DISETUJUI
            </div>

            <div class="summary-value">
                {{ $totalPending }}
            </div>

        </div>


        {{-- DATA DISETUJUI --}}

        <div class="summary-card">

            <div class="summary-label">
                DATA DISETUJUI
            </div>

            <div class="summary-value">
                {{ $totalDisetujui }}
            </div>

        </div>


        {{-- DATA DITOLAK --}}

        <div class="summary-card">

            <div class="summary-label">
                DATA DITOLAK
            </div>

            <div class="summary-value">
                {{ $totalDitolak }}
            </div>

        </div>


    </div>


    {{-- =====================================================
         TABLE CONTAINER
    ====================================================== --}}

    <div class="data-table-container">


        {{-- =================================================
             TOOLBAR
        ================================================== --}}

        <div class="table-toolbar">


            {{-- SEARCH --}}

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


            {{-- ACTION BUTTON --}}

            <div class="table-actions">


                {{-- FILTER --}}

                <button
                    type="button"
                    class="filter-button"
                    onclick="toggleFilter()">

                    <i class="bi bi-filter"></i>

                    Filter

                </button>


                {{-- ADD --}}

                <button
                    type="button"
                    class="add-button"
                    onclick="openAddModal()">

                    <i class="bi bi-plus-lg"></i>

                    Add

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


                {{-- SEARCH --}}

                <input
                    type="hidden"
                    name="search"
                    value="{{ request('search') }}">


                {{-- JENIS DATA --}}

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


                {{-- TAHUN --}}

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


                {{-- STATUS --}}

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


                {{-- TERAPKAN --}}

                <button
                    type="submit"
                    class="filter-submit">

                    <i class="bi bi-check-lg"></i>

                    Terapkan

                </button>


                {{-- RESET --}}

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


                            {{-- ID --}}

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


                            {{-- NAMA DATASET --}}

                            <td>
                                {{ $item->nama_dataset }}
                            </td>


                            {{-- JENIS DATA --}}

                            <td>
                                {{ $item->jenis_data }}
                            </td>


                            {{-- TAHUN --}}

                            <td>
                                {{ $item->tahun }}
                            </td>


                            {{-- TANGGAL PENGAJUAN --}}

                            <td>

                                @if($item->tanggal_pengajuan)

                                    {{
                                        \Carbon\Carbon::parse(
                                            $item->tanggal_pengajuan
                                        )->format('d/m/Y H:i')
                                    }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- FILE DATA --}}

                            <td>

                                @if($item->file_data)

                                    <a
                                        href="{{ asset('storage/' . $item->file_data) }}"
                                        target="_blank"
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


                                    {{-- EDIT --}}

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


            {{-- SHOW DATA --}}

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


            {{-- INFO PAGINATION --}}

            <span>

                Showing

                {{ $data->firstItem() ?? 0 }}

                to

                {{ $data->lastItem() ?? 0 }}

                of

                {{ $data->total() }}

                entries

            </span>


            {{-- PAGINATION --}}

            <div class="pagination">


                {{-- PREVIOUS --}}

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


                {{-- PAGE NUMBER --}}

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


                {{-- NEXT --}}

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
     MODAL ADD DATA
========================================================= --}}

<div
    class="data-modal"
    id="addDataModal">


    <div class="data-modal-content">


        <div class="data-modal-header">

            <h2>
                Add
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


            {{-- NAMA DATASET --}}

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


            {{-- JENIS DATA --}}

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


            {{-- TAHUN --}}

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


            {{-- FILE DATA --}}

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


            {{-- STATUS INFO --}}

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


            {{-- BUTTON --}}

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

                    Add

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
                    Format: CSV, XLS, XLSX, PDF, ZIP.
                    Maksimal 10 MB.

                </small>

            </div>


            {{-- INFO --}}

            <div class="status-info">

                <i class="bi bi-info-circle"></i>

                <span>

                    Perubahan data akan diajukan terlebih dahulu
                    dan menunggu persetujuan Verifikator.

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

                    Ajukan Perubahan

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


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

@push('scripts')
    @include('data.script')
@endpush