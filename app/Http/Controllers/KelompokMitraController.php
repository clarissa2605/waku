<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
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
        $mitra = Mitra::where('status', 'aktif')->get();

        return view('admin_kelompok.show', compact('kelompok', 'mitra'));
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
}