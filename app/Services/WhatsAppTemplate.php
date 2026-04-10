<?php

namespace App\Services;

use App\Models\PencairanDana;

class WhatsAppTemplate
{
    public static function pencairanDana(PencairanDana $pencairan): string
    {
        $pegawai = $pencairan->pegawai;

        $nominalKotor  = (int) $pencairan->nominal;
        $potongan      = (int) ($pencairan->potongan ?? 0);
        $nominalBersih = (int) ($pencairan->nominal_bersih ?? ($nominalKotor - $potongan));

        return
"📢*INFORMASI PENCAIRAN DANA*
BPS Provinsi Sulawesi Utara

Yth. Bapak/Ibu *{$pegawai->nama}*,

Dengan ini kami informasikan bahwa pencairan dana telah dilakukan dengan rincian sebagai berikut:

───────────────

*Jenis Dana*
{$pencairan->jenis_dana}

*Bank*
{$pencairan->nama_bank}

*Nama Rekening*
{$pencairan->nama_rekening}

*Nomor Rekening*
{$pencairan->no_rekening}

───────────────

*Total*
Rp " . number_format($nominalKotor, 0, ',', '.') . "

*Potongan*
Rp " . number_format($potongan, 0, ',', '.') . "

*Diterima*
Rp " . number_format($nominalBersih, 0, ',', '.') . "

───────────────

*Tanggal*
{$pencairan->tanggal}

*Keterangan*
{$pencairan->keterangan}

Apabila terdapat pertanyaan, silakan menghubungi Tim Keuangan.

Terima kasih.

*Tim Keuangan*
BPS Provinsi Sulawesi Utara";
    }
}
