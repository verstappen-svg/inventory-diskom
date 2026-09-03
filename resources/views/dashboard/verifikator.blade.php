@extends('layouts.app')

@section('title', 'Dashboard Verifikator')

@section('page-title', 'Dashboard Verifikator')

@section('content')

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

.verification-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.verification-card {
    background: white;
    border-radius: 15px;
    padding: 22px;
    border: 1px solid #eef0f4;
    box-shadow: 0 3px 10px rgba(0,0,0,.06);
}

.verification-icon {
    width: 48px;
    height: 48px;
    border-radius: 13px;
    background: #e0f2fe;
    color: #075985;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}

.verification-icon i {
    font-size: 22px;
}

.verification-label {
    display: block;
    font-size: 13px;
    color: #6b7280;
}

.verification-value {
    display: block;
    font-size: 28px;
    font-weight: 700;
    margin-top: 6px;
}

.dashboard-card {
    background: white;
    border-radius: 15px;
    padding: 22px;
    border: 1px solid #eef0f4;
    box-shadow: 0 3px 10px rgba(0,0,0,.06);
    margin-bottom: 25px;
}

.card-title {
    margin: 0 0 20px;
    font-size: 16px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #eef0f4;
}

.summary-item:last-child {
    border-bottom: none;
}

.activity-item {
    display: flex;
    gap: 13px;
    padding: 15px 0;
    border-bottom: 1px solid #eef0f4;
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
    align-items: center;
    justify-content: center;
}

.activity-text {
    display: block;
    font-size: 13px;
}

.activity-time {
    display: block;
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
}

@media(max-width:900px) {

    .verification-grid {
        grid-template-columns: 1fr;
    }

}

@media(max-width:600px) {

    .dashboard-top {
        flex-direction: column;
        align-items: flex-start;
    }

}

</style>


<div class="dashboard">

    <div class="dashboard-top">

        <div>

            <h2 class="welcome-title">
                Dashboard Verifikator
            </h2>

            <p class="welcome-text">
                Pantau dan kelola proses verifikasi data aset.
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


    <div class="verification-grid">

        <div class="verification-card">

            <div class="verification-icon">

                <i class="bi bi-hourglass-split"></i>

            </div>

            <span class="verification-label">
                Menunggu Verifikasi
            </span>

            <span class="verification-value">
                {{ $verificationData['Menunggu'] ?? 0 }}
            </span>

        </div>


        <div class="verification-card">

            <div class="verification-icon">

                <i class="bi bi-check-circle"></i>

            </div>

            <span class="verification-label">
                Disetujui
            </span>

            <span class="verification-value">
                {{ $verificationData['Disetujui'] ?? 0 }}
            </span>

        </div>


        <div class="verification-card">

            <div class="verification-icon">

                <i class="bi bi-x-circle"></i>

            </div>

            <span class="verification-label">
                Ditolak
            </span>

            <span class="verification-value">
                {{ $verificationData['Ditolak'] ?? 0 }}
            </span>

        </div>

    </div>


    <div class="dashboard-card">

        <h3 class="card-title">
            Ringkasan Data Aset
        </h3>

        <div class="summary-item">

            <span>Total Aset</span>

            <strong>
                {{ number_format($totalAset) }}
            </strong>

        </div>

        <div class="summary-item">

            <span>Hardware</span>

            <strong>
                {{ number_format($hardwareCount) }}
            </strong>

        </div>

        <div class="summary-item">

            <span>Software</span>

            <strong>
                {{ number_format($softwareCount) }}
            </strong>

        </div>

        <div class="summary-item">

            <span>Infrastruktur</span>

            <strong>
                {{ number_format($infrastrukturCount) }}
            </strong>

        </div>

    </div>


    <div class="dashboard-card">

        <h3 class="card-title">
            Aktivitas Terbaru
        </h3>

        @forelse($activities as $activity)

            <div class="activity-item">

                <div class="activity-icon">

                    <i class="bi {{ $activity['icon'] }}"></i>

                </div>

                <div>

                    <span class="activity-text">
                        {{ $activity['text'] }}
                    </span>

                    <span class="activity-time">
                        {{ $activity['time'] }}
                    </span>

                </div>

            </div>

        @empty

            <p class="welcome-text">
                Belum ada aktivitas.
            </p>

        @endforelse

    </div>

</div>

@endsection