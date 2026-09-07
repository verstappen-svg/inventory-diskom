@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('page-title', 'Dashboard')

@section('content')

<style>

    .dashboard {
        width: 100%;
    }

    .welcome-section {
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
       STAT CARDS (4 kartu: Total User, Operator, Verifikator, Pimpinan)
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
        box-shadow: 0 3px 10px rgba(0,0,0,0.06);
        border: 1px solid #eef0f4;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
        display: block;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .stat-value.operator { color: #d97706; }
    .stat-value.verifikator { color: #16a34a; }
    .stat-value.pimpinan { color: #dc2626; }

    /* =====================================================
       AKTIVITAS TERBARU
    ====================================================== */

    .dashboard-card {
        background: white;
        border-radius: 15px;
        padding: 22px;
        border: 1px solid #eef0f4;
        box-shadow: 0 3px 10px rgba(0,0,0,0.06);
        margin-bottom: 25px;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .card-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    .activity-table {
        width: 100%;
        border-collapse: collapse;
    }

    .activity-table thead th {
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f1f3;
    }

    .activity-table tbody td {
        padding: 13px 0;
        border-bottom: 1px solid #f5f6f8;
        font-size: 13px;
        color: #374151;
        vertical-align: middle;
    }

    .activity-table tbody tr:last-child td {
        border-bottom: none;
    }

    .activity-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .activity-name i {
        font-size: 15px;
        width: 22px;
        height: 22px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .icon-add    { background: #dbeafe; color: #2563eb; }
    .icon-role   { background: #fef3c7; color: #d97706; }
    .icon-login  { background: #dcfce7; color: #16a34a; }
    .icon-reject { background: #fee2e2; color: #dc2626; }

    .activity-by {
        color: #6b7280;
    }

    .activity-time {
        color: #9ca3af;
    }

    .card-footer-link {
        text-align: center;
        margin-top: 16px;
    }

    .card-footer-link a {
        font-size: 12px;
        color: #075985;
        text-decoration: none;
        font-weight: 600;
    }

    .card-footer-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .activity-table thead {
            display: none;
        }
        .activity-table, .activity-table tbody, .activity-table tr, .activity-table td {
            display: block;
            width: 100%;
        }
    }

</style>

<div class="dashboard">

    {{-- WELCOME --}}
    <div class="welcome-section">
        <h2 class="welcome-title">Selamat datang Super Admin!</h2>
        <p class="welcome-text">Kelola pengguna dan pantau seluruh aktivitas sistem Inventory IT Assets.</p>
    </div>

    {{-- STATISTIK USER --}}
    <div class="stats-grid">

        <div class="stat-card">
            <span class="stat-label">Total User</span>
            <span class="stat-value">{{ $totalUser ?? 0 }}</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Operator</span>
            <span class="stat-value operator">{{ $totalOperator ?? 0 }}</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Verifikator</span>
            <span class="stat-value verifikator">{{ $totalVerifikator ?? 0 }}</span>
        </div>

        <div class="stat-card">
            <span class="stat-label">Pimpinan</span>
            <span class="stat-value pimpinan">{{ $totalPimpinan ?? 0 }}</span>
        </div>

    </div>

    {{-- AKTIVITAS TERBARU --}}
    <div class="dashboard-card">

        <div class="card-header">
            <h3 class="card-title">Aktivitas Terbaru</h3>
        </div>

        <table class="activity-table">
            <thead>
                <tr>
                    <th>Aktivitas</th>
                    <th>Oleh</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse (($activities ?? []) as $log)
                    <tr>
                        <td>
                            <div class="activity-name">
                                <i class="bi bi-{{ $log['icon'] }} icon-{{ $log['type'] }}"></i>
                                {{ $log['text'] }}
                            </div>
                        </td>
                        <td class="activity-by">{{ $log['by'] }}</td>
                        <td class="activity-time">{{ $log['time'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center; color:#9ca3af; padding: 20px 0;">
                            Belum ada aktivitas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="card-footer-link">
            <a href="{{ route('log-aktivitas.index') }}">Lihat Semua Riwayat →</a>
        </div>

    </div>

</div>

@endsection