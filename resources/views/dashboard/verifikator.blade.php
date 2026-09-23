@extends('layouts.app')

@section('title', 'Dashboard Verifikator')
@section('page-title', 'Dashboard Verifikator')

@section('content')

@php

/*
|--------------------------------------------------------------------------
| DATA VERIFIKASI
|--------------------------------------------------------------------------
*/

$totalMenunggu =
    $verificationData['Menunggu'] ?? 0;

$totalDisetujui =
    $verificationData['Disetujui'] ?? 0;

$totalDitolak =
    $verificationData['Ditolak'] ?? 0;


/*
|--------------------------------------------------------------------------
| PENGAJUAN TERBARU
|--------------------------------------------------------------------------
*/

use App\Models\VerificationRequest;

$pengajuanTerbaru = VerificationRequest::with([
    'submitter',
])
->latest()
->take(5)
->get();

@endphp

<style>

/* =========================================================
   DASHBOARD VERIFIKATOR
========================================================= */

.verifikator-dashboard {
    width: 100%;
    box-sizing: border-box;
}


/* =========================================================
   TOP
========================================================= */

.verifikator-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 22px;
}


/* =========================================================
   WELCOME
========================================================= */

.verifikator-welcome h2 {
    margin: 0;
    font-size: 23px;
    font-weight: 700;
    color: #111827;
}

.verifikator-welcome p {
    margin: 6px 0 0;
    font-size: 13px;
    color: #64748b;
}


/* =========================================================
   YEAR FILTER
========================================================= */

.verifikator-year-filter {
    display: flex;
    align-items: center;
}

.verifikator-year-filter select {
    min-width: 145px;
    padding: 9px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: #ffffff;
    color: #374151;
    font-size: 11px;
    outline: none;
    cursor: pointer;
}

.verifikator-year-filter select:focus {
    border-color: #2563eb;
}


/* =========================================================
   ALERT
========================================================= */

.verifikator-alert {
    width: 100%;
    padding: 12px 15px;
    border-radius: 9px;
    margin-bottom: 18px;
    font-size: 11px;
    font-weight: 600;
    box-sizing: border-box;
}

.verifikator-alert.success {
    background: #dcfce7;
    border: 1px solid #bbf7d0;
    color: #15803d;
}

.verifikator-alert.error {
    background: #fee2e2;
    border: 1px solid #fecaca;
    color: #dc2626;
}


/* =========================================================
   STATISTICS
========================================================= */

.verifikator-stats {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.verifikator-stat {
    min-width: 0;
    min-height: 110px;
    background: #ffffff;
    border-radius: 12px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(15, 23, 42, .05);
    box-sizing: border-box;
}

.verifikator-stat-icon {
    width: 45px;
    height: 45px;
    min-width: 45px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
}

.verifikator-stat-icon.orange {
    background: #fff4cc;
    color: #f59e0b;
}

.verifikator-stat-icon.green {
    background: #d8f9e5;
    color: #16a34a;
}

.verifikator-stat-icon.red {
    background: #ffe0e0;
    color: #ef4444;
}

.verifikator-stat-label {
    display: block;
    font-size: 11px;
    color: #64748b;
    margin-bottom: 4px;
}

.verifikator-stat-value {
    display: block;
    font-size: 23px;
    font-weight: 700;
    color: #075985;
}


/* =========================================================
   MAIN GRID
========================================================= */

.verifikator-main-grid {
    width: 100%;
    display: grid;
    grid-template-columns:
        minmax(0, 1.7fr)
        minmax(260px, .8fr);
    gap: 18px;
    margin-bottom: 20px;
    align-items: start;
}


/* =========================================================
   CARD
========================================================= */

.verifikator-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
    min-width: 0;
}

.verifikator-card-header {
    min-height: 58px;
    padding: 0 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #e5e7eb;
    box-sizing: border-box;
}

.verifikator-card-title {
    margin: 0;
    font-size: 13px;
    font-weight: 700;
    color: #1f2937;
}


/* =========================================================
   TABLE
========================================================= */

.verifikator-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.verifikator-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 650px;
}

