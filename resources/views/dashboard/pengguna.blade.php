@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')

<style>

    .breadcrumb {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .breadcrumb .sep {
        color: #9ca3af;
        margin: 0 6px;
        font-weight: 400;
    }

    .breadcrumb .current {
        color: #6b7280;
        font-weight: 700;
    }

    .welcome-text {
        font-size: 13px;
        color: #6b7280;
        margin: 0 0 22px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 22px;
    }

    .stat-card {
        border-radius: 15px;
        padding: 18px 20px;
    }

    .stat-card.total { background: #eaf6ff; }
    .stat-card.aktif { background: #eafbf0; }
    .stat-card.nonaktif { background: #fdeeee; }

    .stat-label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .stat-card.total .stat-label { color: #0284c7; }
    .stat-card.aktif .stat-label { color: #16a34a; }
    .stat-card.nonaktif .stat-label { color: #dc2626; }

    .stat-value {
        font-size: 26px;
        font-weight: 700;
        color: #1f2937;
    }

    .table-card {
        background: white;
        border-radius: 15px;
        border: 1px solid #eef0f4;
        box-shadow: 0 3px 10px rgba(0,0,0,0.06);
        padding: 22px;
    }

    .toolbar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .search-box {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f5f6fa;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 14px;
    }

    .search-box i { color: #9ca3af; }

    .search-box input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 13px;
        width: 100%;
    }

    .btn-outline {
        background: white;
        border: 1px solid #e5e7eb;
        color: #374151;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-primary {
        background: #071b88;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover { background: #05146b; }

    /* FILTER DROPDOWN */
    .filter-wrapper {
        position: relative;
    }

    .filter-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        padding: 16px;
        width: 220px;
        z-index: 50;
    }

    .filter-dropdown.show {
        display: block;
    }

    .filter-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        margin: 10px 0 6px;
    }

    .filter-label:first-child {
        margin-top: 0;
    }

    .filter-select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
    }

    .filter-apply {
        width: 100%;
        justify-content: center;
        margin-top: 14px;
    }

    table.users-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.users-table th {
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        color: #9ca3af;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0f1f3;
    }

    table.users-table td {
        padding: 14px 8px;
        border-bottom: 1px solid #f5f6f8;
        font-size: 13px;
        color: #374151;
        vertical-align: middle;
    }

    .status-pill {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .status-aktif { background: #dcfce7; color: #16a34a; }
    .status-nonaktif { background: #fee2e2; color: #dc2626; }

    .icon-btn {
        border: none;
        background: transparent;
        cursor: pointer;
        font-size: 16px;
        padding: 4px 6px;
    }

    .icon-hakakses { color: #6b7280; }
    .icon-activate { color: #16a34a; }
    .icon-deactivate { color: #dc2626; }
    .icon-delete { color: #dc2626; }

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

    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .alert-error { background: #fee2e2; color: #991b1b; }

    /* MODAL TAMBAH/EDIT */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 2000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.show { display: flex; }

    .modal-box {
        background: white;
        border-radius: 15px;
        padding: 26px;
        width: 100%;
        max-width: 420px;
    }

    .modal-box h3 {
        margin: 0 0 18px;
        font-size: 17px;
        color: #1f2937;
    }

    .form-group { margin-bottom: 14px; }

    .form-group label {
        display: block;
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
        box-sizing: border-box;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    /* MODAL HAK AKSES */
    .hakakses-box {
        background: white;
        border-radius: 16px;
        padding: 24px;
        width: 100%;
        max-width: 640px;
        max-height: 85vh;
        overflow-y: auto;
    }

    .hakakses-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 16px;
    }

    .hakakses-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .hakakses-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #eef0f4;
        flex-shrink: 0;
    }

    .hakakses-name {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
    }

    .hakakses-role {
        font-size: 12px;
        color: #9ca3af;
    }

    .hakakses-role-select {
        text-align: right;
    }

    .hakakses-role-select label {
        display: block;
        font-size: 10px;
        text-transform: uppercase;
        color: #9ca3af;
        margin-bottom: 4px;
    }

    .hakakses-role-select select {
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    .hakakses-table-wrapper {
        max-height: 360px;
        overflow-y: auto;
        border: 1px solid #eef0f4;
        border-radius: 10px;
    }

    table.hakakses-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.hakakses-table th {
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        color: #9ca3af;
        padding: 10px 14px;
        background: #f9fafb;
        position: sticky;
        top: 0;
    }

    table.hakakses-table td {
        padding: 10px 14px;
        border-top: 1px solid #f5f6f8;
        font-size: 13px;
        color: #374151;
    }

    table.hakakses-table td.menu-sub {
        padding-left: 26px;
        color: #6b7280;
    }

    table.hakakses-table td.center,
    table.hakakses-table th:not(:first-child) {
        text-align: center;
    }

    table.hakakses-table input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .extra-action-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #374151;
    }

    .dash { color: #d1d5db; }

    .hakakses-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    /* POPUP SUKSES */
    .success-popup-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 3000;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .success-popup-overlay.show {
        display: flex;
        opacity: 1;
    }

    .success-popup-box {
        background: white;
        border-radius: 18px;
        padding: 32px 28px;
        width: 100%;
        max-width: 260px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        transform: scale(0.7) translateY(10px);
        opacity: 0;
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.25s ease;
    }

    .success-popup-overlay.show .success-popup-box {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    .success-popup-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        border: 3px solid #16a34a;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin: 0 auto 16px;
        transform: scale(0);
        opacity: 0;
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s, opacity 0.2s ease 0.15s;
    }

    .success-popup-overlay.show .success-popup-icon {
        transform: scale(1);
        opacity: 1;
        animation: successPulse 0.5s ease 0.15s;
    }

    @keyframes successPulse {
        0% { box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(22, 163, 74, 0); }
        100% { box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
    }

    .success-popup-icon i {
        opacity: 0;
        transform: scale(0.5);
        transition: transform 0.3s ease 0.3s, opacity 0.3s ease 0.3s;
    }

    .success-popup-overlay.show .success-popup-icon i {
        opacity: 1;
        transform: scale(1);
    }

    .success-popup-text {
        font-size: 14px;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 20px;
        line-height: 1.4;
        opacity: 0;
        transform: translateY(6px);
        transition: transform 0.3s ease 0.2s, opacity 0.3s ease 0.2s;
    }

    .success-popup-overlay.show .success-popup-text {
        opacity: 1;
        transform: translateY(0);
    }

    .success-popup-ok {
        background: #071b88;
        color: white;
        border: none;
        padding: 9px 28px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        opacity: 0;
        transform: translateY(6px);
        transition: transform 0.3s ease 0.25s, opacity 0.3s ease 0.25s, background 0.2s ease;
    }

    .success-popup-overlay.show .success-popup-ok {
        opacity: 1;
        transform: translateY(0);
    }

    .success-popup-ok:hover {
        background: #05146b;
    }

</style>

<div class="breadcrumb">
    MANAJEMEN PENGGUNA <span class="sep">›</span> <span class="current">DAFTAR PENGGUNA</span>
</div>
<p class="welcome-text">Selamat datang Super Admin!</p>

@if (session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

{{-- STATISTIK --}}
<div class="stats-grid">

    <div class="stat-card total">
        <span class="stat-label">Total User</span>
        <span class="stat-value">{{ $totalUser }}</span>
    </div>

    <div class="stat-card aktif">
        <span class="stat-label">Pengguna Aktif</span>
        <span class="stat-value">{{ $totalAktif }}</span>
    </div>

    <div class="stat-card nonaktif">
        <span class="stat-label">Pengguna Non Aktif</span>
        <span class="stat-value">{{ $totalNonAktif }}</span>
    </div>

</div>

<div class="table-card">

    {{-- TOOLBAR --}}
    <form method="GET" action="{{ route('pengguna.index') }}" class="toolbar">

        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
        </div>

        <div class="filter-wrapper">

            <button type="button" class="btn-outline" onclick="toggleFilter()">
                <i class="bi bi-funnel"></i> Filter
            </button>

            <div class="filter-dropdown" id="filterDropdown">

                <label class="filter-label">Role</label>
                <select name="role" class="filter-select">
                    <option value="">Semua Role</option>
                    <option value="operator" {{ request('role') === 'operator' ? 'selected' : '' }}>Operator</option>
                    <option value="verifikator" {{ request('role') === 'verifikator' ? 'selected' : '' }}>Verifikator</option>
                    <option value="pimpinan" {{ request('role') === 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                    <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>

                <label class="filter-label">Status</label>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                </select>

                <button type="submit" class="btn-primary filter-apply">Terapkan</button>

            </div>

        </div>

        <button type="button" class="btn-primary" onclick="openAddModal()">
            <i class="bi bi-plus-circle"></i> Add
        </button>

    </form>

    {{-- TABLE --}}
    <table class="users-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Status</th>
                <th>Terakhir Login</th>
                <th>Hak Akses</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $user->role)) }}</td>
                    <td>
                        <span class="status-pill {{ $user->is_active ? 'status-aktif' : 'status-nonaktif' }}">
                            {{ $user->is_active ? 'Aktif' : 'Non Aktif' }}
                        </span>
                    </td>
                    <td>
                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '-' }}
                    </td>
                    <td>
                        <button type="button" class="icon-btn icon-hakakses" title="Hak Akses"
                            onclick='openHakAksesModal(@json($user))'>
                            <i class="bi bi-person-gear"></i>
                        </button>
                    </td>
                    <td>
                        @if ($user->is_active)
                            <form action="{{ route('pengguna.deactivate', $user->id) }}" method="POST" style="display:inline"
                                  onsubmit="return confirm('Nonaktifkan pengguna ini?')">
                                @csrf
                                <button type="submit" class="icon-btn icon-activate" title="Aktif — klik untuk nonaktifkan">
                                    <i class="bi bi-check-circle-fill"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('pengguna.activate', $user->id) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="icon-btn icon-deactivate" title="Non aktif — klik untuk aktifkan">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" style="display:inline"
                              onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn icon-delete" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:#9ca3af; padding: 24px 0;">
                        Belum ada pengguna.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-bar">
        <span class="pagination-info">
            Showing {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
        </span>

        {{ $users->links() }}
    </div>

</div>

{{-- MODAL TAMBAH/EDIT --}}
<div class="modal-overlay" id="userModal">
    <div class="modal-box">
        <h3 id="modalTitle">Tambah Pengguna</h3>

        <form id="userForm" method="POST" action="{{ route('pengguna.store') }}">
            @csrf
            <div id="methodField"></div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" id="field_name" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="field_username" required>
            </div>

            <div class="form-group">
                <label>Password <span id="passwordHint" style="font-weight:400;"></span></label>
                <input type="password" name="password" id="field_password">
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" id="field_role" required>
                    <option value="super_admin">Super Admin</option>
                    <option value="operator">Operator</option>
                    <option value="verifikator">Verifikator</option>
                    <option value="pimpinan">Pimpinan</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL HAK AKSES --}}
<div class="modal-overlay" id="hakAksesModal">
    <div class="hakakses-box">

        <div class="hakakses-header">

            <div class="hakakses-user">
                <img id="hakAksesAvatar" src="" alt="avatar" class="hakakses-avatar">
                <div>
                    <div class="hakakses-name" id="hakAksesName"></div>
                    <div class="hakakses-role" id="hakAksesCurrentRole"></div>
                </div>
            </div>

            <div class="hakakses-role-select">
                <label>Role Saat Ini</label>
                <select id="hakAksesRoleDropdown" onchange="loadPermissions(this.value)">
                    <option value="super_admin">Super Admin</option>
                    <option value="operator">Operator</option>
                    <option value="verifikator">Verifikator</option>
                    <option value="pimpinan">Pimpinan</option>
                </select>
            </div>

        </div>

        <div class="hakakses-table-wrapper">
            <table class="hakakses-table">
                <thead>
                    <tr>
                        <th>Menu/Fitur</th>
                        <th>Lihat</th>
                        <th>Tambah</th>
                        <th>Hapus</th>
                        <th>Aksi Lain</th>
                    </tr>
                </thead>
                <tbody id="hakAksesTableBody">
                    <tr>
                        <td colspan="5" style="text-align:center; padding:20px; color:#9ca3af;">Memuat...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="hakakses-actions">
            <button type="button" class="btn-secondary" onclick="closeHakAksesModal()">Batal</button>
            <button type="button" class="btn-primary" onclick="saveHakAkses()">Simpan</button>
        </div>

    </div>
</div>

{{-- POPUP SUKSES --}}
<div class="success-popup-overlay" id="successPopup">
    <div class="success-popup-box">
        <div class="success-popup-icon">
            <i class="bi bi-check-lg"></i>
        </div>
        <div class="success-popup-text" id="successPopupText">Data berhasil disimpan!</div>
        <button type="button" class="success-popup-ok" onclick="closeSuccessPopup()">OK</button>
    </div>
</div>

<script>
    /* ===================== MODAL TAMBAH/EDIT ===================== */

    function openAddModal() {
        document.getElementById('modalTitle').textContent = 'Tambah Pengguna';
        document.getElementById('userForm').action = "{{ route('pengguna.store') }}";
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('field_name').value = '';
        document.getElementById('field_username').value = '';
        document.getElementById('field_password').value = '';
        document.getElementById('field_password').required = true;
        document.getElementById('passwordHint').textContent = '';
        document.getElementById('field_role').value = 'operator';
        document.getElementById('userModal').classList.add('show');
    }

    function openEditModal(user) {
        document.getElementById('modalTitle').textContent = 'Edit Pengguna';
        document.getElementById('userForm').action = "{{ url('pengguna') }}/" + user.id;
        document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('field_name').value = user.name;
        document.getElementById('field_username').value = user.username;
        document.getElementById('field_password').value = '';
        document.getElementById('field_password').required = false;
        document.getElementById('passwordHint').textContent = '(kosongkan jika tidak diganti)';
        document.getElementById('field_role').value = user.role;
        document.getElementById('userModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('userModal').classList.remove('show');
    }

    /* ===================== FILTER DROPDOWN ===================== */

    function toggleFilter() {
        document.getElementById('filterDropdown').classList.toggle('show');
    }

    document.addEventListener('click', function (event) {
        const wrapper = document.querySelector('.filter-wrapper');
        const dropdown = document.getElementById('filterDropdown');
        if (wrapper && !wrapper.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });

    /* ===================== POPUP SUKSES ===================== */

    function showSuccessPopup(message, onOk) {
        document.getElementById('successPopupText').textContent = message || 'Data berhasil disimpan!';
        document.getElementById('successPopup').classList.add('show');
        window._successPopupOnOk = onOk || null;
    }

    function closeSuccessPopup() {
        document.getElementById('successPopup').classList.remove('show');
        if (typeof window._successPopupOnOk === 'function') {
            const cb = window._successPopupOnOk;
            window._successPopupOnOk = null;
            cb();
        }
    }

    @if (session('success'))
        document.addEventListener('DOMContentLoaded', function () {
            showSuccessPopup(@json(session('success')));
        });
    @endif

    /* ===================== MODAL HAK AKSES ===================== */

    let currentHakAksesRole = null;

    function openHakAksesModal(user) {
        document.getElementById('hakAksesAvatar').src =
            'https://api.dicebear.com/7.x/avataaars/svg?seed=' + encodeURIComponent(user.username);
        document.getElementById('hakAksesName').textContent = user.name;
        document.getElementById('hakAksesCurrentRole').textContent =
            user.role.charAt(0).toUpperCase() + user.role.slice(1).replace('_', ' ');
        document.getElementById('hakAksesRoleDropdown').value = user.role;

        loadPermissions(user.role);

        document.getElementById('hakAksesModal').classList.add('show');
    }

    function closeHakAksesModal() {
        document.getElementById('hakAksesModal').classList.remove('show');
    }

    function loadPermissions(role) {
        currentHakAksesRole = role;
        const tbody = document.getElementById('hakAksesTableBody');
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;padding:20px;color:#9ca3af;">Memuat...</td></tr>';

        fetch("{{ url('hak-akses') }}/" + role)
            .then(res => res.json())
            .then(data => {
                tbody.innerHTML = '';
                let infraHeaderAdded = false;

                const checkboxOrDash = (checked, field) => {
                    return `<input type="checkbox" data-field="${field}" ${checked ? 'checked' : ''}>`;
                };

                const cell = (supports, checked, field) => {
                    if (!supports) {
                        return '<span class="dash">-</span>';
                    }
                    return checkboxOrDash(checked, field);
                };

                data.forEach(item => {
                    const isSub = item.menu_key.includes('.');

                    if (isSub && !infraHeaderAdded) {
                        const headerRow = document.createElement('tr');
                        headerRow.innerHTML = `
                            <td style="font-weight:600;">Infrastruktur</td>
                            <td class="center"><span class="dash">-</span></td>
                            <td class="center"><span class="dash">-</span></td>
                            <td class="center"><span class="dash">-</span></td>
                            <td class="center"><span class="dash">-</span></td>
                        `;
                        tbody.appendChild(headerRow);
                        infraHeaderAdded = true;
                    }

                    const row = document.createElement('tr');
                    row.dataset.menuKey = item.menu_key;

                    row.innerHTML = `
                        <td class="${isSub ? 'menu-sub' : ''}">${isSub ? '↳ ' : ''}${item.menu_label}</td>
                        <td class="center">${checkboxOrDash(item.can_view, 'can_view')}</td>
                        <td class="center">${cell(item.supports_add, item.can_add, 'can_add')}</td>
                        <td class="center">${cell(item.supports_delete, item.can_delete, 'can_delete')}</td>
                        <td class="center">
                            ${item.extra_action_label
                                ? `<label class="extra-action-label"><input type="checkbox" data-field="extra_action_checked" ${item.extra_action_checked ? 'checked' : ''}> ${item.extra_action_label}</label>`
                                : '<span class="dash">-</span>'}
                        </td>
                    `;

                    tbody.appendChild(row);
                });
            });
    }

    function saveHakAkses() {
        const rows = document.querySelectorAll('#hakAksesTableBody tr');
        const items = [];

        rows.forEach(row => {
            const menuKey = row.dataset.menuKey;
            if (!menuKey) return;

            const getChecked = (field) => {
                const el = row.querySelector(`[data-field="${field}"]`);
                return el ? el.checked : false;
            };

            items.push({
                menu_key: menuKey,
                can_view: getChecked('can_view'),
                can_add: getChecked('can_add'),
                can_delete: getChecked('can_delete'),
                extra_action_checked: getChecked('extra_action_checked'),
            });
        });

        fetch("{{ url('hak-akses') }}/" + currentHakAksesRole, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ items }),
        })
            .then(res => res.json())
            .then(() => {
                closeHakAksesModal();
                showSuccessPopup('Hak akses berhasil disimpan!', function () {
                    location.reload();
                });
            });
    }
</script>

@endsection