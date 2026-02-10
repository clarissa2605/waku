<?php

namespace App\Services;

use App\Models\PencairanDana;

class WhatsAppTemplate
{
    public static function pencairanDana(PencairanDana $p)
    {
        return
"📢 Informasi Pencairan Dana
BPS Provinsi Sulawesi Utara

Yth. Bapak/Ibu {$p->pegawai->nama}

Kami informasikan bahwa pencairan dana
{$p->jenis_dana} telah dilakukan dengan rincian:

💰 Nominal Total : Rp " . number_format($p->nominal, 0, ',', '.') . "
➖ Potongan      : Rp " . number_format($p->potongan, 0, ',', '.') . "
✅ Diterima      : Rp " . number_format($p->nominal_bersih, 0, ',', '.') . "

🗓 Tanggal : {$p->tanggal}
📝 Keterangan : {$p->keterangan}

Terima kasih.
Bagian Keuangan";
    }
}
