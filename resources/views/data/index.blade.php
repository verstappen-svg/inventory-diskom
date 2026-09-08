@extends('layouts.app')

@section('title', 'Data')
@section('page-title', 'Data')

{{-- =========================================================
CSS
========================================================= --}}
@push('styles')
@include('data.style')
@endpush

@section('content')

<div class="data-page">

```
{{-- =====================================================
     HEADER
====================================================== --}}

<div class="data-header">

    <div>
        <h1 class="data-title">
            Data
        </h1>

        <p class="data-subtitle">
            Kelola dataset dan informasi data yang tersimpan dalam inventory.
        </p>
    </div>

</div>


{{-- =====================================================
     ALERT SUCCESS
====================================================== --}}

@if(session('success'))

    <div class="data-alert data-alert-success">
        <i class="bi bi-check-circle-fill"></i>

        <span>
            {{ session('success') }}
        </span>
    </div>

@endif


{{-- =====================================================
     ALERT ERROR
====================================================== --}}

@if(session('error'))

    <div class="data-alert data-alert-error">
        <i class="bi bi-exclamation-circle-fill"></i>

        <span>
            {{ session('error') }}
        </span>
    </div>

@endif


{{-- =====================================================
     VALIDATION ERROR
====================================================== --}}

@if($errors->any())

    <div class="data-alert data-alert-error">

        <i class="bi bi-exclamation-circle-fill"></i>

        <div>

            <strong>
                Data gagal disimpan.
            </strong>

            <ul style="margin: 6px 0 0 18px;">

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
            {{ $totalData ?? 0 }}
        </div>

    </div>


    {{-- JENIS DATA --}}

    <div class="summary-card">

        <div class="summary-label">
            JENIS DATA
        </div>

        <div class="summary-value">
            {{ $totalJenis ?? 0 }}
        </div>

    </div>


    {{-- MENUNGGU --}}

    <div class="summary-card">

        <div class="summary-label">
            MENUNGGU DISETUJUI
        </div>

        <div class="summary-value">
            {{ $totalPending ?? ($menunggu ?? 0) }}
        </div>

    </div>


    {{-- DISETUJUI --}}

    <div class="summary-card">

        <div class="summary-label">
            DATA DISETUJUI
        </div>

        <div class="summary-value">
            {{ $totalDisetujui ?? ($disetujui ?? 0) }}
        </div>

    </div>


    {{-- DITOLAK --}}

    <div class="summary-card">

        <div class="summary-label">
            DATA DITOLAK
        </div>

        <div class="summary-value">
            {{ $totalDitolak ?? 0 }}
        </div>

    </div>

</div>


{{-- =====================================================
     TOOLBAR / FILTER
====================================================== --}}

<div class="data-stats">

    {{-- =================================================
         SEARCH + ACTION
    ================================================== --}}

    <div class="data-stat-card">

        <div class="table-toolbar-left">

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

                @if(request('jenis_data'))
                    <input
                        type="hidden"
                        name="jenis_data"
                        value="{{ request('jenis_data') }}"
                    >
                @endif

                @if(request('tahun'))
                    <input
                        type="hidden"
                        name="tahun"
                        value="{{ request('tahun') }}"
                    >
                @endif

                @if(request('verifikasi'))
                    <input
                        type="hidden"
                        name="verifikasi"
                        value="{{ request('verifikasi') }}"
                    >
                @endif

            </form>

        </div>


        <div class="data-stat-content">

            <div class="table-actions">

                <span class="data-stat-value">
                    {{ $data->total() ?? 0 }}
                </span>


                {{-- FILTER --}}

                <button
                    type="button"
                    class="filter-button"
                    onclick="toggleDataFilter(event)"
                >

                    <i class="bi bi-filter"></i>

                    Filter

                </button>


                {{-- ADD --}}

                <button
                    type="button"
                    class="add-button"
                    onclick="openDataModal()"
                >

                    <i class="bi bi-plus-lg"></i>

                    Add

                </button>

            </div>

        </div>

    </div>


    {{-- =================================================
         DISETUJUI
    ================================================== --}}

    <div class="data-stat-card">

        <div class="data-stat-icon green">

            <i class="bi bi-check-circle-fill"></i>

        </div>

        <div class="data-stat-content">

            <span class="data-stat-label">
                Disetujui
            </span>

            <span class="data-stat-value">
                {{ $disetujui ?? ($totalDisetujui ?? 0) }}
            </span>

            <span class="data-stat-description">
                Data telah diverifikasi
            </span>

        </div>

    </div>


    {{-- =================================================
         MENUNGGU
    ================================================== --}}

    <div class="data-stat-card">

        <div class="data-stat-icon orange">

            <i class="bi bi-clock-history"></i>

        </div>

        <div class="data-stat-content">

            <span class="data-stat-label">
                Menunggu
            </span>

            <span class="data-stat-value">
                {{ $menunggu ?? ($totalPending ?? 0) }}
            </span>

            <span class="data-stat-description">
                Menunggu verifikasi
            </span>

        </div>

    </div>

</div>


{{-- =====================================================
     FILTER DROPDOWN
====================================================== --}}

<div
    id="dataFilterDropdown"
    class="data-filter-dropdown"
    style="display:none;"
>

    <form
        method="GET"
        action="{{ route('data.index') }}"
    >

        {{-- SEARCH --}}

        <input
            type="hidden"
            name="search"
            value="{{ request('search') }}"
        >


        {{-- JENIS DATA --}}

        <div class="data-filter-group">

            <label class="data-filter-label">
                Jenis Data
            </label>

            <select name="jenis_data">

                <option value="">
                    Semua Jenis
                </option>

                @foreach(($jenisDataList ?? collect()) as $jenis)

                    <option
                        value="{{ $jenis }}"
                        {{ request('jenis_data') == $jenis ? 'selected' : '' }}
                    >
                        {{ $jenis }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- TAHUN --}}

        <div class="data-filter-group">

            <label class="data-filter-label">
                Tahun
            </label>

            <select name="tahun">

                <option value="">
                    Semua Tahun
                </option>

                @foreach(($tahunData ?? []) as $tahun)

                    <option
                        value="{{ $tahun }}"
                        {{ request('tahun') == $tahun ? 'selected' : '' }}
                    >
                        {{ $tahun }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- STATUS --}}

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
                    {{ request('verifikasi') == 'Menunggu Disetujui' ? 'selected' : '' }}
                >
                    Menunggu Disetujui
                </option>

                <option
                    value="Disetujui"
                    {{ request('verifikasi') == 'Disetujui' ? 'selected' : '' }}
                >
                    Disetujui
                </option>

                <option
                    value="Ditolak"
                    {{ request('verifikasi') == 'Ditolak' ? 'selected' : '' }}
                >
                    Ditolak
                </option>

            </select>

        </div>


        {{-- JUMLAH DATA --}}

        <div class="data-filter-group">

            <label class="data-filter-label">
                Tampilkan
            </label>

            <select name="show">

                @foreach([10, 25, 50, 100] as $jumlah)

                    <option
                        value="{{ $jumlah }}"
                        {{ request('show', 10) == $jumlah ? 'selected' : '' }}
                    >
                        {{ $jumlah }} data
                    </option>

                @endforeach

            </select>

        </div>


        {{-- BUTTON --}}

        <div class="data-filter-actions">

            <a
                href="{{ route('data.index') }}"
                class="data-reset-filter"
            >
                Reset
            </a>

            <button
                type="submit"
                class="data-reset-filter"
            >
                Terapkan
            </button>

        </div>

    </form>

</div>


{{-- =====================================================
     TABLE
====================================================== --}}

<div class="data-table-wrapper">

    @if($data->count() > 0)

        <table class="data-table">

            <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        Nama Dataset
                    </th>

                    <th>
                        Jenis Data
                    </th>

                    <th>
                        Tahun
                    </th>

                    <th>
                        File
                    </th>

                    <th>
                        Tanggal Pengajuan
                    </th>

                    <th>
                        Verifikasi
                    </th>

                    <th>
                        Keterangan
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach($data as $item)

                    <tr>

                        {{-- NO --}}

                        <td>

                            {{ $data->firstItem() + $loop->index }}

                        </td>


                        {{-- NAMA DATASET --}}

                        <td>

                            <strong>
                                {{ $item->nama_dataset }}
                            </strong>

                        </td>


                        {{-- JENIS DATA --}}

                        <td>

                            {{ $item->jenis_data }}

                        </td>


                        {{-- TAHUN --}}

                        <td>

                            <span class="data-year">

                                {{ $item->tahun ?: '-' }}

                            </span>

                        </td>


                        {{-- FILE --}}

                        <td>

                            @if($item->file_data)

                                <a
                                    href="{{ asset('storage/' . $item->file_data) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="data-file"
                                    title="Buka file"
                                >

                                    <i class="bi bi-file-earmark-text-fill"></i>

                                    {{ basename($item->file_data) }}

                                </a>

                            @else

                                <span class="data-no-file">
                                    -
                                </span>

                            @endif

                        </td>


                        {{-- TANGGAL PENGAJUAN --}}

                        <td>

                            <span class="data-date">

                                @if($item->tanggal_pengajuan)

                                    {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y H:i') }}

                                @else

                                    -

                                @endif

                            </span>

                        </td>


                        {{-- VERIFIKASI --}}

                        <td>

                            @if($item->verifikasi === 'Menunggu Disetujui')

                                <span class="verifikasi verifikasi-pending">

                                    <i class="bi bi-clock"></i>

                                    Menunggu Disetujui

                                </span>

                            @elseif($item->verifikasi === 'Disetujui')

                                <span class="verifikasi verifikasi-approved">

                                    <i class="bi bi-check-circle"></i>

                                    Disetujui

                                </span>

                            @elseif($item->verifikasi === 'Ditolak')

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
                                $item->verifikasi === 'Ditolak' &&
                                !empty($item->komentar_verifikasi)
                            )

                                <button
                                    type="button"
                                    class="comment-button"
                                    onclick="showComment(@js($item->komentar_verifikasi))"
                                >

                                    <i class="bi bi-chat-left-text"></i>

                                    Lihat Komentar

                                </button>

                            @elseif($item->verifikasi === 'Ditolak')

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
                                    onclick='openEditDataModal(
                                        @json($item->id),
                                        @json($item->nama_dataset),
                                        @json($item->jenis_data),
                                        @json($item->tahun),
                                        @json($item->file_data)
                                    )'
                                >

                                    <i class="bi bi-pencil-fill"></i>

                                </button>


                                {{-- DELETE --}}

                                <form
                                    action="{{ route('data.destroy', $item->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-button delete"
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
                    request('jenis_data') ||
                    request('tahun') ||
                    request('verifikasi')
                )

                    Data tidak ditemukan

                @else

                    Belum ada data

                @endif

            </h3>

            <p>

                @if(
                    request('search') ||
                    request('jenis_data') ||
                    request('tahun') ||
                    request('verifikasi')
                )

                    Coba ubah kata pencarian atau filter.

                @else

                    Belum ada dataset yang tersimpan.

                @endif

            </p>

        </div>

    @endif

</div>


{{-- =====================================================
     FOOTER / PAGINATION
====================================================== --}}

@if($data->total() > 0)

    <div class="data-table-footer">

        {{-- SHOW --}}

        <div class="show-data">

            <span>
                Show
            </span>

            <form
                method="GET"
                action="{{ route('data.index') }}"
                id="showForm"
            >

                <input
                    type="hidden"
                    name="search"
                    value="{{ request('search') }}"
                >

                <input
                    type="hidden"
                    name="jenis_data"
                    value="{{ request('jenis_data') }}"
                >

                <input
                    type="hidden"
                    name="tahun"
                    value="{{ request('tahun') }}"
                >

                <input
                    type="hidden"
                    name="verifikasi"
                    value="{{ request('verifikasi') }}"
                >

                <select
                    name="show"
                    onchange="document.getElementById('showForm').submit()"
                >

                    @foreach([10, 25, 50, 100] as $jumlah)

                        <option
                            value="{{ $jumlah }}"
                            {{ request('show', 10) == $jumlah ? 'selected' : '' }}
                        >
                            {{ $jumlah }}
                        </option>

                    @endforeach

                </select>

            </form>

            <span>
                entries
            </span>

        </div>


        {{-- INFO --}}

        <div class="data-pagination">

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

                    <span class="page-link disabled">

                        <i class="bi bi-chevron-left"></i>

                    </span>

                @else

                    <a
                        href="{{ $data->previousPageUrl() }}"
                        class="page-link"
                    >

                        <i class="bi bi-chevron-left"></i>

                    </a>

                @endif


                {{-- PAGE NUMBERS --}}

                @foreach(
                    $data->getUrlRange(
                        max(1, $data->currentPage() - 2),
                        min($data->lastPage(), $data->currentPage() + 2)
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
                            class="page-link"
                        >

                            {{ $page }}

                        </a>

                    @endif

                @endforeach


                {{-- NEXT --}}

                @if($data->hasMorePages())

                    <a
                        href="{{ $data->nextPageUrl() }}"
                        class="page-link"
                    >

                        <i class="bi bi-chevron-right"></i>

                    </a>

                @else

                    <span class="page-link disabled">

                        <i class="bi bi-chevron-right"></i>

                    </span>

                @endif

            </div>

        </div>

    </div>

@endif
```

