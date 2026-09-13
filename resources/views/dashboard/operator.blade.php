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


$hardwareStatus =
    is_array($hardwareStatus)
        ? $hardwareStatus
        : [];


$hardwareJenis =
    is_array($hardwareJenis)
        ? $hardwareJenis
        : [];


/*
|--------------------------------------------------------------------------
| STATUS HARDWARE
|--------------------------------------------------------------------------
|
| Status memang tetap menggunakan 3 kategori:
| Baik / Perbaikan / Rusak
|
*/

$hardwareStatus = array_merge([

    'Baik' => 0,
    'Perbaikan' => 0,
    'Rusak' => 0,

], $hardwareStatus);


/*
|--------------------------------------------------------------------------
| JENIS HARDWARE
|--------------------------------------------------------------------------
|
| TIDAK DI-HARDCODE.
|
| Data langsung mengikuti isi kolom jenis_barang di database.
|
*/

$hardwareJenis = array_filter(
    $hardwareJenis,
    function ($value) {
        return is_numeric($value);
    }
);


/*
|--------------------------------------------------------------------------
| SOFTWARE
|--------------------------------------------------------------------------
*/

$softwareDashboard = $softwareDashboard ?? [];

if ($softwareDashboard instanceof \Illuminate\Support\Collection) {

    $softwareDashboard =
        $softwareDashboard->toArray();

}

if (!is_array($softwareDashboard)) {

    $softwareDashboard = [];

}


$softwarePengadaan =
    $softwareDashboard['pengadaan'] ?? [];

$softwareStatus =
    $softwareDashboard['status'] ?? [];


if ($softwarePengadaan instanceof \Illuminate\Support\Collection) {

    $softwarePengadaan =
        $softwarePengadaan->toArray();

}


if ($softwareStatus instanceof \Illuminate\Support\Collection) {

    $softwareStatus =
        $softwareStatus->toArray();

}


$softwarePengadaan =
    is_array($softwarePengadaan)
        ? $softwarePengadaan
        : [];


$softwareStatus =
    is_array($softwareStatus)
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

$infrastrukturDashboard =
    $infrastrukturDashboard ?? [];


if ($infrastrukturDashboard instanceof \Illuminate\Support\Collection) {

    $infrastrukturDashboard =
        $infrastrukturDashboard->toArray();

}


if (!is_array($infrastrukturDashboard)) {

    $infrastrukturDashboard = [];

}


/*
|--------------------------------------------------------------------------
| JENIS INFRASTRUKTUR
|--------------------------------------------------------------------------
*/

$infraJenis =
    $infrastrukturDashboard['jenis'] ?? [];


if ($infraJenis instanceof \Illuminate\Support\Collection) {

    $infraJenis =
        $infraJenis->toArray();

}


$infraJenis =
    is_array($infraJenis)
        ? $infraJenis
        : [];


$infraJenis = array_merge([

    'Jaringan' => 0,
    'Data Center' => 0,

], $infraJenis);


/*
|--------------------------------------------------------------------------
| TENANT DATA CENTER
|--------------------------------------------------------------------------
*/

$infraTenant =
    $infrastrukturDashboard['tenant'] ?? [];


if ($infraTenant instanceof \Illuminate\Support\Collection) {

    $infraTenant =
        $infraTenant->toArray();

}


$infraTenant =
    is_array($infraTenant)
        ? $infraTenant
        : [];


/*
|--------------------------------------------------------------------------
| SUMMARY
|--------------------------------------------------------------------------
*/

$totalAset =
    (int) ($totalAset ?? 0);

$hardwareCount =
    (int) ($hardwareCount ?? 0);

$softwareCount =
    (int) ($softwareCount ?? 0);

$infrastrukturCount =
    (int) ($infrastrukturCount ?? 0);

$sdmCount =
    (int) ($sdmCount ?? 0);

$dataCount =
    (int) ($dataCount ?? 0);


