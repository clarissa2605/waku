<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Helpers\LogHelper;
class PegawaiController extends Controller
{
    /* =====================================================
     |  CRUD DATA PEGAWAI
     ===================================================== */

        public function index(Request $request)
        {
            $query = Pegawai::with('user');

            // SEARCH
            if ($request->search) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nip', 'like', '%' . $request->search . '%');
                });
            }

            // FILTER STATUS
            if ($request->status) {
                $query->where('status', $request->status);
            }

            // FILTER AKUN
            if ($request->akun === 'ada') {
                $query->whereHas('user');
            }

            if ($request->akun === 'belum') {
                $query->whereDoesntHave('user');
            }

            $pegawai = $query->orderBy('nama')->get();

            return view('admin_pegawai.index', compact('pegawai'));
        }

    public function create(): View
    {
        return view('admin_pegawai.create');
    }

   public function store(Request $request): RedirectResponse
{
    $request->validate([
        'nip'         => ['required', 'digits:18', 'unique:pegawai,nip'],
        'nama'        => 'required|string|max:255',
        'unit_kerja'  => 'required|string|max:255',
        'no_whatsapp' => ['required','regex:/^62[0-9]{8,13}$/','min:10','max:15' ],
        'status'      => 'required|in:aktif,nonaktif',], [
        'no_whatsapp.regex' => 'Nomor WhatsApp harus diawali 62 dan tanpa spasi. Contoh: 628123456789',
    ]);

    $pegawai = Pegawai::create([
        'nip'            => $request->nip,
        'nama'           => $request->nama,
        'unit_kerja'     => $request->unit_kerja,
        'no_whatsapp'    => $request->no_whatsapp, // FIXED
        'status'         => $request->status,
    ]);

    LogHelper::simpan(
    'Tambah Pegawai',
    'Pegawai',
    'Pegawai baru ditambahkan: '.$pegawai->nama
);

    return redirect()
        ->route('pegawai.index')
        ->with('success', 'Pegawai berhasil ditambahkan');
}


    public function edit(int $id): View
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('admin_pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $pegawai = Pegawai::findOrFail($id);

        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'status'     => 'required|in:aktif,nonaktif',
        ]);

        $pegawai->update($validated);

        LogHelper::simpan(
    'Update Pegawai',
    'Pegawai',
    'Data pegawai diperbarui: '.$pegawai->nama
);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui');
    }

    public function destroy(int $id): RedirectResponse
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update(['status' => 'nonaktif']);

        LogHelper::simpan(
    'Nonaktifkan Pegawai',
    'Pegawai',
    'Pegawai dinonaktifkan: '.$pegawai->nama
);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Pegawai dinonaktifkan');
    }

    public function toggleStatus($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $pegawai->status = $pegawai->status === 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $pegawai->save();

        LogHelper::simpan(
    'Update Status Pegawai',
    'Pegawai',
    'Status pegawai diubah menjadi '.$pegawai->status.' untuk '.$pegawai->nama
);

        return redirect()->back()->with('success', 'Status pegawai diperbarui.');
    }

    /* =====================================================
     |  AKUN LOGIN PEGAWAI
     ===================================================== */

    public function createUser(int $id): View|RedirectResponse
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->user) {
            return redirect()
                ->back()
                ->with('error', 'Pegawai sudah memiliki akun login');
        }

        return view('admin_pegawai.create_user', compact('pegawai'));
    }

    public function storeUser(Request $request, int $id): RedirectResponse
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'       => $pegawai->nama,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'pegawai_id' => $pegawai->id_pegawai,
            'role'       => 'pegawai',
        ]);

        LogHelper::simpan(
    'Buat Akun Pegawai',
    'User Management',
    'Akun login dibuat untuk pegawai '.$pegawai->nama
);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Akun login pegawai berhasil dibuat');
    }
}
