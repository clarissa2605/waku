<?php

namespace App\Jobs;

use App\Models\PencairanDana;
use App\Services\WhatsAppService;
use App\Services\WhatsAppTemplate;
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
        // 🔒 LIMIT 20 PESAN PER JAM
        // ==============================
        $limitKey = 'wa_hourly_limit';
        $maxPerHour = 20;

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

        $pesan = WhatsAppTemplate::pencairanDana($pencairan);

        // 🔥 PANGGIL SERVICE BARU
        $kirim = $waService->send($pegawai, $pesan);

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