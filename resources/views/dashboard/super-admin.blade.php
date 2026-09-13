@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('page-title', 'Dashboard Super Admin')

@section('content')

@php
/*
|--------------------------------------------------------------------------
| STATUS ASET
|--------------------------------------------------------------------------
*/


$statusData = $statusData ?? [];

$statusTotal = array_sum($statusData);

$aktif = $statusData['Aktif'] ?? 0;
$pending = $statusData['Pending'] ?? 0;
$rusak = $statusData['Rusak'] ?? 0;
$tidakDigunakan = $statusData['Tidak Digunakan'] ?? 0;

$aktifPersen = $statusTotal > 0 ? ($aktif / $statusTotal) * 100 : 0;
$pendingPersen = $statusTotal > 0 ? ($pending / $statusTotal) * 100 : 0;
$rusakPersen = $statusTotal > 0 ? ($rusak / $statusTotal) * 100 : 0;

$p1 = $aktifPersen;
$p2 = $p1 + $pendingPersen;
$p3 = $p2 + $rusakPersen;

/*
|--------------------------------------------------------------------------
| DEFAULT DATA
|--------------------------------------------------------------------------
*/

$tahunList = $tahunList ?? [];
$tahun = $tahun ?? null;

$totalUser = $totalUser ?? 0;
$totalOperator = $totalOperator ?? 0;
$totalVerifikator = $totalVerifikator ?? 0;
$totalPimpinan = $totalPimpinan ?? 0;

$totalAset = $totalAset ?? 0;
$hardwareCount = $hardwareCount ?? 0;
$softwareCount = $softwareCount ?? 0;
$infrastrukturCount = $infrastrukturCount ?? 0;

$kategoriData = $kategoriData ?? [];
$verificationData = $verificationData ?? [];
$activities = $activities ?? [];


@endphp

