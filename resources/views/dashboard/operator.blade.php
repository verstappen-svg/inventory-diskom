@extends('layouts.app')

@section('title', 'Dashboard Operator')
@section('page-title', 'Dashboard Operator')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | HELPER DATA
    |--------------------------------------------------------------------------
    */

    $tahunList = $tahunList ?? [];
    $tahun = $tahun ?? 'all';

    /*
    |--------------------------------------------------------------------------
    | AKTIVITAS
    |--------------------------------------------------------------------------
    */

    if ($activities instanceof \Illuminate\Support\Collection) {
        $activities = $activities;
    } elseif (is_array($activities ?? null)) {
        $activities = collect($activities);
    } else {
        $activities = collect();
    }

    /*
    |--------------------------------------------------------------------------
    | HARDWARE
    |--------------------------------------------------------------------------
    */

    $hardwareDashboard = $hardwareDashboard ?? [];

    if ($hardwareDashboard instanceof \Illuminate\Support\Collection) {
        $hardwareDashboard = $hardwareDashboard->toArray();
    }

    if (!is_array($hardwareDashboard)) {
        $hardwareDashboard = [];
    }

    $hardwareStatus = $hardwareDashboard['status'] ?? [];
    $hardwareJenis = $hardwareDashboard['jenis'] ?? [];

    if ($hardwareStatus instanceof \Illuminate\Support\Collection) {
        $hardwareStatus = $hardwareStatus->toArray();
    }

    if ($hardwareJenis instanceof \Illuminate\Support\Collection) {
        $hardwareJenis = $hardwareJenis->toArray();
    }

    $hardwareStatus = is_array($hardwareStatus)
        ? $hardwareStatus
        : [];

    $hardwareJenis = is_array($hardwareJenis)
        ? $hardwareJenis
        : [];

    $hardwareStatus = array_merge([
        'Baik' => 0,
        'Perbaikan' => 0,
        'Rusak' => 0,
    ], $hardwareStatus);

    $hardwareJenis = array_merge([
        'Laptop' => 0,
        'PC' => 0,
        'Printer' => 0,
        'Monitor' => 0,
        'Keyboard' => 0,
        'Mouse' => 0,
        'Camera' => 0,
    ], $hardwareJenis);

    /*
    |--------------------------------------------------------------------------
    | SOFTWARE
    |--------------------------------------------------------------------------
    */

    $softwareDashboard = $softwareDashboard ?? [];

    if ($softwareDashboard instanceof \Illuminate\Support\Collection) {
        $softwareDashboard = $softwareDashboard->toArray();
    }

    if (!is_array($softwareDashboard)) {
        $softwareDashboard = [];
    }

    $softwarePengadaan = $softwareDashboard['pengadaan'] ?? [];
    $softwareStatus = $softwareDashboard['status'] ?? [];

    if ($softwarePengadaan instanceof \Illuminate\Support\Collection) {
        $softwarePengadaan = $softwarePengadaan->toArray();
    }

    if ($softwareStatus instanceof \Illuminate\Support\Collection) {
        $softwareStatus = $softwareStatus->toArray();
    }

    $softwarePengadaan = is_array($softwarePengadaan)
        ? $softwarePengadaan
        : [];

    $softwareStatus = is_array($softwareStatus)
        ? $softwareStatus
        : [];

    $softwarePengadaan = array_merge([
        'Beli' => 0,
        'Sewa' => 0,
    ], $softwarePengadaan);

    $softwareStatus = array_merge([
        'Tersedia' => 0,
        'Akan Habis' => 0,
        'Expired' => 0,
    ], $softwareStatus);

    /*
    |--------------------------------------------------------------------------
    | INFRASTRUKTUR
    |--------------------------------------------------------------------------
    */

    $infrastrukturDashboard = $infrastrukturDashboard ?? [];

    if ($infrastrukturDashboard instanceof \Illuminate\Support\Collection) {
        $infrastrukturDashboard = $infrastrukturDashboard->toArray();
    }

    if (!is_array($infrastrukturDashboard)) {
        $infrastrukturDashboard = [];
    }

    $infraPengadaan = $infrastrukturDashboard['pengadaan'] ?? [];
    $infraStatus = $infrastrukturDashboard['status'] ?? [];

    if ($infraPengadaan instanceof \Illuminate\Support\Collection) {
        $infraPengadaan = $infraPengadaan->toArray();
    }

    if ($infraStatus instanceof \Illuminate\Support\Collection) {
        $infraStatus = $infraStatus->toArray();
    }

    $infraPengadaan = is_array($infraPengadaan)
        ? $infraPengadaan
        : [];

    $infraStatus = is_array($infraStatus)
        ? $infraStatus
        : [];

    $infraPengadaan = array_merge([
        'Beli' => 0,
        'Sewa' => 0,
    ], $infraPengadaan);

    $infraStatus = array_merge([
        'Tersedia' => 0,
        'Akan Habis' => 0,
        'Expired' => 0,
    ], $infraStatus);

    /*
    |--------------------------------------------------------------------------
    | SUMMARY
    |--------------------------------------------------------------------------
    */

    $totalAset = (int) ($totalAset ?? 0);
    $hardwareCount = (int) ($hardwareCount ?? 0);
    $softwareCount = (int) ($softwareCount ?? 0);
    $infrastrukturCount = (int) ($infrastrukturCount ?? 0);
    $sdmCount = (int) ($sdmCount ?? 0);
    $dataCount = (int) ($dataCount ?? 0);

    /*
    |--------------------------------------------------------------------------
    | NORMALISASI ANGKA
    |--------------------------------------------------------------------------
    */

    foreach ($hardwareStatus as $key => $value) {
        $hardwareStatus[$key] = max(0, (int) $value);
    }

    foreach ($hardwareJenis as $key => $value) {
        $hardwareJenis[$key] = max(0, (int) $value);
    }

    foreach ($softwarePengadaan as $key => $value) {
        $softwarePengadaan[$key] = max(0, (int) $value);
    }

    foreach ($softwareStatus as $key => $value) {
        $softwareStatus[$key] = max(0, (int) $value);
    }

    foreach ($infraPengadaan as $key => $value) {
        $infraPengadaan[$key] = max(0, (int) $value);
    }

    foreach ($infraStatus as $key => $value) {
        $infraStatus[$key] = max(0, (int) $value);
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL DONUT
    |--------------------------------------------------------------------------
    */

    $hardwareTotal = array_sum($hardwareStatus);
    $softwarePengadaanTotal = array_sum($softwarePengadaan);
    $infraPengadaanTotal = array_sum($infraPengadaan);

    /*
    |--------------------------------------------------------------------------
    | PERSENTASE DONUT
    |--------------------------------------------------------------------------
    */

    $hardwarePersen = [];

    foreach ($hardwareStatus as $key => $value) {
        $hardwarePersen[$key] = $hardwareTotal > 0
            ? round(($value / $hardwareTotal) * 100, 1)
            : 0;
    }

    $softwarePersen = [];

    foreach ($softwarePengadaan as $key => $value) {
        $softwarePersen[$key] = $softwarePengadaanTotal > 0
            ? round(($value / $softwarePengadaanTotal) * 100, 1)
            : 0;
    }

    $infraPersen = [];

    foreach ($infraPengadaan as $key => $value) {
        $infraPersen[$key] = $infraPengadaanTotal > 0
            ? round(($value / $infraPengadaanTotal) * 100, 1)
            : 0;
    }

    /*
    |--------------------------------------------------------------------------
    | HARDWARE DONUT
    |--------------------------------------------------------------------------
    */

    $hardwareBaikDeg = 0;
    $hardwarePerbaikanDeg = 0;

    if ($hardwareTotal > 0) {

        $hardwareBaikDeg =
            ($hardwareStatus['Baik'] / $hardwareTotal) * 360;

        $hardwarePerbaikanDeg =
            (
                (
                    $hardwareStatus['Baik']
                    + $hardwareStatus['Perbaikan']
                )
                / $hardwareTotal
            ) * 360;
    }

    /*
    |--------------------------------------------------------------------------
    | SOFTWARE DONUT
    |--------------------------------------------------------------------------
    */

    $softwareBeliDeg = 0;

    if ($softwarePengadaanTotal > 0) {

        $softwareBeliDeg =
            ($softwarePengadaan['Beli'] / $softwarePengadaanTotal) * 360;
    }

    /*
    |--------------------------------------------------------------------------
    | INFRA DONUT
    |--------------------------------------------------------------------------
    */

    $infraBeliDeg = 0;

    if ($infraPengadaanTotal > 0) {

        $infraBeliDeg =
            ($infraPengadaan['Beli'] / $infraPengadaanTotal) * 360;
    }

    /*
    |--------------------------------------------------------------------------
    | BAR MAX
    |--------------------------------------------------------------------------
    */

    $hardwareBarMax = max(
        !empty($hardwareJenis) ? max($hardwareJenis) : 0,
        1
    );

    $softwareBarMax = max(
        !empty($softwareStatus) ? max($softwareStatus) : 0,
        1
    );

    $infraBarMax = max(
        !empty($infraStatus) ? max($infraStatus) : 0,
        1
    );
@endphp


<style>

    .dashboard {
        width: 100%;
    }

    /* =====================================================
       WELCOME
    ===================================================== */

    .welcome-section {
        margin-bottom: 20px;
    }

    .welcome-title {
        margin: 0 0 5px;
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
       FILTER
    ===================================================== */

    .dashboard-toolbar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .filter-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
    }

    .filter-select {
        min-width: 150px;
        padding: 9px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        background: #fff;
        color: #374151;
        font-size: 12px;
        outline: none;
        cursor: pointer;
        transition: .2s ease;
    }

    .filter-select:hover {
        border-color: #d1d5db;
    }

    .filter-select:focus {
        border-color: #079bd8;
        box-shadow: 0 0 0 3px rgba(7, 155, 216, .10);
    }

    .filter-button {
        border: none;
        background: #079bd8;
        color: #fff;
        border-radius: 9px;
        padding: 9px 15px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s ease;
    }

    .filter-button:hover {
        background: #0788bd;
    }


    /* =====================================================
       SUMMARY
    ===================================================== */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 17px;
        border: 1px solid #eef0f4;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
        min-width: 0;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, .07);
    }

    .stat-card-top {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e0f2fe;
        color: #075985;
        flex-shrink: 0;
    }

    .stat-icon i {
        font-size: 19px;
    }

    .stat-content {
        min-width: 0;
    }

    .stat-label {
        display: block;
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-value {
        display: block;
        font-size: 23px;
        line-height: 1;
        font-weight: 700;
        color: #1f2937;
    }


    /* =====================================================
       ASSET PANELS
    ===================================================== */

    .asset-panels {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .asset-panel {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #eef0f4;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
        padding: 17px;
        min-width: 0;
    }

    .asset-panel-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 13px;
    }

    .asset-panel-header i {
        font-size: 14px;
        color: #6b7280;
    }

    .asset-panel-title {
        margin: 0;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }


    /* =====================================================
       DONUT
    ===================================================== */

    .donut-section {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 22px;
        min-height: 135px;
        padding-bottom: 13px;
        border-bottom: 1px solid #f0f1f3;
    }

    .donut {
        position: relative;
        width: 112px;
        height: 112px;
        border-radius: 50%;
        flex-shrink: 0;

        --donut-baik: 0deg;
        --donut-perbaikan: 0deg;
        --donut-beli: 0deg;
        --donut-infra-beli: 0deg;

        animation: donutEntrance .5s ease-out;
    }

    @keyframes donutEntrance {

        from {
            opacity: 0;
            transform: scale(.75) rotate(-25deg);
        }

        to {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

    }

    .donut::after {
        content: "";
        position: absolute;
        width: 66px;
        height: 66px;
        border-radius: 50%;
        background: #fff;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .donut-center {
        position: absolute;
        z-index: 2;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .donut-number {
        font-size: 18px;
        line-height: 1;
        font-weight: 700;
        color: #1f2937;
    }

    .donut-caption {
        margin-top: 3px;
        font-size: 9px;
        color: #9ca3af;
    }


    /* =====================================================
       LEGEND
    ===================================================== */

    .legend {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 145px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .legend-left {
        display: flex;
        align-items: center;
        gap: 6px;
        min-width: 0;
    }

    .legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .legend-name {
        font-size: 12px;
        color: #6b7280;
        white-space: nowrap;
    }

    .legend-value {
        font-size: 12px;
        font-weight: 700;
        color: #374151;
        white-space: nowrap;
    }


    /* =====================================================
       BAR CHART
    ===================================================== */

    .bar-section {
        padding-top: 13px;
    }

    .bar-title {
        font-size: 12px;
        font-weight: 600;
        color: #9ca3af;
        margin-bottom: 10px;
    }

    .bar-chart {
        height: 82px;
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        gap: 12px;
    }

    .bar-item {
        flex: 1;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        min-width: 0;
    }

    .bar-value {
        font-size: 11px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 4px;
        line-height: 1;
    }

    .bar {
        width: 18px;
        max-height: 55px;
        min-height: 0;
        border-radius: 4px 4px 0 0;
    }

    .bar-label {
        margin-top: 7px;
        font-size: 10px;
        color: #6b7280;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .chart-empty {
        width: 100%;
        font-size: 10px;
        color: #9ca3af;
        text-align: center;
        padding: 20px 0;
    }


    /* =====================================================
       ACTIVITY
    ===================================================== */

    .dashboard-card {
        background: #fff;
        border-radius: 15px;
        padding: 21px;
        border: 1px solid #eef0f4;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
    }

    .activity-card {
        margin-bottom: 22px;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 18px;
    }

    .card-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    .card-subtitle {
        margin: 4px 0 0;
        font-size: 11px;
        color: #9ca3af;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .activity-header,
    .activity-item {
        display: grid;
        grid-template-columns: 38px 145px 120px minmax(0, 1fr);
        gap: 14px;
    }

    .activity-header {
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
    }

    .activity-header span {
        font-size: 10px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
    }

    .activity-item {
        align-items: center;
        padding: 13px 0;
        border-bottom: 1px solid #f0f1f3;
    }

    .activity-item:last-child {
        border-bottom: none;
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
    }

    .activity-icon i {
        font-size: 14px;
    }

    /*
    |--------------------------------------------------------------------------
    | TANGGAL + JAM SEJAJAR
    |--------------------------------------------------------------------------
    */

    .activity-date {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }

    .activity-date-main {
        font-size: 11px;
        font-weight: 600;
        color: #374151;
        white-space: nowrap;
    }

    .activity-date-time {
        font-size: 10px;
        color: #9ca3af;
        white-space: nowrap;
    }

    .activity-operator {
        font-size: 11px;
        font-weight: 600;
        color: #075985;
        word-break: break-word;
    }

    .activity-description {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 0;
    }

    .activity-feature {
        font-size: 10px;
        color: #9ca3af;
    }

    .activity-text {
        font-size: 12px;
        color: #374151;
        word-break: break-word;
    }

    .empty-state {
        padding: 30px 10px;
        text-align: center;
        color: #9ca3af;
        font-size: 12px;
    }

    .empty-state i {
        font-size: 22px;
        display: block;
        margin-bottom: 8px;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 1300px) {

        .stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .asset-panels {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }


    @media (max-width: 900px) {

        .asset-panels {
            grid-template-columns: 1fr;
        }

        .activity-header,
        .activity-item {
            grid-template-columns: 38px 120px 110px minmax(0, 1fr);
        }
    }


    @media (max-width: 700px) {

        .welcome-title {
            font-size: 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-toolbar {
            justify-content: flex-start;
        }

        .filter-wrapper {
            width: 100%;
        }

        .filter-select {
            flex: 1;
        }

        .activity-header {
            display: none;
        }

        .activity-item {
            grid-template-columns: 38px minmax(0, 1fr);
            align-items: start;
            row-gap: 7px;
        }

        .activity-date,
        .activity-operator,
        .activity-description {
            grid-column: 2;
        }

        .activity-date {
            flex-direction: row;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .activity-icon {
            grid-row: span 3;
        }
    }


    @media (max-width: 500px) {

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-toolbar {
            margin-bottom: 15px;
        }

        .filter-wrapper {
            flex-wrap: wrap;
        }

        .filter-label {
            width: 100%;
        }

        .filter-select {
            min-width: 0;
            flex: 1;
        }

        .filter-button {
            flex-shrink: 0;
        }

        .asset-panel {
            padding: 14px;
        }

        .donut-section {
            gap: 15px;
        }

        .donut {
            width: 100px;
            height: 100px;
        }

        .donut::after {
            width: 58px;
            height: 58px;
        }

        .legend {
            min-width: 95px;
        }

        .legend-value {
            font-size: 8px;
        }

        .dashboard-card {
            padding: 16px;
        }
    }

</style>


<div class="dashboard">

    {{-- =====================================================
         WELCOME
    ====================================================== --}}

    <div class="welcome-section">

        <h2 class="welcome-title">
            Selamat Datang,
            {{ auth()->user()->name ?? 'Operator' }} 👋
        </h2>

        <p class="welcome-text">
            Pantau dan kelola data aset IT melalui sistem
            Inventory IT Assets.
        </p>

    </div>


    {{-- =====================================================
         FILTER TAHUN
    ====================================================== --}}

    <div class="dashboard-toolbar">

        <form
            method="GET"
            action="{{ url()->current() }}"
            class="filter-wrapper"
        >

            <span class="filter-label">
                Filter Tahun
            </span>

            <select
                name="tahun"
                class="filter-select"
                onchange="this.form.submit()"
            >

                <option
                    value="all"
                    {{ empty($tahun) || (string) $tahun === 'all' ? 'selected' : '' }}
                >
                    Semua Tahun
                </option>

                @foreach($tahunList as $year)

                    <option
                        value="{{ $year }}"
                        {{ (string) $tahun === (string) $year ? 'selected' : '' }}
                    >
                        {{ $year }}
                    </option>

                @endforeach

            </select>

            <button
                type="submit"
                class="filter-button"
            >
                <i class="bi bi-funnel"></i>
                Filter
            </button>

        </form>

    </div>


    {{-- =====================================================
         SUMMARY
    ====================================================== --}}

    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Total Aset
                    </span>

                    <span class="stat-value">
                        {{ number_format($totalAset) }}
                    </span>

                </div>

            </div>
        </div>


        <div class="stat-card">
            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-pc-display"></i>
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Hardware
                    </span>

                    <span class="stat-value">
                        {{ number_format($hardwareCount) }}
                    </span>

                </div>

            </div>
        </div>


        <div class="stat-card">
            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-laptop"></i>
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Software
                    </span>

                    <span class="stat-value">
                        {{ number_format($softwareCount) }}
                    </span>

                </div>

            </div>
        </div>


        <div class="stat-card">
            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Infrastruktur
                    </span>

                    <span class="stat-value">
                        {{ number_format($infrastrukturCount) }}
                    </span>

                </div>

            </div>
        </div>


        <div class="stat-card">
            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        SDM
                    </span>

                    <span class="stat-value">
                        {{ number_format($sdmCount) }}
                    </span>

                </div>

            </div>
        </div>


        <div class="stat-card">
            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-database-fill"></i>
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Data
                    </span>

                    <span class="stat-value">
                        {{ number_format($dataCount) }}
                    </span>

                </div>

            </div>
        </div>

    </div>


    {{-- =====================================================
         3 PANEL
    ====================================================== --}}

    <div class="asset-panels">


        {{-- =================================================
             HARDWARE
        ================================================== --}}

        <div class="asset-panel">

            <div class="asset-panel-header">

                <i class="bi bi-pc-display"></i>

                <h3 class="asset-panel-title">
                    Hardware
                </h3>

            </div>


            <div class="donut-section">

                <div
                    class="donut hardware-donut"
                    data-baik="{{ $hardwareBaikDeg }}"
                    data-perbaikan="{{ $hardwarePerbaikanDeg }}"
                    data-total="{{ $hardwareTotal }}"
                >

                    <div class="donut-center">

                        <span class="donut-number">
                            {{ number_format($hardwareTotal) }}
                        </span>

                        <span class="donut-caption">
                            Total
                        </span>

                    </div>

                </div>


                <div class="legend">

                    <div class="legend-item">

                        <div class="legend-left">

                            <span
                                class="legend-dot"
                                style="background:#16a34a;"
                            ></span>

                            <span class="legend-name">
                                Baik
                            </span>

                        </div>

                        <span class="legend-value">
                            {{ number_format($hardwareStatus['Baik']) }}
                            ({{ number_format($hardwarePersen['Baik'], 1, ',', '.') }}%)
                        </span>

                    </div>


                    <div class="legend-item">

                        <div class="legend-left">

                            <span
                                class="legend-dot"
                                style="background:#f59e0b;"
                            ></span>

                            <span class="legend-name">
                                Perbaikan
                            </span>

                        </div>

                        <span class="legend-value">
                            {{ number_format($hardwareStatus['Perbaikan']) }}
                            ({{ number_format($hardwarePersen['Perbaikan'], 1, ',', '.') }}%)
                        </span>

                    </div>


                    <div class="legend-item">

                        <div class="legend-left">

                            <span
                                class="legend-dot"
                                style="background:#ef4444;"
                            ></span>

                            <span class="legend-name">
                                Rusak
                            </span>

                        </div>

                        <span class="legend-value">
                            {{ number_format($hardwareStatus['Rusak']) }}
                            ({{ number_format($hardwarePersen['Rusak'], 1, ',', '.') }}%)
                        </span>

                    </div>

                </div>

            </div>


            {{-- BAR HARDWARE --}}

            <div class="bar-section">

                <div class="bar-title">
                    Jenis barang
                </div>

                @if(array_sum($hardwareJenis) > 0)

                    <div class="bar-chart">

                        @foreach($hardwareJenis as $label => $value)

                            @php

                                $height = $value > 0
                                    ? max(4, ($value / $hardwareBarMax) * 55)
                                    : 0;

                            @endphp

                            <div class="bar-item">

                                <span class="bar-value">
                                    {{ number_format($value) }}
                                </span>

                                <div
                                    class="bar"
                                    data-height="{{ $height }}"
                                    style="
                                        height: {{ $height }}px;
                                        background:#079bd8;
                                    "
                                ></div>

                                <span class="bar-label">
                                    {{ $label }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="chart-empty">
                        Belum ada data jenis hardware.
                    </div>

                @endif

            </div>

        </div>


        {{-- =================================================
             SOFTWARE
        ================================================== --}}

        <div class="asset-panel">

            <div class="asset-panel-header">

                <i class="bi bi-grid-3x3-gap"></i>

                <h3 class="asset-panel-title">
                    Software
                </h3>

            </div>


            <div class="donut-section">

                <div
                    class="donut software-donut"
                    data-beli="{{ $softwareBeliDeg }}"
                    data-total="{{ $softwarePengadaanTotal }}"
                >

                    <div class="donut-center">

                        <span class="donut-number">
                            {{ number_format($softwarePengadaanTotal) }}
                        </span>

                        <span class="donut-caption">
                            Total
                        </span>

                    </div>

                </div>


                <div class="legend">

                    <div class="legend-item">

                        <div class="legend-left">

                            <span
                                class="legend-dot"
                                style="background:#2f80d7;"
                            ></span>

                            <span class="legend-name">
                                Beli
                            </span>

                        </div>

                        <span class="legend-value">
                            {{ number_format($softwarePengadaan['Beli']) }}
                            ({{ number_format($softwarePersen['Beli'], 1, ',', '.') }}%)
                        </span>

                    </div>


                    <div class="legend-item">

                        <div class="legend-left">

                            <span
                                class="legend-dot"
                                style="background:#9ca3af;"
                            ></span>

                            <span class="legend-name">
                                Sewa
                            </span>

                        </div>

                        <span class="legend-value">
                            {{ number_format($softwarePengadaan['Sewa']) }}
                            ({{ number_format($softwarePersen['Sewa'], 1, ',', '.') }}%)
                        </span>

                    </div>

                </div>

            </div>


            {{-- BAR SOFTWARE --}}

            <div class="bar-section">

                <div class="bar-title">
                    Status
                </div>

                @if(array_sum($softwareStatus) > 0)

                    <div class="bar-chart">

                        @foreach($softwareStatus as $label => $value)

                            @php

                                $height = $value > 0
                                    ? max(4, ($value / $softwareBarMax) * 55)
                                    : 0;

                                if ($label === 'Tersedia') {
                                    $barColor = '#16a34a';
                                } elseif ($label === 'Akan Habis') {
                                    $barColor = '#f59e0b';
                                } else {
                                    $barColor = '#ef4444';
                                }

                                if ($label === 'Akan Habis') {
                                    $barLabel = 'Akan habis';
                                } elseif ($label === 'Expired') {
                                    $barLabel = 'Exp';
                                } else {
                                    $barLabel = $label;
                                }

                            @endphp

                            <div class="bar-item">

                                <span class="bar-value">
                                    {{ number_format($value) }}
                                </span>

                                <div
                                    class="bar"
                                    data-height="{{ $height }}"
                                    style="
                                        height: {{ $height }}px;
                                        background: {{ $barColor }};
                                    "
                                ></div>

                                <span class="bar-label">
                                    {{ $barLabel }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="chart-empty">
                        Belum ada data status software.
                    </div>

                @endif

            </div>

        </div>


        {{-- =================================================
             INFRASTRUKTUR
        ================================================== --}}

        <div class="asset-panel">

            <div class="asset-panel-header">

                <i class="bi bi-diagram-3"></i>

                <h3 class="asset-panel-title">
                    Infrastruktur
                </h3>

            </div>


            <div class="donut-section">

                <div
                    class="donut infrastructure-donut"
                    data-beli="{{ $infraBeliDeg }}"
                    data-total="{{ $infraPengadaanTotal }}"
                >

                    <div class="donut-center">

                        <span class="donut-number">
                            {{ number_format($infraPengadaanTotal) }}
                        </span>

                        <span class="donut-caption">
                            Total
                        </span>

                    </div>

                </div>


                <div class="legend">

                    <div class="legend-item">

                        <div class="legend-left">

                            <span
                                class="legend-dot"
                                style="background:#2f80d7;"
                            ></span>

                            <span class="legend-name">
                                Beli
                            </span>

                        </div>

                        <span class="legend-value">
                            {{ number_format($infraPengadaan['Beli']) }}
                            ({{ number_format($infraPersen['Beli'], 1, ',', '.') }}%)
                        </span>

                    </div>


                    <div class="legend-item">

                        <div class="legend-left">

                            <span
                                class="legend-dot"
                                style="background:#9ca3af;"
                            ></span>

                            <span class="legend-name">
                                Sewa
                            </span>

                        </div>

                        <span class="legend-value">
                            {{ number_format($infraPengadaan['Sewa']) }}
                            ({{ number_format($infraPersen['Sewa'], 1, ',', '.') }}%)
                        </span>

                    </div>

                </div>

            </div>


            {{-- BAR INFRASTRUKTUR --}}

            <div class="bar-section">

                <div class="bar-title">
                    Status keseluruhan
                </div>

                @if(array_sum($infraStatus) > 0)

                    <div class="bar-chart">

                        @foreach($infraStatus as $label => $value)

                            @php

                                $height = $value > 0
                                    ? max(4, ($value / $infraBarMax) * 55)
                                    : 0;

                                if ($label === 'Tersedia') {
                                    $barColor = '#16a34a';
                                } elseif ($label === 'Akan Habis') {
                                    $barColor = '#f59e0b';
                                } else {
                                    $barColor = '#ef4444';
                                }

                                if ($label === 'Akan Habis') {
                                    $barLabel = 'Akan habis';
                                } elseif ($label === 'Expired') {
                                    $barLabel = 'Exp';
                                } else {
                                    $barLabel = $label;
                                }

                            @endphp

                            <div class="bar-item">

                                <span class="bar-value">
                                    {{ number_format($value) }}
                                </span>

                                <div
                                    class="bar"
                                    data-height="{{ $height }}"
                                    style="
                                        height: {{ $height }}px;
                                        background: {{ $barColor }};
                                    "
                                ></div>

                                <span class="bar-label">
                                    {{ $barLabel }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="chart-empty">
                        Belum ada data status infrastruktur.
                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- =====================================================
         AKTIVITAS TERBARU
    ====================================================== --}}

    <div class="dashboard-card activity-card">

        <div class="card-header">

            <div>

                <h3 class="card-title">
                    Aktivitas Terbaru
                </h3>

                <p class="card-subtitle">
                    Aktivitas pengelolaan data aset terbaru
                </p>

            </div>

        </div>


        <div class="activity-list">

            @if($activities->isNotEmpty())

                <div class="activity-header">

                    <span></span>

                    <span>
                        Tanggal & Jam
                    </span>

                    <span>
                        Operator
                    </span>

                    <span>
                        Aktivitas
                    </span>

                </div>

            @endif


            @forelse($activities as $activity)

                @php

                    if (is_array($activity)) {

                        $activityDateValue =
                            $activity['date']
                            ?? $activity['created_at']
                            ?? null;

                        $activityIcon =
                            $activity['icon']
                            ?? 'bi-activity';

                        $activityOperator =
                            $activity['operator']
                            ?? 'Operator';

                        $activityFeature =
                            $activity['feature']
                            ?? 'Inventory IT Assets';

                        $activityText =
                            $activity['text']
                            ?? 'Aktivitas data aset';

                    } else {

                        $activityDateValue =
                            $activity->date
                            ?? $activity->created_at
                            ?? null;

                        $activityIcon =
                            $activity->icon
                            ?? 'bi-activity';

                        $activityOperator =
                            $activity->operator
                            ?? 'Operator';

                        $activityFeature =
                            $activity->feature
                            ?? 'Inventory IT Assets';

                        $activityText =
                            $activity->text
                            ?? 'Aktivitas data aset';

                    }

                    $activityIcon = trim((string) $activityIcon);

                    if (!str_starts_with($activityIcon, 'bi-')) {
                        $activityIcon = 'bi-' . $activityIcon;
                    }

                    $activityDate = null;

                    if (!empty($activityDateValue)) {

                        try {

                            $activityDate = \Carbon\Carbon::parse(
                                $activityDateValue
                            );

                        } catch (\Throwable $e) {

                            $activityDate = null;

                        }

                    }

                @endphp


                <div class="activity-item">

                    <div class="activity-icon">

                        <i class="bi {{ $activityIcon }}"></i>

                    </div>


                    <div class="activity-date">

                        @if($activityDate)

                            <span class="activity-date-main">
                                {{ $activityDate->format('d M Y') }}
                            </span>

                            <span class="activity-date-time">
                                {{ $activityDate->format('H:i') }}
                            </span>

                        @else

                            <span class="activity-date-main">
                                -
                            </span>

                        @endif

                    </div>


                    <div class="activity-operator">
                        {{ $activityOperator }}
                    </div>


                    <div class="activity-description">

                        <span class="activity-feature">
                            {{ $activityFeature }}
                        </span>

                        <span class="activity-text">
                            {{ $activityText }}
                        </span>

                    </div>

                </div>


            @empty

                <div class="empty-state">

                    <i class="bi bi-clock-history"></i>

                    Belum ada aktivitas terbaru.

                </div>

            @endforelse

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DURASI ANIMASI
    |--------------------------------------------------------------------------
    */

    const duration = 1200;


    /*
    |--------------------------------------------------------------------------
    | HARDWARE DONUT
    |--------------------------------------------------------------------------
    */

    const hardware =
        document.querySelector('.hardware-donut');

    if (hardware) {

        const targetBaik =
            parseFloat(
                hardware.dataset.baik
            ) || 0;

        const targetPerbaikan =
            parseFloat(
                hardware.dataset.perbaikan
            ) || 0;

        const total =
            parseFloat(
                hardware.dataset.total
            ) || 0;

        if (total <= 0) {

            hardware.style.background = '#e5e7eb';

        } else {

            const start =
                performance.now();

            function animateHardware(time) {

                const progress =
                    Math.min(
                        (time - start) / duration,
                        1
                    );

                const ease =
                    1 -
                    Math.pow(
                        1 - progress,
                        3
                    );

                const baik =
                    targetBaik * ease;

                const perbaikan =
                    targetPerbaikan * ease;

                hardware.style.background = `
                    conic-gradient(
                        #16a34a 0deg ${baik}deg,
                        #f59e0b ${baik}deg ${perbaikan}deg,
                        #ef4444 ${perbaikan}deg 360deg
                    )
                `;

                if (progress < 1) {

                    requestAnimationFrame(
                        animateHardware
                    );

                }

            }

            requestAnimationFrame(
                animateHardware
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | SOFTWARE DONUT
    |--------------------------------------------------------------------------
    */

    const software =
        document.querySelector('.software-donut');

    if (software) {

        const targetBeli =
            parseFloat(
                software.dataset.beli
            ) || 0;

        const total =
            parseFloat(
                software.dataset.total
            ) || 0;

        if (total <= 0) {

            software.style.background = '#e5e7eb';

        } else {

            const start =
                performance.now();

            function animateSoftware(time) {

                const progress =
                    Math.min(
                        (time - start) / duration,
                        1
                    );

                const ease =
                    1 -
                    Math.pow(
                        1 - progress,
                        3
                    );

                const beli =
                    targetBeli * ease;

                software.style.background = `
                    conic-gradient(
                        #2f80d7 0deg ${beli}deg,
                        #9ca3af ${beli}deg 360deg
                    )
                `;

                if (progress < 1) {

                    requestAnimationFrame(
                        animateSoftware
                    );

                }

            }

            requestAnimationFrame(
                animateSoftware
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | INFRASTRUKTUR DONUT
    |--------------------------------------------------------------------------
    */

    const infrastructure =
        document.querySelector(
            '.infrastructure-donut'
        );

    if (infrastructure) {

        const targetBeli =
            parseFloat(
                infrastructure.dataset.beli
            ) || 0;

        const total =
            parseFloat(
                infrastructure.dataset.total
            ) || 0;

        if (total <= 0) {

            infrastructure.style.background =
                '#e5e7eb';

        } else {

            const start =
                performance.now();

            function animateInfrastructure(time) {

                const progress =
                    Math.min(
                        (time - start) / duration,
                        1
                    );

                const ease =
                    1 -
                    Math.pow(
                        1 - progress,
                        3
                    );

                const beli =
                    targetBeli * ease;

                infrastructure.style.background = `
                    conic-gradient(
                        #2f80d7 0deg ${beli}deg,
                        #9ca3af ${beli}deg 360deg
                    )
                `;

                if (progress < 1) {

                    requestAnimationFrame(
                        animateInfrastructure
                    );

                }

            }

            requestAnimationFrame(
                animateInfrastructure
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | BAR CHART
    |--------------------------------------------------------------------------
    | Animasi sama seperti donut:
    | 0 -> nilai asli secara smooth
    |--------------------------------------------------------------------------
    */

    const bars =
        document.querySelectorAll('.bar');

    bars.forEach(function (bar) {

        const targetHeight =
            parseFloat(
                bar.dataset.height
            ) || 0;

        const start =
            performance.now();

        function animateBar(time) {

            const progress =
                Math.min(
                    (time - start) / duration,
                    1
                );

            const ease =
                1 -
                Math.pow(
                    1 - progress,
                    3
                );

            const height =
                targetHeight * ease;

            bar.style.height =
                height + 'px';

            if (progress < 1) {

                requestAnimationFrame(
                    animateBar
                );

            } else {

                bar.style.height =
                    targetHeight + 'px';

            }

        }

        requestAnimationFrame(
            animateBar
        );

    });

});
</script>

@endsection