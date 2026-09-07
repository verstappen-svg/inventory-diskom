@extends('layouts.app')

@section('title', 'Laporan - Inventory IT Assets')

@section('page-title', 'LAPORAN')


@push('styles')

<style>

/* =========================================================
   LAPORAN PAGE
========================================================= */

.laporan-page {
    width: 100%;
}


/* =========================================================
   HEADER INFO
========================================================= */

.laporan-header {
    margin-bottom: 20px;
}

.laporan-header h2 {
    margin: 0 0 6px;
    font-size: 20px;
    font-weight: 700;
    color: #111827;
}

.laporan-header p {
    margin: 0;
    font-size: 13px;
    color: #6b7280;
}


/* =========================================================
   TABLE CONTAINER
========================================================= */

.laporan-container {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}


/* =========================================================
   TOOLBAR
========================================================= */

.laporan-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 20px;
    border-bottom: 1px solid #e5e7eb;
    gap: 15px;
}

.laporan-search {
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

.laporan-search i {
    color: #9ca3af;
}

.laporan-search input {
    width: 100%;
    border: none;
    outline: none;
    font-size: 14px;
}

.laporan-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-button {
    height: 40px;
    padding: 0 15px;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 7px;
    background: #ffffff;
    color: #374151;
    border: 1px solid #d1d5db;
}

.filter-button:hover {
    background: #f9fafb;
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
    min-width: 190px;
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

.filter-submit:hover {
    background: #1d4ed8;
}

.filter-reset {
    border: 1px solid #d1d5db;
    background: #ffffff;
    color: #374151;
}


/* =========================================================
   TABLE
========================================================= */

.laporan-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.laporan-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 850px;
}

.laporan-table th {
    background: #f9fafb;
    color: #374151;
    font-size: 12px;
    font-weight: 700;
    text-align: left;
    padding: 14px 15px;
    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
}

.laporan-table td {
    padding: 15px;
    font-size: 13px;
    color: #374151;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.laporan-table tbody tr:hover {
    background: #fafafa;
}


/* =========================================================
   BADGE
========================================================= */

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.status-approved {
    background: #dcfce7;
    color: #15803d;
}

.status-pending {
    background: #fef3c7;
    color: #b45309;
}

.status-rejected {
    background: #fee2e2;
    color: #dc2626;
}

.status-default {
    background: #f3f4f6;
    color: #4b5563;
}


/* =========================================================
   EMPTY
========================================================= */

.empty-data {
    text-align: center !important;
    padding: 60px 30px !important;
    color: #9ca3af !important;
}

.empty-data i {
    display: block;
    font-size: 38px;
    margin-bottom: 12px;
}

.empty-data strong {
    display: block;
    color: #6b7280;
    font-size: 14px;
    margin-bottom: 5px;
}


/* =========================================================
   FOOTER
========================================================= */

.laporan-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    font-size: 12px;
    color: #6b7280;
}


/* =========================================================
   INFO FILTER
========================================================= */

.filter-info {
    padding: 12px 20px;
    background: #eff6ff;
    border-bottom: 1px solid #dbeafe;
    color: #1d4ed8;
    font-size: 12px;
}