<style>

    /* =========================================================
       DASHBOARD
    ========================================================= */

    .dashboard {
        width: 100%;
    }


    /* =========================================================
       HEADER DASHBOARD
    ========================================================= */

    .dashboard-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .welcome-title {
        margin: 0 0 6px;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .welcome-text {
        margin: 0;
        font-size: 13px;
        color: #6b7280;
    }


    /* =========================================================
       FILTER TAHUN
    ========================================================= */

    .year-filter {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .year-filter label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .year-filter select {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 9px 12px;
        outline: none;
        background: white;
        color: #374151;
        cursor: pointer;
    }


    /* =========================================================
       SECTION TITLE
    ========================================================= */

    .section-title {
        margin: 0 0 15px;
        font-size: 15px;
        font-weight: 700;
        color: #374151;
    }


    /* =========================================================
       STATISTICS GRID
    ========================================================= */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }


    /* =========================================================
       STAT CARD
    ========================================================= */

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #eef0f4;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e0f2fe;
        color: #075985;
        flex-shrink: 0;
    }

    .stat-icon i {
        font-size: 22px;
    }

    .stat-label {
        display: block;
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .stat-value {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }


    /* =========================================================
       USER COLOR
    ========================================================= */

    .operator-color {
        color: #d97706;
    }

    .verifikator-color {
        color: #16a34a;
    }

    .pimpinan-color {
        color: #dc2626;
    }


    /* =========================================================
       DASHBOARD GRID
    ========================================================= */

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }


    /* =========================================================
       DASHBOARD CARD
    ========================================================= */

    .dashboard-card {
        background: white;
        border-radius: 15px;
        padding: 22px;
        border: 1px solid #eef0f4;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
        margin-bottom: 25px;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .card-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }


    /* =========================================================
       STATUS ASET
    ========================================================= */

    .status-content {
        display: flex;
        align-items: center;
        gap: 35px;
    }

    .donut {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        flex-shrink: 0;
        position: relative;

        background: conic-gradient(
            #22c55e 0% {{ $p1 }}%,
            #f59e0b {{ $p1 }}% {{ $p2 }}%,
            #ef4444 {{ $p2 }}% {{ $p3 }}%,
            #6b7280 {{ $p3 }}% 100%
        );
    }

    .donut::after {
        content: "";
        position: absolute;
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 50%;
        top: 30px;
        left: 30px;
    }

    .donut-center {
        position: absolute;
        z-index: 2;
        top: 62px;
        left: 0;
        width: 100%;
        text-align: center;
    }

    .donut-total {
        display: block;
        font-size: 25px;
        font-weight: 700;
        color: #1f2937;
    }

    .donut-label {
        font-size: 11px;
        color: #6b7280;
    }


    /* =========================================================
       STATUS LIST
    ========================================================= */

    .status-list {
        flex: 1;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .status-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .status-name {
        font-size: 13px;
        color: #4b5563;
    }

    .status-count {
        font-size: 13px;
        font-weight: 700;
        color: #1f2937;
    }


    /* =========================================================
       KATEGORI ASET
    ========================================================= */

    .category-item {
        margin-bottom: 20px;
    }

    .category-item:last-child {
        margin-bottom: 0;
    }

    .category-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 7px;
    }

    .category-name {
        font-size: 13px;
        color: #4b5563;
    }

    .category-number {
        font-size: 13px;
        font-weight: 700;
        color: #1f2937;
    }

    .progress {
        width: 100%;
        height: 8px;
        background: #eef2f7;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: #079bd8;
        border-radius: 10px;
        transition: width .3s ease;
    }


    /* =========================================================
       VERIFIKASI
    ========================================================= */

    .verification-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .verification-card {
        padding: 18px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #eef0f4;
    }

    .verification-label {
        display: block;
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .verification-value {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }


    /* =========================================================
       AKTIVITAS
    ========================================================= */

    .activity-item {
        display: flex;
        gap: 13px;
        padding: 15px 0;
        border-bottom: 1px solid #f0f1f3;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #e0f2fe;
        color: #075985;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
    }

    .activity-text {
        display: block;
        font-size: 13px;
        color: #374151;
    }

    .activity-time {
        display: block;
        font-size: 11px;
        color: #9ca3af;
        margin-top: 4px;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        text-align: center;
        padding: 30px 15px;
        color: #9ca3af;
        font-size: 13px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1100px) {

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 700px) {

        .dashboard-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .status-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .verification-grid {
            grid-template-columns: 1fr;
        }

        .year-filter {
            width: 100%;
        }

        .year-filter select {
            flex: 1;
        }

    }

</style>

<div class="dashboard">

{{-- =====================================================
     HEADER
====================================================== --}}
<div class="dashboard-top">

    <div>
        <h2 class="welcome-title">
            Dashboard Super Admin 👋
        </h2>

        <p class="welcome-text">
            Kelola pengguna dan pantau seluruh data aset serta aktivitas sistem Inventory IT Assets.
        </p>
    </div>


    {{-- FILTER TAHUN --}}
    <form method="GET"
          action="{{ route('dashboard') }}"
          class="year-filter">

        <label for="tahun">Filter Tahun</label>

        <select name="tahun"
                id="tahun"
                onchange="this.form.submit()">

            <option value="all"
                {{ !$tahun || $tahun === 'all' ? 'selected' : '' }}>
                Semua Tahun
            </option>

            @foreach ($tahunList as $item)
                <option value="{{ $item }}"
                    {{ (string) $tahun === (string) $item ? 'selected' : '' }}>
                    {{ $item }}
                </option>
            @endforeach

        </select>

    </form>

</div>


{{-- =====================================================
     STATISTIK PENGGUNA
====================================================== --}}
<h3 class="section-title">
    Statistik Pengguna
</h3>

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-icon">
            <i class="bi bi-people-fill"></i>
        </div>

        <div>
            <span class="stat-label">Total User</span>

            <span class="stat-value">
                {{ number_format($totalUser) }}
            </span>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon">
            <i class="bi bi-person-workspace"></i>
        </div>

        <div>
            <span class="stat-label">Operator</span>

            <span class="stat-value operator-color">
                {{ number_format($totalOperator) }}
            </span>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon">
            <i class="bi bi-patch-check-fill"></i>
        </div>

        <div>
            <span class="stat-label">Verifikator</span>

            <span class="stat-value verifikator-color">
                {{ number_format($totalVerifikator) }}
            </span>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon">
            <i class="bi bi-person-badge-fill"></i>
        </div>

        <div>
            <span class="stat-label">Pimpinan</span>

            <span class="stat-value pimpinan-color">
                {{ number_format($totalPimpinan) }}
            </span>
        </div>

    </div>

</div>


{{-- =====================================================
     STATISTIK ASET
====================================================== --}}
<h3 class="section-title">
    Statistik Aset
</h3>

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-icon">
            <i class="bi bi-box-seam"></i>
        </div>

        <div>
            <span class="stat-label">Total Aset</span>

            <span class="stat-value">
                {{ number_format($totalAset) }}
            </span>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon">
            <i class="bi bi-pc-display"></i>
        </div>

        <div>
            <span class="stat-label">Hardware</span>

            <span class="stat-value">
                {{ number_format($hardwareCount) }}
            </span>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon">
            <i class="bi bi-laptop"></i>
        </div>

        <div>
            <span class="stat-label">Software</span>

            <span class="stat-value">
                {{ number_format($softwareCount) }}
            </span>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon">
            <i class="bi bi-diagram-3-fill"></i>
        </div>

        <div>
            <span class="stat-label">Infrastruktur</span>

            <span class="stat-value">
                {{ number_format($infrastrukturCount) }}
            </span>
        </div>

    </div>

</div>


{{-- =====================================================
     STATUS & KATEGORI ASET
====================================================== --}}
<div class="dashboard-grid">


    {{-- STATUS ASET --}}
    <div class="dashboard-card">

        <div class="card-header">
            <h3 class="card-title">
                Status Aset
            </h3>
        </div>


        <div class="status-content">

            <div class="donut">

                <div class="donut-center">

                    <span class="donut-total">
                        {{ number_format($statusTotal) }}
                    </span>

                    <span class="donut-label">
                        Total Status
                    </span>

                </div>

            </div>


            <div class="status-list">

                @php
                    $statusColors = [
                        'Aktif' => '#22c55e',
                        'Pending' => '#f59e0b',
                        'Rusak' => '#ef4444',
                        'Tidak Digunakan' => '#6b7280',
                    ];
                @endphp


                @forelse ($statusData as $nama => $jumlah)

                    <div class="status-item">

                        <div class="status-left">

                            <span class="status-dot"
                                  style="background: {{ $statusColors[$nama] ?? '#6b7280' }}">
                            </span>

                            <span class="status-name">
                                {{ $nama }}
                            </span>

                        </div>


                        <span class="status-count">
                            {{ number_format($jumlah) }}
                        </span>

                    </div>

                @empty

                    <div class="empty-state">
                        Belum ada data status aset.
                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- KATEGORI ASET --}}
    <div class="dashboard-card">

        <div class="card-header">
            <h3 class="card-title">
                Kategori Aset
            </h3>
        </div>


        @forelse ($kategoriData as $kategori)

            <div class="category-item">

                <div class="category-info">

                    <span class="category-name">
                        {{ $kategori['nama'] ?? '-' }}
                    </span>


                    <span class="category-number">

                        {{ number_format($kategori['jumlah'] ?? 0) }}

                        ({{ $kategori['persentase'] ?? 0 }}%)

                    </span>

                </div>


                <div class="progress">

                    <div class="progress-bar"
                         style="width: {{ $kategori['persentase'] ?? 0 }}%">
                    </div>

                </div>

            </div>

        @empty

            <div class="empty-state">
                Belum ada data kategori aset.
            </div>

        @endforelse

    </div>

