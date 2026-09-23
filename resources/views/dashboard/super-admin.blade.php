@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('page-title', 'Dashboard Super Admin')

@section('content')

@php
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

$activities = $activities ?? [];


/*
|--------------------------------------------------------------------------
| FORMAT WAKTU AKTIVITAS - KHUSUS SUPER ADMIN
|--------------------------------------------------------------------------
|
| Hari yang sama:
| - Baru saja
| - 1 menit lalu
| - 15 menit lalu
| - 2 jam lalu
|
| Hari berbeda:
| - 22 September 2026, 14:35
|
*/

$now = \Carbon\Carbon::now('Asia/Jakarta');

$activities = collect($activities)->map(function ($activity) use ($now) {

    /*
     * Ambil tanggal aktivitas.
     */
    $activityDate = null;

    if (
        isset($activity['date']) &&
        $activity['date']
    ) {
        try {

            if (
                $activity['date'] instanceof \Carbon\Carbon
            ) {
                $activityDate = $activity['date']
                    ->copy()
                    ->setTimezone('Asia/Jakarta');

            } else {
                $activityDate = \Carbon\Carbon::parse(
                    $activity['date'],
                    'Asia/Jakarta'
                );
            }

        } catch (\Throwable $e) {
            $activityDate = null;
        }
    }


    /*
     * Kalau controller tidak mengirim date,
     * gunakan time yang sudah ada.
     */
    if (!$activityDate) {
        return $activity;
    }


    /*
     * Kalau tanggal aktivitas ternyata berada
     * di masa depan, jangan tampilkan waktu aneh.
     */
    if ($activityDate->gt($now)) {
        $activityDate = $now->copy();
    }


    /*
     * =========================================================
     * HARI YANG SAMA
     * =========================================================
     */

    if ($activityDate->isSameDay($now)) {

        $diffInSeconds = abs(
            $activityDate->diffInSeconds($now)
        );

        $diffInMinutes = intdiv(
            $diffInSeconds,
            60
        );

        $diffInHours = intdiv(
            $diffInSeconds,
            3600
        );


        /*
         * Kurang dari 1 menit
         */
        if ($diffInSeconds < 60) {

            $activity['time'] = 'Baru saja';

        }


        /*
         * Kurang dari 1 jam
         */
        elseif ($diffInMinutes < 60) {

            $activity['time'] =
                $diffInMinutes .
                ' menit lalu';

        }


        /*
         * Masih di hari yang sama
         */
        else {

            $activity['time'] =
                $diffInHours .
                ' jam lalu';
        }

    }


    /*
     * =========================================================
     * SUDAH BEDA HARI
     * =========================================================
     */

    else {

        $activity['time'] = $activityDate
            ->locale('id')
            ->translatedFormat(
                'd F Y, H:i'
            );
    }


    /*
     * Simpan kembali tanggal supaya tetap
     * tersedia jika diperlukan.
     */
    $activity['date'] = $activityDate;

    return $activity;

})->values();

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

.year-filter select:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, .10);
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
   AKTIVITAS HEADER
========================================================= */

.activity-header-action {
    display: flex;
    align-items: center;
}

.view-all-activity {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 600;
    color: #079bd8;
    text-decoration: none;
    transition: all .2s ease;
}

.view-all-activity:hover {
    color: #0577a5;
    text-decoration: none;
}

.view-all-activity i {
    font-size: 13px;
    transition: transform .2s ease;
}

.view-all-activity:hover i {
    transform: translateX(3px);
}


/* =========================================================
   ACTIVITY GRID
========================================================= */

.activity-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    column-gap: 30px;
}


/* =========================================================
   ACTIVITY ITEM
========================================================= */

.activity-item {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 15px 0;
    border-bottom: 1px solid #f0f1f3;
    min-width: 0;
}


/*
|--------------------------------------------------------------------------
| KOLOM KIRI
|--------------------------------------------------------------------------
*/

.activity-item:nth-child(odd) {
    padding-right: 20px;
}


/*
|--------------------------------------------------------------------------
| KOLOM KANAN
|--------------------------------------------------------------------------
*/

