@extends('layouts.app')

@section('title', 'Data Center Master')

@section('page-title', 'Data Center Master')

@section('content')

<style>

/* =========================================================
   PAGE
========================================================= */

.master-page {
    width: 100%;
}


/* =========================================================
   HEADER
========================================================= */

.master-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
}

.master-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #172033;
}

.master-header p {
    margin: 6px 0 0;
    font-size: 14px;
    color: #6b7280;
}


/* =========================================================
   BUTTON
========================================================= */

.master-btn {
    height: 40px;
    padding: 0 15px;
    border: none;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: .2s ease;
}

.master-btn:hover {
    transform: translateY(-1px);
}

.master-btn-primary {
    background: #071b88;
    color: #fff;
}

.master-btn-primary:hover {
    background: #05146b;
    color: #fff;
}

.master-btn-secondary {
    background: #eef1f7;
    color: #374151;
}

.master-btn-secondary:hover {
    background: #e2e6ef;
    color: #374151;
}


/* =========================================================
   ALERT
========================================================= */

.master-alert {
    margin-bottom: 18px;
    padding: 13px 16px;
    border-radius: 9px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 15px;
    font-size: 13px;
}

.master-alert-success {
    background: #eaf8ef;
    border: 1px solid #ccebd7;
    color: #166534;
}

.master-alert-error {
    background: #fff0f0;
    border: 1px solid #ffd3d3;
    color: #991b1b;
}

.master-alert-close {
    border: none;
    background: transparent;
    font-size: 19px;
    cursor: pointer;
    color: inherit;
}


/* =========================================================
   STAT
========================================================= */

.master-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 22px;
}

.master-stat {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 18px 20px;
}

.master-stat-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 7px;
}

.master-stat-value {
    font-size: 26px;
    font-weight: 700;
    color: #172033;
}


/* =========================================================
   FILTER
========================================================= */

.master-filter {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 17px;
    margin-bottom: 22px;
}

.master-filter-form {
    display: grid;
    grid-template-columns: 1fr 220px 180px auto;
    gap: 12px;
    align-items: end;
}

.master-field {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.master-field label {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
}

.master-input,
.master-select {
    width: 100%;
    height: 40px;
    box-sizing: border-box;
    border: 1px solid #d7dce5;
    border-radius: 8px;
    background: #fff;
    padding: 0 11px;
    color: #1f2937;
    font-size: 13px;
    outline: none;
}

.master-input:focus,
.master-select:focus {
    border-color: #071b88;
    box-shadow: 0 0 0 3px rgba(7, 27, 136, .08);
}

.master-filter-buttons {
    display: flex;
    gap: 7px;
}


/* =========================================================
   CATEGORY GRID
========================================================= */

.master-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
}


/* =========================================================
   CATEGORY CARD
========================================================= */

.master-card {
    background: #fff;
    border: 1px solid #e4e7ec;
    border-radius: 13px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .035);
}

.master-card-header {
    min-height: 70px;
    padding: 14px 15px;
    border-bottom: 1px solid #edf0f4;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.master-card-title {
    display: flex;
    align-items: center;
    gap: 11px;
    min-width: 0;
}

.master-card-icon {
    width: 37px;
    height: 37px;
    flex-shrink: 0;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eef1ff;
    color: #071b88;
    font-size: 17px;
}

.master-card-title-text {
    min-width: 0;
}

.master-card-title h3 {
    margin: 0;
    color: #172033;
    font-size: 14px;
    font-weight: 700;
}

.master-card-title span {
    display: block;
    margin-top: 3px;
    color: #8a93a3;
    font-size: 11px;
}

.master-add {
    width: 32px;
    height: 32px;
    flex-shrink: 0;
    border: none;
    border-radius: 8px;
    background: #071b88;
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .2s ease;
}

.master-add:hover {
    background: #05146b;
    transform: translateY(-1px);
}


/* =========================================================
   LIST
========================================================= */

.master-list {
    padding: 4px 0;
    max-height: 430px;
    overflow-y: auto;
}

