<?php

namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function simpan($aktivitas, $modul, $detail = null)
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'nama_user' => Auth::user()->name ?? 'System',
            'aktivitas' => $aktivitas,
            'modul' => $modul,
            'detail' => $detail,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}
