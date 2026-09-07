@extends('layouts.app')

@section('title', 'Software')
@section('page-title', 'Software')

@section('content')

<style>

/* =========================================================
   SOFTWARE PAGE
========================================================= */

.software-page {
    width: 100%;
}

/* =========================================================
   HEADER
========================================================= */

.software-header {
    margin-bottom: 24px;
}

.software-heading h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
}

.software-heading p {
    margin: 6px 0 0;
    font-size: 13px;
    color: #6b7280;
}

/* =========================================================
   SUCCESS ALERT
========================================================= */

.alert-success {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #047857;
    padding: 12px 15px;
    border-radius: 9px;
    margin-bottom: 20px;
    font-size: 13px;
}

.alert-success i {
    font-size: 17px;
}

/* =========================================================
   STATISTIC CARDS
========================================================= */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 25px;
}

.stat-card {
    min-height: 135px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.08);
}

.stat-icon {
    width: 45px;
    height: 45px;
    flex-shrink: 0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.stat-icon.blue {
    background: #e0f2fe;
    color: #0284c7;
}

.stat-icon.purple {
    background: #ede9fe;
    color: #7c3aed;
}

.stat-icon.orange {
    background: #ffedd5;
    color: #ea580c;
}

.stat-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.stat-icon.red {
    background: #fee2e2;
    color: #dc2626;
}

.stat-content {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.stat-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 23px;
    font-weight: 700;
    color: #075985;
    line-height: 1.2;
}

.stat-value.currency {
    font-size: 17px;
    white-space: nowrap;
}

.stat-description {
    margin-top: 7px;
    font-size: 10px;
    color: #9ca3af;
}

/* =========================================================
   SOFTWARE TABLE CARD
========================================================= */

.software-table-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: visible;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.04);
}

/* =========================================================
   TABLE HEADER
========================================================= */

.table-header {
    min-height: 70px;
    padding: 15px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    border-bottom: 1px solid #e5e7eb;
}

.table-header-left {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.table-title {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #1f2937;
}

.table-count {
    font-size: 11px;
    color: #9ca3af;
}

/* =========================================================
   TOOLBAR
========================================================= */

.software-toolbar {
    position: relative;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
}

/* =========================================================
   SEARCH
========================================================= */

.software-search {
    width: 230px;
    height: 36px;
    display: flex;
    align-items: center;
    padding: 0 13px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
}

.software-search i {
    margin-right: 8px;
    color: #9ca3af;
    font-size: 14px;
}

.software-search input {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-size: 11px;
    color: #374151;
}

.software-search input::placeholder {
    color: #9ca3af;
}

/* =========================================================
   TOOLBAR BUTTON
========================================================= */

.filter-button,
.add-button {
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 0 13px;
    border-radius: 7px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
}

/* FILTER */

.filter-button {
    background: white;
    border: 1px solid #d1d5db;
    color: #374151;
}

.filter-button:hover {
    background: #f3f4f6;
}

.filter-button i {
    font-size: 12px;
}

/* ADD */

.add-button {
    background: #071b88;
    border: 1px solid #071b88;
    color: white;
}

.add-button:hover {
    background: #050f63;
    color: white;
}

.add-button i {
    font-size: 13px;
}

/* =========================================================
   FILTER DROPDOWN
========================================================= */

.filter-dropdown {
    display: none;
    position: absolute;
    top: 44px;
    right: 65px;
    width: 230px;
    padding: 15px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    z-index: 1000;
}

.filter-dropdown.show {
    display: block;
}

.filter-title {
    margin-bottom: 14px;
    font-size: 13px;
    font-weight: 700;
    color: #075985;
}

.filter-dropdown label {
    display: block;
    margin-bottom: 6px;
    font-size: 11px;
    font-weight: 600;
    color: #374151;
}

.filter-dropdown select {
    width: 100%;
    height: 34px;
    padding: 0 10px;
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 11px;
    color: #374151;
    outline: none;
}

.filter-dropdown select:focus {
    border-color: #075985;
}

.filter-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 7px;
    margin-top: 15px;
}

.reset-filter,
.apply-filter {
    height: 31px;
    padding: 0 11px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
}

.reset-filter {
    background: #f3f4f6;
    color: #6b7280;
}

.reset-filter:hover {
    background: #e5e7eb;
    color: #374151;
}

.apply-filter {
    border: none;
    background: #071b88;
    color: white;
}

