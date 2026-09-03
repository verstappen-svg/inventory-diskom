@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<style>
    .dashboard {
        width: 100%;
    }

    /* =====================================================
       WELCOME
    ====================================================== */

    .welcome-section {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
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

    /* =====================================================
       YEAR FILTER
    ====================================================== */

    .year-filter {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .year-filter label {
        font-size: 13px;
        font-weight: 600;
        color: #4b5563;
    }

    .year-filter select {
        padding: 9px 12px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background: white;
        color: #374151;
        font-size: 13px;
        outline: none;
        cursor: pointer;
    }

    .year-filter select:focus {
        border-color: #079bd8;
    }

    /* =====================================================
       STATISTICS
    ====================================================== */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        border: 1px solid #eef0f4;
        min-width: 0;
    }

    .stat-top {
        display: flex;
        align-items: center;
        gap: 15px;
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
        font-size: 23px;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .stat-label {
        font-size: 12px;
        color: #6b7280;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    /* =====================================================
       INFRASTRUCTURE DETAIL
    ====================================================== */

    .infrastructure-card {
        min-height: 150px;
    }

    .infrastructure-detail {
        display: grid;
        grid-template-columns: 1fr;
        gap: 9px;
        margin-top: 15px;
        padding-top: 14px;
        border-top: 1px solid #eef0f4;
    }

    .infrastructure-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 12px;
        color: #6b7280;
    }

    .infrastructure-item span {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .infrastructure-item i {
        color: #075985;
        font-size: 14px;
    }

    .infrastructure-item strong {
        font-size: 13px;
        color: #1f2937;
    }

    /* =====================================================
       DASHBOARD GRID
    ====================================================== */

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .dashboard-card {
        background: white;
        border-radius: 15px;
        padding: 22px;
        border: 1px solid #eef0f4;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
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

    .card-link {
        font-size: 12px;
        color: #075985;
        text-decoration: none;
        font-weight: 600;
    }

    .card-link:hover {
        text-decoration: underline;
    }

    /* =====================================================
       STATUS CHART
    ====================================================== */

    .status-chart-container {
        position: relative;
        height: 280px;
    }

    /* =====================================================
       CATEGORY
    ====================================================== */

    .category-list {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .category-item {
        width: 100%;
    }

    .category-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 7px;
    }

    .category-name {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        color: #4b5563;
    }

    .category-name i {
        color: #075985;
    }

    .category-number {
        font-size: 12px;
        font-weight: 700;
        color: #1f2937;
        white-space: nowrap;
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
        transition: width 0.3s ease;
    }

    /* =====================================================
       ACTIVITY
    ====================================================== */

    .activity-list {
        display: flex;
        flex-direction: column;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 15px 0;
        border-bottom: 1px solid #f0f1f3;
    }

    .activity-item:first-child {
        padding-top: 0;
    }

    .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .activity-icon {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        background: #e0f2fe;
        color: #075985;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .activity-content {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .activity-text {
        font-size: 13px;
        color: #374151;
        line-height: 1.4;
    }

    .activity-time {
        font-size: 11px;
        color: #9ca3af;
    }

    .empty-data {
        color: #9ca3af;
        font-size: 13px;
        text-align: center;
        padding: 30px 0;
    }

    /* =====================================================
       RESPONSIVE
    ====================================================== */

    @media (max-width: 1100px) {

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 700px) {

        .welcome-section {
            flex-direction: column;
        }

        .year-filter {
            width: 100%;
        }

        .year-filter select {
            flex: 1;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {

        .welcome-title {
            font-size: 20px;
        }

        .dashboard-card {
            padding: 18px;
        }

        .status-chart-container {
            height: 240px;
        }
    }
</style>


<div class="dashboard">

    {{-- =================================================
         WELCOME + FILTER
    ================================================== --}}

    <div class="welcome-section">

        <div>

            <h2 class="welcome-title">
                Selamat Datang, {{ auth()->user()->name ?? 'User' }} 👋
            </h2>

            <p class="welcome-text">
                Pantau seluruh aset IT melalui sistem Inventory IT Assets.
            </p>

        </div>


        <form method="GET"
              action="{{ route('dashboard') }}"
              class="year-filter">

            <label for="tahun">
                Tahun
            </label>

            <select name="tahun"
                    id="tahun"
                    onchange="this.form.submit()">

                <option value="all"
                    {{ empty($tahun) ? 'selected' : '' }}>
                    Semua Tahun
                </option>

                @foreach($tahunList as $itemTahun)

                    <option value="{{ $itemTahun }}"
                        {{ (string) $tahun === (string) $itemTahun ? 'selected' : '' }}>

                        {{ $itemTahun }}

                    </option>

                @endforeach

            </select>

        </form>

    </div>


    {{-- =================================================
         STATISTICS
    ================================================== --}}

    <div class="stats-grid">

        {{-- TOTAL ASET --}}
        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div class="stat-info">

                    <span class="stat-label">
                        Total Aset
                    </span>

                    <span class="stat-value">
                        {{ number_format($totalAset) }}
                    </span>

                </div>

            </div>

        </div>


        {{-- HARDWARE --}}
        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon">
                    <i class="bi bi-pc-display"></i>
                </div>

                <div class="stat-info">

                    <span class="stat-label">
                        Hardware
                    </span>

                    <span class="stat-value">
                        {{ number_format($hardwareCount) }}
                    </span>

                </div>

            </div>

        </div>


        {{-- SOFTWARE --}}
        <div class="stat-card">

            <div class="stat-top">

                <div class="stat-icon">
                    <i class="bi bi-laptop"></i>
                </div>

                <div class="stat-info">

                    <span class="stat-label">
                        Software
                    </span>

                    <span class="stat-value">
                        {{ number_format($softwareCount) }}
                    </span>

                </div>

            </div>

        </div>


        {{-- INFRASTRUKTUR --}}
        <div class="stat-card infrastructure-card">

            <div class="stat-top">

                <div class="stat-icon">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>

                <div class="stat-info">

                    <span class="stat-label">
                        Infrastruktur
                    </span>

                    <span class="stat-value">
                        {{ number_format($infrastrukturCount) }}
                    </span>

                </div>

            </div>


            {{-- DETAIL INFRASTRUKTUR --}}

            <div class="infrastructure-detail">

                {{-- JARINGAN --}}
                <div class="infrastructure-item">

                    <span>
                        <i class="bi bi-diagram-3"></i>
                        Jaringan
                    </span>

                    <strong>
                        {{ number_format($jaringanCount) }}
                    </strong>

                </div>


                {{-- DATA CENTER --}}
                <div class="infrastructure-item">

                    <span>
                        <i class="bi bi-server"></i>
                        Data Center
                    </span>

                    <strong>
                        {{ number_format($dataCenterCount) }}
                    </strong>

                </div>


                {{-- SPLP --}}
                <div class="infrastructure-item">

                    <span>
                        <i class="bi bi-hdd-network"></i>
                        SPLP
                    </span>

                    <strong>
                        {{ number_format($splpCount) }}
                    </strong>

                </div>

            </div>

        </div>

    </div>


    {{-- =================================================
         STATUS + KATEGORI
    ================================================== --}}

    <div class="dashboard-grid">


        {{-- =================================================
             STATUS ASET
        ================================================== --}}

        <div class="dashboard-card">

            <div class="card-header">

                <h3 class="card-title">
                    Status Aset
                </h3>

                <a href="{{ route('laporan.index') }}"
                   class="card-link">

                    Lihat Laporan

                </a>

            </div>


            <div class="status-chart-container">

                <canvas id="statusChart"></canvas>

            </div>

        </div>


        {{-- =================================================
             KATEGORI ASET
        ================================================== --}}

        <div class="dashboard-card">

            <div class="card-header">

                <h3 class="card-title">
                    Kategori Aset
                </h3>

            </div>


            <div class="category-list">

                @forelse($kategoriData as $kategori)

                    <div class="category-item">

                        <div class="category-info">

                            <span class="category-name">

                                <i class="bi {{ $kategori['icon'] }}"></i>

                                {{ $kategori['nama'] }}

                            </span>


                            <span class="category-number">

                                {{ number_format($kategori['jumlah']) }}

                                ({{ $kategori['persentase'] }}%)

                            </span>

                        </div>


                        <div class="progress">

                            <div class="progress-bar"
                                 style="width: {{ $kategori['persentase'] }}%;">

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="empty-data">
                        Belum ada data kategori aset.
                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- =================================================
         AKTIVITAS TERBARU
    ================================================== --}}

    <div class="dashboard-card">

        <div class="card-header">

            <h3 class="card-title">
                Aktivitas Terbaru
            </h3>

        </div>


        <div class="activity-list">

            @forelse($activities as $activity)

                <div class="activity-item">

                    <div class="activity-icon">

                        <i class="bi {{ $activity['icon'] }}"></i>

                    </div>


                    <div class="activity-content">

                        <span class="activity-text">

                            {{ $activity['text'] }}

                        </span>


                        <span class="activity-time">

                            {{ $activity['time'] }}

                        </span>

                    </div>

                </div>

            @empty

                <div class="empty-data">

                    Belum ada aktivitas terbaru.

                </div>

            @endforelse

        </div>

    </div>

</div>


{{-- =====================================================
     CHART JS
====================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const statusData = @json($statusData);

    const statusCanvas =
        document.getElementById('statusChart');


    if (statusCanvas) {

        const ctx =
            statusCanvas.getContext('2d');


        new Chart(ctx, {

            type: 'doughnut',

            data: {

                labels: Object.keys(statusData),

                datasets: [{

                    data: Object.values(statusData),

                    backgroundColor: [

                        '#22c55e',

                        '#f59e0b',

                        '#ef4444',

                        '#6b7280'

                    ],

                    borderWidth: 0

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '65%',

                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            padding: 18,

                            usePointStyle: true,

                            pointStyle: 'circle'

                        }

                    }

                }

            }

        });

    }

</script>

@endsection