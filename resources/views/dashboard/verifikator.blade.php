@extends('layouts.app')

@section('title', 'Dashboard Verifikator')

@section('page-title', 'DASHBOARD')

@section('content')

@php

    use App\Models\VerificationRequest;

    /*
    |--------------------------------------------------------------------------
    | DATA DASHBOARD
    |--------------------------------------------------------------------------
    */

    $totalMenunggu = VerificationRequest::where(
        'status',
        'menunggu'
    )->count();

    $totalDisetujui = VerificationRequest::where(
        'status',
        'disetujui'
    )->count();

    $totalDitolak = VerificationRequest::where(
        'status',
        'ditolak'
    )->count();


    /*
    |--------------------------------------------------------------------------
    | PENGAJUAN TERBARU
    |--------------------------------------------------------------------------
    */

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
   WELCOME
========================================================= */

.verifikator-welcome {
    margin-bottom: 22px;
}

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
   STATISTIC
========================================================= */

.verifikator-stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.verifikator-stat {
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
    display: grid;
    grid-template-columns: minmax(0, 1.7fr) minmax(260px, .8fr);
    gap: 18px;
    margin-bottom: 20px;
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


/* =========================================================
   DATA
========================================================= */

.verifikator-data-name {
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
   EMPTY
========================================================= */

.verifikator-empty {
    padding: 35px 20px;
    text-align: center;
    color: #94a3b8;
    font-size: 10px;
}


/* =========================================================
   BUTTON KE VERIFIKASI
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

    .verifikator-stats {
        grid-template-columns: 1fr;
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
         WELCOME
    ====================================================== --}}

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


    {{-- =====================================================
         STATISTIK
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
                    {{ $totalMenunggu }}
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
                    {{ $totalDisetujui }}
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
                    {{ $totalDitolak }}
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         MAIN
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

                                <th>
                                    DATA
                                </th>

                                <th>
                                    KATEGORI
                                </th>

                                <th>
                                    JENIS
                                </th>

                                <th>
                                    DIAJUKAN OLEH
                                </th>

                                <th>
                                    STATUS
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($pengajuanTerbaru as $item)

                                @php

                                    $data = $item->data ?? [];

                                    $namaData =
                                        $data['jenis']
                                        ?? $data['nama']
                                        ?? $data['nama_data']
                                        ?? $data['kode']
                                        ?? ucfirst($item->module);

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

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="verifikator-empty">

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
                            {{ $totalMenunggu }}
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
                            {{ $totalDisetujui }}
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
                            {{ $totalDitolak }}
                            pengajuan ditolak.

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>

@endsection