<?php

namespace App\Http\Controllers;

use App\Models\PencairanDana;
use App\Models\Pegawai;
use App\Models\Mitra;
use App\Models\PencairanDanaMitra;



class ViewerController extends Controller
{

    public function dashboard()
    {
        $totalPegawai = Pegawai::count();

        $totalMitra = Mitra::count();

        $totalDanaPegawai = PencairanDana::whereNotNull('pegawai_id')
                ->sum('nominal_bersih');

        $totalDanaMitra = PencairanDanaMitra::whereNotNull('mitra_id')
                ->sum('nominal_bersih');

        $distribusiDana = [
            'pegawai' => $totalDanaPegawai,
            'mitra' => $totalDanaMitra
        ];

        // KPI
        $totalTransaksi = PencairanDana::count();

        $totalDana = PencairanDana::sum('nominal');

        $totalPotongan = PencairanDana::sum('potongan');

        $totalDiterima = PencairanDana::sum('nominal_bersih');


        // Dana Bulan Ini
        $danaBulanIni = PencairanDana::whereMonth('tanggal', now()->month)
                        ->sum('nominal_bersih');

        // Dana Tahun Ini
        $danaTahunIni = PencairanDana::whereYear('tanggal', now()->year)
                        ->sum('nominal_bersih');


        // Tren Dana per Bulan
        $perBulan = PencairanDana::selectRaw("
            MONTH(tanggal) as bulan,
            MONTHNAME(tanggal) as nama_bulan,
            SUM(nominal_bersih) as total
        ")
        ->groupByRaw("MONTH(tanggal), MONTHNAME(tanggal)")
        ->orderByRaw("MONTH(tanggal)")
        ->get();


        // Distribusi Jenis Dana
        $perJenis = PencairanDana::selectRaw("
            jenis_dana,
            SUM(nominal_bersih) as total
        ")
        ->groupBy('jenis_dana')
        ->get();


        // Status Notifikasi
        $statusNotif = PencairanDana::selectRaw("
            status_notifikasi,
            COUNT(*) as total
        ")
        ->groupBy('status_notifikasi')
        ->get();


        // Top 10 Pencairan
        $topPencairan = PencairanDana::orderByDesc('nominal_bersih')
                        ->limit(10)
                        ->get();
        
        $perUnit = PencairanDana::join('pegawai', 'pencairan_dana.pegawai_id', '=', 'pegawai.id_pegawai')
            ->selectRaw("
                pegawai.unit_kerja,
                SUM(pencairan_dana.nominal_bersih) as total
            ")
            ->groupBy('pegawai.unit_kerja')
            ->get();


        return view('viewer.dashboard', compact(
    'totalTransaksi',
    'totalDana',
    'totalPotongan',
    'totalDiterima',
    'perBulan',
    'perJenis',
    'statusNotif',
    'topPencairan',
    'perUnit',
    'totalPegawai',
    'totalMitra',
    'totalDanaPegawai',
    'totalDanaMitra',
    'distribusiDana'
));
    }
}