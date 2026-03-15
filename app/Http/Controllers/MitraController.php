<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\KelompokMitra;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;

class MitraController extends Controller
{
    /* ==============================
     * LIST MITRA + FILTER
     * ============================== */
    public function index(Request $request)
    {
        $query = Mitra::with('kelompok');

        // ================= SEARCH =================
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_mitra', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // ================= FILTER STATUS =================
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ================= FILTER KELOMPOK (MANY TO MANY) =================
        if ($request->filled('kelompok')) {
            $query->whereHas('kelompok', function ($q) use ($request) {
                $q->where('id_kelompok', $request->kelompok);
            });
        }

        $mitra = $query->orderBy('nama_mitra')
                       ->paginate(10)
                       ->withQueryString();

        // Data untuk dropdown filter kelompok
        $kelompokList = KelompokMitra::orderBy('nama_kelompok')->get();

        return view('admin_mitra.index', compact('mitra', 'kelompokList'));
    }

    /* ==============================
     * FORM CREATE
     * ============================== */
    public function create()
    {
        return view('admin_mitra.create');
    }

    /* ==============================
     * SIMPAN MITRA
     * ============================== */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'            => 'required|digits:16|unique:mitra,nik',
            'nama_mitra'     => 'required|string|max:100',
            'no_whatsapp'    => ['nullable','regex:/^62[0-9]{8,13}$/'],
            'alamat'         => 'nullable|string',
            'nama_bank'      => 'nullable|string|max:100',
            'nama_rekening'  => 'nullable|string|max:100',
            'no_rekening'    => 'nullable|digits_between:8,20',
            'jenis_mitra'    => 'nullable|string|max:100',
            'tanggal_mulai_kontrak'   => 'nullable|date',
            'tanggal_selesai_kontrak' => 'nullable|date',
            'keterangan'     => 'nullable|string',
            'status'         => 'required|in:aktif,nonaktif',
        ]);

        // Normalisasi nomor WA
        if (!empty($validated['no_whatsapp'])) {
            $noWa = preg_replace('/[^0-9]/', '', $validated['no_whatsapp']);

            if (substr($noWa, 0, 1) === '0') {
                $noWa = '62' . substr($noWa, 1);
            }

            $validated['no_whatsapp'] = $noWa;
        }

        Mitra::create($validated);

        // LOG AKTIVITAS
        LogHelper::simpan(
            'Tambah Mitra',
            'Mitra',
            'Mitra baru ditambahkan: '.$validated['nama_mitra']
        );

        return redirect()
            ->route('mitra.index')
            ->with('success', 'Data mitra berhasil ditambahkan.');
    }

    /* ==============================
     * FORM EDIT
     * ============================== */
    public function edit($id)
    {
        $mitra = Mitra::with('kelompok')->findOrFail($id);
        $kelompokList = \App\Models\KelompokMitra::orderBy('nama_kelompok')->get();

        return view('admin_mitra.edit', compact('mitra', 'kelompokList'));
    }

    /* ==============================
    * DETAIL MITRA
    * ============================== */
    public function show($id)
    {
        $mitra = Mitra::with('kelompok')->findOrFail($id);

        return view('admin_mitra.show', compact('mitra'));
}

    /* ==============================
     * UPDATE MITRA
     * ============================== */
    public function update(Request $request, $id)
    {
        $mitra = Mitra::findOrFail($id);

        $validated = $request->validate([
    'nik'            => 'required|digits:16|unique:mitra,nik,' . $mitra->id_mitra . ',id_mitra',
    'nama_mitra'     => 'required|string|max:100',
    'no_whatsapp'    => [
        'nullable',
        'regex:/^62[0-9]{8,13}$/',
        'unique:mitra,no_whatsapp,' . $mitra->id_mitra . ',id_mitra'
    ],
    'alamat'         => 'nullable|string',
    'jenis_mitra'    => 'nullable|string|max:100',
    'tanggal_mulai_kontrak'   => 'nullable|date',
    'tanggal_selesai_kontrak' => 'nullable|date',
    'keterangan'     => 'nullable|string',
    'status'         => 'required|in:aktif,nonaktif',
],[
    'no_whatsapp.regex' => 'Nomor WhatsApp harus diawali 62. Contoh: 628123456789',
    'no_whatsapp.unique' => 'Nomor WhatsApp sudah digunakan oleh mitra lain.'
]);

        if (!empty($validated['no_whatsapp'])) {
            $noWa = preg_replace('/[^0-9]/', '', $validated['no_whatsapp']);

            if (substr($noWa, 0, 1) === '0') {
                $noWa = '62' . substr($noWa, 1);
            }

            $validated['no_whatsapp'] = $noWa;
        }

        $mitra->update($validated);

        LogHelper::simpan(
    'Update Mitra',
    'Mitra',
    'Data mitra diperbarui: '.$mitra->nama_mitra
);

        return redirect()
            ->route('mitra.index')
            ->with('success', 'Data mitra berhasil diperbarui.');
    }

    /* ==============================
     * DELETE MITRA
     * ============================== */