</div>

{{-- =========================================================
MODAL TAMBAH / EDIT DATA
========================================================= --}}

<div
    class="data-modal"
    id="dataModal"
    style="display:none;"
>

```
<div
    class="data-modal-content"
    onclick="event.stopPropagation()"
>

    {{-- HEADER --}}

    <div class="data-modal-header">

        <div class="data-modal-header-left">

            <div class="data-modal-icon">

                <i class="bi bi-database-fill"></i>

            </div>

            <div>

                <h2
                    id="dataModalTitle"
                    class="data-modal-title"
                >
                    Tambah Data
                </h2>

                <p
                    id="dataModalSubtitle"
                    class="data-modal-subtitle"
                >
                    Tambahkan dataset baru ke dalam sistem.
                </p>

            </div>

        </div>


        <button
            type="button"
            class="data-modal-close"
            onclick="closeDataModal()"
            title="Tutup"
        >

            <i class="bi bi-x-lg"></i>

        </button>

    </div>


    {{-- FORM --}}

    <form
        id="dataForm"
        action="{{ route('data.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        <input
            type="hidden"
            id="dataMethod"
            name="_method"
            value="POST"
        >


        {{-- BODY --}}

        <div class="data-modal-body">

            <div class="data-form-grid">


                {{-- NAMA DATASET --}}

                <div class="data-form-group full">

                    <label
                        for="data_nama_dataset"
                        class="data-form-label"
                    >

                        Nama Dataset

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        id="data_nama_dataset"
                        name="nama_dataset"
                        class="data-form-control"
                        placeholder="Contoh: Data Penduduk Kota Bekasi"
                        required
                    >

                </div>


                {{-- JENIS DATA --}}

                <div class="data-form-group">

                    <label
                        for="data_jenis_data"
                        class="data-form-label"
                    >

                        Jenis Data

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        id="data_jenis_data"
                        name="jenis_data"
                        class="data-form-control"
                        placeholder="Contoh: Kependudukan"
                        required
                    >

                </div>


                {{-- TAHUN --}}

                <div class="data-form-group">

                    <label
                        for="data_tahun"
                        class="data-form-label"
                    >

                        Tahun

                        <span>*</span>

                    </label>

                    <input
                        type="number"
                        id="data_tahun"
                        name="tahun"
                        class="data-form-control"
                        min="1900"
                        max="2100"
                        placeholder="Contoh: 2026"
                        required
                    >

                </div>


                {{-- FILE --}}

                <div class="data-form-group full">

                    <label
                        for="data_file_data"
                        class="data-form-label"
                    >

                        File Data

                    </label>

                    <div
                        id="currentDataFile"
                        style="display:none; margin-bottom:8px;"
                    >

                        <i class="bi bi-file-earmark-text"></i>

                        <span>
                            File saat ini:
                        </span>

                        <a
                            id="currentDataFileLink"
                            href="#"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            Lihat File
                        </a>

                    </div>

                    <input
                        type="file"
                        id="data_file_data"
                        name="file_data"
                        class="data-form-control data-file-input"
                        accept=".csv,.xls,.xlsx,.pdf,.zip"
                    >

                    <small class="data-form-help">

                        Saat menambah data, upload file jika tersedia.
                        Saat edit, kosongkan jika tidak ingin mengganti file.

                    </small>

                </div>


                {{-- KETERANGAN --}}

                <div class="data-form-group full">

                    <label
                        for="data_komentar_verifikasi"
                        class="data-form-label"
                    >

                        Keterangan

                    </label>

                    <textarea
                        id="data_komentar_verifikasi"
                        name="komentar_verifikasi"
                        class="data-form-control"
                        rows="4"
                        placeholder="Tambahkan keterangan jika diperlukan..."
                    ></textarea>

                </div>


                {{-- INFO VERIFIKASI --}}

                <div class="data-form-group full">

                    <div class="status-info">

                        <i class="bi bi-info-circle"></i>

                        <span>

                            Perubahan data akan diajukan terlebih dahulu
                            dan menunggu persetujuan Verifikator.

                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- FOOTER --}}

        <div class="data-modal-footer">

            <button
                type="button"
                class="data-modal-cancel"
                onclick="closeDataModal()"
            >

                Batal

            </button>

            <button
                type="submit"
                class="save-btn"
            >

                <i class="bi bi-send"></i>

                Ajukan Perubahan

            </button>

        </div>

    </form>

</div>
```

</div>

{{-- =========================================================
MODAL KOMENTAR
========================================================= --}}

<div
    class="data-modal"
    id="commentModal"
    style="display:none;"
>

```
<div class="data-modal-content comment-modal-content">

    <div class="data-modal-header">

        <h2>
            Komentar Verifikator
        </h2>

        <button
            type="button"
            class="modal-close"
            onclick="closeCommentModal()"
        >

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
            onclick="closeCommentModal()"
        >

            Tutup

        </button>

    </div>

</div>
```

</div>

@endsection

{{-- =========================================================
JAVASCRIPT
========================================================= --}}

@push('scripts')

```
@include('data.script')
```

@endpush