</div>


{{-- =====================================================
     RINGKASAN VERIFIKASI
====================================================== --}}
<div class="dashboard-card">

    <div class="card-header">
        <h3 class="card-title">
            Ringkasan Verifikasi
        </h3>
    </div>


    <div class="verification-grid">

        <div class="verification-card">

            <span class="verification-label">
                Menunggu
            </span>

            <span class="verification-value">
                {{ number_format($verificationData['Menunggu'] ?? 0) }}
            </span>

        </div>


        <div class="verification-card">

            <span class="verification-label">
                Disetujui
            </span>

            <span class="verification-value">
                {{ number_format($verificationData['Disetujui'] ?? 0) }}
            </span>

        </div>


        <div class="verification-card">

            <span class="verification-label">
                Ditolak
            </span>

            <span class="verification-value">
                {{ number_format($verificationData['Ditolak'] ?? 0) }}
            </span>

        </div>

    </div>

</div>


{{-- =====================================================
     AKTIVITAS TERBARU
====================================================== --}}
<div class="dashboard-card">

    <div class="card-header">

        <h3 class="card-title">
            Aktivitas Terbaru
        </h3>

    </div>


    @forelse ($activities as $activity)

        <div class="activity-item">

            <div class="activity-icon">
                <i class="bi {{ $activity['icon'] ?? 'bi-clock-history' }}"></i>
            </div>


            <div>

                <span class="activity-text">
                    {{ $activity['text'] ?? '-' }}
                </span>

                <span class="activity-time">
                    {{ $activity['time'] ?? '-' }}
                </span>

            </div>

        </div>

    @empty

        <div class="empty-state">
            Belum ada aktivitas terbaru.
        </div>

    @endforelse

</div>

</div>

@endsection
