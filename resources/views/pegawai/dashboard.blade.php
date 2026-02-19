@extends('layouts.app')

@section('content')

<div style="max-width:1200px; margin:auto; padding:20px;">

    <h2 style="margin-bottom:20px;">
        Dashboard Riwayat Pencairan Dana
    </h2>

    {{-- ===================== --}}
    {{-- SUMMARY CARDS --}}
    {{-- ===================== --}}
    <div style="display:flex; gap:20px; margin-bottom:30px;">

        <div style="flex:1; background:#f8f9fa; padding:20px; border-radius:10px;">
            <h4>Total Dana</h4>
            <h2>Rp {{ number_format($totalNominal,0,',','.') }}</h2>
        </div>

        <div style="flex:1; background:#fff3cd; padding:20px; border-radius:10px;">
            <h4>Total Potongan</h4>
            <h2>Rp {{ number_format($totalPotongan,0,',','.') }}</h2>
        </div>

        <div style="flex:1; background:#d4edda; padding:20px; border-radius:10px;">
            <h4>Total Diterima</h4>
            <h2>Rp {{ number_format($totalBersih,0,',','.') }}</h2>
        </div>

    </div>

    {{-- ===================== --}}
    {{-- TABEL DETAIL --}}
    {{-- ===================== --}}

    <h4>Detail Riwayat</h4>

    <table width="100%" border="1" cellpadding="8" style="border-collapse:collapse; font-size:14px;">
        <thead style="background:#343a40; color:white;">
            <tr>
                <th>Tanggal</th>
                <th>Jenis Dana</th>
                <th>Bank</th>
                <th>Nama Rekening</th>
                <th>No Rekening</th>
                <th>Nominal</th>
                <th>Potongan</th>
                <th>Diterima</th>
                <th>Status Notifikasi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($riwayat as $item)
                <tr>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->jenis_dana }}</td>
                    <td>{{ $item->nama_bank }}</td>
                    <td>{{ $item->nama_rekening }}</td>
                    <td>{{ $item->no_rekening }}</td>
                    <td>Rp {{ number_format($item->nominal,0,',','.') }}</td>
                    <td>Rp {{ number_format($item->potongan,0,',','.') }}</td>
                    <td><strong>Rp {{ number_format($item->nominal_bersih,0,',','.') }}</strong></td>
                    <td>
                        @if($item->status_notifikasi == 'terkirim')
                            <span style="color:green;">Terkirim</span>
                        @elseif($item->status_notifikasi == 'gagal')
                            <span style="color:red;">Gagal</span>
                        @else
                            <span style="color:orange;">Belum</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" align="center">
                        Belum ada data pencairan dana.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