/*
|--------------------------------------------------------------------------
| NORMALISASI ANGKA
|--------------------------------------------------------------------------
*/

foreach ($hardwareStatus as $key => $value) {

    $hardwareStatus[$key] =
        max(0, (int) $value);

}


foreach ($hardwareJenis as $key => $value) {

    $hardwareJenis[$key] =
        max(0, (int) $value);

}


foreach ($softwarePengadaan as $key => $value) {

    $softwarePengadaan[$key] =
        max(0, (int) $value);

}


foreach ($softwareStatus as $key => $value) {

    $softwareStatus[$key] =
        max(0, (int) $value);

}


foreach ($infraJenis as $key => $value) {

    $infraJenis[$key] =
        max(0, (int) $value);

}


foreach ($infraTenant as $key => $value) {

    $infraTenant[$key] =
        max(0, (int) $value);

}


/*
|--------------------------------------------------------------------------
| TOTAL
|--------------------------------------------------------------------------
*/

$hardwareTotal =
    array_sum($hardwareJenis);


$softwarePengadaanTotal =
    array_sum($softwarePengadaan);


$infraJenisTotal =
    array_sum($infraJenis);


/*
|--------------------------------------------------------------------------
| PERSENTASE HARDWARE
|--------------------------------------------------------------------------
*/

$hardwarePersen = [];

foreach ($hardwareJenis as $key => $value) {

    $hardwarePersen[$key] =
        $hardwareTotal > 0
            ? round(
                ($value / $hardwareTotal) * 100,
                1
            )
            : 0;

}


/*
|--------------------------------------------------------------------------
| PERSENTASE SOFTWARE
|--------------------------------------------------------------------------
*/

$softwarePersen = [];

foreach ($softwarePengadaan as $key => $value) {

    $softwarePersen[$key] =
        $softwarePengadaanTotal > 0
            ? round(
                ($value / $softwarePengadaanTotal) * 100,
                1
            )
            : 0;

}


/*
|--------------------------------------------------------------------------
| PERSENTASE INFRASTRUKTUR
|--------------------------------------------------------------------------
*/

$infraPersen = [];

foreach ($infraJenis as $key => $value) {

    $infraPersen[$key] =
        $infraJenisTotal > 0
            ? round(
                ($value / $infraJenisTotal) * 100,
                1
            )
            : 0;

}


/*
|--------------------------------------------------------------------------
| BAR MAX
|--------------------------------------------------------------------------
*/

$hardwareBarMax = max(

    !empty($hardwareStatus)
        ? max($hardwareStatus)
        : 0,

    1

);


$softwareBarMax = max(

    !empty($softwareStatus)
        ? max($softwareStatus)
        : 0,

    1

);


$infraBarMax = max(

    !empty($infraTenant)
        ? max($infraTenant)
        : 0,

    1

);


/*
|--------------------------------------------------------------------------
| SOFTWARE DONUT DEGREE
|--------------------------------------------------------------------------
*/

$softwareBeliDeg = 0;

if ($softwarePengadaanTotal > 0) {

    $softwareBeliDeg =
        ($softwarePengadaan['Beli']
        / $softwarePengadaanTotal)
        * 360;

}

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
    box-shadow: 0 0 0 3px rgba(7,155,216,.10);
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
    grid-template-columns: repeat(6,minmax(0,1fr));
    gap: 14px;
    margin-bottom: 22px;
}

.stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 17px;
    border: 1px solid #eef0f4;
    box-shadow: 0 3px 10px rgba(0,0,0,.05);
    min-width: 0;
    transition:
        transform .2s ease,
        box-shadow .2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,.07);
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
    grid-template-columns: repeat(3,minmax(0,1fr));
    gap: 14px;
    margin-bottom: 22px;
}

.asset-panel {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #eef0f4;
    box-shadow: 0 3px 10px rgba(0,0,0,.05);
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

    animation:
        donutEntrance .5s ease-out;
}

