<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\KelompokMitra;
use Illuminate\Http\Request;

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

        // Normalisasi nomor WA
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
            'no_whatsapp'    => 'nullable|string',
            'alamat'         => 'nullable|string',
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

    $mitra->status = 'nonaktif';
    $mitra->save();

    return back()->with('success', 'Mitra dinonaktifkan.');
}

    public function toggleStatus($id)
{
    $mitra = Mitra::findOrFail($id);

    $mitra->status = $mitra->status === 'aktif' 
        ? 'nonaktif' 
        : 'aktif';

    $mitra->save();

    return back()->with('success', 'Status mitra berhasil diperbarui.');
}
}