.apply-filter:hover {
    background: #050f63;
}

/* =========================================================
   TABLE
========================================================= */

.table-wrapper {
    width: 100%;
    overflow-x: auto;
    border-radius: 0 0 14px 14px;
}

.software-table {
    width: 100%;
    min-width: 1050px;
    border-collapse: collapse;
}

.software-table th {
    padding: 13px 14px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    color: #475569;
    font-size: 10px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.software-table td {
    padding: 13px 14px;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    font-size: 11px;
    vertical-align: middle;
}

.software-table tbody tr:hover {
    background: #f8fafc;
}

.software-table tbody tr:last-child td {
    border-bottom: none;
}

/* =========================================================
   KODE
========================================================= */

.software-code {
    font-weight: 700;
    color: #075985;
    white-space: nowrap;
}

/* =========================================================
   SOFTWARE NAME
========================================================= */

.software-name {
    font-weight: 600;
    color: #1f2937;
}

.software-spec {
    margin-top: 3px;
    max-width: 150px;
    font-size: 10px;
    color: #9ca3af;
}

/* =========================================================
   LICENSE
========================================================= */

.license-badge {
    min-width: 32px;
    height: 27px;
    padding: 0 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 7px;
    background: #e0f2fe;
    color: #075985;
    font-size: 11px;
    font-weight: 700;
}

/* =========================================================
   PROCUREMENT
========================================================= */

.procurement-badge {
    display: inline-flex;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.procurement-sewa {
    background: #fef3c7;
    color: #92400e;
}

.procurement-beli {
    background: #dcfce7;
    color: #166534;
}

/* =========================================================
   PRICE
========================================================= */

.price {
    font-weight: 600;
    color: #374151;
    white-space: nowrap;
}

/* =========================================================
   DATE
========================================================= */

.date {
    color: #4b5563;
    white-space: nowrap;
}

/* =========================================================
   STATUS
========================================================= */

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.status-active {
    background: #dcfce7;
    color: #166534;
}

.status-warning {
    background: #fef3c7;
    color: #92400e;
}

.status-expired {
    background: #fee2e2;
    color: #991b1b;
}

.status-perpetual {
    background: #e0f2fe;
    color: #075985;
}

/* =========================================================
   ACTION
========================================================= */

.action-buttons {
    display: flex;
    align-items: center;
    gap: 6px;
}

.action-button {
    width: 30px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 7px;
    text-decoration: none;
    cursor: pointer;
    transition: 0.2s ease;
}

.action-button i {
    font-size: 12px;
}

.edit-button {
    background: #e0f2fe;
    color: #075985;
}

.edit-button:hover {
    background: #bae6fd;
    color: #075985;
}

.delete-button {
    background: #fee2e2;
    color: #dc2626;
}

.delete-button:hover {
    background: #fecaca;
    color: #dc2626;
}

/* =========================================================
   EMPTY STATE
========================================================= */

.empty-state {
    padding: 55px 20px;
    text-align: center;
}

.empty-state-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    color: #94a3b8;
}

.empty-state-icon i {
    font-size: 27px;
}

.empty-state h3 {
    margin: 0 0 6px;
    font-size: 15px;
    color: #374151;
}

.empty-state p {
    margin: 0;
    font-size: 12px;
    color: #9ca3af;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .table-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .software-toolbar {
        width: 100%;
        justify-content: flex-start;
    }

    .filter-dropdown {
        left: 238px;
        right: auto;
    }
}

@media (max-width: 800px) {

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .software-toolbar {
        flex-wrap: wrap;
    }

    .software-search {
        width: 100%;
    }

    .filter-dropdown {
        left: 0;
        right: auto;
    }
}

@media (max-width: 500px) {

    .stats-grid {
        grid-template-columns: 1fr;
    }
}

</style>


