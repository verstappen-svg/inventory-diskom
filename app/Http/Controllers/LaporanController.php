<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hardware;
use App\Models\Software;
use App\Models\Jaringan;
use App\Models\DataCenter;
use App\Models\Splp;
use App\Models\Data;
use App\Models\SDM;

class LaporanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $jenis  = $request->get('jenis');
        $tahun  = $request->get('tahun');
        $bulan  = $request->get('bulan');
        $status = $request->get('status');
        $search = $request->get('search');


        /*
        |--------------------------------------------------------------------------
        | HASIL DATA
        |--------------------------------------------------------------------------
        */

        $hasil = collect();


        /*
        |--------------------------------------------------------------------------
        | HARDWARE
        |--------------------------------------------------------------------------
        */

        if ($jenis === 'hardware') {

            $query = Hardware::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
                });
            }

            if ($tahun) {
                $query->whereYear('tanggal_pengadaan', $tahun);
            }

            if ($bulan) {
                $query->whereMonth('tanggal_pengadaan', $bulan);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $hasil = $query
                ->orderByDesc('created_at')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | SOFTWARE
        |--------------------------------------------------------------------------
        */

        elseif ($jenis === 'software') {

            $query = Software::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_software', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
                });
            }

            if ($tahun) {
                $query->whereYear('tanggal_pengadaan', $tahun);
            }

            if ($bulan) {
                $query->whereMonth('tanggal_pengadaan', $bulan);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $hasil = $query
                ->orderByDesc('created_at')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | JARINGAN
        |--------------------------------------------------------------------------
        */

        elseif ($jenis === 'jaringan') {

            $query = Jaringan::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_infrastruktur', 'like', "%{$search}%")
                      ->orWhere('pengadaan', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
                });
            }

            if ($tahun) {
                $query->whereYear('tanggal_pengadaan', $tahun);
            }

            if ($bulan) {
                $query->whereMonth('tanggal_pengadaan', $bulan);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $hasil = $query
                ->orderByDesc('created_at')
                ->get();


            /*
            |--------------------------------------------------------------------------
            | STATUS OTOMATIS JARINGAN
            |--------------------------------------------------------------------------
            */

            foreach ($hasil as $jaringan) {

                if (
                    $jaringan->pengadaan === 'Sewa' &&
                    $jaringan->tanggal_berakhir
                ) {

                    $tanggalBerakhir = \Carbon\Carbon::parse(
                        $jaringan->tanggal_berakhir
                    );

                    $today = \Carbon\Carbon::today();

                    if ($tanggalBerakhir->lt($today)) {

                        $jaringan->status_laporan = 'Expired';

                    } elseif (
                        $tanggalBerakhir->lte(
                            $today->copy()->addDays(30)
                        )
                    ) {

                        $jaringan->status_laporan = 'Akan Habis';

                    } else {

                        $jaringan->status_laporan = 'Digunakan';
                    }

                } else {

                    $jaringan->status_laporan =
                        $jaringan->status ?? 'Tersedia';
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | DATA CENTER
        |--------------------------------------------------------------------------
        */

        elseif ($jenis === 'data-center') {

            $query = DataCenter::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_infrastruktur', 'like', "%{$search}%")
                      ->orWhere('pengadaan', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
                });
            }

            if ($tahun) {
                $query->whereYear('tanggal_pengadaan', $tahun);
            }

            if ($bulan) {
                $query->whereMonth('tanggal_pengadaan', $bulan);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $hasil = $query
                ->orderByDesc('created_at')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | SPLP
        |--------------------------------------------------------------------------
        */

        elseif ($jenis === 'splp') {

            $query = Splp::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_infrastruktur', 'like', "%{$search}%")
                      ->orWhere('pengadaan', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
                });
            }

            if ($tahun) {
                $query->whereYear('tanggal_pengadaan', $tahun);
            }

            if ($bulan) {
                $query->whereMonth('tanggal_pengadaan', $bulan);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $hasil = $query
                ->orderByDesc('created_at')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        elseif ($jenis === 'data') {

            $query = Data::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_dataset', 'like', "%{$search}%")
                      ->orWhere('jenis_data', 'like', "%{$search}%")
                      ->orWhere('verifikasi', 'like', "%{$search}%");
                });
            }

            if ($tahun) {
                $query->where('tahun', $tahun);
            }

            if ($status) {
                $query->where('verifikasi', $status);
            }

            $hasil = $query
                ->orderByDesc('created_at')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | SDM
        |--------------------------------------------------------------------------
        */

        elseif ($jenis === 'sdm') {

            $query = SDM::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
                });
            }

            if ($tahun) {
                $query->whereYear('created_at', $tahun);
            }

            if ($bulan) {
                $query->whereMonth('created_at', $bulan);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $hasil = $query
                ->orderByDesc('created_at')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | DATA TAHUN
        |--------------------------------------------------------------------------
        */

        $tahunList = collect();


        /*
        |--------------------------------------------------------------------------
        | HARDWARE
        |--------------------------------------------------------------------------
        */

        try {

            $tahunList = $tahunList->merge(
                Hardware::query()
                    ->whereNotNull('tanggal_pengadaan')
                    ->get()
                    ->map(function ($item) {

                        return \Carbon\Carbon::parse(
                            $item->tanggal_pengadaan
                        )->format('Y');

                    })
            );

        } catch (\Throwable $e) {
            // Lewati jika kolom belum tersedia
        }


        /*
        |--------------------------------------------------------------------------
        | SOFTWARE
        |--------------------------------------------------------------------------
        */

        try {

            $tahunList = $tahunList->merge(
                Software::query()
                    ->whereNotNull('tanggal_pengadaan')
                    ->get()
                    ->map(function ($item) {

                        return \Carbon\Carbon::parse(
                            $item->tanggal_pengadaan
                        )->format('Y');

                    })
            );

        } catch (\Throwable $e) {
            // Lewati jika kolom belum tersedia
        }


        /*
        |--------------------------------------------------------------------------
        | JARINGAN
        |--------------------------------------------------------------------------
        */

        try {

            $tahunList = $tahunList->merge(
                Jaringan::query()
                    ->whereNotNull('tanggal_pengadaan')
                    ->get()
                    ->map(function ($item) {

                        return \Carbon\Carbon::parse(
                            $item->tanggal_pengadaan
                        )->format('Y');

                    })
            );

        } catch (\Throwable $e) {
            // Lewati jika kolom belum tersedia
        }


        /*
        |--------------------------------------------------------------------------
        | DATA CENTER
        |--------------------------------------------------------------------------
        */

        try {

            $tahunList = $tahunList->merge(
                DataCenter::query()
                    ->whereNotNull('tanggal_pengadaan')
                    ->get()
                    ->map(function ($item) {

                        return \Carbon\Carbon::parse(
                            $item->tanggal_pengadaan
                        )->format('Y');

                    })
            );

        } catch (\Throwable $e) {
            // Lewati jika kolom belum tersedia
        }


        /*
        |--------------------------------------------------------------------------
        | SPLP
        |--------------------------------------------------------------------------
        */

        try {

            $tahunList = $tahunList->merge(
                Splp::query()
                    ->whereNotNull('tanggal_pengadaan')
                    ->get()
                    ->map(function ($item) {

                        return \Carbon\Carbon::parse(
                            $item->tanggal_pengadaan
                        )->format('Y');

                    })
            );

        } catch (\Throwable $e) {
            // Lewati jika kolom belum tersedia
        }


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        try {

            $tahunList = $tahunList->merge(
                Data::query()
                    ->whereNotNull('tahun')
                    ->pluck('tahun')
            );

        } catch (\Throwable $e) {
            // Lewati jika kolom belum tersedia
        }


        /*
        |--------------------------------------------------------------------------
        | SDM
        |--------------------------------------------------------------------------
        */

        try {

            $tahunList = $tahunList->merge(
                SDM::query()
                    ->whereNotNull('created_at')
                    ->get()
                    ->map(function ($item) {

                        return \Carbon\Carbon::parse(
                            $item->created_at
                        )->format('Y');

                    })
            );

        } catch (\Throwable $e) {
            // Lewati jika kolom belum tersedia
        }


        /*
        |--------------------------------------------------------------------------
        | HASIL TAHUN
        |--------------------------------------------------------------------------
        */

        $tahunList = $tahunList
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | KIRIM KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'laporan.index',
            compact(
                'hasil',
                'jenis',
                'tahun',
                'bulan',
                'status',
                'search',
                'tahunList'
            )
        );
    }
}