public function destroy($id)
{
    $mitra = Mitra::findOrFail($id);

    $mitra->status = 'nonaktif';
    $mitra->save();

    LogHelper::simpan(
    'Nonaktifkan Mitra',
    'Mitra',
    'Mitra dinonaktifkan: '.$mitra->nama_mitra
);

    return back()->with('success', 'Mitra dinonaktifkan.');
}

    public function toggleStatus($id)
{
    $mitra = Mitra::findOrFail($id);

    $mitra->status = $mitra->status === 'aktif' 
        ? 'nonaktif' 
        : 'aktif';

    $mitra->save();

    LogHelper::simpan(
    'Update Status Mitra',
    'Mitra',
    'Status mitra diubah menjadi '.$mitra->status.' untuk '.$mitra->nama_mitra
);

    return back()->with('success', 'Status mitra berhasil diperbarui.');
}

/* ==============================
 * FORM IMPORT CSV MITRA
 * ============================== */
public function importForm()
{
    return view('admin_mitra.import');
}

/* ==============================
 * PROSES IMPORT CSV MITRA
 * ============================== */
public function importCSV(Request $request)
{
    $request->validate([
        'file_csv' => 'required|mimes:csv,txt'
    ]);

    $file = $request->file('file_csv');

    $handle = fopen($file->getRealPath(), 'r');

    // Skip header
    fgetcsv($handle);

    $jumlahImport = 0;

    while (($row = fgetcsv($handle, 1000, ',')) !== false) {

        $nik = trim($row[0] ?? '');
        $nama = trim($row[1] ?? '');
        $wa = trim($row[2] ?? '');
        $alamat = trim($row[3] ?? '');
        $jenis = trim($row[4] ?? '');
        $mulai = trim($row[5] ?? '');
        $selesai = trim($row[6] ?? '');
        $ket = trim($row[7] ?? '');
        $status = trim($row[8] ?? 'aktif');

        if(empty($nik) || empty($nama)){
            continue;
        }

        // Normalisasi WhatsApp
        if (!empty($wa)) {

            $wa = preg_replace('/[^0-9]/', '', $wa);

            if (substr($wa,0,1) === '0') {
                $wa = '62'.substr($wa,1);
            }

            if (!str_starts_with($wa,'62')) {
                $wa = '62'.$wa;
            }
        }

        try {

            Mitra::updateOrCreate(
                ['nik' => $nik],
                [
                    'nama_mitra' => $nama,
                    'no_whatsapp' => $wa,
                    'alamat' => $alamat,
                    'jenis_mitra' => $jenis,
                    'tanggal_mulai_kontrak' => $mulai ?: null,
                    'tanggal_selesai_kontrak' => $selesai ?: null,
                    'keterangan' => $ket,
                    'status' => $status
                ]
            );

            $jumlahImport++;

        } catch (\Exception $e) {
            continue;
        }
    }

    fclose($handle);

    LogHelper::simpan(
        'Import CSV Mitra',
        'Mitra',
        'Admin mengimport '.$jumlahImport.' data mitra'
    );

    return redirect()->route('mitra.index')
        ->with('success', $jumlahImport.' data mitra berhasil diimport.');
}

