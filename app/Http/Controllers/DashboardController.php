<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Mitra;
use App\Models\KelompokMitra;
use App\Models\PencairanDana;
use App\Models\LogNotifikasi;
use App\Models\PencairanDanaMitra;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{
    public function index()
    {

        // Statistik utama
        $totalPegawai = Pegawai::count();
        $totalMitra = Mitra::count();
        $totalKelompok = KelompokMitra::count();

        $totalPegawaiDana = PencairanDana::sum('nominal');
        $totalMitraDana   = PencairanDanaMitra::sum('nominal');

        $totalPencairan = $totalPegawaiDana + $totalMitraDana;

        // Statistik WhatsApp
        $waSuccess = LogNotifikasi::where('status', 'success')->count();
        $waError = LogNotifikasi::where('status', 'error')->count();
        $waPending = LogNotifikasi::where('status', 'pending')->count();

        // Pencairan terbaru
        $latestPegawai = PencairanDana::with('pegawai')
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        $latestMitra = PencairanDanaMitra::with('mitra')
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        $latest = $latestPegawai
            ->merge($latestMitra)
            ->sortByDesc('tanggal')
            ->take(5);

        

        // ================= GRAFIK PENCAIRAN PER BULAN =================

$pegawaiBulanan = PencairanDana::select(
    DB::raw('MONTH(created_at) as bulan'),
    DB::raw('SUM(nominal) as total')
)
->groupBy('bulan')
->pluck('total','bulan');

$mitraBulanan = PencairanDanaMitra::select(
    DB::raw('MONTH(created_at) as bulan'),
    DB::raw('SUM(nominal) as total')
)
->groupBy('bulan')
->pluck('total','bulan');

$bulan = [];
$totalPencairanBulanan = [];

for ($i = 1; $i <= 12; $i++) {

    $bulan[] = date('M', mktime(0,0,0,$i,1));

    $pegawai = $pegawaiBulanan[$i] ?? 0;
    $mitra   = $mitraBulanan[$i] ?? 0;

    $totalPencairanBulanan[] = $pegawai + $mitra;
}
// ================= GRAFIK PENCAIRAN PER TAHUN =================

$pegawaiTahunan = PencairanDana::select(
    DB::raw('YEAR(created_at) as tahun'),
    DB::raw('SUM(nominal) as total')
)
->groupBy('tahun')
->pluck('total','tahun');

$mitraTahunan = PencairanDanaMitra::select(
    DB::raw('YEAR(created_at) as tahun'),
    DB::raw('SUM(nominal) as total')
)
->groupBy('tahun')
->pluck('total','tahun');

$tahun = [];
$totalPencairanTahunan = [];

$years = array_unique(array_merge(
    array_keys($pegawaiTahunan->toArray()),
    array_keys($mitraTahunan->toArray())
));

sort($years);

foreach ($years as $y) {

    $tahun[] = $y;

    $pegawai = $pegawaiTahunan[$y] ?? 0;
    $mitra   = $mitraTahunan[$y] ?? 0;

    $totalPencairanTahunan[] = $pegawai + $mitra;
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