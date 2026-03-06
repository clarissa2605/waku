<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

public function index(Request $request)
{

    // =========================
    // FILTER BULAN & TAHUN
    // =========================

    $bulan = $request->bulan ?? date('m');
    $tahun = $request->tahun ?? date('Y');


    /*
    |---------------------------------
    | DATA PENCAIRAN PEGAWAI
    |---------------------------------
    */

    $pegawai = DB::table('pencairan_dana')
        ->join('pegawai','pegawai.id_pegawai','=','pencairan_dana.pegawai_id')
        ->whereMonth('pencairan_dana.tanggal',$bulan)
        ->whereYear('pencairan_dana.tanggal',$tahun)
        ->select(
            'pencairan_dana.tanggal',
            'pegawai.nama as nama_penerima',
            'pencairan_dana.jenis_dana',
            'pencairan_dana.nominal_bersih as total_diterima',
            'pencairan_dana.status_notifikasi as status_wa',
            'pencairan_dana.created_at'
        )
        ->get()
        ->map(function($item){

            $item->tipe = 'Pegawai';
            return $item;

        });



    /*
    |---------------------------------
    | DATA PENCAIRAN MITRA
    |---------------------------------
    */

    $mitra = DB::table('pencairan_dana_mitra')
        ->join('mitra','mitra.id_mitra','=','pencairan_dana_mitra.mitra_id')
        ->whereMonth('pencairan_dana_mitra.tanggal',$bulan)
        ->whereYear('pencairan_dana_mitra.tanggal',$tahun)
        ->select(
            'pencairan_dana_mitra.tanggal',
            'mitra.nama_mitra as nama_penerima',
            'pencairan_dana_mitra.jenis_dana',
            'pencairan_dana_mitra.nominal_bersih as total_diterima',
            'pencairan_dana_mitra.status_notifikasi as status_wa',
            'pencairan_dana_mitra.created_at'
        )
        ->get()
        ->map(function($item){

            $item->tipe = 'Mitra';
            return $item;

        });



    /*
    |---------------------------------
    | GABUNGKAN DATA
    |---------------------------------
    */

    $pencairans = $pegawai
        ->merge($mitra)
        ->sortByDesc('created_at')
        ->values();



    /*
    |---------------------------------
    | STATISTIK
    |---------------------------------
    */

    $totalPencairan = $pencairans->count();

    $totalDana = $pencairans->sum('total_diterima');

    $waTerkirim = $pencairans->where('status_wa','terkirim')->count();

    $waGagal = $pencairans->where('status_wa','gagal')->count();



    return view('admin.laporan.index', compact(
        'pencairans',
        'totalPencairan',
        'totalDana',
        'waTerkirim',
        'waGagal',
        'bulan',
        'tahun'
    ));

}



    // =========================
    // EXPORT PDF
    // =========================

    public function exportPdf(Request $request)
    {

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');


        $pegawai = DB::table('pencairan_dana')
            ->join('pegawai','pegawai.id_pegawai','=','pencairan_dana.pegawai_id')
            ->whereMonth('pencairan_dana.tanggal',$bulan)
            ->whereYear('pencairan_dana.tanggal',$tahun)
            ->select(
                'pencairan_dana.tanggal',
                'pegawai.nama as nama_penerima',
                'pencairan_dana.jenis_dana',
                'pencairan_dana.nominal_bersih as total_diterima',
                'pencairan_dana.status_notifikasi as status_wa',
                'pencairan_dana.created_at'
            )
            ->get()
            ->map(function ($item) {

                $item->tipe = 'Pegawai';
                return $item;

            });



        $mitra = DB::table('pencairan_dana_mitra')
            ->join('mitra','mitra.id_mitra','=','pencairan_dana_mitra.mitra_id')
            ->whereMonth('pencairan_dana_mitra.tanggal',$bulan)
            ->whereYear('pencairan_dana_mitra.tanggal',$tahun)
            ->select(
                'pencairan_dana_mitra.tanggal',
                'mitra.nama_mitra as nama_penerima',
                'pencairan_dana_mitra.jenis_dana',
                'pencairan_dana_mitra.nominal_bersih as total_diterima',
                'pencairan_dana_mitra.status_notifikasi as status_wa',
                'pencairan_dana_mitra.created_at'
            )
            ->get()
            ->map(function ($item) {

                $item->tipe = 'Mitra';
                return $item;

            });



        $pencairans = $pegawai
                        ->merge($mitra)
                        ->sortByDesc('created_at')
                        ->values();



        $totalPencairan = $pencairans->count();

        $totalDana = $pencairans->sum('total_diterima');

        $waTerkirim = $pencairans->where('status_wa','terkirim')->count();

        $waGagal = $pencairans->where('status_wa','gagal')->count();



        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'pencairans',
            'totalPencairan',
            'totalDana',
            'waTerkirim',
            'waGagal',
            'bulan',
            'tahun'
        ));


        return $pdf->download('laporan-waku-'.$bulan.'-'.$tahun.'.pdf');
    }

}