.verifikator-table th {
    padding: 10px 13px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    color: #64748b;
    font-size: 9px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.verifikator-table td {
    padding: 11px 13px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 10px;
    color: #374151;
    white-space: nowrap;
}

.verifikator-table tbody tr:last-child td {
    border-bottom: none;
}

.verifikator-table tbody tr:hover {
    background: #f8fafc;
}


/* =========================================================
   DATA
========================================================= */

.verifikator-data-name {
    display: block;
    font-weight: 600;
    color: #1f2937;
}

.verifikator-data-code {
    display: block;
    margin-top: 3px;
    font-size: 8px;
    color: #94a3b8;
}

.verifikator-category {
    display: inline-flex;
    padding: 4px 7px;
    border-radius: 5px;
    background: #eff6ff;
    color: #2563eb;
    font-size: 8px;
    font-weight: 600;
}


/* =========================================================
   STATUS
========================================================= */

.verifikator-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 8px;
    font-weight: 600;
}

.verifikator-status.pending {
    background: #fff4cc;
    color: #b45309;
}

.verifikator-status.approved {
    background: #dcfce7;
    color: #15803d;
}

.verifikator-status.rejected {
    background: #fee2e2;
    color: #dc2626;
}


/* =========================================================
   NOTIFICATION
========================================================= */

.verifikator-notification {
    display: flex;
    gap: 10px;
    padding: 15px;
    border-bottom: 1px solid #f1f5f9;
}

.verifikator-notification:last-child {
    border-bottom: none;
}

.verifikator-notification-icon {
    width: 30px;
    height: 30px;
    min-width: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.verifikator-notification-icon.orange {
    background: #fff4cc;
    color: #f59e0b;
}

.verifikator-notification-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.verifikator-notification-icon.red {
    background: #fee2e2;
    color: #ef4444;
}

.verifikator-notification-title {
    font-size: 10px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 4px;
}

.verifikator-notification-text {
    font-size: 8px;
    color: #64748b;
    line-height: 1.5;
}


/* =========================================================
   SUMMARY
========================================================= */

.verifikator-summary {
    width: 100%;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
    margin-bottom: 20px;
    overflow: hidden;
}

.verifikator-summary-header {
    min-height: 58px;
    padding: 0 16px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
}

.verifikator-summary-title {
    margin: 0;
    font-size: 13px;
    font-weight: 700;
    color: #1f2937;
}

.verifikator-summary-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
}

.verifikator-summary-item {
    padding: 18px;
    border-right: 1px solid #f1f5f9;
}

.verifikator-summary-item:last-child {
    border-right: none;
}

.verifikator-summary-label {
    display: block;
    font-size: 10px;
    color: #64748b;
    margin-bottom: 6px;
}

.verifikator-summary-value {
    display: block;
    font-size: 20px;
    font-weight: 700;
    color: #075985;
}


/* =========================================================
   ACTIVITY
========================================================= */

.verifikator-activity {
    width: 100%;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, .04);

    /*
    |---------------------------------------------------------
    | JARAK DARI RINGKASAN DATA ASET
    |---------------------------------------------------------
    */

    margin-top: 20px;
    margin-bottom: 20px;

    overflow: hidden;
}

.verifikator-activity-header {
    min-height: 58px;
    padding: 0 16px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
    box-sizing: border-box;
}

.verifikator-activity-title {
    margin: 0;
    font-size: 13px;
    font-weight: 700;
    color: #1f2937;
}

.verifikator-activity-list {
    padding: 0 16px;
}

.verifikator-activity-item {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 14px 0;
    border-bottom: 1px solid #f1f5f9;
}

.verifikator-activity-item:last-child {
    border-bottom: none;
}

.verifikator-activity-icon {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 10px;
    background: #e0f2fe;
    color: #075985;
    display: flex;
    align-items: center;
    justify-content: center;
}

.verifikator-activity-content {
    min-width: 0;
    flex: 1;
}

.verifikator-activity-text {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #374151;
}

.verifikator-activity-meta {
    display: flex;
    align-items: center;
    gap: 7px;
    flex-wrap: wrap;
    margin-top: 5px;
}

.verifikator-activity-operator {
    font-size: 9px;
    color: #64748b;
}

