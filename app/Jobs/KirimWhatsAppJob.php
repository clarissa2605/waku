<?php

namespace App\Jobs;

use App\Models\PencairanDana;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use App\Models\LogPencairan;

class KirimWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pencairanId;

    public $tries = 3;

    public function __construct($pencairanId)
    {
        $this->pencairanId = $pencairanId;
        $this->delay(now()->addSeconds(rand(30, 60)));
    }

    public function handle(WhatsAppService $waService): void
    {
        // ==============================
        // 🔒 LIMIT 100 PESAN PER JAM
        // ==============================
        $limitKey = 'wa_hourly_limit_' . now()->format('YmdH');
        $maxPerHour = 100;

        $count = Cache::get($limitKey, 0);

        if ($count >= $maxPerHour) {
            $this->release(600);
            return;
        }

        Cache::put($limitKey, $count + 1, now()->addHour());

        sleep(rand(3, 8));

        // ==============================
        // Ambil data pencairan
        // ==============================
        $pencairan = PencairanDana::with('pegawai')
            ->find($this->pencairanId);

        if (!$pencairan) {
            return;
        }

        // ubah status jadi diproses
        $pencairan->update([
            'status_notifikasi' => 'diproses'
        ]);

        if (!$pencairan || !$pencairan->pegawai) {
            return;
        }

        $pegawai = $pencairan->pegawai;

        if (!$pegawai->no_whatsapp) {
            $pencairan->update([
                'status_notifikasi' => 'gagal'
            ]);
            return;
        }

// ==============================
// Siapkan parameter template
// ==============================

$params = [
    $pegawai->nama,                                // {{1}}
    $pencairan->jenis_dana,                        // {{2}}
    $pencairan->nama_bank,                         // {{3}}
    $pencairan->nama_rekening,                     // {{4}}
    $pencairan->no_rekening,                       // {{5}}
    number_format($pencairan->nominal, 0, ',', '.'), // {{6}}
    number_format($pencairan->potongan ?? 0, 0, ',', '.'), // {{7}}
    number_format($pencairan->nominal_bersih, 0, ',', '.'),   // {{8}}
    $pencairan->tanggal,                           // {{9}}
];

// Kirim template ke MeeChat
$kirim = $waService->sendTemplate(
    $pegawai,
    '499_client_wakuforwa_notifikasi_fix',
    $params
);
        if ($kirim['status'] === 'success') {

            $pencairan->update([
                'status_notifikasi' => 'terkirim'
            ]);

            LogPencairan::create([
                'id_pencairan' => $pencairan->id_pencairan,
                'pegawai_id'   => $pencairan->pegawai_id,
                'aksi'         => 'terkirim',
                'deskripsi'    => 'Notifikasi WhatsApp berhasil dikirim',
            ]);

        } else {

            $pencairan->update([
                'status_notifikasi' => 'gagal'
            ]);

            LogPencairan::create([
                'id_pencairan' => $pencairan->id_pencairan,
                'pegawai_id'   => $pencairan->pegawai_id,
                'aksi'         => 'gagal',
                'deskripsi'    => 'Notifikasi WhatsApp gagal dikirim',
            ]);
        }
    }
}