@keyframes donutEntrance {

    from {
        opacity: 0;
        transform:
            scale(.75)
            rotate(-25deg);
    }

    to {
        opacity: 1;
        transform:
            scale(1)
            rotate(0deg);
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
    transform:
        translate(-50%,-50%);
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
    max-height: 125px;
    overflow-y: auto;
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
    border-radius: 16px;
    padding: 22px;
    border: 1px solid #eef0f4;
    box-shadow: 0 4px 14px rgba(0,0,0,.05);
}

.activity-card {
    margin-bottom: 22px;
}

.card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 22px;
}

.card-title {
    margin: 0;
    font-size: 17px;
    font-weight: 700;
    color: #1f2937;
}

.card-subtitle {
    margin: 5px 0 0;
    font-size: 11px;
    color: #9ca3af;
}

.activity-total {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 11px;
    border-radius: 20px;
    background: #f0f9ff;
    color: #0284c7;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.activity-total i {
    font-size: 12px;
}


/* =====================================================
   ACTIVITY TIMELINE
===================================================== */

.activity-list {
    position: relative;
    display: flex;
    flex-direction: column;
}

.activity-item {
    position: relative;
    display: grid;
    grid-template-columns:
        46px minmax(0,1fr) auto;
    gap: 14px;
    align-items: start;

    padding: 15px 14px;
    border-radius: 12px;

    transition:
        background .2s ease,
        transform .2s ease;
}

.activity-item:hover {
    background: #f8fafc;
    transform: translateX(3px);
}

.activity-timeline {
    position: relative;
    display: flex;
    justify-content: center;
    height: 100%;
}

.activity-timeline::after {
    content: "";
    position: absolute;
    top: 40px;
    bottom: -18px;
    width: 2px;
    background: #e5e7eb;
}

.activity-item:last-child
.activity-timeline::after {
    display: none;
}

.activity-icon {
    position: relative;
    z-index: 2;

    width: 40px;
    height: 40px;

    border-radius: 12px;

    background: #e0f2fe;
    color: #0284c7;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 4px solid #fff;

    box-shadow:
        0 2px 7px
        rgba(2,132,199,.12);
}

.activity-icon i {
    font-size: 16px;
}


/* =====================================================
   CONTENT
===================================================== */

.activity-content {
    min-width: 0;
    padding-top: 2px;
}

.activity-top {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 5px;
    flex-wrap: wrap;
}

.activity-feature {
    display: inline-flex;
    align-items: center;

    padding: 4px 8px;

    border-radius: 6px;

    background: #f3f4f6;

    color: #6b7280;

    font-size: 10px;
    font-weight: 600;
}

.activity-text {
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    line-height: 1.5;
    word-break: break-word;
}


/* =====================================================
   META
===================================================== */

.activity-meta {
    display: flex;
    align-items: center;
    gap: 12px;

    margin-top: 8px;

    font-size: 10px;
    color: #9ca3af;

    flex-wrap: wrap;
}

.activity-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.activity-meta-item i {
    font-size: 10px;
}

.activity-operator {
    color: #0284c7;
    font-weight: 600;
}


/* =====================================================
   DATE
===================================================== */

.activity-date {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
    text-align: right;
    padding-top: 4px;
    min-width: 105px;
}

.activity-date-main {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #374151;
    white-space: nowrap;
}

.activity-date-time {
    display: block;
    margin-top: 3px;
    font-size: 10px;
    color: #9ca3af;
    white-space: nowrap;
}


/* =====================================================
   EMPTY
===================================================== */

.empty-state {
    padding: 45px 15px;
    text-align: center;
    color: #9ca3af;
    font-size: 12px;
}

.empty-state i {
    width: 50px;
    height: 50px;

    margin: 0 auto 12px;

    border-radius: 50%;

    background: #f3f4f6;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 22px;
    color: #9ca3af;
}

.empty-state-title {
    display: block;
    margin-bottom: 4px;

    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
}