<div class="software-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="software-header">

        <div class="software-heading">

            <h2>
                Software
            </h2>

            <p>
                Kelola data aset software dan lisensi yang tersedia.
            </p>

        </div>

    </div>


    {{-- =====================================================
         SUCCESS MESSAGE
    ====================================================== --}}

    @if(session('success'))

        <div class="alert-success">

            <i class="bi bi-check-circle-fill"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         STATISTIC CARDS
    ====================================================== --}}

    <div class="stats-grid">

        {{-- TOTAL SOFTWARE --}}

        <div class="stat-card">

            <div class="stat-icon blue">
                <i class="bi bi-grid-fill"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Total Software
                </span>

                <span class="stat-value">
                    {{ $totalSoftware }}
                </span>

                <span class="stat-description">
                    Jenis software terdaftar
                </span>

            </div>

        </div>


        {{-- TOTAL LISENSI --}}

        <div class="stat-card">

            <div class="stat-icon purple">
                <i class="bi bi-key-fill"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Total Lisensi
                </span>

                <span class="stat-value">
                    {{ $totalLisensi }}
                </span>

                <span class="stat-description">
                    Seluruh lisensi software
                </span>

            </div>

        </div>


        {{-- AKAN BERAKHIR --}}

        <div class="stat-card">

            <div class="stat-icon orange">
                <i class="bi bi-clock-history"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Akan Berakhir
                </span>

                <span class="stat-value">
                    {{ $akanBerakhir }}
                </span>

                <span class="stat-description">
                    Berakhir dalam 30 hari
                </span>

            </div>

        </div>


        {{-- EXPIRED --}}

        <div class="stat-card">

            <div class="stat-icon red">
                <i class="bi bi-x-circle-fill"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Expired
                </span>

                <span class="stat-value">
                    {{ $expired }}
                </span>

                <span class="stat-description">
                    Software sudah berakhir
                </span>

            </div>

        </div>


        {{-- TERSEDIA --}}

        <div class="stat-card">

            <div class="stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Tersedia
                </span>

                <span class="stat-value">
                    {{ $tersedia }}
                </span>

                <span class="stat-description">
                    Software masih aktif
                </span>

            </div>

        </div>


        {{-- TOTAL PENGELUARAN --}}

        <div class="stat-card">

            <div class="stat-icon red">
                <i class="bi bi-wallet2"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Pengeluaran / Tahun
                </span>

                <span class="stat-value currency">
                    Rp {{ number_format($totalPengeluaranPertahun, 0, ',', '.') }}
                </span>

                <span class="stat-description">
                    Estimasi pengeluaran tahunan
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         SOFTWARE TABLE
    ====================================================== --}}

    <div class="software-table-card">

        {{-- TABLE HEADER --}}

        <div class="table-header">

            <div class="table-header-left">

                <h3 class="table-title">
                    Data Software
                </h3>

                <span class="table-count">
                    ({{ $softwares->count() }} data)
                </span>

            </div>


            {{-- TOOLBAR --}}

            <div class="software-toolbar">

                {{-- SEARCH --}}

                <form
                    action="{{ route('software.index') }}"
                    method="GET"
                    class="software-search"
                >

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search..."
                    >

                    @if(request('pengadaan'))

                        <input
                            type="hidden"
                            name="pengadaan"
                            value="{{ request('pengadaan') }}"
                        >

                    @endif

                </form>


                {{-- FILTER --}}

                <button
                    type="button"
                    class="filter-button"
                    onclick="toggleFilter()"
                >

                    <i class="bi bi-funnel"></i>

                    <span>
                        Filter
                    </span>

                </button>


                {{-- ADD --}}

                {{-- JANGAN DIUBAH:
                     tetap menggunakan modal create yang sudah berhasil --}}

                <button
                    type="button"
                    class="add-button"
                    onclick="openSoftwareModal()"
                >

                    <i class="bi bi-plus-lg"></i>

                    <span>
                        Add
                    </span>

                </button>


                {{-- FILTER DROPDOWN --}}

                <div
                    id="filter-dropdown"
                    class="filter-dropdown"
                >

                    <form
                        action="{{ route('software.index') }}"
                        method="GET"
                    >

                        <div class="filter-title">
                            Filter Software
                        </div>


                        {{-- SEARCH --}}

                        <input
                            type="hidden"
                            name="search"
                            value="{{ request('search') }}"
                        >


                        {{-- PENGADAAN --}}

                        <label for="filter-pengadaan">
                            Pengadaan
                        </label>

                        <select
                            name="pengadaan"
                            id="filter-pengadaan"
                        >

                            <option value="">
                                Semua
                            </option>

                            <option
                                value="Beli"
                                {{ request('pengadaan') === 'Beli' ? 'selected' : '' }}
                            >
                                Beli
                            </option>

                            <option
                                value="Sewa"
                                {{ request('pengadaan') === 'Sewa' ? 'selected' : '' }}
                            >
                                Sewa
                            </option>

                        </select>


                        <div class="filter-buttons">

                            <a
                                href="{{ route('software.index') }}"
                                class="reset-filter"
                            >
                                Reset
                            </a>

                            <button
                                type="submit"
                                class="apply-filter"
                            >
                                Terapkan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="table-wrapper">

            @if($softwares->count() > 0)

                <table class="software-table">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Kode</th>
                            <th>Jenis Software</th>
                            <th>Lisensi</th>
                            <th>Pengadaan</th>
                            <th>Harga</th>
                            <th>Tanggal Pengadaan</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($softwares as $software)

                            @php

                                $status = 'Aktif';
                                $statusClass = 'status-active';

                                if ($software->tanggal_berakhir) {

                                    $today = now()->startOfDay();

                                    $endDate = $software
                                        ->tanggal_berakhir
                                        ->startOfDay();

                                    $daysLeft = $today->diffInDays(
                                        $endDate,
                                        false
                                    );

                                    if ($daysLeft < 0) {

                                        $status = 'Expired';
                                        $statusClass = 'status-expired';

                                    } elseif ($daysLeft <= 30) {

                                        $status = 'Segera Berakhir';
                                        $statusClass = 'status-warning';

                                    }

                                } else {

                                    $status = 'Perpetual';
                                    $statusClass = 'status-perpetual';

                                }

                            @endphp


                            <tr>

                                {{-- NO --}}

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                {{-- KODE --}}

                                <td>

                                    <span class="software-code">
                                        {{ $software->kode }}
                                    </span>

                                </td>


                                {{-- JENIS SOFTWARE --}}

                                <td>

                                    <div class="software-name">
                                        {{ $software->jenis }}
                                    </div>

                                    @if($software->spesifikasi)

                                        <div class="software-spec">
                                            {{ $software->spesifikasi }}
                                        </div>

                                    @endif

                                </td>


                                {{-- LISENSI --}}

                                <td>

                                    <span class="license-badge">
                                        {{ $software->jumlah_lisensi }}
                                    </span>

                                </td>


                                {{-- PENGADAAN --}}

                                <td>

                                    @if($software->pengadaan === 'Sewa')

                                        <span class="procurement-badge procurement-sewa">
                                            Sewa
                                        </span>

                                    @else

                                        <span class="procurement-badge procurement-beli">
                                            Beli
                                        </span>

                                    @endif

                                </td>


                                {{-- HARGA --}}

                                <td>

                                    <span class="price">
                                        Rp {{ number_format(
                                            $software->harga,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </span>

                                </td>


                                {{-- TANGGAL PENGADAAN --}}

                                <td>

                                    <span class="date">
                                        {{ $software->tanggal_pengadaan?->format('d M Y') }}
                                    </span>

                                </td>


                                {{-- TANGGAL BERAKHIR --}}

                                <td>

                                    <span class="date">

                                        @if($software->tanggal_berakhir)

                                            {{ $software->tanggal_berakhir->format('d M Y') }}

                                        @else

                                            -

                                        @endif

                                    </span>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $status }}
                                    </span>

                                </td>


                                {{-- AKSI --}}

                                <td>

                                    <div class="action-buttons">

                                        {{-- EDIT --}}

                                        <button
                                            type="button"
                                            class="action-button edit-button"
                                            title="Edit"
                                            onclick="openEditSoftwareModal('{{ $software->id }}')"
                                        >

                                            <i class="bi bi-pencil-fill"></i>

                                        </button>


                                        {{-- DELETE --}}

                                        <form
                                            action="{{ route('software.destroy', $software) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus software ini?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-button delete-button"
                                                title="Hapus"
                                            >

                                                <i class="bi bi-trash-fill"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                            {{-- =================================================
                                 EDIT MODAL UNTUK DATA INI
                            ================================================== --}}

                            @include(
                                'software.edit',
                                ['software' => $software]
                            )

                        @endforeach

                    </tbody>

                </table>

            @else

                {{-- EMPTY STATE --}}

                <div class="empty-state">

                    <div class="empty-state-icon">

                        <i class="bi bi-laptop"></i>

                    </div>

                    <h3>

                        @if(request('search') || request('pengadaan'))

                            Data software tidak ditemukan

                        @else

                            Belum ada data software

                        @endif

                    </h3>

                    <p>

                        @if(request('search') || request('pengadaan'))

                            Coba ubah kata pencarian atau filter.

                        @else

                            Belum ada aset software yang tersimpan.

                        @endif

                    </p>

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH SOFTWARE
     
     CREATE.BLADE.PHP TIDAK DIUBAH
========================================================= --}}