.master-list::-webkit-scrollbar {
    width: 5px;
}

.master-list::-webkit-scrollbar-thumb {
    background: #d5d9e0;
    border-radius: 20px;
}

.master-item {
    padding: 10px 14px;
    border-bottom: 1px solid #f1f2f4;
}

.master-item:last-child {
    border-bottom: none;
}

.master-item-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.master-item-info {
    min-width: 0;
    flex: 1;
}

.master-item-name {
    color: #273142;
    font-size: 12.5px;
    font-weight: 600;
    line-height: 1.4;
    overflow-wrap: anywhere;
}

.master-item-status {
    margin-top: 5px;
}


/* =========================================================
   ACTION
========================================================= */

.master-actions {
    display: flex;
    align-items: center;
    gap: 4px;
    flex-shrink: 0;
}

.master-action {
    width: 29px;
    height: 29px;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .15s ease;
}

.master-action:hover {
    transform: translateY(-1px);
}

.master-edit {
    background: #eef1ff;
    color: #071b88;
}

.master-edit:hover {
    background: #dfe4ff;
}

.master-toggle {
    background: #f1f3f5;
    color: #4b5563;
}

.master-toggle:hover {
    background: #e5e7eb;
}

.master-delete {
    background: #fff0f0;
    color: #dc2626;
}

.master-delete:hover {
    background: #ffe0e0;
}


/* =========================================================
   BADGE
========================================================= */

.master-badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 8px;
    border-radius: 999px;
    font-size: 9px;
    line-height: 1;
    font-weight: 700;
}

.master-badge-active {
    background: #eaf8ef;
    color: #16803c;
}

.master-badge-inactive {
    background: #f1f3f5;
    color: #6b7280;
}


/* =========================================================
   EMPTY
========================================================= */

.master-empty {
    padding: 28px 15px;
    text-align: center;
    color: #9ca3af;
    font-size: 12px;
}

.master-empty i {
    display: block;
    font-size: 25px;
    margin-bottom: 7px;
}


/* =========================================================
   MODAL
========================================================= */

.master-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(15, 23, 42, .48);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.master-modal-overlay.show {
    display: flex;
}

.master-modal {
    width: 100%;
    max-width: 510px;
    background: #fff;
    border-radius: 13px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
}

.master-modal-header {
    padding: 17px 20px;
    border-bottom: 1px solid #edf0f4;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.master-modal-header h3 {
    margin: 0;
    font-size: 17px;
    font-weight: 700;
    color: #172033;
}

.master-modal-close {
    width: 33px;
    height: 33px;
    border: none;
    border-radius: 8px;
    background: #f3f4f6;
    color: #4b5563;
    cursor: pointer;
    font-size: 18px;
}

.master-modal-body {
    padding: 20px;
}

.master-modal-footer {
    padding: 15px 20px;
    border-top: 1px solid #edf0f4;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .master-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .master-filter-form {
        grid-template-columns: 1fr 1fr;
    }

}

@media (max-width: 760px) {

    .master-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .master-stats {
        grid-template-columns: 1fr;
    }

    .master-grid {
        grid-template-columns: 1fr;
    }

    .master-filter-form {
        grid-template-columns: 1fr;
    }

    .master-filter-buttons {
        width: 100%;
    }

    .master-filter-buttons .master-btn {
        flex: 1;
    }

}

</style>