.filter-info strong {
    font-weight: 700;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .laporan-toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .laporan-search {
        width: 100%;
        box-sizing: border-box;
    }

    .laporan-actions {
        justify-content: flex-end;
    }

    .filter-form {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group select {
        width: 100%;
    }

    .laporan-footer {
        flex-wrap: wrap;
        gap: 10px;
    }

}

</style>

@endpush


@section('content')

<div class="laporan-page">

   

    {{-- =====================================================
         CONTAINER
    ====================================================== --}}

    <div class="laporan-container">


        {{-- =================================================
             TOOLBAR
        ================================================== --}}

        <div class="laporan-toolbar">


            {{-- SEARCH --}}

            <form
                method="GET"
                action="{{ route('laporan.index') }}">

                <input
                    type="hidden"
                    name="jenis"
                    value="{{ $jenis }}">

                <input
                    type="hidden"
                    name="tahun"
                    value="{{ $tahun }}">

                <input
                    type="hidden"
                    name="status"
                    value="{{ $status }}">

                <div class="laporan-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search..."
                        autocomplete="off">

                </div>

            </form>


            {{-- ACTION --}}

            <div class="laporan-actions">

                <button
                    type="button"
                    class="filter-button"
                    onclick="toggleLaporanFilter()">

                    <i class="bi bi-filter"></i>

                    Filter

                </button>

            </div>


        </div>


        {{-- =================================================
             FILTER BOX
        ================================================== --}}

        <div
            class="filter-box
            {{ $jenis || $tahun || $status ? 'show' : '' }}"
            id="laporanFilter">


            <form
                method="GET"
                action="{{ route('laporan.index') }}"
                class="filter-form">


                {{-- SEARCH --}}

                <input
                    type="hidden"
                    name="search"
                    value="{{ $search }}">


                {{-- JENIS DATA --}}

                <div class="filter-group">

                    <label>
                        Jenis Data
                    </label>

                    <select name="jenis">

                        <option value="">
                            Pilih Jenis Data
                        </option>

                        <option
                            value="hardware"
                            {{ $jenis == 'hardware' ? 'selected' : '' }}>

                            Hardware

                        </option>

                        <option
                            value="software"
                            {{ $jenis == 'software' ? 'selected' : '' }}>

                            Software

                        </option>

                        <option
                            value="jaringan"
                            {{ $jenis == 'jaringan' ? 'selected' : '' }}>

                            Jaringan

                        </option>

                        <option
                            value="data-center"
                            {{ $jenis == 'data-center' ? 'selected' : '' }}>

                            Data Center

                        </option>

                        <option
                            value="splp"
                            {{ $jenis == 'splp' ? 'selected' : '' }}>

                            SPLP

                        </option>

                        <option
                            value="data"
                            {{ $jenis == 'data' ? 'selected' : '' }}>

                            Data

                        </option>

                        <option
                            value="sdm"
                            {{ $jenis == 'sdm' ? 'selected' : '' }}>

                            SDM

                        </option>

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

                        @foreach($tahunList as $itemTahun)

                            <option
                                value="{{ $itemTahun }}"
                                {{ $tahun == $itemTahun ? 'selected' : '' }}>

                                {{ $itemTahun }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}

                <div class="filter-group">

                    <label>
                        Status
                    </label>

                    <select name="status">

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="Disetujui"
                            {{ $status == 'Disetujui' ? 'selected' : '' }}>

                            Disetujui

                        </option>

                        <option
                            value="Menunggu Disetujui"
                            {{ $status == 'Menunggu Disetujui' ? 'selected' : '' }}>

                            Menunggu Disetujui

                        </option>

                        <option
                            value="Ditolak"
                            {{ $status == 'Ditolak' ? 'selected' : '' }}>

                            Ditolak

                        </option>

                        <option
                            value="Tersedia"
                            {{ $status == 'Tersedia' ? 'selected' : '' }}>

                            Tersedia

                        </option>

                        <option
                            value="Digunakan"
                            {{ $status == 'Digunakan' ? 'selected' : '' }}>

                            Digunakan

                        </option>

                    </select>

                </div>


                {{-- SUBMIT --}}

                <button
                    type="submit"
                    class="filter-submit">

                    <i class="bi bi-check-lg"></i>

                    Terapkan

                </button>


                {{-- RESET --}}

                <a
                    href="{{ route('laporan.index') }}"
                    class="filter-reset">

                    <i class="bi bi-arrow-counterclockwise"></i>

                    Reset

                </a>


            </form>

        </div>


        {{-- =================================================
             INFO
        ================================================== --}}

        @if($jenis)

            <div class="filter-info">

                Menampilkan laporan:

                <strong>

                    @switch($jenis)

                        @case('hardware')
                            Hardware
                            @break

                        @case('software')
                            Software
                            @break

                        @case('jaringan')
                            Jaringan
                            @break

                        @case('data-center')
                            Data Center
                            @break

                        @case('splp')
                            SPLP
                            @break

                        @case('data')
                            Data
                            @break

                        @case('sdm')
                            SDM
                            @break

                    @endswitch

                </strong>

                @if($tahun)

                    — Tahun {{ $tahun }}

                @endif

            </div>

        @endif


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="laporan-table-wrapper">

            <table class="laporan-table">


                @if(!$jenis)

                    <tbody>

                        <tr>

                            <td class="empty-data">

                                <i class="bi bi-file-earmark-bar-graph"></i>

                                <strong>
                                    Pilih Jenis Data
                                </strong>

                                Pilih jenis data pada filter untuk menampilkan laporan.

                            </td>

                        </tr>

                    </tbody>


                @else


                    {{-- =================================================
                         HARDWARE
                    ================================================== --}}

                    @if($jenis == 'hardware')

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>NAMA BARANG</th>

                                <th>STATUS</th>

                                <th>TANGGAL</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($hasil as $item)

                                <tr>

                                    <td>
                                        {{ $item->id }}
                                    </td>

                                    <td>
                                        {{ $item->nama_barang ?? '-' }}
                                    </td>

                                    <td>

                                        <span class="status-badge status-default">

                                            {{ $item->status ?? '-' }}

                                        </span>

                                    </td>

                                    <td>
                                        {{ $item->created_at?->format('d/m/Y') ?? '-' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="empty-data">

                                        <i class="bi bi-database-x"></i>

                                        Tidak ada data hardware.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>


                    {{-- =================================================
                         SOFTWARE
                    ================================================== --}}

                    @elseif($jenis == 'software')

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>NAMA SOFTWARE</th>

                                <th>STATUS</th>

                                <th>TANGGAL</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($hasil as $item)

                                <tr>

                                    <td>
                                        {{ $item->id }}
                                    </td>

                                    <td>
                                        {{ $item->nama_software ?? '-' }}
                                    </td>

                                    <td>

                                        <span class="status-badge status-default">

                                            {{ $item->status ?? '-' }}

                                        </span>

                                    </td>

                                    <td>
                                        {{ $item->created_at?->format('d/m/Y') ?? '-' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="empty-data">

                                        <i class="bi bi-database-x"></i>

                                        Tidak ada data software.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>


                    {{-- =================================================
                         JARINGAN
                    ================================================== --}}

                    @elseif($jenis == 'jaringan')

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>NAMA INFRASTRUKTUR</th>

                                <th>PENGADAAN</th>

                                <th>HARGA</th>

                                <th>VERIFIKASI</th>

                                <th>TANGGAL</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($hasil as $item)

                                <tr>

                                    <td>
                                        {{ $item->id }}
                                    </td>

                                    <td>
                                        {{ $item->nama_infrastruktur ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->pengadaan ?? '-' }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td>

                                        @if($item->verifikasi == 'Disetujui')

                                            <span class="status-badge status-approved">
                                                <i class="bi bi-check-circle"></i>
                                                Disetujui
                                            </span>

                                        @elseif($item->verifikasi == 'Menunggu disetujui' || $item->verifikasi == 'Menunggu Disetujui')

                                            <span class="status-badge status-pending">
                                                <i class="bi bi-clock"></i>
                                                Menunggu
                                            </span>

                                        @elseif($item->verifikasi == 'Ditolak')

                                            <span class="status-badge status-rejected">
                                                <i class="bi bi-x-circle"></i>
                                                Ditolak
                                            </span>

                                        @else

                                            <span class="status-badge status-default">
                                                {{ $item->verifikasi ?? '-' }}
                                            </span>

                                        @endif

                                    </td>

                                    <td>
                                        {{ $item->tanggal_pengadaan ? \Carbon\Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y') : '-' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="empty-data">

                                        <i class="bi bi-database-x"></i>

                                        Tidak ada data jaringan.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>


                    {{-- =================================================
                         DATA CENTER
                    ================================================== --}}

                    @elseif($jenis == 'data-center')

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>NAMA INFRASTRUKTUR</th>

                                <th>PENGADAAN</th>

                                <th>HARGA</th>

                                <th>VERIFIKASI</th>

                                <th>TANGGAL</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($hasil as $item)

                                <tr>

                                    <td>
                                        {{ $item->id }}
                                    </td>

                                    <td>
                                        {{ $item->nama_infrastruktur ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->pengadaan ?? '-' }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td>

                                        <span class="status-badge status-default">

                                            {{ $item->verifikasi ?? '-' }}

                                        </span>

                                    </td>

                                    <td>
                                        {{ $item->tanggal_pengadaan ? \Carbon\Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y') : '-' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="empty-data">

                                        <i class="bi bi-database-x"></i>

                                        Tidak ada data Data Center.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>


                    {{-- =================================================
                         SPLP
                    ================================================== --}}

                    @elseif($jenis == 'splp')

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>NAMA INFRASTRUKTUR</th>

                                <th>PENGADAAN</th>

                                <th>HARGA</th>

                                <th>VERIFIKASI</th>

                                <th>TANGGAL</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($hasil as $item)

                                <tr>

                                    <td>
                                        {{ $item->id }}
                                    </td>

                                    <td>
                                        {{ $item->nama_infrastruktur ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->pengadaan ?? '-' }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td>

                                        <span class="status-badge status-default">

                                            {{ $item->verifikasi ?? '-' }}

                                        </span>

                                    </td>

                                    <td>
                                        {{ $item->tanggal_pengadaan ? \Carbon\Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y') : '-' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="empty-data">

                                        <i class="bi bi-database-x"></i>

                                        Tidak ada data SPLP.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>


                    {{-- =================================================
                         DATA
                    ================================================== --}}

                    @elseif($jenis == 'data')

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>NAMA DATASET</th>

                                <th>JENIS DATA</th>

                                <th>TAHUN</th>

                                <th>VERIFIKASI</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($hasil as $item)

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

                                        @if($item->verifikasi == 'Disetujui')

                                            <span class="status-badge status-approved">
                                                <i class="bi bi-check-circle"></i>
                                                Disetujui
                                            </span>

                                        @elseif($item->verifikasi == 'Menunggu Disetujui')

                                            <span class="status-badge status-pending">
                                                <i class="bi bi-clock"></i>
                                                Menunggu
                                            </span>

                                        @elseif($item->verifikasi == 'Ditolak')

                                            <span class="status-badge status-rejected">
                                                <i class="bi bi-x-circle"></i>
                                                Ditolak
                                            </span>

                                        @else

                                            <span class="status-badge status-default">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="empty-data">

                                        <i class="bi bi-database-x"></i>

                                        Tidak ada data dataset.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>


                    {{-- =================================================
                         SDM
                    ================================================== --}}

                    @elseif($jenis == 'sdm')

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>NAMA</th>

                                <th>STATUS</th>

                                <th>TANGGAL</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($hasil as $item)

                                <tr>

                                    <td>
                                        {{ $item->id }}
                                    </td>

                                    <td>
                                        {{ $item->nama ?? '-' }}
                                    </td>

                                    <td>

                                        <span class="status-badge status-default">

                                            {{ $item->status ?? '-' }}

                                        </span>

                                    </td>

                                    <td>
                                        {{ $item->created_at?->format('d/m/Y') ?? '-' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="empty-data">

                                        <i class="bi bi-database-x"></i>

                                        Tidak ada data SDM.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    @endif

                @endif


            </table>

        </div>


        {{-- =================================================
             FOOTER
        ================================================== --}}

        @if($jenis)

            <div class="laporan-footer">

                <span>

                    Menampilkan

                    <strong>
                        {{ $hasil->count() }}
                    </strong>

                    data

                </span>

                <span>

                    Inventory IT Assets

                </span>

            </div>

        @endif


    </div>

</div>

@endsection


@push('scripts')

<script>

function toggleLaporanFilter()
{
    const filter =
        document.getElementById('laporanFilter');

    filter.classList.toggle('show');
}

</script>

@endpush