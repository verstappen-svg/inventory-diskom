@extends('layouts.app')

@section('title', 'Hardware Management')

@section('page-title', 'Hardware Management')

@section('content')
<div class="hardware-page">

    {{-- SUMMARY CARDS --}}
    <div class="summary-cards">

        <div class="summary-card">
    <span class="summary-title">Jumlah Barang</span>
    <strong>{{ $jumlahBarang }}</strong>
</div>

<div class="summary-card">
    <span class="summary-title">Harga Barang</span>
    <strong>
        Rp. {{ number_format($hargaBarang, 0, ',', '.') }}
    </strong>
</div>

<div class="summary-card warning">
    <span class="summary-title">Perlu Perbaikan</span>
    <strong>{{ $perluPerbaikan }}</strong>
</div>

<div class="summary-card danger">
    <span class="summary-title">Rusak</span>
    <strong>{{ $rusak }}</strong>
</div>

<div class="summary-card">
    <span class="summary-title">Tersedia</span>
    <strong>{{ $tersedia }}</strong>
</div>
</div>


    {{-- TABLE CONTAINER --}}
    <div class="hardware-table-container">

        {{-- TABLE TOOLBAR --}}
        <div class="table-toolbar">

            {{-- SEARCH --}}
            <div class="search-box">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                    <circle cx="11" cy="11" r="6.5"
                            stroke="currentColor"
                            stroke-width="1.8"/>
                    <path d="M16 16L21 21"
                          stroke="currentColor"
                          stroke-width="1.8"
                          stroke-linecap="round"/>
                </svg>

                <input
                    type="text"
                    id="hardwareSearch"
                    placeholder="Search..."
                >
            </div>


            {{-- ACTION BUTTONS --}}
            <div class="table-actions">

                <button class="filter-btn" type="button">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M4 6H20"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linecap="round"/>

                        <path d="M7 12H17"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linecap="round"/>

                        <path d="M10 18H14"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linecap="round"/>
                    </svg>

                    Filter
                </button>


                {{-- ADD --}}
                <button
                    class="add-btn"
                    type="button"
                    onclick="openHardwareForm()"
                >
                    <span class="add-icon">+</span>
                    Add
                </button>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="table-wrapper">

            <table class="hardware-table">

                <thead>
                    <tr>
                        <th>ASSET ID</th>
                        <th>SPESIFIKASI</th>
                        <th>JENIS BARANG</th>
                        <th>TAHUN PEMBELIAN</th>
                        <th>HARGA</th>
                        <th>KONDISI</th>
                        <th class="verification-column">VERIFIKASI</th>
                        <th class="action-column">AKSI</th>
                    </tr>
                </thead>


                <tbody id="hardwareTableBody">

                    @forelse($hardwares as $hardware)

                        <tr>

                            {{-- ASSET ID --}}
                            <td>
                                {{ $hardware->asset_id }}
                            </td>


                            {{-- SPESIFIKASI --}}
                            <td>
                                <div class="specification">

                                    <strong>
                                        {{ $hardware->nama_barang }}
                                    </strong>

                                    <small>
                                        {{ $hardware->spesifikasi }}
                                    </small>

                                </div>
                            </td>


                            {{-- JENIS BARANG --}}
                            <td>
                                {{ $hardware->jenis_barang }}
                            </td>


                            {{-- TAHUN PEMBELIAN --}}
                            <td>
                                {{ $hardware->tahun_pembelian }}
                            </td>


                            {{-- HARGA --}}
                            <td>
                                Rp. {{ number_format($hardware->harga, 0, ',', '.') }}
                            </td>


                            {{-- KONDISI --}}
                            <td>

                                @if($hardware->kondisi === 'Baik')

                                    <span class="condition good">
                                        Baik
                                    </span>

                                @elseif($hardware->kondisi === 'Perlu Perbaikan')

                                    <span class="condition repair">
                                        Perlu<br>Perbaikan
                                    </span>

                                @elseif($hardware->kondisi === 'Rusak')

                                    <span class="condition damaged">
                                        Rusak
                                    </span>

                                @endif

                            </td>

                            {{-- VERIFIKASI --}}
