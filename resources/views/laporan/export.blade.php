{{-- resources/views/laporan/export.blade.php --}}

<table>

    @foreach($hasil as $jenisHasil => $rows)

        @php
            $kolomJenis = $kolom[$jenisHasil] ?? [];
            $labelJenis = $jenisLabel[$jenisHasil] ?? $jenisHasil;
            $labelKolom = $kolomDiizinkan[$jenisHasil] ?? [];

            $jumlahKolom = max(count($kolomJenis), 1);
        @endphp


        {{-- =====================================================
            KOP SEDERHANA
        ====================================================== --}}

        <tr>
            <td colspan="{{ $jumlahKolom }}"
                style="
                    text-align: center;
                    font-size: 16px;
                    font-weight: bold;
                ">
                PEMERINTAH KOTA BEKASI
            </td>
        </tr>

        <tr>
            <td colspan="{{ $jumlahKolom }}"
                style="
                    text-align: center;
                    font-size: 18px;
                    font-weight: bold;
                ">
                DINAS KOMUNIKASI, INFORMATIKA, STATISTIK
            </td>
        </tr>

        <tr>
            <td colspan="{{ $jumlahKolom }}"
                style="
                    text-align: center;
                    font-size: 18px;
                    font-weight: bold;
                ">
                DAN PERSANDIAN
            </td>
        </tr>

        <tr>
            <td colspan="{{ $jumlahKolom }}"
                style="
                    text-align: center;
                    font-size: 11px;
                ">
                Pemerintah Kota Bekasi
            </td>
        </tr>

        {{-- Garis bawah kop --}}
        <tr>
            <td colspan="{{ $jumlahKolom }}"
                style="
                    border-bottom: 2px solid #000000;
                ">
            </td>
        </tr>

        {{-- Jarak --}}
        <tr>
            <td colspan="{{ $jumlahKolom }}"></td>
        </tr>


        {{-- =====================================================
            JUDUL LAPORAN
        ====================================================== --}}

        <tr>
            <td colspan="{{ $jumlahKolom }}"
                style="
                    text-align: center;
                    font-size: 15px;
                    font-weight: bold;
                ">
                LAPORAN
            </td>
        </tr>

        <tr>
            <td colspan="{{ $jumlahKolom }}"
                style="
                    text-align: center;
                    font-size: 15px;
                    font-weight: bold;
                ">
                DATA {{ strtoupper($labelJenis) }}
            </td>
        </tr>

        <tr>
            <td colspan="{{ $jumlahKolom }}"
                style="
                    text-align: center;
                    font-size: 15px;
                    font-weight: bold;
                ">
                INVENTORY IT ASSETS
            </td>
        </tr>

        <tr>
            <td colspan="{{ $jumlahKolom }}"></td>
        </tr>


        {{-- =====================================================
            HEADER TABEL
        ====================================================== --}}

        <tr>
            @foreach($kolomJenis as $key)

                <th style="
                    font-weight: bold;
                    text-align: center;
                    background-color: #D9EAF7;
                    border: 1px solid #000000;
                ">
                    {{ $labelKolom[$key] ?? $key }}
                </th>

            @endforeach
        </tr>


        {{-- =====================================================
            DATA
        ====================================================== --}}

        @forelse($rows as $row)

            <tr>

                @foreach($kolomJenis as $key)

                    @php
                        $value = data_get($row, $key);

                        /*
                         * =================================================
                         * FORMAT TANGGAL DAN WAKTU
                         * =================================================
                         */

                        if (
                            $value !== null &&
                            $value !== '' &&
                            in_array($key, [
                                'created_at',
                                'updated_at',
                                'tanggal_pengadaan',
                                'tanggal_berakhir',
                                'tanggal_pengajuan',
                                'masa_berlaku',
                            ])
                        ) {

                            try {

                                $rawValue = $value instanceof \Carbon\Carbon
                                    ? $value->toIso8601String()
                                    : (string) $value;

                                $date = \Carbon\Carbon::parse($value);


                                /*
                                 * Field DATE ONLY
                                 */
                                if (
                                    in_array($key, [
                                        'tanggal_pengadaan',
                                        'tanggal_berakhir',
                                        'tanggal_pengajuan',
                                    ])
                                ) {

                                    $value = $date
                                        ->locale('id')
                                        ->translatedFormat('d F Y');

                                }


                                /*
                                 * created_at dan updated_at
                                 * selalu tanggal + waktu
                                 *
                                 * masa_berlaku:
                                 * jika memiliki waktu -> tanggal + waktu
                                 * jika hanya tanggal -> tanggal saja
                                 */
                                elseif (
                                    in_array($key, [
                                        'created_at',
                                        'updated_at',
                                    ]) ||
                                    preg_match(
                                        '/(?:T|\s)\d{2}:\d{2}/',
                                        $rawValue
                                    )
                                ) {

                                    $value = $date
                                        ->locale('id')
                                        ->translatedFormat('d F Y, H:i');

                                }


                                /*
                                 * Field DATE ONLY lainnya
                                 */
                                else {

                                    $value = $date
                                        ->locale('id')
                                        ->translatedFormat('d F Y');

                                }

                            } catch (\Throwable $e) {

                                // Jika gagal parse, gunakan nilai asli.

                            }

                        }


                        /*
                         * =================================================
                         * ARRAY / OBJECT
                         * =================================================
                         */

                        if (is_array($value) || is_object($value)) {

                            $value = json_encode(
                                $value,
                                JSON_UNESCAPED_UNICODE
                            );

                        }
                    @endphp

                    <td style="
                        border: 1px solid #000000;
                    ">
                        {{ $value ?? '-' }}
                    </td>

                @endforeach

            </tr>

        @empty

            <tr>
                <td colspan="{{ $jumlahKolom }}"
                    style="
                        border: 1px solid #000000;
                        text-align: center;
                    ">
                    Tidak ada data.
                </td>
            </tr>

        @endforelse

    @endforeach


    {{-- =========================================================
        INFORMASI CETAK
    ========================================================== --}}

    <tr>
        <td colspan="{{ $jumlahKolom }}">
        </td>
    </tr>

    <tr>
        <td colspan="{{ $jumlahKolom }}">
            Dicetak pada tanggal
            {{ now()->format('d-m-Y H:i:s') }}
            oleh
            {{ auth()->user()->username ?? auth()->user()->name ?? '-' }}
        </td>
    </tr>

</table>