.empty-state-text {
    font-size: 11px;
    color: #9ca3af;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width:1300px) {

    .stats-grid {
        grid-template-columns:
            repeat(3,minmax(0,1fr));
    }

    .asset-panels {
        grid-template-columns:
            repeat(2,minmax(0,1fr));
    }

}


@media (max-width:900px) {

    .asset-panels {
        grid-template-columns: 1fr;
    }

    .activity-item {
        grid-template-columns:
            38px minmax(0,1fr) 110px;
    }

}


@media (max-width:700px) {

    .welcome-title {
        font-size: 20px;
    }

    .stats-grid {
        grid-template-columns:
            repeat(2,minmax(0,1fr));
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

    .activity-item {
        grid-template-columns:
            46px minmax(0,1fr);

        gap: 10px;
    }

    .activity-date {
        grid-column: 2;
        grid-row: 3;

        text-align: left;

        display: flex;
        align-items: center;
        gap: 7px;

        padding-top: 0;
    }

    .activity-date-main,
    .activity-date-time {
        display: inline;
        margin-top: 0;
    }

    .activity-date-time::before {
        content: "•";
        margin-right: 7px;
    }

}


@media (max-width:500px) {

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
===================================================== --}}

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
===================================================== --}}

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
                {{ empty($tahun) ||
                    (string) $tahun === 'all'
                    ? 'selected'
                    : '' }}
            >
                Semua Tahun
            </option>


            @foreach($tahunList as $year)

                <option
                    value="{{ $year }}"
                    {{ (string) $tahun === (string) $year
                        ? 'selected'
                        : '' }}
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
===================================================== --}}

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
===================================================== --}}

<div class="asset-panels">


{{-- =====================================================
     HARDWARE
===================================================== --}}

