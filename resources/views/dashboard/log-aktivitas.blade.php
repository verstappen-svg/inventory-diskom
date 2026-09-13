@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')

@section('content')

<style>
    .log-table-card {
        background: white;
        border-radius: 15px;
        border: 1px solid #eef0f4;
        box-shadow: 0 3px 10px rgba(0,0,0,0.06);
        padding: 22px;
    }

    table.log-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.log-table thead th {
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f1f3;
    }

    table.log-table tbody td {
        padding: 13px 8px;
        border-bottom: 1px solid #f5f6f8;
        font-size: 13px;
        color: #374151;
        vertical-align: middle;
    }

    .log-role-badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .role-super_admin { background: #ede9fe; color: #6d28d9; }
    .role-operator    { background: #fef3c7; color: #d97706; }
    .role-verifikator { background: #dcfce7; color: #16a34a; }
    .role-pimpinan    { background: #fee2e2; color: #dc2626; }

    .log-time {
        color: #9ca3af;
        white-space: nowrap;
    }

    .pagination-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 16px;
    }

    .pagination-info {
        font-size: 12px;
        color: #9ca3af;
    }
</style>

<div class="log-table-card">

    <table class="log-table">
        <thead>
            <tr>
                <th>Aktivitas</th>
                <th>Oleh</th>
                <th>Role</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->user_name ?? '-' }}</td>
                    <td>
                        <span class="log-role-badge role-{{ $log->role }}">
                            {{ str_replace('_', ' ', $log->role) }}
                        </span>
                    </td>
                    <td class="log-time">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#9ca3af; padding: 24px 0;">
                        Belum ada aktivitas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-bar">
        <span class="pagination-info">
            Showing {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} entries
        </span>

        {{ $logs->links() }}
    </div>

</div>

@endsection