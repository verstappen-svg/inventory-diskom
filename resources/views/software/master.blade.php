@extends('layouts.app')

@section('title', 'Data Master Software')

@section('page-title', 'Software')

@section('content')

<style>
    .master-page {
        padding: 4px 0 30px;
    }

    .master-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 22px;
    }

    .master-header-left h2 {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #111827;
    }

    .master-header-left p {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .back-button,
    .add-master-button,
    .edit-button,
    .toggle-button {
        border: 0;
        cursor: pointer;
        font-family: inherit;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 14px;
        border-radius: 9px;
        background: #f3f4f6;
        color: #374151;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .back-button:hover {
        background: #e5e7eb;
    }

    .master-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .master-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
    }

    .master-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 17px 18px;
        border-bottom: 1px solid #e5e7eb;
    }

    .master-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .master-card-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #2563eb;
        font-size: 16px;
    }

    .master-card-title h3 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: #111827;
    }

    .master-card-title span {
        display: block;
        margin-top: 2px;
        color: #9ca3af;
        font-size: 11px;
    }

    .add-master-button {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 11px;
        border-radius: 8px;
        background: #2563eb;
        color: #ffffff;
        font-size: 12px;
        font-weight: 600;
    }

    .add-master-button:hover {
        background: #1d4ed8;
    }

    .master-table-wrapper {
        overflow-x: auto;
    }

    .master-table {
        width: 100%;
        border-collapse: collapse;
    }

    .master-table th {
        padding: 11px 16px;
        background: #f9fafb;
        color: #6b7280;
        font-size: 11px;
        font-weight: 700;
        text-align: left;
        white-space: nowrap;
    }

    .master-table td {
        padding: 12px 16px;
        border-top: 1px solid #f1f5f9;
        color: #374151;
        font-size: 12px;
        vertical-align: middle;
    }

    .master-table tbody tr:hover {
        background: #fafafa;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-inactive {
        background: #f3f4f6;
        color: #6b7280;
    }

    .action-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .edit-button,
    .toggle-button {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .edit-button {
        background: #eff6ff;
        color: #2563eb;
    }

    .edit-button:hover {
        background: #dbeafe;
    }

    .toggle-button {
        background: #f3f4f6;
        color: #4b5563;
    }

    .toggle-button:hover {
        background: #e5e7eb;
    }

    .delete-button {
        width: 30px;
        height: 30px;
        border: 0;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fef2f2;
        color: #dc2626;
        font-size: 13px;
        cursor: pointer;
    }

    .delete-button:hover {
        background: #fee2e2;
    }

    .empty-master {
        padding: 25px 16px;
        text-align: center;
        color: #9ca3af;
        font-size: 12px;
    }

    .success-alert {
        margin-bottom: 18px;
        padding: 11px 14px;
        border-radius: 9px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #047857;
        font-size: 12px;
    }

    .error-alert {
        margin-bottom: 18px;
        padding: 11px 14px;
        border-radius: 9px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        font-size: 12px;
    }

    /* MODAL */

    .master-modal {
        position: fixed;
        inset: 0;
        z-index: 10000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, .55);
    }

    .master-modal.show {
        display: flex;
    }

    .master-modal-box {
        width: 100%;
        max-width: 460px;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 25px 70px rgba(0,0,0,.25);
        overflow: hidden;
    }

    .master-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 17px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .master-modal-header h3 {
        margin: 0;
        font-size: 16px;
        color: #111827;
    }

    .modal-close {
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 8px;
        background: #f3f4f6;
        color: #6b7280;
        font-size: 19px;
        cursor: pointer;
    }

    .master-modal-body {
        padding: 20px;
    }

    .master-field {
        margin-bottom: 16px;
    }

    .master-field:last-child {
        margin-bottom: 0;
    }

    .master-field label {
        display: block;
        margin-bottom: 7px;
        font-size: 12px;
        font-weight: 600;
        color: #374151;
    }

    .master-field input {
        width: 100%;
        height: 40px;
        box-sizing: border-box;
        padding: 0 11px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        outline: none;
        font-family: inherit;
        font-size: 12px;
    }

    .master-field input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.1);
    }

    .master-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 15px 20px;
        border-top: 1px solid #e5e7eb;
    }

    .modal-cancel,
    .modal-save {
        height: 38px;
        padding: 0 14px;
        border-radius: 8px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .modal-cancel {
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #374151;
    }

    .modal-save {
        border: 0;
        background: #2563eb;
        color: #ffffff;
    }

    .modal-save:hover {
        background: #1d4ed8;
    }

    .expire-text {
        color: #6b7280;
        font-size: 11px;
    }

    @media (max-width: 800px) {
        .master-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .master-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .master-card-header {
            align-items: flex-start;
            gap: 10px;
            flex-direction: column;
        }
    }
</style>

<div class="master-page">

    {{-- HEADER --}}
    <div class="master-header">

        <div class="master-header-left">
            <h2>Data Master Software</h2>
            <p>
                Kelola kategori, SSL, hosting, dan PIC yang digunakan
                pada data software.
            </p>
        </div>

        <a
            href="{{ route('software.index') }}"
            class="back-button"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke Software
        </a>

    </div>


    {{-- ALERT --}}
    @if(session('success'))
        <div class="success-alert">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error-alert">
            <i class="bi bi-exclamation-circle"></i>
            {{ $errors->first() }}
        </div>
    @endif


    <div class="master-grid">

        {{-- =====================================================
             KATEGORI
        ====================================================== --}}
        <div class="master-card">

            <div class="master-card-header">

                <div class="master-card-title">

                    <div class="master-card-icon">
                        <i class="bi bi-grid"></i>
                    </div>

                    <div>
                        <h3>Kategori Software</h3>
                        <span>
                            {{ $kategori->count() }} data
                        </span>
                    </div>

                </div>

                <button
                    type="button"
                    class="add-master-button"
                    onclick="openAddModal('kategori')"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah
                </button>

            </div>

            <div class="master-table-wrapper">

                <table class="master-table">

                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th style="width: 90px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($kategori as $item)

                            <tr>

                                <td>
                                    {{ $item->nama }}
                                </td>

                                <td>
                                    <span
                                        class="status-badge
                                        {{ $item->status === 'Aktif'
                                            ? 'status-active'
                                            : 'status-inactive' }}"
                                    >
                                        {{ $item->status }}
                                    </span>
                                </td>

                                <td>

                                    <div class="action-group">

                                        <button
                                            type="button"
                                            class="edit-button"
                                            title="Edit"
                                            onclick="openEditModal(
                                                'kategori',
                                                {{ $item->id }},
                                                @js($item->nama),
                                                ''
                                            )"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form
                                            action="{{ route(
                                                'software.master.toggle',
                                                [
                                                    'type' => 'kategori',
                                                    'id' => $item->id
                                                ]
                                            ) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="toggle-button"
                                                title="{{ $item->status === 'Aktif'
                                                    ? 'Nonaktifkan'
                                                    : 'Aktifkan' }}"
                                            >
                                                <i class="bi
                                                    {{ $item->status === 'Aktif'
                                                        ? 'bi-toggle-on'
                                                        : 'bi-toggle-off' }}"
                                                ></i>
                                            </button>

                                        </form>

                                        <form
                                            action="{{ route(
                                                'software.master.destroy',
                                                [
                                                    'type' => 'kategori',
                                                    'id' => $item->id
                                                ]
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="delete-button"
                                                title="Hapus"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3">
                                    <div class="empty-master">
                                        Belum ada data kategori.
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =====================================================
             SSL
        ====================================================== --}}
        <div class="master-card">

            <div class="master-card-header">

                <div class="master-card-title">

                    <div class="master-card-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>

                    <div>
                        <h3>SSL</h3>
                        <span>
                            {{ $ssl->count() }} data
                        </span>
                    </div>

                </div>

                <button
                    type="button"
                    class="add-master-button"
                    onclick="openAddModal('ssl')"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah
                </button>

            </div>

            <div class="master-table-wrapper">

                <table class="master-table">

                    <thead>
                        <tr>
                            <th>Nama SSL</th>
                            <th>Expire</th>
                            <th>Status</th>
                            <th style="width: 90px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($ssl as $item)

                            <tr>

                                <td>
                                    {{ $item->nama_ssl }}
                                </td>

                                <td>

                                    @if($item->tanggal_expire)

                                        <span class="expire-text">
                                            {{ $item->tanggal_expire->format('d/m/Y') }}
                                        </span>

                                    @else

                                        <span class="expire-text">
                                            Tidak ada expire
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <span
                                        class="status-badge
                                        {{ $item->status === 'Aktif'
                                            ? 'status-active'
                                            : 'status-inactive' }}"
                                    >
                                        {{ $item->status }}
                                    </span>

                                </td>

                                <td>

                                    <div class="action-group">

                                        <button
                                            type="button"
                                            class="edit-button"
                                            title="Edit"
                                            onclick="openEditModal(
                                                'ssl',
                                                {{ $item->id }},
                                                @js($item->nama_ssl),
                                                @js(
                                                    $item->tanggal_expire
                                                        ? $item->tanggal_expire->format('Y-m-d')
                                                        : ''
                                                )
                                            )"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form
                                            action="{{ route(
                                                'software.master.toggle',
                                                [
                                                    'type' => 'ssl',
                                                    'id' => $item->id
                                                ]
                                            ) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="toggle-button"
                                                title="{{ $item->status === 'Aktif'
                                                    ? 'Nonaktifkan'
                                                    : 'Aktifkan' }}"
                                            >
                                                <i class="bi
                                                    {{ $item->status === 'Aktif'
                                                        ? 'bi-toggle-on'
                                                        : 'bi-toggle-off' }}"
                                                ></i>
                                            </button>

                                        </form>

                                        <form
                                            action="{{ route(
                                                'software.master.destroy',
                                                [
                                                    'type' => 'ssl',
                                                    'id' => $item->id
                                                ]
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="delete-button"
                                                title="Hapus"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4">
                                    <div class="empty-master">
                                        Belum ada data SSL.
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =====================================================
             HOSTING
        ====================================================== --}}
        <div class="master-card">

            <div class="master-card-header">

                <div class="master-card-title">

                    <div class="master-card-icon">
                        <i class="bi bi-server"></i>
                    </div>

                    <div>
                        <h3>Hosting</h3>
                        <span>
                            {{ $hosting->count() }} data
                        </span>
                    </div>

                </div>

                <button
                    type="button"
                    class="add-master-button"
                    onclick="openAddModal('hosting')"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah
                </button>

            </div>

            <div class="master-table-wrapper">

                <table class="master-table">

                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th style="width: 90px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($hosting as $item)

                            <tr>

                                <td>
                                    {{ $item->nama }}
                                </td>

                                <td>
                                    <span
                                        class="status-badge
                                        {{ $item->status === 'Aktif'
                                            ? 'status-active'
                                            : 'status-inactive' }}"
                                    >
                                        {{ $item->status }}
                                    </span>
                                </td>

                                <td>

                                    <div class="action-group">

                                        <button
                                            type="button"
                                            class="edit-button"
                                            title="Edit"
                                            onclick="openEditModal(
                                                'hosting',
                                                {{ $item->id }},
                                                @js($item->nama),
                                                ''
                                            )"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form
                                            action="{{ route(
                                                'software.master.toggle',
                                                [
                                                    'type' => 'hosting',
                                                    'id' => $item->id
                                                ]
                                            ) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="toggle-button"
                                                title="{{ $item->status === 'Aktif'
                                                    ? 'Nonaktifkan'
                                                    : 'Aktifkan' }}"
                                            >
                                                <i class="bi
                                                    {{ $item->status === 'Aktif'
                                                        ? 'bi-toggle-on'
                                                        : 'bi-toggle-off' }}"
                                                ></i>
                                            </button>

                                        </form>

                                        <form
                                            action="{{ route(
                                                'software.master.destroy',
                                                [
                                                    'type' => 'hosting',
                                                    'id' => $item->id
                                                ]
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="delete-button"
                                                title="Hapus"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3">
                                    <div class="empty-master">
                                        Belum ada data hosting.
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =====================================================
             PIC
        ====================================================== --}}
        <div class="master-card">

            <div class="master-card-header">

                <div class="master-card-title">

                    <div class="master-card-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>

                    <div>
                        <h3>PIC</h3>
                        <span>
                            {{ $pic->count() }} data
                        </span>
                    </div>

                </div>

                <button
                    type="button"
                    class="add-master-button"
                    onclick="openAddModal('pic')"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah
                </button>

            </div>

            <div class="master-table-wrapper">

                <table class="master-table">

                    <thead>
                        <tr>
                            <th>Nama PIC</th>
                            <th>Status</th>
                            <th style="width: 90px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($pic as $item)

                            <tr>

                                <td>
                                    {{ $item->nama }}
                                </td>

                                <td>
                                    <span
                                        class="status-badge
                                        {{ $item->status === 'Aktif'
                                            ? 'status-active'
                                            : 'status-inactive' }}"
                                    >
                                        {{ $item->status }}
                                    </span>
                                </td>

                                <td>

                                    <div class="action-group">

                                        <button
                                            type="button"
                                            class="edit-button"
                                            title="Edit"
                                            onclick="openEditModal(
                                                'pic',
                                                {{ $item->id }},
                                                @js($item->nama),
                                                ''
                                            )"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form
                                            action="{{ route(
                                                'software.master.toggle',
                                                [
                                                    'type' => 'pic',
                                                    'id' => $item->id
                                                ]
                                            ) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="toggle-button"
                                                title="{{ $item->status === 'Aktif'
                                                    ? 'Nonaktifkan'
                                                    : 'Aktifkan' }}"
                                            >
                                                <i class="bi
                                                    {{ $item->status === 'Aktif'
                                                        ? 'bi-toggle-on'
                                                        : 'bi-toggle-off' }}"
                                                ></i>
                                            </button>

                                        </form>

                                        <form
                                            action="{{ route(
                                                'software.master.destroy',
                                                [
                                                    'type' => 'pic',
                                                    'id' => $item->id
                                                ]
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="delete-button"
                                                title="Hapus"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3">
                                    <div class="empty-master">
                                        Belum ada data PIC.
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH / EDIT
========================================================= --}}