.verifikator-activity-date {
    font-size: 9px;
    color: #64748b;
}

.verifikator-activity-date::before {
    content: "•";
    margin-right: 7px;
}

.verifikator-empty {
    padding: 35px 20px;
    text-align: center;
    color: #94a3b8;
    font-size: 10px;
}


/* =========================================================
   BUTTON
========================================================= */

.verifikator-see-all {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 13px;
    border-radius: 6px;
    background: #2563eb;
    color: #ffffff;
    text-decoration: none;
    font-size: 9px;
    font-weight: 600;
}

.verifikator-see-all:hover {
    background: #1d4ed8;
    color: #ffffff;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 950px) {

    .verifikator-main-grid {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 700px) {

    .verifikator-top {
        flex-direction: column;
    }

    .verifikator-year-filter {
        width: 100%;
    }

    .verifikator-year-filter select {
        width: 100%;
    }

    .verifikator-stats {
        grid-template-columns: 1fr;
    }

    .verifikator-summary-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .verifikator-summary-item:nth-child(2) {
        border-right: none;
    }

}

@media (max-width: 450px) {

    .verifikator-summary-grid {
        grid-template-columns: 1fr;
    }

    .verifikator-summary-item {
        border-right: none;
        border-bottom: 1px solid #f1f5f9;
    }

    .verifikator-summary-item:last-child {
        border-bottom: none;
    }

}

</style>

<div class="verifikator-dashboard">

{{-- =====================================================
     ALERT
====================================================== --}}

@if(session('success'))

    <div class="verifikator-alert success">

        <i class="bi bi-check-circle"></i>

        {{ session('success') }}

    </div>

@endif


@if(session('error'))

    <div class="verifikator-alert error">

        <i class="bi bi-exclamation-circle"></i>

        {{ session('error') }}

    </div>

@endif


{{-- =====================================================
     WELCOME + FILTER TAHUN
====================================================== --}}

<div class="verifikator-top">

    <div class="verifikator-welcome">

        <h2>
            Selamat datang,
            {{ auth()->user()->name ?? 'Verifikator' }}
            👋
        </h2>

        <p>
            Kelola dan verifikasi pengajuan perubahan data aset.
        </p>

    </div>


    <form
        method="GET"
        action="{{ route('dashboard') }}"
        class="verifikator-year-filter"
    >

        <select
            name="tahun"
            onchange="this.form.submit()"
        >

            <option value="all">
                Semua Tahun
            </option>

            @foreach($tahunList as $item)

                <option
                    value="{{ $item }}"
                    {{ (string) $tahun === (string) $item ? 'selected' : '' }}
                >
                    {{ $item }}
                </option>

            @endforeach

        </select>

    </form>

</div>


{{-- =====================================================
     STATISTIK VERIFIKASI
====================================================== --}}

<div class="verifikator-stats">


    {{-- MENUNGGU --}}

    <div class="verifikator-stat">

        <div class="verifikator-stat-icon orange">

            <i class="bi bi-clock"></i>

        </div>

        <div>

            <span class="verifikator-stat-label">
                Menunggu Verifikasi
            </span>

            <span class="verifikator-stat-value">
                {{ number_format($totalMenunggu) }}
            </span>

        </div>

    </div>


    {{-- DISETUJUI --}}

    <div class="verifikator-stat">

        <div class="verifikator-stat-icon green">

            <i class="bi bi-check-circle"></i>

        </div>

        <div>

            <span class="verifikator-stat-label">
                Disetujui
            </span>

            <span class="verifikator-stat-value">
                {{ number_format($totalDisetujui) }}
            </span>

        </div>

    </div>


    {{-- DITOLAK --}}

    <div class="verifikator-stat">

        <div class="verifikator-stat-icon red">

            <i class="bi bi-x-circle"></i>

        </div>

        <div>

            <span class="verifikator-stat-label">
                Ditolak
            </span>

            <span class="verifikator-stat-value">
                {{ number_format($totalDitolak) }}
            </span>

        </div>

    </div>

</div>


{{-- =====================================================
     PENGAJUAN TERBARU + NOTIFIKASI
====================================================== --}}

<div class="verifikator-main-grid">


    {{-- =================================================
         PENGAJUAN TERBARU
    ================================================== --}}

    <div class="verifikator-card">

        <div class="verifikator-card-header">

            <h3 class="verifikator-card-title">
                Pengajuan Terbaru
            </h3>

            <a
                href="{{ route('verifikasi.index') }}"
                class="verifikator-see-all"
            >
                Lihat semua
            </a>

        </div>


        <div class="verifikator-table-wrapper">

            @if($pengajuanTerbaru->count())

                <table class="verifikator-table">

                    <thead>

                        <tr>

                            <th>DATA</th>

                            <th>KATEGORI</th>

                            <th>JENIS</th>

                            <th>DIAJUKAN OLEH</th>

                            <th>STATUS</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($pengajuanTerbaru as $item)

                            @php

                                $data =
                                    is_array($item->data ?? null)
                                        ? $item->data
                                        : [];

                                $namaData =
                                    $data['jenis']
                                    ?? $data['nama']
                                    ?? $data['nama_data']
                                    ?? $data['nama_infrastruktur']
                                    ?? $data['kode']
                                    ?? ucfirst($item->module ?? 'Data');

                                $kodeData =
                                    $data['kode']
                                    ?? null;

                            @endphp


                            <tr>

                                <td>

                                    <span class="verifikator-data-name">

                                        {{ $namaData }}

                                    </span>

                                    @if($kodeData)

                                        <span class="verifikator-data-code">

                                            {{ $kodeData }}

                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <span class="verifikator-category">

                                        @if(
                                            $item->module === 'data-center' ||
                                            $item->module === 'data_center'
                                        )

                                            Data Center

                                        @elseif($item->module === 'jaringan')

                                            Jaringan

                                        @elseif($item->module === 'splp')

                                            SPLP

                                        @else

                                            {{ ucfirst($item->module ?? 'Data') }}

                                        @endif

                                    </span>

                                </td>


                                <td>

                                    @if($item->action === 'create')

                                        Tambah

                                    @elseif($item->action === 'update')

                                        Perbarui

                                    @elseif($item->action === 'delete')

                                        Hapus

                                    @else

                                        {{ ucfirst($item->action ?? '-') }}

                                    @endif

                                </td>


                                <td>

                                    {{ $item->submitter->name ?? '-' }}

                                </td>


                                <td>

                                    @if($item->status === 'menunggu')

                                        <span class="verifikator-status pending">
                                            Menunggu
                                        </span>

                                    @elseif($item->status === 'disetujui')

                                        <span class="verifikator-status approved">
                                            Disetujui
                                        </span>

                                    @elseif($item->status === 'ditolak')

                                        <span class="verifikator-status rejected">
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="verifikator-status pending">
                                            {{ ucfirst($item->status ?? '-') }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="verifikator-empty">

                    <i class="bi bi-inbox"></i>

                    <br><br>

                    Belum ada pengajuan.

                </div>

            @endif

        </div>

    </div>


    {{-- =================================================
         NOTIFIKASI
    ================================================== --}}

    <div class="verifikator-card">

        <div class="verifikator-card-header">

            <h3 class="verifikator-card-title">
                Notifikasi
            </h3>

        </div>


        <div>

            {{-- MENUNGGU --}}

            <div class="verifikator-notification">

                <div class="verifikator-notification-icon orange">

                    <i class="bi bi-clock"></i>

                </div>

                <div>

                    <div class="verifikator-notification-title">
                        Pengajuan menunggu verifikasi
                    </div>

                    <div class="verifikator-notification-text">

                        Terdapat
                        <strong>
                            {{ number_format($totalMenunggu) }}
                        </strong>
                        pengajuan yang perlu diperiksa.

                    </div>

                </div>

            </div>


            {{-- DISETUJUI --}}

            <div class="verifikator-notification">

                <div class="verifikator-notification-icon green">

                    <i class="bi bi-check-circle"></i>

                </div>

                <div>

                    <div class="verifikator-notification-title">
                        Pengajuan disetujui
                    </div>

                    <div class="verifikator-notification-text">

                        Total
                        <strong>
                            {{ number_format($totalDisetujui) }}
                        </strong>
                        pengajuan telah disetujui.

                    </div>

                </div>

            </div>


            {{-- DITOLAK --}}

            <div class="verifikator-notification">

                <div class="verifikator-notification-icon red">

                    <i class="bi bi-x-circle"></i>

                </div>

                <div>

                    <div class="verifikator-notification-title">
                        Pengajuan ditolak
                    </div>

                    <div class="verifikator-notification-text">

                        Total
                        <strong>
                            {{ number_format($totalDitolak) }}
                        </strong>
                        pengajuan ditolak.

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
     RINGKASAN DATA ASET
====================================================== --}}