<div class="asset-panel">

    <div class="asset-panel-header">

        <i class="bi bi-pc-display"></i>

        <h3 class="asset-panel-title">
            Hardware
        </h3>

    </div>


    {{-- DONUT = JENIS BARANG --}}

    <div class="donut-section">

        <div
            class="donut hardware-donut"
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

            @php

                /*
                |--------------------------------------------------------------------------
                | WARNA HARDWARE
                |--------------------------------------------------------------------------
                |
                | Warna berdasarkan urutan jenis yang berasal dari database.
                | Tidak bergantung pada nama jenis barang.
                |
                */

                $hardwareColors = [

                    '#079bd8',
                    '#6366f1',
                    '#8b5cf6',
                    '#ec4899',
                    '#f59e0b',
                    '#16a34a',
                    '#ef4444',
                    '#14b8a6',
                    '#f97316',
                    '#06b6d4',
                    '#84cc16',
                    '#a855f7',
                    '#e11d48',
                    '#0ea5e9',
                    '#64748b',
                    '#d946ef',

                ];

                $hardwareColorIndex = 0;

            @endphp


            @forelse($hardwareJenis as $label => $value)

                @php

                    $legendColor =
                        $hardwareColors[
                            $hardwareColorIndex
                            % count($hardwareColors)
                        ];

                    $hardwareColorIndex++;

                @endphp


                <div class="legend-item">

                    <div class="legend-left">

                        <span
                            class="legend-dot"
                            style="
                                background:
                                {{ $legendColor }};
                            "
                        ></span>

                        <span
                            class="legend-name"
                            title="{{ $label }}"
                        >
                            {{ $label }}
                        </span>

                    </div>

                    <span class="legend-value">

                        {{ number_format($value) }}

                        (

                        {{ number_format(
                            $hardwarePersen[$label] ?? 0,
                            1,
                            ',',
                            '.'
                        ) }}%

                        )

                    </span>

                </div>

            @empty

                <div class="chart-empty">
                    Belum ada data jenis hardware.
                </div>

            @endforelse

        </div>

    </div>


    {{-- BAR = KONDISI HARDWARE --}}

    <div class="bar-section">

        <div class="bar-title">
            Kondisi hardware
        </div>


        @if(array_sum($hardwareStatus) > 0)

            <div class="bar-chart">

                @foreach($hardwareStatus as $label => $value)

                    @php

                        $height =
                            $value > 0
                                ? max(
                                    4,
                                    (
                                        $value
                                        / $hardwareBarMax
                                    ) * 55
                                )
                                : 0;


                        if ($label === 'Baik') {

                            $barColor = '#16a34a';

                        } elseif ($label === 'Perbaikan') {

                            $barColor = '#f59e0b';

                        } else {

                            $barColor = '#ef4444';

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
                                height:
                                    {{ $height }}px;

                                background:
                                    {{ $barColor }};
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
                Belum ada data kondisi hardware.
            </div>

        @endif

    </div>

</div>


{{-- =====================================================
     SOFTWARE
===================================================== --}}

<div class="asset-panel">

    <div class="asset-panel-header">

        <i class="bi bi-grid-3x3-gap"></i>

        <h3 class="asset-panel-title">
            Software
        </h3>

    </div>


    {{-- DONUT = PENGADAAN --}}

    <div class="donut-section">

        <div
            class="donut software-donut"
            data-beli="{{ $softwareBeliDeg }}"
            data-total="{{ $softwarePengadaanTotal }}"
        >

            <div class="donut-center">

                <span class="donut-number">
                    {{ number_format(
                        $softwarePengadaanTotal
                    ) }}
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
                        style="
                            background:#2f80d7;
                        "
                    ></span>

                    <span class="legend-name">
                        Beli
                    </span>

                </div>

                <span class="legend-value">

                    {{ number_format(
                        $softwarePengadaan['Beli']
                    ) }}

                    (

                    {{ number_format(
                        $softwarePersen['Beli'],
                        1,
                        ',',
                        '.'
                    ) }}%

                    )

                </span>

            </div>


            <div class="legend-item">

                <div class="legend-left">

                    <span
                        class="legend-dot"
                        style="
                            background:#9ca3af;
                        "
                    ></span>

                    <span class="legend-name">
                        Sewa
                    </span>

                </div>

                <span class="legend-value">

                    {{ number_format(
                        $softwarePengadaan['Sewa']
                    ) }}

                    (

                    {{ number_format(
                        $softwarePersen['Sewa'],
                        1,
                        ',',
                        '.'
                    ) }}%

                    )

                </span>

            </div>

        </div>

    </div>


    {{-- BAR = STATUS SOFTWARE --}}

    <div class="bar-section">

        <div class="bar-title">
            Status
        </div>


        @if(array_sum($softwareStatus) > 0)

            <div class="bar-chart">

                @foreach($softwareStatus as $label => $value)

                    @php

                        $height =
                            $value > 0
                                ? max(
                                    4,
                                    (
                                        $value
                                        / $softwareBarMax
                                    ) * 55
                                )
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
                                height:
                                    {{ $height }}px;

                                background:
                                    {{ $barColor }};
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


{{-- =====================================================
     INFRASTRUKTUR
===================================================== --}}

<div class="asset-panel">

    <div class="asset-panel-header">

        <i class="bi bi-diagram-3"></i>

        <h3 class="asset-panel-title">
            Infrastruktur
        </h3>

    </div>


    {{-- DONUT = JARINGAN + DATA CENTER --}}

    <div class="donut-section">

        <div
            class="donut infrastructure-donut"
            data-total="{{ $infraJenisTotal }}"
        >

            <div class="donut-center">

                <span class="donut-number">
                    {{ number_format(
                        $infraJenisTotal
                    ) }}
                </span>

                <span class="donut-caption">
                    Total
                </span>

            </div>

        </div>


        <div class="legend">

            @php

                $infraColors = [

                    'Jaringan' =>
                        '#079bd8',

                    'Data Center' =>
                        '#8b5cf6',

                ];

            @endphp


            @foreach($infraJenis as $label => $value)

                <div class="legend-item">

                    <div class="legend-left">

                        <span
                            class="legend-dot"
                            style="
                                background:
                                {{ $infraColors[$label]
                                    ?? '#9ca3af' }};
                            "
                        ></span>

                        <span class="legend-name">
                            {{ $label }}
                        </span>

                    </div>


                    <span class="legend-value">

                        {{ number_format($value) }}

                        (

                        {{ number_format(
                            $infraPersen[$label] ?? 0,
                            1,
                            ',',
                            '.'
                        ) }}%

                        )

                    </span>

                </div>

            @endforeach

        </div>

    </div>


    {{-- BAR = TENANT DATA CENTER --}}

    <div class="bar-section">

        <div class="bar-title">
            Tenant Data Center
        </div>


        @if(array_sum($infraTenant) > 0)

            <div class="bar-chart">

                @foreach($infraTenant as $label => $value)

                    @php

                        $height =
                            $value > 0
                                ? max(
                                    4,
                                    (
                                        $value
                                        / $infraBarMax
                                    ) * 55
                                )
                                : 0;

                        $barColor =
                            '#8b5cf6';

                    @endphp


                    <div class="bar-item">

                        <span class="bar-value">
                            {{ number_format($value) }}
                        </span>

                        <div
                            class="bar"
                            data-height="{{ $height }}"
                            style="
                                height:
                                    {{ $height }}px;

                                background:
                                    {{ $barColor }};
                            "
                        ></div>

                        <span
                            class="bar-label"
                            title="{{ $label }}"
                        >
                            {{ $label }}
                        </span>

                    </div>

                @endforeach

            </div>

        @else

            <div class="chart-empty">
                Belum ada data tenant Data Center.
            </div>

        @endif

    </div>

</div>


</div>


{{-- =====================================================
     AKTIVITAS TERBARU
===================================================== --}}

<div class="dashboard-card activity-card">


    <div class="card-header">

        <div>

            <h3 class="card-title">
                Aktivitas Terbaru
            </h3>

            <p class="card-subtitle">
                Riwayat pembaruan dan pengelolaan data aset terbaru
            </p>

        </div>


        @if($activities->isNotEmpty())

            <div class="activity-total">

                <i class="bi bi-activity"></i>

                {{ $activities->count() }}
                Aktivitas

            </div>

        @endif

    </div>


    <div class="activity-list">


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
                        ?? $activity['username']
                        ?? $activity['user_name']
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
                        ?? $activity->username
                        ?? $activity->user_name
                        ?? 'Operator';

                    $activityFeature =
                        $activity->feature
                        ?? 'Inventory IT Assets';

                    $activityText =
                        $activity->text
                        ?? 'Aktivitas data aset';

                }


                $activityIcon =
                    trim((string) $activityIcon);


                if (
                    !str_starts_with(
                        $activityIcon,
                        'bi-'
                    )
                ) {

                    $activityIcon =
                        'bi-' . $activityIcon;

                }


                $activityDate = null;


                if (
                    $activityDateValue
                    instanceof \Carbon\Carbon
                ) {

                    $activityDate =
                        $activityDateValue->copy();

                } elseif (
                    $activityDateValue
                    instanceof \DateTimeInterface
                ) {

                    $activityDate =
                        \Carbon\Carbon::instance(
                            $activityDateValue
                        );

                } elseif (
                    !empty($activityDateValue)
                ) {

                    try {

                        $activityDate =
                            \Carbon\Carbon::parse(
                                $activityDateValue,
                                'Asia/Jakarta'
                            );

                    } catch (\Throwable $e) {

                        $activityDate = null;

                    }

                }


                $activityDateLabel = '-';


                if ($activityDate) {

                    $activityDate =
                        $activityDate->setTimezone(
                            'Asia/Jakarta'
                        );

                    if ($activityDate->isToday()) {

                        $activityDateLabel =
                            'Hari ini';

                    } elseif (
                        $activityDate->isYesterday()
                    ) {

                        $activityDateLabel =
                            'Kemarin';

                    } else {

                        $activityDateLabel =
                            $activityDate
                                ->locale('id')
                                ->translatedFormat(
                                    'd M Y'
                                );

                    }

                }

            @endphp


            <div class="activity-item">


                <div class="activity-timeline">

                    <div class="activity-icon">

                        <i class="
                            bi {{ $activityIcon }}
                        "></i>

                    </div>

                </div>


                <div class="activity-content">


                    <div class="activity-top">

                        <span class="activity-feature">
                            {{ $activityFeature }}
                        </span>

                    </div>


                    <div class="activity-text">

                        {{ $activityText }}

                    </div>


                    <div class="activity-meta">


                        <span
                            class="
                                activity-meta-item
                                activity-operator
                            "
                        >

                            <i class="bi bi-person"></i>

                            {{ $activityOperator }}

                        </span>


                        @if($activityDate)

                            <span
                                class="
                                    activity-meta-item
                                "
                            >

                                <i class="bi bi-clock"></i>

                                {{ $activityDate
                                    ->locale('id')
                                    ->diffForHumans()
                                }}

                            </span>

                        @endif


                    </div>


                </div>


                <div class="activity-date">


                    @if($activityDate)

                        <span class="activity-date-main">

                            {{ $activityDateLabel }}

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


            </div>


        @empty


            <div class="empty-state">

                <i class="bi bi-clock-history"></i>

                <span class="empty-state-title">
                    Belum ada aktivitas terbaru
                </span>

                <span class="empty-state-text">
                    Aktivitas pengelolaan data akan muncul di sini.
                </span>

            </div>


        @endforelse


    </div>