<td class="verification-column">
    @if($hardware->verifikasi)

        @if($hardware->verifikasi->status === 'Menunggu Persetujuan')
            <span class="verification pending">
                Menunggu Disetujui
            </span>

        @elseif($hardware->verifikasi->status === 'Disetujui')
            <span class="verification approved">
                Disetujui
            </span>

        @elseif($hardware->verifikasi->status === 'Ditolak')
            <span class="verification rejected">
                Ditolak
            </span>
        @endif

    @else
        <span class="verification pending">
            Belum Diverifikasi
        </span>
    @endif
</td>


                            {{-- AKSI --}}
                            <td>

                                <div class="action-buttons">

                                    {{-- EDIT --}}
                                    <button
                                        class="edit-action"
                                        title="Edit"
                                        type="button"
                                        onclick="editHardware({{ $hardware->id }})"
                                    >
                                        ✎
                                    </button>


                                    {{-- HAPUS --}}
                                    <form
                                        action="{{ route('hardware.destroy', $hardware->id) }}"
                                        method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus data hardware ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="delete-action"
                                            title="Hapus"
                                            type="submit"
                                        >
                                            ×
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" style="text-align: center;">
                                Belum ada data hardware.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- TABLE FOOTER --}}
        <div class="table-footer">

            <span class="showing-text">
                Showing 1 to 10 of 125 entries
            </span>

            <div class="pagination">

                <button class="page-arrow">
                    ‹
                </button>

                <button class="page-number active">
                    1
                </button>

                <button class="page-number">
                    2
                </button>

                <button class="page-number">
                    3
                </button>

                <button class="page-arrow">
                    ›
                </button>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- FORM TAMBAH / EDIT HARDWARE --}}
{{-- ========================================================= --}}

<div id="hardwareFormOverlay" class="hardware-form-overlay">

    <div class="hardware-form-modal">


        {{-- HEADER FORM --}}
        <div class="hardware-form-header">

            <div>

                <h2 id="hardwareFormTitle">
                    Tambah Data Hardware
                </h2>

                <p id="hardwareFormDescription">
                    Masukan detail aset data hardware baru ke dalam sistem.
                </p>

            </div>


            <button
                type="button"
                class="hardware-form-close"
                onclick="closeHardwareForm()"
            >
                ×
            </button>

        </div>


        {{-- FORM --}}
        <form
            id="hardwareForm"
            method="POST"
            action="{{ route('hardware.store') }}"
        >

            @csrf

            {{-- METHOD POST / PUT --}}
            <input
                type="hidden"
                name="_method"
                id="hardwareMethod"
                value="POST"
            >


            {{-- ISI FORM --}}
            <div class="hardware-form-body">


                {{-- Nama Barang --}}
                <div class="hardware-form-group">

                    <label for="nama_barang">
                        Nama Barang
                    </label>

                    <input
                        type="text"
                        id="nama_barang"
                        name="nama_barang"
                        placeholder="Merk barang"
                    >

                </div>


                {{-- Spesifikasi --}}
                <div class="hardware-form-group">

                    <label for="spesifikasi">
                        Spesifikasi
                    </label>

                    <input
                        type="text"
                        id="spesifikasi"
                        name="spesifikasi"
                    >

                </div>


                {{-- Jenis Barang --}}
                <div class="hardware-form-group">

                    <label for="jenis_barang">
                        Jenis Barang
                    </label>

                    <select
                        id="jenis_barang"
                        name="jenis_barang"
                    >

                        <option value="" selected disabled>
                            Pilih jenis barang
                        </option>

                        <option value="Laptop">
                            Laptop
                        </option>

                        <option value="PC">
                            PC
                        </option>

                        <option value="Printer">
                            Printer
                        </option>

                        <option value="Monitor">
                            Monitor
                        </option>

                        <option value="Keyboard">
                            Keyboard
                        </option>

                        <option value="Mouse">
                            Mouse
                        </option>

                        <option value="Camera">
                            Camera
                        </option>

                    </select>

                </div>


                {{-- Tahun + Harga --}}
                <div class="hardware-form-row">


                    {{-- Tahun Pembelian --}}
                    <div class="hardware-form-group">

                        <label for="tahun_pembelian">
                            Tahun Pembelian
                        </label>

                        <input
                            type="number"
                            id="tahun_pembelian"
                            name="tahun_pembelian"
                            placeholder="yyyy"
                        >

                    </div>


                    {{-- Harga --}}
                    <div class="hardware-form-group">

                        <label for="harga">
                            Harga
                        </label>

                        <input
                            type="number"
                            id="harga"
                            name="harga"
                            placeholder="Rp.2.000"
                        >

                    </div>

                </div>


                {{-- Kondisi --}}
                <div class="hardware-form-group">

                    <label for="kondisi">
                        Kondisi
                    </label>

                    <select
                        id="kondisi"
                        name="kondisi"
                    >

                        <option value="" selected disabled>
                            Pilih kondisi
                        </option>

                        <option value="Baik">
                            Baik
                        </option>

                        <option value="Perlu Perbaikan">
                            Perlu Perbaikan
                        </option>

                        <option value="Rusak">
                            Rusak
                        </option>

                    </select>

                </div>

            </div>


            {{-- FOOTER FORM --}}
            <div class="hardware-form-footer">

                <button
                    type="button"
                    class="hardware-btn-batal"
                    onclick="closeHardwareForm()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="hardware-btn-simpan"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       SEARCH HARDWARE
    ===================================================== */

    const searchInput = document.getElementById('hardwareSearch');

    const rows = document.querySelectorAll(
        '#hardwareTableBody tr'
    );


    searchInput.addEventListener('keyup', function () {

        const searchValue = this.value.toLowerCase();


        rows.forEach(function (row) {

            const rowText = row.textContent.toLowerCase();


            if (rowText.includes(searchValue)) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    });


    /* =====================================================
       TUTUP MODAL KLIK LUAR
    ===================================================== */

    const overlay = document.getElementById(
        'hardwareFormOverlay'
    );


    overlay.addEventListener('click', function (event) {

        if (event.target === overlay) {

            closeHardwareForm();

        }

    });

});


