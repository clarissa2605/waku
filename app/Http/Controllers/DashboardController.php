<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Mitra;
use App\Models\KelompokMitra;
use App\Models\PencairanDana;
use App\Models\LogNotifikasi;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {

        // Statistik utama
        $totalPegawai = Pegawai::count();
        $totalMitra = Mitra::count();
        $totalKelompok = KelompokMitra::count();

        $totalPencairan = PencairanDana::sum('nominal');

        // Statistik WhatsApp
        $waSuccess = LogNotifikasi::where('status', 'success')->count();
        $waError = LogNotifikasi::where('status', 'error')->count();
        $waPending = LogNotifikasi::where('status', 'pending')->count();

        // Pencairan terbaru
        $latest = PencairanDana::with('pegawai')
            ->latest()
            ->limit(5)
            ->get();

        // ================= GRAFIK PENCAIRAN PER BULAN =================

        $grafikPencairan = PencairanDana::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('SUM(nominal) as total')
        )
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        $bulan = [];
        $totalPencairanBulanan = [];

        foreach ($grafikPencairan as $item) {

            $bulan[] = date('M', mktime(0,0,0,$item->bulan,1));
            $totalPencairanBulanan[] = $item->total;

}
// ================= GRAFIK PENCAIRAN PER TAHUN =================

$grafikTahunan = PencairanDana::select(
    DB::raw('YEAR(created_at) as tahun'),
    DB::raw('SUM(nominal) as total')
)
->groupBy('tahun')
->orderBy('tahun')
->get();

$tahun = [];
$totalPencairanTahunan = [];

foreach ($grafikTahunan as $item) {

    $tahun[] = $item->tahun;
    $totalPencairanTahunan[] = $item->total;

}

       return view('admin.dashboard', compact(
    'totalPegawai',
    'totalMitra',
    'totalKelompok',
    'totalPencairan',
    'waSuccess',
    'waError',
    'waPending',
    'latest',
    'bulan',
    'totalPencairanBulanan',
    'tahun',
    'totalPencairanTahunan'
));
}

            
}