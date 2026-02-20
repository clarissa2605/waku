<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PencairanDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsAppTemplate;
use App\Http\Controllers\Controller;
use App\Jobs\KirimWhatsAppJob;
use App\Models\LogPencairan;


class PencairanDanaController extends Controller
{
    /* =========================================================
     * DAFTAR PENCAIRAN DANA
     * ========================================================= */
    public function index()
    {
        $pencairan = PencairanDana::with('pegawai')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin_pencairan.index', compact('pencairan'));
    }

    /* =========================================================
     * FORM INPUT PENCAIRAN INDIVIDU
     * ========================================================= */
    public function create()
    {
        $pegawai = Pegawai::where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        return view('admin_pencairan.create', compact('pegawai'));
    }

    /* =========================================================
     * SIMPAN PENCAIRAN INDIVIDU
     * ========================================================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id'     => 'required|exists:pegawai,id_pegawai',

            // ✅ TAMBAHAN BANK
            'nama_bank'      => 'required|string|max:100',

            // ✅ TAMBAHAN REKENING
            'nama_rekening'  => 'required|string|max:100',
            'no_rekening'    => 'required|digits_between:8,20',

            'jenis_dana'     => 'required|string|max:100',
            'nominal'        => 'required|numeric|min:1',
            'potongan'       => 'nullable|numeric|min:0',
            'tanggal'        => 'required|date',
            'keterangan'     => 'nullable|string|max:255',
        ], [
            'no_rekening.digits_between' => 'Nomor rekening hanya boleh angka dan minimal 8 digit.',
        ]);

        $pegawai = Pegawai::where('id_pegawai', $validated['pegawai_id'])
            ->where('status', 'aktif')
            ->firstOrFail();

        $nominal  = $validated['nominal'];
        $potongan = $request->input('potongan', 0);
        $bersih   = $nominal - $potongan;

        $pencairan = PencairanDana::create([
            'pegawai_id'     => $pegawai->id_pegawai,

            // ✅ TAMBAHAN BANK
            'nama_bank'      => $validated['nama_bank'],

            // ✅ TAMBAHAN REKENING
            'nama_rekening'  => $validated['nama_rekening'],
            'no_rekening'    => $validated['no_rekening'],

            'jenis_dana'     => $validated['jenis_dana'],
            'nominal'        => $nominal,
            'potongan'       => $potongan,
            'nominal_bersih' => $bersih,
            'tanggal'        => $validated['tanggal'],
            'keterangan'     => $validated['keterangan'] ?? null,
            'status_notifikasi' => 'belum',
        ]);

        // ✅ SIMPAN LOG
        LogPencairan::create([
        'id_pencairan' => $pencairan->id_pencairan,
        'pegawai_id'   => $pencairan->pegawai_id,
        'aksi'         => 'dibuat',
        'deskripsi'    => 'Pencairan dana dibuat oleh admin',
        ]);


        // Generate pesan WA
        $pesanWa = WhatsAppTemplate::pencairanDana($pencairan);
        // logger($pesanWa);

        return redirect()
            ->route('pencairan.index')
            ->with('success', 'Pencairan dana berhasil disimpan');
    }

    /* =========================================================
     * FORM IMPORT CSV
     * ========================================================= */
    public function importForm()
    {
        return view('admin_pencairan.import');
    }

    /* =========================================================
     * PREVIEW IMPORT CSV
     * ========================================================= */
    public function importPreview(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        [$header, $rowsCsv] = $this->readCsv($request);

        $rows = [];

        foreach ($rowsCsv as $row) {

            if (count($header) !== count($row)) {
                continue;
            }

            $data = array_combine($header, $row);

            if (!isset($data['nip']) || trim($data['nip']) === '') {
                continue;
            }

            $nip = trim((string) $data['nip']);

            $pegawai = Pegawai::where('nip', $nip)
                ->where('status', 'aktif')
                ->first();

            $nominal  = (int) preg_replace('/[^0-9]/', '', $data['nominal'] ?? 0);
            $potongan = (int) preg_replace('/[^0-9]/', '', $data['potongan'] ?? 0);

$rows[] = [
    'nip'           => $nip,
    'nama'          => $pegawai->nama ?? '❌ TIDAK DITEMUKAN',
    'tanggal'       => $data['tanggal'] ?? '',
    'jenis_dana'    => $data['jenis_dana'] ?? '',
    'nominal'       => $nominal,
    'potongan'      => $potongan,
    'bersih'        => $nominal - $potongan,

    // ✅ TAMBAHAN BANK & REKENING
    'nama_bank'     => $data['nama_bank'] ?? '',
    'nama_rekening' => $data['nama_rekening'] ?? '',
    'no_rekening'   => preg_replace('/[^0-9]/', '', $data['no_rekening'] ?? ''),

    'keterangan'    => $data['keterangan'] ?? '-',
    'valid'         => $pegawai ? 1 : 0,
];

        }

        return view('admin_pencairan.import_preview', compact('rows'));
    }

/* =========================================================
 * KONFIRMASI & SIMPAN IMPORT
 * ========================================================= */
public function importConfirm(Request $request)
{
    $data = $request->input('data', []);

    DB::beginTransaction();

    try {
        foreach ($data as $item) {

            if (empty($item['valid'])) {
                continue;
            }

            $pegawai = Pegawai::where('nip', trim($item['nip']))
                ->where('status', 'aktif')
                ->first();

            if (!$pegawai) {
                continue;
            }

            $nominal  = (int) $item['nominal'];
            $potongan = (int) ($item['potongan'] ?? 0);

            PencairanDana::create([
                'pegawai_id'     => $pegawai->id_pegawai,

                // ✅ SIMPAN DATA ASLI DARI CSV
                'nama_bank'      => $item['nama_bank'] ?? null,
                'nama_rekening'  => $item['nama_rekening'] ?? null,
                'no_rekening'    => $item['no_rekening'] ?? null,

                'tanggal'        => $item['tanggal'],
                'jenis_dana'     => trim($item['jenis_dana']),
                'nominal'        => $nominal,
                'potongan'       => $potongan,
                'nominal_bersih' => $nominal - $potongan,
                'keterangan'     => $item['keterangan'] ?? null,
                'status_notifikasi' => 'belum',
            ]);
        }

        DB::commit();

        return redirect()
            ->route('pencairan.index')
            ->with('success', 'Import pencairan dana berhasil');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->withErrors([
            'file' => 'Gagal menyimpan data: ' . $e->getMessage(),
        ]);
    }
}