@include('software.create')


<script>

/* =========================================================
   FILTER
========================================================= */

function toggleFilter()
{
    const dropdown =
        document.getElementById('filter-dropdown');

    if (!dropdown) {
        return;
    }

    dropdown.classList.toggle('show');
}


/* =========================================================
   CLOSE FILTER WHEN CLICK OUTSIDE
========================================================= */

document.addEventListener('click', function(event) {

    const dropdown =
        document.getElementById('filter-dropdown');

    const button =
        document.querySelector('.filter-button');

    if (
        dropdown &&
        button &&
        !dropdown.contains(event.target) &&
        !button.contains(event.target)
    ) {

        dropdown.classList.remove('show');

    }

});


/* =========================================================
   OPEN CREATE SOFTWARE MODAL
========================================================= */

function openSoftwareModal()
{
    const modal =
        document.getElementById('software-modal');

    if (!modal) {
        return;
    }

    modal.classList.add('show');

    document.body.classList.add(
        'software-modal-open'
    );

    if (typeof updatePengadaan === 'function') {
        updatePengadaan();
    }
}


/* =========================================================
   CLOSE CREATE SOFTWARE MODAL
========================================================= */

function closeSoftwareModal()
{
    const modal =
        document.getElementById('software-modal');

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    document.body.classList.remove(
        'software-modal-open'
    );
}