.activity-item:nth-child(even) {
    padding-left: 20px;
    border-left: 1px solid #f0f1f3;
}


/*
|--------------------------------------------------------------------------
| ITEM PERTAMA SETIAP BARIS
|--------------------------------------------------------------------------
*/

.activity-item:nth-child(-n+2) {
    padding-top: 0;
}


/*
|--------------------------------------------------------------------------
| ITEM TERAKHIR
|--------------------------------------------------------------------------
*/

.activity-item:last-child {
    border-bottom: none;
}


/* =========================================================
   ACTIVITY ICON
========================================================= */

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

.activity-icon i {
    font-size: 16px;
}


/* =========================================================
   ACTIVITY CONTENT
========================================================= */

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-text {
    display: block;
    font-size: 13px;
    color: #374151;
    line-height: 1.5;
    word-break: break-word;
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

}


@media (max-width: 700px) {

    .dashboard-top {
        flex-direction: column;
        align-items: flex-start;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .year-filter {
        width: 100%;
    }

    .year-filter select {
        flex: 1;
    }

    .card-header {
        gap: 10px;
    }

    .view-all-activity {
        white-space: nowrap;
    }


    /*
    |--------------------------------------------------------------------------
    | AKTIVITAS KEMBALI 1 KOLOM DI HP
    |--------------------------------------------------------------------------
    */

    .activity-grid {
        grid-template-columns: 1fr;
    }

    .activity-item:nth-child(odd),
    .activity-item:nth-child(even) {
        padding-left: 0;
        padding-right: 0;
        border-left: none;
    }

    .activity-item:nth-child(n+2) {
        padding-top: 15px;
    }

    .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
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


        {{-- =================================================
             FILTER TAHUN
        ================================================== --}}

        <form method="GET"
              action="{{ route('dashboard') }}"
              class="year-filter">

            <label for="tahun">
                Filter Tahun
            </label>

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


        {{-- TOTAL USER --}}

        <div class="stat-card">

            <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>

            <div>

                <span class="stat-label">
                    Total User
                </span>

                <span class="stat-value">
                    {{ number_format($totalUser) }}
                </span>

            </div>

        </div>


        {{-- OPERATOR --}}

        <div class="stat-card">

            <div class="stat-icon">
                <i class="bi bi-person-workspace"></i>
            </div>

            <div>

                <span class="stat-label">
                    Operator
                </span>

                <span class="stat-value operator-color">
                    {{ number_format($totalOperator) }}
                </span>

            </div>

        </div>


        {{-- VERIFIKATOR --}}

        <div class="stat-card">

            <div class="stat-icon">
                <i class="bi bi-patch-check-fill"></i>
            </div>

            <div>

                <span class="stat-label">
                    Verifikator
                </span>

                <span class="stat-value verifikator-color">
                    {{ number_format($totalVerifikator) }}
                </span>

            </div>

        </div>


        {{-- PIMPINAN --}}

        <div class="stat-card">

            <div class="stat-icon">
                <i class="bi bi-person-badge-fill"></i>
            </div>

            <div>

                <span class="stat-label">
                    Pimpinan
                </span>

                <span class="stat-value pimpinan-color">
                    {{ number_format($totalPimpinan) }}
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


            {{-- LIHAT SEMUA --}}

            <div class="activity-header-action">

                <a href="{{ route('log-aktivitas.index') }}"
                   class="view-all-activity">

                    Lihat Semua

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>

        </div>


        {{-- =================================================
             DAFTAR AKTIVITAS 2 KOLOM
        ================================================== --}}

        @if($activities->count() > 0)

            <div class="activity-grid">

                @foreach ($activities as $activity)

                    <div class="activity-item">

                        <div class="activity-icon">

                            <i class="bi {{ $activity['icon'] ?? 'bi-clock-history' }}"></i>

                        </div>


                        <div class="activity-content">

                            <span class="activity-text">
                                {{ $activity['text'] ?? '-' }}
                            </span>

                            <span class="activity-time">
                                {{ $activity['time'] ?? '-' }}
                            </span>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty-state">
                Belum ada aktivitas terbaru.
            </div>

        @endif

    </div>

</div>

@endsection