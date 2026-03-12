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
use App\Models\PencairanDanaMitra;
use App\Helpers\LogHelper;


class PencairanDanaController extends Controller
{
    /* =========================================================
     * DAFTAR PENCAIRAN DANA
     * ========================================================= */
public function index(Request $request)
{
    $mode = $request->mode ?? 'pegawai';

    if ($mode === 'mitra') {

        $query = PencairanDanaMitra::with(['mitra.kelompok']);

        // filter kelompok hanya untuk mitra
        if ($request->kelompok) {
            $query->where('kelompok_id', $request->kelompok);
        }

    } else {

        $query = PencairanDana::with('pegawai');
    }

    // filter status
    if ($request->status) {
        $query->where('status_notifikasi', $request->status);
    }

    // search
    if ($request->search) {
        $query->where(function ($q) use ($request, $mode) {

            if ($mode === 'mitra') {
                $q->whereHas('mitra', function ($sub) use ($request) {
                    $sub->where('nama_mitra', 'like', '%' . $request->search . '%')
                        ->orWhere('nik', 'like', '%' . $request->search . '%');
                });
            } else {
                $q->whereHas('pegawai', function ($sub) use ($request) {
                    $sub->where('nama', 'like', '%' . $request->search . '%')
                        ->orWhere('nip', 'like', '%' . $request->search . '%');
                });
            }

        });
    }

    $pencairan = $query->orderBy('tanggal', 'desc')->get();

    $kelompokList = \App\Models\KelompokMitra::orderBy('nama_kelompok')->get();

    return view('admin_pencairan.index', compact(
        'pencairan',
        'mode',
        'kelompokList'
    ));
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

        LogHelper::simpan(
    'Input Pencairan Dana',
    'Pencairan Pegawai',
    'Pencairan dana untuk '.$pegawai->nama.' sebesar Rp '.number_format($nominal,0,',','.')
);

        // Generate pesan WA
        $pesanWa = WhatsAppTemplate::pencairanDana($pencairan);
        // logger($pesanWa);

        return redirect()
    ->route('pencairan.create')
    ->with('success', 'Detail pencairan dana sudah tersimpan. Silahkan lihat di halaman Riwayat Pencairan.');
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
        'mode' => 'required|in:pegawai,mitra',
        'file' => 'required|file|mimes:csv,txt|max:2048',
    ]);

    $mode = $request->mode;

    [$header, $rowsCsv] = $this->readCsv($request);

    $rows = [];

    foreach ($rowsCsv as $row) {

        if (count($header) !== count($row)) {
            continue;
        }

        $data = array_combine($header, $row);

        $identifier = trim((string) ($data['nip'] ?? $data['nik'] ?? ''));

        if ($identifier === '') {
            continue;
        }

        $nominal  = (int) preg_replace('/[^0-9]/', '', $data['nominal'] ?? 0);
        $potongan = (int) preg_replace('/[^0-9]/', '', $data['potongan'] ?? 0);

        $valid = false;
        $nama  = '';

        if ($mode === 'pegawai') {

            $pegawai = Pegawai::where('nip', $identifier)
                ->where('status', 'aktif')
                ->first();

            $valid = $pegawai ? true : false;
            $nama  = $pegawai->nama ?? '❌ TIDAK DITEMUKAN';

        } else {

            $kelompok_id = $data['kelompok_id'] ?? null;

            $mitra = \App\Models\Mitra::where('nik', $identifier)
                ->where('status', 'aktif')
                ->first();

            if ($mitra && $kelompok_id) {
                $validKelompok = $mitra->kelompok()
                    ->where('id_kelompok', $kelompok_id)
                    ->exists();

                $valid = $validKelompok;
                $nama  = $mitra->nama_mitra;
            } else {
                $nama = '❌ MITRA / KELOMPOK TIDAK VALID';
            }
        }

        $rows[] = [
            'identifier'    => $identifier,
            'nama'          => $nama,
            'tanggal'       => $data['tanggal'] ?? '',
            'jenis_dana'    => $data['jenis_dana'] ?? '',
            'nominal'       => $nominal,
            'potongan'      => $potongan,
            'bersih'        => $nominal - $potongan,
            'nama_bank'     => $data['nama_bank'] ?? '',
            'nama_rekening' => $data['nama_rekening'] ?? '',
            'no_rekening'   => preg_replace('/[^0-9]/', '', $data['no_rekening'] ?? ''),
            'keterangan'    => $data['keterangan'] ?? '-',
            'valid'         => $valid ? 1 : 0,
        ];
    }

    return view('admin_pencairan.import_preview', compact('rows', 'mode'));
}

/* =========================================================
 * KONFIRMASI & SIMPAN IMPORT
 * ========================================================= */