/* =========================================================
   OPEN EDIT SOFTWARE MODAL
========================================================= */

function openEditSoftwareModal(id)
{
    const modal =
        document.getElementById(
            'software-edit-modal-' + id
        );

    if (!modal) {
        console.error(
            'Edit modal tidak ditemukan:',
            id
        );

        return;
    }

    modal.classList.add('show');

    document.body.classList.add(
        'software-modal-open'
    );

    /*
    |---------------------------------------------------------
    | Jalankan fungsi edit modal
    |---------------------------------------------------------
    */

    if (
        typeof window['initEditSoftwareModal_' + id]
        === 'function'
    ) {

        window['initEditSoftwareModal_' + id]();

    }
}


/* =========================================================
   CLOSE EDIT SOFTWARE MODAL
========================================================= */

function closeEditSoftwareModal(id)
{
    const modal =
        document.getElementById(
            'software-edit-modal-' + id
        );

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    document.body.classList.remove(
        'software-modal-open'
    );
}


/* =========================================================
   CLOSE MODAL WHEN CLICK BACKDROP
========================================================= */

document.addEventListener('click', function(event) {

    /*
    |---------------------------------------------------------
    | CREATE MODAL
    |---------------------------------------------------------
    */

    const createModal =
        document.getElementById(
            'software-modal'
        );

    if (
        createModal &&
        event.target === createModal
    ) {

        closeSoftwareModal();

        return;

    }


    /*
    |---------------------------------------------------------
    | EDIT MODALS
    |---------------------------------------------------------
    */

    if (
        event.target.classList &&
        event.target.classList.contains(
            'software-edit-modal'
        )
    ) {

        const id =
            event.target.dataset.softwareId;

        closeEditSoftwareModal(id);

    }

});


/* =========================================================
   ESCAPE
========================================================= */

document.addEventListener('keydown', function(event) {

    if (event.key !== 'Escape') {
        return;
    }


    /*
    |---------------------------------------------------------
    | CREATE
    |---------------------------------------------------------
    */

    const createModal =
        document.getElementById(
            'software-modal'
        );

    if (
        createModal &&
        createModal.classList.contains('show')
    ) {

        closeSoftwareModal();

        return;

    }


    /*
    |---------------------------------------------------------
    | EDIT
    |---------------------------------------------------------
    */

    const editModals =
        document.querySelectorAll(
            '.software-edit-modal.show'
        );

    editModals.forEach(function(modal) {

        const id =
            modal.dataset.softwareId;

        closeEditSoftwareModal(id);

    });

});


/* =========================================================
   AUTO OPEN CREATE JIKA VALIDATION ERROR
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function()
    {

        @if($errors->any())

            openSoftwareModal();

        @endif

    }
);

</script>

@endsection