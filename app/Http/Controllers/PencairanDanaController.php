<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PencairanDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'pegawai_id' => 'required|exists:pegawai,id_pegawai',
            'jenis_dana' => 'required|string|max:100',
            'nominal'    => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $pegawai = Pegawai::where('id_pegawai', $validated['pegawai_id'])
            ->where('status', 'aktif')
            ->firstOrFail();

        PencairanDana::create([
            'pegawai_id'        => $pegawai->id_pegawai,
            'jenis_dana'        => $validated['jenis_dana'],
            'nominal'           => $validated['nominal'],
            'tanggal'           => $validated['tanggal'],
            'keterangan'        => $validated['keterangan'] ?? null,
            'status_notifikasi' => 'belum',
        ]);

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

            $rows[] = [
                'nip'        => $nip,
                'nama'       => $pegawai->nama ?? '❌ TIDAK DITEMUKAN',
                'tanggal'    => $data['tanggal'] ?? '',
                'jenis_dana' => $data['jenis_dana'] ?? '',
                'nominal'    => (int) preg_replace('/[^0-9]/', '', $data['nominal'] ?? 0),
                'keterangan' => $data['keterangan'] ?? '-',
                'valid'      => $pegawai ? true : false,
            ];
        }

        return view('admin_pencairan.import_preview', compact('rows'));
    }

    /* =========================================================
     * KONFIRMASI & SIMPAN HASIL IMPORT
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

                PencairanDana::create([
                    'pegawai_id'        => $pegawai->id_pegawai,
                    'tanggal'           => $item['tanggal'],
                    'jenis_dana'        => trim($item['jenis_dana']),
                    'nominal'           => (int) $item['nominal'],
                    'keterangan'        => $item['keterangan'] ?? null,
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
     * HELPER: BACA CSV (AUTO-DETECT , ATAU ;)
     * ========================================================= */
    private function readCsv(Request $request): array
    {
        $file = fopen($request->file->getRealPath(), 'r');

        // Deteksi delimiter otomatis
        $firstLine = fgets($file);
        rewind($file);

        $delimiter = str_contains($firstLine, ';') ? ';' : ',';

        // Header
        $header = fgetcsv($file, 0, $delimiter);
        $header = array_map(function ($h) {
            return strtolower(
                trim(preg_replace('/[\x{FEFF}\x{200B}\s]+/u', '', $h))
            );
        }, $header);

        // Rows
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
