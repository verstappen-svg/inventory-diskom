@extends('layouts.app')

@section('title', 'Dashboard Pimpinan')

@section('page-title', 'Dashboard Pimpinan')

@section('content')

@php

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

@endphp

<style>

.dashboard {
    width: 100%;
}

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
}

.welcome-text {
    margin: 0;
    font-size: 13px;
    color: #6b7280;
}

.year-filter select {
    padding: 9px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.stat-card,
.dashboard-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    border: 1px solid #eef0f4;
    box-shadow: 0 3px 10px rgba(0,0,0,.06);
}

.stat-label {
    display: block;
    font-size: 12px;
    color: #6b7280;
}

.stat-value {
    display: block;
    margin-top: 7px;
    font-size: 25px;
    font-weight: 700;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
}

.card-title {
    margin: 0 0 20px;
    font-size: 16px;
}

.status-content {
    display: flex;
    align-items: center;
    gap: 35px;
}

.donut {
    width: 190px;
    height: 190px;
    border-radius: 50%;
    position: relative;
    flex-shrink: 0;

    background: conic-gradient(
        #22c55e 0% {{ $p1 }}%,
        #f59e0b {{ $p1 }}% {{ $p2 }}%,
        #ef4444 {{ $p2 }}% {{ $p3 }}%,
        #6b7280 {{ $p3 }}% 100%
    );
}

.donut::after {
    content: "";
    width: 125px;
    height: 125px;
    background: white;
    border-radius: 50%;
    position: absolute;
    top: 32px;
    left: 32px;
}

.donut-text {
    position: absolute;
    z-index: 2;
    width: 100%;
    text-align: center;
    top: 65px;
}

.donut-number {
    display: block;
    font-size: 27px;
    font-weight: 700;
}

.donut-label {
    font-size: 11px;
    color: #6b7280;
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

.category-item {
    margin-bottom: 20px;
}

.category-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.progress {
    height: 8px;
    background: #eef2f7;
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: #079bd8;
    border-radius: 10px;
}

.infrastructure-item {
    display: flex;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #eef0f4;
}

.infrastructure-item:last-child {
    border-bottom: none;
}

@media(max-width:1000px) {

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
    }

}

@media(max-width:600px) {

    .dashboard-top {
        flex-direction: column;
        align-items: flex-start;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .status-content {
        flex-direction: column;
    }

}

</style>


<div class="dashboard">

    <div class="dashboard-top">

        <div>

            <h2 class="welcome-title">
                Dashboard Pimpinan
            </h2>

            <p class="welcome-text">
                Ringkasan kondisi dan distribusi aset IT.
            </p>

        </div>


        <form method="GET"
              action="{{ route('dashboard') }}"
              class="year-filter">

            <select name="tahun"
                    onchange="this.form.submit()">

                <option value="all">
                    Semua Tahun
                </option>

                @foreach($tahunList as $item)

                    <option value="{{ $item }}"
                        {{ $tahun == $item ? 'selected' : '' }}>

                        {{ $item }}

                    </option>

                @endforeach

            </select>

        </form>

    </div>


    <div class="stats-grid">

        <div class="stat-card">

            <span class="stat-label">
                Total Aset
            </span>

            <span class="stat-value">
                {{ number_format($totalAset) }}
            </span>

        </div>


        <div class="stat-card">

            <span class="stat-label">
                Hardware
            </span>

            <span class="stat-value">
                {{ number_format($hardwareCount) }}
            </span>

        </div>


        <div class="stat-card">

            <span class="stat-label">
                Software
            </span>

            <span class="stat-value">
                {{ number_format($softwareCount) }}
            </span>

        </div>


        <div class="stat-card">

            <span class="stat-label">
                Infrastruktur
            </span>

            <span class="stat-value">
                {{ number_format($infrastrukturCount) }}
            </span>

        </div>

    </div>


    <div class="dashboard-grid">

        <div class="dashboard-card">

            <h3 class="card-title">
                Kondisi Aset
            </h3>

            <div class="status-content">

                <div class="donut">

                    <div class="donut-text">

                        <span class="donut-number">
                            {{ $statusTotal }}
                        </span>

                        <span class="donut-label">
                            Total Aset
                        </span>

                    </div>

                </div>


                <div>

                    <div class="status-item">

                        <div class="status-left">

                            <span class="status-dot"
                                  style="background:#22c55e"></span>

                            Aktif

                        </div>

                        <strong>{{ $aktif }}</strong>

                    </div>


                    <div class="status-item">

                        <div class="status-left">

                            <span class="status-dot"
                                  style="background:#f59e0b"></span>

                            Pending

                        </div>

                        <strong>{{ $pending }}</strong>

                    </div>


                    <div class="status-item">

                        <div class="status-left">

                            <span class="status-dot"
                                  style="background:#ef4444"></span>

                            Rusak

                        </div>

                        <strong>{{ $rusak }}</strong>

                    </div>


                    <div class="status-item">

                        <div class="status-left">

                            <span class="status-dot"
                                  style="background:#6b7280"></span>

                            Tidak Digunakan

                        </div>

                        <strong>{{ $tidakDigunakan }}</strong>

                    </div>

                </div>

            </div>

        </div>


        <div class="dashboard-card">

            <h3 class="card-title">
                Distribusi Kategori
            </h3>

            @foreach($kategoriData as $kategori)

                <div class="category-item">

                    <div class="category-info">

                        <span>
                            {{ $kategori['nama'] }}
                        </span>

                        <strong>
                            {{ $kategori['jumlah'] }}
                        </strong>

                    </div>

                    <div class="progress">

                        <div class="progress-bar"
                             style="width:{{ $kategori['persentase'] }}%">
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>


    <div class="dashboard-card">

        <h3 class="card-title">
            Ringkasan Infrastruktur
        </h3>

        @foreach($infrastrukturDetail as $detail)

            <div class="infrastructure-item">

                <span>
                    {{ $detail['nama'] }}
                </span>

                <strong>
                    {{ $detail['jumlah'] }}
                </strong>

            </div>

        @endforeach

    </div>

</div>

@endsection