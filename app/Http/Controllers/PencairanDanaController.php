<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PencairanDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\WhatsAppTemplate;

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
     * SIMPAN PENCAIRAN INDIVIDU (TAMBAH POTONGAN & BERSIH)
     * ========================================================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id_pegawai',
            'jenis_dana' => 'required|string|max:100',
            'nominal'    => 'required|numeric|min:1',
            'potongan'   => 'nullable|numeric|min:0',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $pegawai = Pegawai::where('id_pegawai', $validated['pegawai_id'])
            ->where('status', 'aktif')
            ->firstOrFail();

        $nominal  = $validated['nominal'];
        $potongan = $request->input('potongan', 0);
        $bersih   = $nominal - $potongan;

        $pencairan = PencairanDana::create([
            'pegawai_id'     => $pegawai->id_pegawai,
            'jenis_dana'     => $validated['jenis_dana'],
            'nominal'        => $nominal,
            'potongan'       => $potongan,
            'nominal_bersih' => $bersih,
            'tanggal'        => $validated['tanggal'],
            'keterangan'     => $validated['keterangan'] ?? null,
            'status_notifikasi' => 'belum',
        ]);

        // Generate pesan WA (Sprint 3A)
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
     * PREVIEW IMPORT CSV (TAMBAH POTONGAN & BERSIH)
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
                'nip'        => $nip,
                'nama'       => $pegawai->nama ?? '❌ TIDAK DITEMUKAN',
                'tanggal'    => $data['tanggal'] ?? '',
                'jenis_dana' => $data['jenis_dana'] ?? '',
                'nominal'    => $nominal,
                'potongan'   => $potongan,
                'bersih'     => $nominal - $potongan,
                'keterangan' => $data['keterangan'] ?? '-',
                'valid'      => $pegawai ? 1 : 0,
            ];
        }

        return view('admin_pencairan.import_preview', compact('rows'));
    }

    /* =========================================================
     * KONFIRMASI & SIMPAN HASIL IMPORT (TAMBAH POTONGAN & BERSIH)
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

                $pencairan = PencairanDana::create([
                    'pegawai_id'     => $pegawai->id_pegawai,
                    'tanggal'        => $item['tanggal'],
                    'jenis_dana'     => trim($item['jenis_dana']),
                    'nominal'        => $nominal,
                    'potongan'       => $potongan,
                    'nominal_bersih' => $nominal - $potongan,
                    'keterangan'     => $item['keterangan'] ?? null,
                    'status_notifikasi' => 'belum',
                ]);

                // Generate pesan WA (Sprint 3A)
                $pesanWa = WhatsAppTemplate::pencairanDana($pencairan);
                // logger($pesanWa);
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

        return view('admin_pencairan.preview_wa', [
            'pencairan' => $pencairan,
            'pesan'     => $pesan,
        ]);
    }

    /* =========================================================
     * HELPER: BACA CSV (AUTO-DETECT , ATAU ;)
     * ========================================================= */
    private function readCsv(Request $request): array
    {
        $file = fopen($request->file->getRealPath(), 'r');

        $firstLine = fgets($file);
        rewind($file);

        $delimiter = str_contains($firstLine, ';') ? ';' : ',';

        $header = fgetcsv($file, 0, $delimiter);
        $header = array_map(function ($h) {
            return strtolower(
                trim(preg_replace('/[\x{FEFF}\x{200B}\s]+/u', '', $h))
            );
        }, $header);

        $rows = [];
        while (($row = fgetcsv($file, 0, $delimiter)) !== false) {
            if (array_filter($row)) {
                $rows[] = $row;
            }
        }

        fclose($file);

        return [$header, $rows];
    }
}
