<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogNotifikasi;

class LogNotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->mode ?? 'pegawai';

        $query = LogNotifikasi::query();

        // ==========================
        // FILTER MODE
        // ==========================
        if ($mode === 'pegawai') {
            $query->where('recipient_type', 'App\Models\Pegawai');
        } else {
            $query->where('recipient_type', 'App\Models\Mitra');
        }

        // ==========================
        // FILTER STATUS
        // ==========================
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // ==========================
        // SEARCH NOMOR
        // ==========================
        if ($request->search) {
            $query->where('no_whatsapp', 'like', '%' . $request->search . '%');
        }

        $logs = $query->latest()->paginate(15);

        // Statistik kecil
        $totalSuccess = (clone $query)->where('status', 'success')->count();
        $totalError   = (clone $query)->where('status', 'error')->count();

        return view('admin_log_notifikasi.index', compact(
            'logs',
            'mode',
            'totalSuccess',
            'totalError'
        ));
    }
}