public function downloadTemplate()
{
    $filename = "template_mitra.csv";

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $columns = [
        'nik',
        'nama_mitra',
        'no_whatsapp',
        'alamat',
        'jenis_mitra',
        'tanggal_mulai_kontrak',
        'tanggal_selesai_kontrak',
        'keterangan',
        'status'
    ];

    $callback = function() use ($columns) {

        $file = fopen('php://output', 'w');

        fputcsv($file, $columns);

        // contoh data
        fputcsv($file, [
            '1234567890123456',
            'Budi Santoso',
            '628123456789',
            'Manado',
            'Petugas Lapangan',
            '2025-01-01',
            '2025-12-31',
            'Mitra survei',
            'aktif'
        ]);

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function importPreview(Request $request)
{
    $request->validate([
        'file_csv' => 'required|mimes:csv,txt'
    ]);

    $file = $request->file('file_csv');

    $handle = fopen($file->getRealPath(), 'r');

    // skip header
    fgetcsv($handle);

    $rows = [];

    while (($data = fgetcsv($handle, 1000, ',')) !== false) {

        $nik = trim($data[0] ?? '');
        $nama = trim($data[1] ?? '');
        $wa = trim($data[2] ?? '');
        $alamat = trim($data[3] ?? '');
        $jenis = trim($data[4] ?? '');
        $mulai = trim($data[5] ?? '');
        $selesai = trim($data[6] ?? '');
        $ket = trim($data[7] ?? '');
        $status = trim($data[8] ?? 'aktif');

        $valid = true;

        if(empty($nik) || strlen($nik) != 16){
            $valid = false;
        }

        if(empty($nama)){
            $valid = false;
        }

        // Normalisasi WA
        if(!empty($wa)){
            $wa = preg_replace('/[^0-9]/','',$wa);

            if(substr($wa,0,1) == '0'){
                $wa = '62'.substr($wa,1);
            }

            if(!str_starts_with($wa,'62')){
                $wa = '62'.$wa;
            }
        }

        $rows[] = [
            'nik' => $nik,
            'nama_mitra' => $nama,
            'no_whatsapp' => $wa,
            'alamat' => $alamat,
            'jenis_mitra' => $jenis,
            'tanggal_mulai_kontrak' => $mulai,
            'tanggal_selesai_kontrak' => $selesai,
            'keterangan' => $ket,
            'status' => $status,
            'valid' => $valid
        ];
    }

    fclose($handle);

    return view('admin_mitra.preview', compact('rows'));
}

public function importConfirm(Request $request)
{
    $data = $request->data ?? [];

    $jumlahImport = 0;

    foreach($data as $row){

        if(!$row['valid']){
            continue;
        }

        try{

            Mitra::updateOrCreate(
                ['nik' => $row['nik']],
                [
                    'nama_mitra' => $row['nama_mitra'],
                    'no_whatsapp' => $row['no_whatsapp'],
                    'alamat' => $row['alamat'],
                    'jenis_mitra' => $row['jenis_mitra'],
                    'tanggal_mulai_kontrak' => $row['tanggal_mulai_kontrak'] ?: null,
                    'tanggal_selesai_kontrak' => $row['tanggal_selesai_kontrak'] ?: null,
                    'keterangan' => $row['keterangan'],
                    'status' => $row['status']
                ]
            );

            $jumlahImport++;

        } catch (\Exception $e){
            continue;
        }

    }

    LogHelper::simpan(
        'Import CSV Mitra',
        'Mitra',
        'Import '.$jumlahImport.' data mitra'
    );

    return redirect()->route('mitra.index')
        ->with('success',$jumlahImport.' data mitra berhasil diimport.');
}

}