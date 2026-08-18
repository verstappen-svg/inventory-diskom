<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hardware Management</title>

    <link rel="stylesheet" href="{{ asset('css/hardware.css') }}">
</head>

<body>

    <div class="hardware-page">

        <div class="hardware-header">
            <div>
                <h1>HARDWARE MANAGEMENT</h1>
            </div>

            <div class="hardware-user">
                <button class="notification-btn">
                    🔔
                </button>

                <div class="user-divider"></div>

                <img
                    src="{{ asset('images/profile.jpg') }}"
                    alt="Profile"
                    class="user-avatar"
                >

                <div class="user-info">
                    <strong>Jamaludin</strong>
                    <span>Operator</span>
                </div>
            </div>
        </div>

        
<div class="hardware-page">

    {{-- HEADER --}}
    <div class="hardware-header">
        <div>
            <h1>HARDWARE MANAGEMENT</h1>
        </div>

        <div class="hardware-user">
            <button class="notification-btn" title="Notifikasi">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                    <path d="M18 8C18 5.79 16.21 4 14 4H10C7.79 4 6 5.79 6 8V13L4 16H20L18 13V8Z"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linejoin="round"/>
                    <path d="M10 19C10.4 20.1 11.3 20.7 12 20.7C12.7 20.7 13.6 20.1 14 19"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"/>
                </svg>
            </button>

            <div class="user-divider"></div>

            <img
                src="{{ asset('images/profile.jpg') }}"
                alt="Profile"
                class="user-avatar"
            >

            <div class="user-info">
                <strong>Jamaludin</strong>
                <span>Operator</span>
            </div>
        </div>
    </div>


    {{-- SUMMARY CARDS --}}
    <div class="summary-cards">

        <div class="summary-card">
            <span class="summary-title">Jumlah Barang</span>
            <strong>125</strong>
        </div>

        <div class="summary-card">
            <span class="summary-title">Harga Barang</span>
            <strong>Rp. 12M</strong>
        </div>

        <div class="summary-card warning">
            <span class="summary-title">Perlu Perbaikan</span>
            <strong>75</strong>
        </div>

        <div class="summary-card danger">
            <span class="summary-title">Rusak</span>
            <strong>13</strong>
        </div>

        <div class="summary-card">
            <span class="summary-title">Tersedia</span>
            <strong>37</strong>
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


                <button class="add-btn" type="button">
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
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody id="hardwareTableBody">

                    {{-- DATA 1 --}}
                    <tr>
                        <td>LP-23-001</td>

                        <td>
                            <div class="specification">
                                <strong>MacBook Pro 16"</strong>
                                <small>M1Max, 32GB RAM, 1TB SSD</small>
                            </div>
                        </td>

                        <td>Laptop</td>

                        <td>2023</td>

                        <td>Rp. 8.000.000</td>

                        <td>
                            <span class="condition repair">
                                Perlu<br>Perbaikan
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">
                                <button class="edit-action" title="Edit">
                                     ✎
                                </button>

                                <button class="delete-action" title="Hapus">
                                    ×
                                </button>
                            </div>
                        </td>
                    </tr>


                    {{-- DATA 2 --}}
                    <tr>
                        <td>PR-19-005</td>

                        <td>
                            <div class="specification">
                                <strong>HP LaserJet Pro</strong>
                                <small>M428fdw, Monochrome</small>
                            </div>
                        </td>

                        <td>Printer</td>

                        <td>2019</td>

                        <td>Rp. 24.500.000</td>

                        <td>
                            <span class="condition damaged">
                                Rusak
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">
                                <button class="edit-action" title="Edit">
                                     ✎
                                </button>

                                <button class="delete-action" title="Hapus">
                                    ×
                                </button>
                            </div>
                        </td>
                    </tr>


                    {{-- DATA 3 --}}
                    <tr>
                        <td>PC-20-004</td>

                        <td>
                            <div class="specification">
                                <strong>PC Lenovo ThinkCentre</strong>
                                <small>Neo 50T, i7-12700, 8GB...</small>
                            </div>
                        </td>

                        <td>PC</td>

                        <td>2020</td>

                        <td>Rp. 45.000.000</td>

                        <td>
                            <span class="condition good">
                                Baik
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">
                                <button class="edit-action" title="Edit">
                                     ✎
                                </button>

                                <button class="delete-action" title="Hapus">
                                    ×
                                </button>
                            </div>
                        </td>
                    </tr>


                    {{-- DATA 4 --}}
                    <tr>
                        <td>LP-24-002</td>

                        <td>
                            <div class="specification">
                                <strong>ThinkPad T14 Gen 3</strong>
                                <small>Intel i7-1260P, 16GB RAM, 512GB...</small>
                            </div>
                        </td>

                        <td>Laptop</td>

                        <td>2024</td>

                        <td>Rp. 6.500.000</td>

                        <td>
                            <span class="condition good">
                                Baik
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">
                                <button class="edit-action" title="Edit">
                                     ✎
                                </button>

                                <button class="delete-action" title="Hapus">
                                    ×
                                </button>
                            </div>
                        </td>
                    </tr>

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


{{-- SEARCH SCRIPT --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('hardwareSearch');
    const rows = document.querySelectorAll('#hardwareTableBody tr');

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

});

</script>

    </div>

</body>
</html>