    /* =========================================================
     * PREVIEW PESAN WHATSAPP
     * ========================================================= */
    public function previewPesanWA($id)
    {
        $pencairan = PencairanDana::with('pegawai')->findOrFail($id);

        $pesan = WhatsAppTemplate::pencairanDana($pencairan);

        return view('admin_pencairan.preview_wa', compact('pencairan', 'pesan'));
    }

    /* =========================================================
     * KIRIM NOTIFIKASI WHATSAPP
     * ========================================================= */
    public function kirimWA($id)
{
    $pencairan = PencairanDana::findOrFail($id);

    // Kirim ke queue (background)
    KirimWhatsAppJob::dispatch($pencairan->id_pencairan);

    return back()->with('success', 'Pesan sedang diproses di background.');
}

    private function readCsv(Request $request): array
    {
        $file = fopen($request->file->getRealPath(), 'r');

        $firstLine = fgets($file);
        rewind($file);

        $delimiter = str_contains($firstLine, ';') ? ';' : ',';

        $header = fgetcsv($file, 0, $delimiter);
        $header = array_map(fn($h) => strtolower(trim($h)), $header);

        $rows = [];
        while (($row = fgetcsv($file, 0, $delimiter)) !== false) {
            if (array_filter($row)) {
                $rows[] = $row;
            }
        }

        fclose($file);

        return [$header, $rows];
    }

/* =========================================================
 * RIWAYAT PENCAIRAN UNTUK PEGAWAI
 * ========================================================= */
public function dashboardPegawai()
{
    $user = Auth::user();
    if (!$user->pegawai_id) {
        abort(403, 'Akun tidak terhubung ke data pegawai.');
    }

    $riwayat = PencairanDana::where('pegawai_id', $user->pegawai_id)
        ->orderBy('tanggal', 'desc')
        ->get();

    $totalNominal  = $riwayat->sum('nominal');
    $totalPotongan = $riwayat->sum('potongan');
    $totalBersih   = $riwayat->sum('nominal_bersih');

    return view('pegawai.dashboard', compact(
        'riwayat',
        'totalNominal',
        'totalPotongan',
        'totalBersih'
    ));
}

/* =========================================================
 * DOWNLOAD TEMPLATE CSV
 * ========================================================= */
public function downloadTemplate()
{
    $filename = "template_import_pencairan_dana.csv";

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=\"$filename\"",
    ];

    $columns = [
        'nip',
        'tanggal',
        'jenis_dana',
        'nominal',
        'potongan',
        'nama_bank',
        'nama_rekening',
        'no_rekening',
        'keterangan'
    ];

    $callback = function () use ($columns) {
        $file = fopen('php://output', 'w');

        // Header CSV
        fputcsv($file, $columns, ';');

        // Contoh 1 baris dummy
        fputcsv($file, [
            '123456789012345678',
            '2024-07-01',
            'Tunjangan Kinerja',
            '5000000',
            '0',
            'BRI',
            'JOHN DOE',
            '1234567890',
            'Tunjangan bulan Juli'
        ], ';');

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function dashboardViewer()
{
    // ===============================
    // RINGKASAN TOTAL
    // ===============================
    $totalDana      = PencairanDana::sum('nominal');
    $totalPotongan  = PencairanDana::sum('potongan');
    $totalDiterima  = PencairanDana::sum('nominal_bersih');
    $totalTransaksi = PencairanDana::count();

    // ===============================
    // GRAFIK PER BULAN (LINE)
    // ===============================
    $perBulan = PencairanDana::selectRaw("
        DATE_FORMAT(tanggal, '%Y-%m') as bulan,
        SUM(nominal_bersih) as total
    ")
    ->groupBy('bulan')
    ->orderBy('bulan')
    ->get();

    // ===============================
    // GRAFIK JENIS DANA (PIE)
    // ===============================
    $perJenis = PencairanDana::selectRaw("
        jenis_dana,
        SUM(nominal_bersih) as total
    ")
    ->groupBy('jenis_dana')
    ->get();

    // ===============================
    // STATUS NOTIFIKASI (DONUT)
    // ===============================
    $statusNotif = PencairanDana::selectRaw("
        status_notifikasi,
        COUNT(*) as total
    ")
    ->groupBy('status_notifikasi')
    ->get();

    return view('viewer.dashboard', compact(
        'totalDana',
        'totalPotongan',
        'totalDiterima',
        'totalTransaksi',
        'perBulan',
        'perJenis',
        'statusNotif'
    ));
}
}
