<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    /**
     * LIST LOG AKTIVITAS SISTEM
     */
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user');

        /*
        |------------------------------------------
        | SEARCH
        |------------------------------------------
        */
        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->where('aktivitas','like','%'.$request->search.'%')
                  ->orWhere('modul','like','%'.$request->search.'%')
                  ->orWhere('detail','like','%'.$request->search.'%');

            });

        }

        /*
        |------------------------------------------
        | FILTER MODUL
        |------------------------------------------
        */
        if ($request->modul) {

            $query->where('modul',$request->modul);

        }

        /*
        |------------------------------------------
        | DATA
        |------------------------------------------
        */
        $logs = $query
            ->orderBy('created_at','desc')
            ->paginate(20)
            ->withQueryString();

        /*
        |------------------------------------------
        | LIST MODUL UNTUK FILTER
        |------------------------------------------
        */
        $modulList = LogAktivitas::select('modul')
                        ->distinct()
                        ->orderBy('modul')
                        ->pluck('modul');

        return view('admin_log.index', compact(
            'logs',
            'modulList'
        ));
    }
}