</div>


</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const duration = 1200;


        /*
        |--------------------------------------------------------------------------
        | HARDWARE DONUT
        |--------------------------------------------------------------------------
        |
        | Menggunakan jenis hardware DINAMIS dari database.
        |
        */

        const hardware =
            document.querySelector(
                '.hardware-donut'
            );


        if (hardware) {

            const total =
                parseFloat(
                    hardware.dataset.total
                ) || 0;


            const jenisData =
                @json($hardwareJenis);


            /*
            |--------------------------------------------------------------------------
            | WARNA HARDWARE
            |--------------------------------------------------------------------------
            |
            | Warna berdasarkan urutan data.
            | Tidak tergantung nama jenis barang.
            |
            */

            const jenisColors = [

                '#079bd8',
                '#6366f1',
                '#8b5cf6',
                '#ec4899',
                '#f59e0b',
                '#16a34a',
                '#ef4444',
                '#14b8a6',
                '#f97316',
                '#06b6d4',
                '#84cc16',
                '#a855f7',
                '#e11d48',
                '#0ea5e9',
                '#64748b',
                '#d946ef'

            ];


            if (total <= 0) {

                hardware.style.background =
                    '#e5e7eb';

            } else {

                const segments = [];

                let currentDegree = 0;


                Object.entries(
                    jenisData
                ).forEach(
                    function ([label, value], index) {

                        value =
                            parseFloat(value)
                            || 0;


                        if (value <= 0) {

                            return;

                        }


                        const degree =
                            (
                                value
                                / total
                            ) * 360;


                        const start =
                            currentDegree;


                        const end =
                            currentDegree
                            + degree;


                        segments.push({

                            start:
                                start,

                            end:
                                end,

                            color:
                                jenisColors[
                                    index
                                    %
                                    jenisColors.length
                                ]

                        });


                        currentDegree =
                            end;

                    }
                );


                if (segments.length === 0) {

                    hardware.style.background =
                        '#e5e7eb';

                    return;

                }


                const start =
                    performance.now();


                function animateHardware(time) {

                    const progress =
                        Math.min(

                            (
                                time - start
                            ) / duration,

                            1

                        );


                    const ease =
                        1 -
                        Math.pow(
                            1 - progress,
                            3
                        );


                    const gradientParts =
                        segments.map(
                            function (segment) {

                                const animatedStart =
                                    segment.start
                                    * ease;


                                const animatedEnd =
                                    segment.end
                                    * ease;


                                return `
                                    ${segment.color}
                                    ${animatedStart}deg
                                    ${animatedEnd}deg
                                `;

                            }
                        );


                    hardware.style.background =
                        `conic-gradient(
                            ${gradientParts.join(',')}
                        )`;


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
            document.querySelector(
                '.software-donut'
            );


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

                software.style.background =
                    '#e5e7eb';

            } else {

                const start =
                    performance.now();


                function animateSoftware(time) {

                    const progress =
                        Math.min(

                            (
                                time - start
                            ) / duration,

                            1

                        );


                    const ease =
                        1 -
                        Math.pow(
                            1 - progress,
                            3
                        );


                    const beli =
                        targetBeli
                        * ease;


                    software.style.background = `
                        conic-gradient(
                            #2f80d7
                            0deg
                            ${beli}deg,

                            #9ca3af
                            ${beli}deg
                            360deg
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
        |
        | Jaringan / Data Center
        |
        */

        const infrastructure =
            document.querySelector(
                '.infrastructure-donut'
            );


        if (infrastructure) {

            const total =
                parseFloat(
                    infrastructure.dataset.total
                ) || 0;


            const infraData =
                @json($infraJenis);


            const infraColors = {

                'Jaringan':
                    '#079bd8',

                'Data Center':
                    '#8b5cf6'

            };


            if (total <= 0) {

                infrastructure.style.background =
                    '#e5e7eb';

            } else {

                const segments = [];

                let currentDegree = 0;


                Object.entries(
                    infraData
                ).forEach(
                    function ([label, value]) {

                        value =
                            parseFloat(value)
                            || 0;


                        if (value <= 0) {

                            return;

                        }


                        const degree =
                            (
                                value
                                / total
                            ) * 360;


                        const start =
                            currentDegree;


                        const end =
                            currentDegree
                            + degree;


                        segments.push({

                            start:
                                start,

                            end:
                                end,

                            color:
                                infraColors[label]
                                || '#9ca3af'

                        });


                        currentDegree =
                            end;

                    }
                );


                if (segments.length === 0) {

                    infrastructure.style.background =
                        '#e5e7eb';

                    return;

                }


                const start =
                    performance.now();


                function animateInfrastructure(time) {

                    const progress =
                        Math.min(

                            (
                                time - start
                            ) / duration,

                            1

                        );


                    const ease =
                        1 -
                        Math.pow(
                            1 - progress,
                            3
                        );


                    const gradientParts =
                        segments.map(
                            function (segment) {

                                const animatedStart =
                                    segment.start
                                    * ease;


                                const animatedEnd =
                                    segment.end
                                    * ease;


                                return `
                                    ${segment.color}
                                    ${animatedStart}deg
                                    ${animatedEnd}deg
                                `;

                            }
                        );


                    infrastructure.style.background =
                        `conic-gradient(
                            ${gradientParts.join(',')}
                        )`;


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
        */

        const bars =
            document.querySelectorAll(
                '.bar'
            );


        bars.forEach(
            function (bar) {

                const targetHeight =
                    parseFloat(
                        bar.dataset.height
                    ) || 0;


                const start =
                    performance.now();


                function animateBar(time) {

                    const progress =
                        Math.min(

                            (
                                time - start
                            ) / duration,

                            1

                        );


                    const ease =
                        1 -
                        Math.pow(
                            1 - progress,
                            3
                        );


                    const height =
                        targetHeight
                        * ease;


                    bar.style.height =
                        height + 'px';


                    if (progress < 1) {

                        requestAnimationFrame(
                            animateBar
                        );

                    } else {

                        bar.style.height =
                            targetHeight
                            + 'px';

                    }

                }


                requestAnimationFrame(
                    animateBar
                );

            }
        );

    }
);

</script>

@endsection