<div class="master-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="master-header">

        <div>

            <h2>
                Data Center Master
            </h2>

            <p>
                Kelola data referensi yang digunakan pada Data Center.
            </p>

        </div>


        <a
            href="{{ route('data-center.index') }}"
            class="master-btn master-btn-secondary"
        >

            <i class="bi bi-arrow-left"></i>

            Kembali ke Data Center

        </a>

    </div>


    {{-- =====================================================
         ALERT SUCCESS
    ====================================================== --}}

    @if(session('success'))

        <div class="master-alert master-alert-success">

            <div>

                <i class="bi bi-check-circle me-1"></i>

                {{ session('success') }}

            </div>

            <button
                type="button"
                class="master-alert-close"
                onclick="this.parentElement.remove()"
            >
                &times;
            </button>

        </div>

    @endif


    {{-- =====================================================
         ALERT ERROR
    ====================================================== --}}

    @if(session('error'))

        <div class="master-alert master-alert-error">

            <div>

                <i class="bi bi-exclamation-circle me-1"></i>

                {{ session('error') }}

            </div>

            <button
                type="button"
                class="master-alert-close"
                onclick="this.parentElement.remove()"
            >
                &times;
            </button>

        </div>

    @endif


    {{-- =====================================================
         VALIDATION ERROR
    ====================================================== --}}

    @if($errors->any())

        <div class="master-alert master-alert-error">

            <div>

                <strong>
                    Terdapat kesalahan:
                </strong>

                <ul style="margin:6px 0 0 18px;">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

            <button
                type="button"
                class="master-alert-close"
                onclick="this.parentElement.remove()"
            >
                &times;
            </button>

        </div>

    @endif


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="master-stats">

        <div class="master-stat">

            <div class="master-stat-label">
                Total Data Master
            </div>

            <div class="master-stat-value">
                {{ $total }}
            </div>

        </div>


        <div class="master-stat">

            <div class="master-stat-label">
                Active
            </div>

            <div class="master-stat-value">
                {{ $active }}
            </div>

        </div>


        <div class="master-stat">

            <div class="master-stat-label">
                Inactive
            </div>

            <div class="master-stat-value">
                {{ $inactive }}
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTER
    ====================================================== --}}

    <div class="master-filter">

        <form
            method="GET"
            action="{{ route('data-center.master') }}"
            class="master-filter-form"
        >

            <div class="master-field">

                <label>
                    Cari Data
                </label>

                <input
                    type="text"
                    name="search"
                    class="master-input"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, jenis, atau status..."
                >

            </div>


            <div class="master-field">

                <label>
                    Jenis
                </label>

                <select
                    name="jenis"
                    class="master-select"
                >

                    <option value="">
                        Semua Jenis
                    </option>

                    @foreach($jenisList as $jenis)

                        <option
                            value="{{ $jenis }}"
                            {{ request('jenis') === $jenis ? 'selected' : '' }}
                        >
                            {{ $jenisLabels[$jenis] ?? ucfirst($jenis) }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="master-field">

                <label>
                    Status
                </label>

                <select
                    name="status"
                    class="master-select"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="Active"
                        {{ request('status') === 'Active' ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="Inactive"
                        {{ request('status') === 'Inactive' ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>

            </div>


            <div class="master-filter-buttons">

                <button
                    type="submit"
                    class="master-btn master-btn-primary"
                >

                    <i class="bi bi-search"></i>

                    Cari

                </button>


                <a
                    href="{{ route('data-center.master') }}"
                    class="master-btn master-btn-secondary"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- =====================================================
         MASTER GRID
    ====================================================== --}}

    <div class="master-grid">

        @foreach($jenisList as $jenis)

            @php
                $items = $mastersByJenis[$jenis] ?? collect();
            @endphp


            <div class="master-card">

                {{-- CARD HEADER --}}

                <div class="master-card-header">

                    <div class="master-card-title">

                        <div class="master-card-icon">

                            @switch($jenis)

                                @case('tenant')
                                    <i class="bi bi-building"></i>
                                    @break

                                @case('site')
                                    <i class="bi bi-geo-alt"></i>
                                    @break

                                @case('rack')
                                    <i class="bi bi-server"></i>
                                    @break

                                @case('region')
                                    <i class="bi bi-map"></i>
                                    @break

                                @case('location')
                                    <i class="bi bi-pin-map"></i>
                                    @break

                                @case('role')
                                    <i class="bi bi-person-badge"></i>
                                    @break

                                @case('manufacturer')
                                    <i class="bi bi-cpu"></i>
                                    @break

                                @case('pic')
                                    <i class="bi bi-person"></i>
                                    @break

                                @case('platform')
                                    <i class="bi bi-layers"></i>
                                    @break

                                @default
                                    <i class="bi bi-list"></i>

                            @endswitch

                        </div>


                        <div class="master-card-title-text">

                            <h3>
                                {{ $jenisLabels[$jenis] ?? ucfirst($jenis) }}
                            </h3>

                            <span>
                                {{ $counts[$jenis] ?? 0 }} data
                            </span>

                        </div>

                    </div>


                    <button
                        type="button"
                        class="master-add"
                        title="Tambah {{ $jenisLabels[$jenis] ?? ucfirst($jenis) }}"
                        onclick="openAddMasterModal('{{ $jenis }}')"
                    >

                        <i class="bi bi-plus-lg"></i>

                    </button>

                </div>


                {{-- CARD LIST --}}

                <div class="master-list">

                    @forelse($items as $master)

                        <div class="master-item">

                            <div class="master-item-row">

                                <div class="master-item-info">

                                    <div class="master-item-name">
                                        {{ $master->nama }}
                                    </div>

                                    <div class="master-item-status">

                                        @if($master->status === 'Active')

                                            <span class="master-badge master-badge-active">
                                                Active
                                            </span>

                                        @else

                                            <span class="master-badge master-badge-inactive">
                                                Inactive
                                            </span>

                                        @endif

                                    </div>

                                </div>


                                <div class="master-actions">

                                    {{-- EDIT --}}

                                    <button
                                        type="button"
                                        class="master-action master-edit"
                                        title="Edit"
                                        onclick='openEditMasterModal(@json($master))'
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </button>


                                    {{-- TOGGLE --}}

                                    <form
                                        method="POST"
                                        action="{{ route('data-center.master.toggle', $master->id) }}"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="master-action master-toggle"
                                            title="Ubah Status"
                                            onclick="return confirm('Yakin ingin mengubah status data {{ $master->nama }}?')"
                                        >

                                            @if($master->status === 'Active')

                                                <i class="bi bi-toggle-on"></i>

                                            @else

                                                <i class="bi bi-toggle-off"></i>

                                            @endif

                                        </button>

                                    </form>


                                    {{-- DELETE --}}

                                    <form
                                        method="POST"
                                        action="{{ route('data-center.master.destroy', $master->id) }}"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="master-action master-delete"
                                            title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus {{ $master->nama }}?')"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="master-empty">

                            <i class="bi bi-inbox"></i>

                            Belum ada data
                            {{ strtolower($jenisLabels[$jenis] ?? $jenis) }}.

                        </div>

                    @endforelse

                </div>

            </div>

        @endforeach

    </div>

</div>


{{-- =========================================================
     MODAL
========================================================= --}}

<div
    id="masterModal"
    class="master-modal-overlay"
>

    <div class="master-modal">

        <div class="master-modal-header">

            <h3 id="masterModalTitle">
                Tambah Data Master
            </h3>

            <button
                type="button"
                class="master-modal-close"
                onclick="closeMasterModal()"
            >
                &times;
            </button>

        </div>


        <form
            id="masterForm"
            method="POST"
            action="{{ route('data-center.master.store') }}"
        >

            @csrf

            <div id="masterMethodContainer"></div>


            <div class="master-modal-body">

                {{-- JENIS --}}

                <div class="master-field">

                    <label for="masterJenis">
                        Jenis
                    </label>

                    <select
                        name="jenis"
                        id="masterJenis"
                        class="master-select"
                        required
                    >

                        <option value="">
                            Pilih Jenis
                        </option>

                        @foreach($jenisList as $jenis)

                            <option value="{{ $jenis }}">
                                {{ $jenisLabels[$jenis] ?? ucfirst($jenis) }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- NAMA --}}

                <div
                    class="master-field"
                    style="margin-top:16px;"
                >

                    <label for="masterNama">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="nama"
                        id="masterNama"
                        class="master-input"
                        placeholder="Masukkan nama..."
                        maxlength="255"
                        required
                    >

                </div>


                {{-- STATUS --}}

                <div
                    class="master-field"
                    style="margin-top:16px;"
                >

                    <label for="masterStatus">
                        Status
                    </label>

                    <select
                        name="status"
                        id="masterStatus"
                        class="master-select"
                        required
                    >

                        <option value="Active">
                            Active
                        </option>

                        <option value="Inactive">
                            Inactive
                        </option>

                    </select>

                </div>

            </div>


            <div class="master-modal-footer">

                <button
                    type="button"
                    class="master-btn master-btn-secondary"
                    onclick="closeMasterModal()"
                >
                    Batal
                </button>


                <button
                    type="submit"
                    class="master-btn master-btn-primary"
                >

                    <i class="bi bi-check-lg"></i>

                    <span id="masterSubmitText">
                        Simpan
                    </span>

                </button>

            </div>

        </form>

    </div>

</div>


<script>

/* =========================================================
   ELEMENT
========================================================= */

const masterModal =
    document.getElementById('masterModal');

const masterForm =
    document.getElementById('masterForm');

const masterModalTitle =
    document.getElementById('masterModalTitle');

const masterSubmitText =
    document.getElementById('masterSubmitText');

const masterJenis =
    document.getElementById('masterJenis');

const masterNama =
    document.getElementById('masterNama');

const masterStatus =
    document.getElementById('masterStatus');

const masterMethodContainer =
    document.getElementById('masterMethodContainer');


/* =========================================================
   TAMBAH
========================================================= */

function openAddMasterModal(jenis = '') {

    masterForm.reset();

    masterForm.action =
        "{{ route('data-center.master.store') }}";

    masterMethodContainer.innerHTML = '';

    masterModalTitle.textContent =
        'Tambah Data Master';

    masterSubmitText.textContent =
        'Simpan';

    masterJenis.disabled = false;

    if (jenis) {

        masterJenis.value = jenis;

        /*
        |--------------------------------------------------------------------------
        | Kunci jenis ketika tombol + berasal dari card
        |--------------------------------------------------------------------------
        */

        masterJenis.disabled = true;

    }

    masterStatus.value = 'Active';

    masterModal.classList.add('show');

    setTimeout(() => {

        masterNama.focus();

    }, 100);

}


/* =========================================================
   EDIT
========================================================= */

function openEditMasterModal(master) {

    masterForm.action =
        "{{ url('/infrastruktur/data-center/master') }}/" +
        master.id;

    masterMethodContainer.innerHTML =
        '<input type="hidden" name="_method" value="PUT">';

    masterModalTitle.textContent =
        'Edit Data Master';

    masterSubmitText.textContent =
        'Simpan Perubahan';

    masterJenis.disabled = false;

    masterJenis.value =
        master.jenis || '';

    masterNama.value =
        master.nama || '';

    masterStatus.value =
        master.status || 'Active';

    masterModal.classList.add('show');

    setTimeout(() => {

        masterNama.focus();

    }, 100);

}


/* =========================================================
   CLOSE
========================================================= */

function closeMasterModal() {

    masterModal.classList.remove('show');

    masterForm.reset();

    masterForm.action =
        "{{ route('data-center.master.store') }}";

    masterMethodContainer.innerHTML = '';

    masterJenis.disabled = false;

    masterModalTitle.textContent =
        'Tambah Data Master';

    masterSubmitText.textContent =
        'Simpan';

}


/* =========================================================
   SUBMIT
========================================================= */

masterForm.addEventListener(
    'submit',
    function () {

        /*
        |--------------------------------------------------------------------------
        | SELECT DISABLED TIDAK DIKIRIM BROWSER
        |--------------------------------------------------------------------------
        */

        masterJenis.disabled = false;

    }
);


/* =========================================================
   CLICK OUTSIDE
========================================================= */

masterModal.addEventListener(
    'click',
    function (event) {

        if (event.target === masterModal) {

            closeMasterModal();

        }

    }
);


/* =========================================================
   ESC
========================================================= */

document.addEventListener(
    'keydown',
    function (event) {

        if (
            event.key === 'Escape' &&
            masterModal.classList.contains('show')
        ) {

            closeMasterModal();

        }

    }
);

</script>

@endsection