<div class="verifikator-summary">

    <div class="verifikator-summary-header">

        <h3 class="verifikator-summary-title">
            Ringkasan Data Aset
        </h3>

    </div>


    <div class="verifikator-summary-grid">


        {{-- TOTAL --}}

        <div class="verifikator-summary-item">

            <span class="verifikator-summary-label">
                Total Aset
            </span>

            <span class="verifikator-summary-value">
                {{ number_format($totalAset ?? 0) }}
            </span>

        </div>


        {{-- HARDWARE --}}

        <div class="verifikator-summary-item">

            <span class="verifikator-summary-label">
                Hardware
            </span>

            <span class="verifikator-summary-value">
                {{ number_format($hardwareCount ?? 0) }}
            </span>

        </div>


        {{-- SOFTWARE --}}

        <div class="verifikator-summary-item">

            <span class="verifikator-summary-label">
                Software
            </span>

            <span class="verifikator-summary-value">
                {{ number_format($softwareCount ?? 0) }}
            </span>

        </div>


        {{-- INFRASTRUKTUR --}}

        <div class="verifikator-summary-item">

            <span class="verifikator-summary-label">
                Infrastruktur
            </span>

            <span class="verifikator-summary-value">
                {{ number_format($infrastrukturCount ?? 0) }}
            </span>

        </div>

    </div>

