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
"📢 *Informasi Pencairan Dana*
BPS Provinsi Sulawesi Utara

Yth. Bapak/Ibu *{$pegawai->nama}*

Kami informasikan bahwa pencairan dana *{$pencairan->jenis_dana}* telah ditransfer dengan rincian:

💰 *Total*      : Rp " . number_format($nominalKotor, 0, ',', '.') . "
✂️ *Potongan*   : Rp " . number_format($potongan, 0, ',', '.') . "
✅ *Diterima*   : Rp " . number_format($nominalBersih, 0, ',', '.') . "

🗓 *Tanggal*    :  {$pencairan->tanggal}
📝 *Keterangan* : {$pencairan->keterangan}

Apabila terdapat pertanyaan, silakan menghubungi Bagian Keuangan.

Terima kasih.
*Bagian Keuangan*";
    }
}