public function importConfirm(Request $request)
{
    $data = $request->input('data', []);
    $mode = $request->input('mode');

    DB::beginTransaction();

    try {

        foreach ($data as $item) {

            if (empty($item['valid'])) {
                continue;
            }

            $nominal  = (int) $item['nominal'];
            $potongan = (int) ($item['potongan'] ?? 0);
            $bersih   = $nominal - $potongan;

            if ($mode === 'pegawai') {

                $pegawai = Pegawai::where('nip', trim($item['identifier']))
                    ->where('status', 'aktif')
                    ->first();

                if (!$pegawai) {
                    continue;
                }

                PencairanDana::create([
                    'pegawai_id'     => $pegawai->id_pegawai,
                    'nama_bank'      => $item['nama_bank'] ?? null,
                    'nama_rekening'  => $item['nama_rekening'] ?? null,
                    'no_rekening'    => $item['no_rekening'] ?? null,
                    'tanggal'        => $item['tanggal'],
                    'jenis_dana'     => trim($item['jenis_dana']),
                    'nominal'        => $nominal,
                    'potongan'       => $potongan,
                    'nominal_bersih' => $bersih,
                    'keterangan'     => $item['keterangan'] ?? null,
                    'status_notifikasi' => 'belum',
                ]);

            } else {

                $mitra = \App\Models\Mitra::where('nik', trim($item['identifier']))
                    ->where('status', 'aktif')
                    ->first();

                if (!$mitra) {
                    continue;
                }

                PencairanDanaMitra::create([
                    'mitra_id'       => $mitra->id_mitra,
                    'kelompok_id'    => $item['kelompok_id'] ?? null,
                    'nama_bank'      => $item['nama_bank'] ?? null,
                    'nama_rekening'  => $item['nama_rekening'] ?? null,
                    'no_rekening'    => $item['no_rekening'] ?? null,
                    'tanggal'        => $item['tanggal'],
                    'jenis_dana'     => trim($item['jenis_dana']),
                    'nominal'        => $nominal,
                    'potongan'       => $potongan,
                    'nominal_bersih' => $bersih,
                    'keterangan'     => $item['keterangan'] ?? null,
                    'status_notifikasi' => 'belum',
                ]);
            }
        }

        DB::commit();

            LogHelper::simpan(
            'Import Pencairan Dana',
            'Pencairan',
            'Admin melakukan import pencairan dana via CSV'
        );

        return redirect()
        ->route('pencairan.import.form')
        ->with('success', 'Pencairan dana massal berhasil diimport. Silakan lihat pada halaman Riwayat Pencairan.');

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
       // 🔹 TAMBAHAN: cek apakah data milik mitra
    $pencairanMitra = PencairanDanaMitra::find($id);

    if ($pencairanMitra) {

        if (in_array($pencairanMitra->status_notifikasi, ['belum', 'gagal'])) {

            $pencairanMitra->update([
                'status_notifikasi' => 'diproses'
            ]);

            KirimWhatsAppJob::dispatch($pencairanMitra->id_pencairan);

            LogHelper::simpan(
                'Kirim Notifikasi WA',
                'Notifikasi',
                'Notifikasi pencairan mitra dikirim'
            );

            return back()->with('success', 'Pesan dimasukkan ke antrian.');
        }

        return back()->with('error', 'Pesan tidak bisa dikirim ulang.');
    }
    $pencairan = PencairanDana::findOrFail($id);

    if (in_array($pencairan->status_notifikasi, ['belum', 'gagal'])) {

        // 🔥 ubah status jadi antrian dulu
        $pencairan->update([
            'status_notifikasi' => 'diproses'
        ]);

        KirimWhatsAppJob::dispatch($pencairan->id_pencairan);

        LogHelper::simpan(
    'Kirim Notifikasi WA',
    'Notifikasi',
    'Notifikasi pencairan dikirim ke '.$pencairan->pegawai->nama
);

        return back()->with('success', 'Pesan dimasukkan ke antrian.');
    }

    return back()->with('error', 'Pesan tidak bisa dikirim ulang.');
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
 * BULK SEND WHATSAPP
 * ========================================================= */
public function bulkSend(Request $request)
{
    $mode = $request->mode;
    $ids  = $request->selected ?? [];

    if (empty($ids)) {
        return back()->with('error', 'Tidak ada data yang dipilih.');
    }

    if ($mode === 'mitra') {

    $items = PencairanDanaMitra::whereIn('id_pencairan', $ids)
        ->whereIn('status_notifikasi', ['belum', 'gagal'])
        ->get();

    foreach ($items as $item) {
        $item->update(['status_notifikasi' => 'diproses']);
        KirimWhatsAppJob::dispatch($item->id_pencairan);
    }

    } else {

        $items = PencairanDana::whereIn('id_pencairan', $ids)
            ->whereIn('status_notifikasi', ['belum', 'gagal'])
            ->get();

        foreach ($items as $item) {
            $item->update(['status_notifikasi' => 'diproses']);
            KirimWhatsAppJob::dispatch($item->id_pencairan);
        }
    }

    LogHelper::simpan(
    'Bulk Send WhatsApp',
    'Notifikasi',
    'Admin mengirim notifikasi WhatsApp massal untuk pencairan dana'
);

    return back()->with('success', 'Data berhasil dimasukkan ke antrian.');
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
public function downloadTemplate(Request $request)
{
    $mode = $request->mode ?? 'pegawai';

    if ($mode === 'mitra') {

        $filename = "template_pencairan_mitra.csv";

        $columns = [
            'nik',
            'tanggal',
            'jenis_dana',
            'nominal',
            'potongan',
            'kelompok_id',
            'nama_bank',
            'nama_rekening',
            'no_rekening',
            'keterangan'
        ];

        $dummy = [
            '1234567890123456',
            '2024-07-01',
            'Honor Mitra',
            '500000',
            '0',
            '1',
            'BRI',
            'BUDI SANTOSO',
            '1234567890',
            'Honor kegiatan survei'
        ];

    } else {

        $filename = "template_pencairan_pegawai.csv";

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

        $dummy = [
            '198712312020121001',
            '2024-07-01',
            'Tunjangan Kinerja',
            '5000000',
            '0',
            'MANDIRI',
            'ANDI SAPUTRA',
            '9876543210',
            'Tunjangan bulan Juli'
        ];
    }

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=\"$filename\"",
    ];

    $callback = function () use ($columns, $dummy) {

        $file = fopen('php://output', 'w');

        // Header
        fputcsv($file, $columns, ';');

        // Dummy row
        fputcsv($file, $dummy, ';');

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