</div>


{{-- =====================================================
     AKTIVITAS TERBARU
====================================================== --}}

<div class="verifikator-activity">

    <div class="verifikator-activity-header">

        <h3 class="verifikator-activity-title">
            Aktivitas Terbaru
        </h3>

    </div>


    <div class="verifikator-activity-list">

        @forelse($activities as $activity)

            @php

                /*
                |--------------------------------------------------------------------------
                | TANGGAL AKTIVITAS
                |--------------------------------------------------------------------------
                | HANYA TANGGAL.
                | TIDAK MENAMPILKAN JAM.
                */

                $activityDate =
                    $activity['date']
                    ?? $activity['tanggal']
                    ?? null;


                /*
                |--------------------------------------------------------------------------
                | FALLBACK DARI created_at
                |--------------------------------------------------------------------------
                */

                if (
                    !$activityDate &&
                    !empty($activity['created_at'])
                ) {

                    try {

                        $activityDate =
                            \Carbon\Carbon::parse(
                                $activity['created_at']
                            )->translatedFormat('d F Y');

                    } catch (\Throwable $e) {

                        $activityDate = null;

                    }

                }

            @endphp


            <div class="verifikator-activity-item">


                {{-- ICON --}}

                <div class="verifikator-activity-icon">

                    <i class="bi {{ $activity['icon'] ?? 'bi-activity' }}"></i>

                </div>


                {{-- CONTENT --}}

                <div class="verifikator-activity-content">

                    <span class="verifikator-activity-text">

                        {{ $activity['text'] ?? 'Aktivitas data' }}

                    </span>


                    <div class="verifikator-activity-meta">


                        {{-- OPERATOR --}}

                        <span class="verifikator-activity-operator">

                            {{ $activity['operator'] ?? 'Operator' }}

                        </span>


                        {{-- TANGGAL SAJA --}}

                        @if($activityDate)

                            <span class="verifikator-activity-date">

                                {{ $activityDate }}

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="verifikator-empty">

                <i class="bi bi-clock-history"></i>

                <br><br>

                Belum ada aktivitas terbaru.

            </div>

        @endforelse

    </div>

</div>


</div>

@endsection