<div
    class="master-modal"
    id="masterModal"
>

    <div class="master-modal-box">

        <div class="master-modal-header">

            <h3 id="masterModalTitle">
                Tambah Data Master
            </h3>

            <button
                type="button"
                class="modal-close"
                onclick="closeMasterModal()"
            >
                ×
            </button>

        </div>

        <form
            method="POST"
            id="masterForm"
        >

            @csrf

            <input
                type="hidden"
                name="type"
                id="masterType"
            >

            <div id="masterMethod"></div>

            <div class="master-modal-body">

                <div class="master-field">

                    <label for="masterName">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="nama"
                        id="masterName"
                        placeholder="Masukkan nama"
                        required
                    >

                </div>


                <div
                    class="master-field"
                    id="expireField"
                    style="display: none;"
                >

                    <label for="masterExpire">
                        Tanggal Expire SSL
                    </label>

                    <input
                        type="date"
                        name="tanggal_expire"
                        id="masterExpire"
                    >

                </div>

            </div>

            <div class="master-modal-footer">

                <button
                    type="button"
                    class="modal-cancel"
                    onclick="closeMasterModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="modal-save"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>


<script>
    const masterModal = document.getElementById('masterModal');
    const masterForm = document.getElementById('masterForm');
    const masterModalTitle = document.getElementById('masterModalTitle');
    const masterType = document.getElementById('masterType');
    const masterName = document.getElementById('masterName');
    const masterExpire = document.getElementById('masterExpire');
    const expireField = document.getElementById('expireField');
    const masterMethod = document.getElementById('masterMethod');


    function openAddModal(type) {

        masterModal.classList.add('show');

        masterModalTitle.textContent =
            'Tambah ' + getTypeLabel(type);

        masterType.value = type;

        masterName.value = '';

        masterExpire.value = '';

        masterForm.action =
            '{{ route('software.master.store') }}';

        masterMethod.innerHTML = '';

        if (type === 'ssl') {

            expireField.style.display = 'block';

        } else {

            expireField.style.display = 'none';

        }

        setTimeout(function () {
            masterName.focus();
        }, 100);
    }


    function openEditModal(
        type,
        id,
        name,
        expire
    ) {

        masterModal.classList.add('show');

        masterModalTitle.textContent =
            'Edit ' + getTypeLabel(type);

        masterType.value = type;

        masterName.value = name || '';

        masterExpire.value = expire || '';

        masterForm.action =
            '{{ url('/software/master') }}/'
            + type
            + '/'
            + id;

        masterMethod.innerHTML =
            '<input type="hidden" name="_method" value="PUT">';

        if (type === 'ssl') {

            expireField.style.display = 'block';

        } else {

            expireField.style.display = 'none';

        }

        setTimeout(function () {
            masterName.focus();
        }, 100);
    }


    function getTypeLabel(type) {

        switch (type) {

            case 'kategori':
                return 'Kategori';

            case 'ssl':
                return 'SSL';

            case 'hosting':
                return 'Hosting';

            case 'pic':
                return 'PIC';

            default:
                return 'Data Master';
        }
    }


    function closeMasterModal() {

        masterModal.classList.remove('show');

        masterForm.reset();

        masterMethod.innerHTML = '';

        expireField.style.display = 'none';
    }


    masterModal.addEventListener(
        'click',
        function (event) {

            if (event.target === masterModal) {
                closeMasterModal();
            }

        }
    );


    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {
                closeMasterModal();
            }

        }
    );
</script>

@endsection