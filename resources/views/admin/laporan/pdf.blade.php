<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
    color:#2d3748;
    margin:10px 25px;
}

/* HEADER */

.header{
    width:100%;
    border-bottom:3px solid #1a365d;
    padding-bottom:8px;
    margin-bottom:15px;
}

.logo{
    width:60px;
}

.header-table{
    width:100%;
}

.header-title{
    font-size:20px;
    font-weight:bold;
    letter-spacing:1px;
}

.header-sub{
    font-size:13px;
    margin-top:2px;
}

/* META INFO */

.meta{
    margin-top:8px;
    margin-bottom:15px;
}

.meta-table{
    width:100%;
}

.meta-table td{
    padding:2px 0;
}

/* SUMMARY BOX */

.summary{
    margin-bottom:15px;
}

.summary-table{
    width:100%;
    border-collapse:collapse;
}

.summary-table td{
    border:1px solid #d1d5db;
    padding:8px;
}

.summary-title{
    font-weight:bold;
    color:#1a365d;
    margin-bottom:3px;
}

/* DATA TABLE */

.table{
    width:100%;
    border-collapse:collapse;
}

.table th{
    background:#edf2f7;
    border:1px solid #cbd5e0;
    padding:7px;
    text-align:left;
    font-weight:bold;
}

.table td{
    border:1px solid #e2e8f0;
    padding:7px;
}

/* FOOTER */

.footer{
    margin-top:35px;
    font-size:11px;
    color:#718096;
}

/* SIGNATURE */

.signature{
    width:100%;
    margin-top:45px;
}

.signature td{
    text-align:right;
}

/* PDF SETTINGS */

@page {
    margin: 35px 25px;
}

/* HEADER FIXED */

header {
    position: fixed;
    top: -30px;
    left: 0;
    right: 0;
}

/* FOOTER FIXED */

footer {
    position: fixed;
    bottom: -25px;
    left: 0;
    right: 0;
    text-align: center;
    font-size:11px;
    color:#718096;
}

footer .pagenum:before {
    content: counter(page);
}

/* TABLE HEADER STAY ON NEXT PAGE */

thead{
    display: table-header-group;
}

</style>

</head>

<body>

{{-- HEADER --}}
<table class="header-table">

<tr>

<td width="70">
<img src="{{ public_path('logo-bps.png') }}" class="logo">
</td>

<td>

<div class="header-title">
LAPORAN PENCAIRAN DANA
</div>

<div class="header-sub">
WAKU – Web Aktif Komunikasi Keuangan
</div>

<div class="header-sub">
BPS Provinsi Sulawesi Utara
</div>

</td>

</tr>

</table>

<div class="header"></div>



{{-- META DATA --}}
<div class="meta">

<table class="meta-table">

<tr>
<td width="150"><strong>Periode Laporan</strong></td>
<td>
: {{ \Carbon\Carbon::create()->month(intval($bulan))->translatedFormat('F') }} {{ $tahun }}
</td>
</tr>

<tr>
<td><strong>Tanggal Cetak</strong></td>
<td>
: {{ \Carbon\Carbon::now()->format('d M Y') }}
</td>
</tr>

<tr>
<td><strong>Sistem</strong></td>
<td>
: WAKU – Web Aktif Komunikasi Keuangan
</td>
</tr>

</table>

</div>



{{-- SUMMARY --}}
<div class="summary">

<table class="summary-table">

<tr>

<td width="25%">
<div class="summary-title">Total Pencairan</div>
{{ $totalPencairan }}
</td>

<td width="25%">
<div class="summary-title">Total Dana</div>
Rp {{ number_format($totalDana,0,',','.') }}
</td>

<td width="25%">
<div class="summary-title">WA Terkirim</div>
{{ $waTerkirim }}
</td>

<td width="25%">
<div class="summary-title">WA Gagal</div>
{{ $waGagal }}
</td>

</tr>

</table>

</div>



{{-- DATA TABLE --}}
<table class="table">

<thead>

<tr>

<th width="12%">Tanggal</th>
<th width="28%">Nama Penerima</th>
<th width="12%">Tipe</th>
<th width="25%">Jenis Dana</th>
<th width="13%">Total</th>
<th width="10%">Status WA</th>

</tr>

</thead>

<tbody>

@foreach($pencairans as $item)

<tr>

<td>
{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
</td>

<td>
{{ $item->nama_penerima }}
</td>

<td>
{{ $item->tipe }}
</td>

<td>
{{ $item->jenis_dana }}
</td>

<td>
Rp {{ number_format($item->total_diterima,0,',','.') }}
</td>

<td>
{{ $item->status_wa }}
</td>

</tr>

@endforeach

</tbody>

</table>



{{-- SIGNATURE --}}
<table class="signature">

<tr>

<td>

Manado, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

<br><br>

Admin Keuangan

<br><br><br><br>

____________________________

</td>

</tr>

</table>



{{-- FOOTER --}}
<div class="footer">

Dokumen ini dihasilkan secara otomatis oleh sistem  
<strong>WAKU – Web Aktif Komunikasi Keuangan</strong>  
BPS Provinsi Sulawesi Utara

</div>

<footer>
Halaman <span class="pagenum"></span>
</footer>

</body>
</html>