/* =========================================================
   BUKA FORM TAMBAH
========================================================= */

function openHardwareForm()
{

    const form = document.getElementById(
        'hardwareForm'
    );


    /* Kembalikan ke mode TAMBAH */

    form.action = "{{ route('hardware.store') }}";


    document.getElementById(
        'hardwareMethod'
    ).value = 'POST';


    /* Judul */

    document.getElementById(
        'hardwareFormTitle'
    ).textContent = 'Tambah Data Hardware';


    document.getElementById(
        'hardwareFormDescription'
    ).textContent =
        'Masukan detail aset data hardware baru ke dalam sistem.';


    /* Kosongkan form */

    form.reset();


    /* Buka modal */

    document.getElementById(
        'hardwareFormOverlay'
    ).classList.add('active');

}


/* =========================================================
   BUKA FORM EDIT
========================================================= */

function editHardware(id)
{

    /*
     * Ambil semua data hardware
     * yang dikirim dari Controller
     */

    const hardwares = @json($hardwares);


    /*
     * Cari data berdasarkan ID
     */

    const hardware = hardwares.find(
        item => item.id === id
    );


    if (!hardware) {

        alert('Data hardware tidak ditemukan.');

        return;

    }


    const form = document.getElementById(
        'hardwareForm'
    );


    /* =====================================================
       UBAH FORM MENJADI MODE EDIT
    ===================================================== */

    form.action = `/hardware/${id}`;


    document.getElementById(
        'hardwareMethod'
    ).value = 'PUT';


    /* =====================================================
       UBAH JUDUL
    ===================================================== */

    document.getElementById(
        'hardwareFormTitle'
    ).textContent = 'Edit Data Hardware';


    document.getElementById(
        'hardwareFormDescription'
    ).textContent =
        'Perbarui detail aset hardware yang dipilih.';


    /* =====================================================
       MASUKKAN DATA KE FORM
    ===================================================== */

    document.getElementById(
        'nama_barang'
    ).value = hardware.nama_barang;


    document.getElementById(
        'spesifikasi'
    ).value = hardware.spesifikasi;


    document.getElementById(
        'jenis_barang'
    ).value = hardware.jenis_barang;


    document.getElementById(
        'tahun_pembelian'
    ).value = hardware.tahun_pembelian;


    document.getElementById(
        'harga'
    ).value = hardware.harga;


    document.getElementById(
        'kondisi'
    ).value = hardware.kondisi;


    /* =====================================================
       BUKA MODAL
    ===================================================== */

    document.getElementById(
        'hardwareFormOverlay'
    ).classList.add('active');

}


/* =========================================================
   TUTUP FORM
========================================================= */

function closeHardwareForm()
{

    document.getElementById(
        'hardwareFormOverlay'
    ).classList.remove('active');

}

</script>

@endpush

@endsection