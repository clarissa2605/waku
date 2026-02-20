<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    /* ==============================
     * LIST MITRA
     * ============================== */
    public function index()
    {
        $mitra = Mitra::orderBy('nama_mitra')
            ->paginate(10);

        return view('admin_mitra.index', compact('mitra'));
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
            'no_whatsapp'    => 'nullable|string',
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

        // 🔥 Normalisasi nomor WA
        if (!empty($validated['no_whatsapp'])) {
            $noWa = preg_replace('/[^0-9]/', '', $validated['no_whatsapp']);

            if (substr($noWa, 0, 1) === '0') {
                $noWa = '62' . substr($noWa, 1);
            }

            $validated['no_whatsapp'] = $noWa;
        }

        Mitra::create($validated);

        return redirect()
            ->route('mitra.index')
            ->with('success', 'Data mitra berhasil ditambahkan.');
    }

    /* ==============================
     * FORM EDIT
     * ============================== */
    public function edit($id)
    {
        $mitra = Mitra::findOrFail($id);

        return view('admin_mitra.edit', compact('mitra'));
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
            'no_whatsapp'    => 'nullable|string',
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

        if (!empty($validated['no_whatsapp'])) {
            $noWa = preg_replace('/[^0-9]/', '', $validated['no_whatsapp']);

            if (substr($noWa, 0, 1) === '0') {
                $noWa = '62' . substr($noWa, 1);
            }

            $validated['no_whatsapp'] = $noWa;
        }

        $mitra->update($validated);

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
        $mitra->delete();

        return back()->with('success', 'Data mitra berhasil dihapus.');
    }
}