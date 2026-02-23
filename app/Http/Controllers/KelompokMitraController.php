<?php

namespace App\Http\Controllers;

use App\Models\KelompokMitra;
use Illuminate\Http\Request;

class KelompokMitraController extends Controller
{
    /**
     * Tampilkan detail kelompok + daftar anggota
     */
public function show($id)
{
    $kelompok = KelompokMitra::with('mitra')->findOrFail($id);

    // Ambil ID mitra yang sudah ada di kelompok ini
    $mitraSudahAda = $kelompok->mitra->pluck('id_mitra');

    // Ambil mitra aktif yang BELUM masuk kelompok ini
    $mitra = \App\Models\Mitra::where('status', 'aktif')
        ->whereNotIn('id_mitra', $mitraSudahAda)
        ->orderBy('nama_mitra')
        ->get();

    $totalAnggota = $kelompok->mitra->count();

    $totalTransaksi = \App\Models\PencairanDanaMitra::where('kelompok_id', $id)->count();
    $totalNominal = \App\Models\PencairanDanaMitra::where('kelompok_id', $id)->sum('nominal');
    $totalDanaBersih = \App\Models\PencairanDanaMitra::where('kelompok_id', $id)->sum('nominal_bersih');

    return view('admin_kelompok.show', compact(
        'kelompok',
        'mitra',
        'totalAnggota',
        'totalTransaksi',
        'totalNominal',
        'totalDanaBersih'
    ));
}
    /**
     * Tambahkan mitra ke kelompok
     */
    public function addMitra(Request $request, $id)
    {
        $request->validate([
            'mitra_id' => 'required|exists:mitra,id_mitra'
        ]);

        $kelompok = KelompokMitra::findOrFail($id);

        $kelompok->mitra()->attach($request->mitra_id);

        return redirect()->back()->with('success', 'Mitra berhasil ditambahkan ke kelompok.');
    }

    /**
     * Hapus mitra dari kelompok
     */
    public function removeMitra($kelompokId, $mitraId)
    {
        $kelompok = KelompokMitra::findOrFail($kelompokId);

        $kelompok->mitra()->detach($mitraId);

        return redirect()->back()->with('success', 'Mitra berhasil dihapus dari kelompok.');
    }
    /* ===============================
   LIST KELOMPOK
================================ */
public function index()
{
    $kelompok = KelompokMitra::withCount('mitra')
        ->orderBy('tahun', 'desc')
        ->orderBy('nama_kelompok')
        ->get();

    return view('admin_kelompok.index', compact('kelompok'));
}

/* ===============================
   FORM CREATE
================================ */
public function create()
{
    return view('admin_kelompok.create');
}

/* ===============================
   STORE KELOMPOK
================================ */
public function store(Request $request)
{
    $validated = $request->validate([
        'nama_kelompok' => 'required|string|max:100',
        'nama_kegiatan' => 'required|string|max:150',
        'tahun' => 'required|digits:4',
        'keterangan' => 'nullable|string|max:255',
    ]);

    $kelompok = KelompokMitra::create($validated);

    return redirect()
        ->route('kelompok.show', $kelompok->id_kelompok)
        ->with('success', 'Kelompok berhasil dibuat.');
}

public function edit($id)
{
    $kelompok = KelompokMitra::findOrFail($id);

    return view('admin_kelompok.edit', compact('kelompok'));
}
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nama_kelompok' => 'required|string|max:100',
        'nama_kegiatan' => 'required|string|max:150',
        'tahun' => 'required|digits:4',
        'keterangan' => 'nullable|string|max:255',
    ]);

    $kelompok = KelompokMitra::findOrFail($id);
    $kelompok->update($validated);

    return redirect()
        ->route('kelompok.show', $kelompok->id_kelompok)
        ->with('success', 'Kelompok berhasil diperbarui.');
}

public function destroy($id)
{
    $kelompok = KelompokMitra::findOrFail($id);

    // Hapus relasi pivot dulu
    $kelompok->mitra()->detach();

    $kelompok->delete();

    return redirect()
        ->route('kelompok.index')
        ->with('success', 'Kelompok berhasil dihapus.');
}

}
