<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\PencairanDanaMitra;
use Illuminate\Http\Request;

class PencairanDanaMitraController extends Controller
{
    /* ==============================
     * LIST
     * ============================== */
    public function index()
    {
        $pencairan = PencairanDanaMitra::with('mitra')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin_pencairan_mitra.index', compact('pencairan'));
    }

    /* ==============================
     * FORM CREATE
     * ============================== */
public function create()
{
    $mitra = Mitra::where('status', 'aktif')
        ->orderBy('nama_mitra')
        ->get();

    return view(
        'admin_pencairan_mitra.create',
        compact('mitra')
    );
}

    /* ==============================
     * STORE
     * ============================== */
    public function store(Request $request)
{
    $validated = $request->validate([
        'mitra_id'   => 'required|exists:mitra,id_mitra',
        'kelompok_id'  => 'nullable|exists:kelompok_mitra,id_kelompok',
        'jenis_dana' => 'required|string|max:100',
        'nominal'    => 'required|numeric|min:1|max:1000000000000',
        'potongan'   => 'nullable|numeric|min:0|lte:nominal',
        'tanggal'    => 'required|date|before_or_equal:today',

        'nama_bank' => 'required|string|max:100',
        'nama_rekening' => 'required|string|max:100',
        'no_rekening' => 'required|digits_between:8,25',

        'keterangan' => 'nullable|string|max:500',
    ]);

    $potongan = $validated['potongan'] ?? 0;
    $bersih = $validated['nominal'] - $potongan;

    PencairanDanaMitra::create([
        'mitra_id'       => $validated['mitra_id'],
        'kelompok_id'    => $validated['kelompok_id'] ?? null,
        'jenis_dana'     => $validated['jenis_dana'],
        'nominal'        => $validated['nominal'],
        'potongan'       => $potongan,
        'nominal_bersih' => $bersih,
        'tanggal'        => $validated['tanggal'],

        'nama_bank'      => $validated['nama_bank'],
        'nama_rekening'  => $validated['nama_rekening'],
        'no_rekening'    => $validated['no_rekening'],

        'keterangan'     => $validated['keterangan'],
        'status_notifikasi' => 'belum'
    ]);

    return redirect()
        ->route('pencairan.mitra.index')
        ->with('success', 'Pencairan dana mitra berhasil disimpan.');
}
}