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

class KirimWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pencairanId;

    public $tries = 3; // retry maksimal 3x

    /**
     * Create a new job instance.
     */
    public function __construct($pencairanId)
    {
        $this->pencairanId = $pencairanId;

        // ⏳ Delay random 30–60 detik sebelum diproses
        $this->delay(now()->addSeconds(rand(30, 60)));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // ==============================
        // 🔒 LIMIT 20 PESAN PER JAM
        // ==============================
        $limitKey = 'wa_hourly_limit';
        $maxPerHour = 20;

        $count = Cache::get($limitKey, 0);

        if ($count >= $maxPerHour) {
            // Kalau sudah penuh, tunda 10 menit
            $this->release(600);
            return;
        }

        Cache::put($limitKey, $count + 1, now()->addHour());

        // Delay natural seperti manusia
        sleep(rand(3, 8));

        // ==============================
        // Ambil data pencairan
        // ==============================
        $pencairan = PencairanDana::with('pegawai')
            ->find($this->pencairanId);

        if (!$pencairan || !$pencairan->pegawai) {
            return;
        }

        $nomor = $pencairan->pegawai->no_whatsapp ?? null;

        if (!$nomor) {
            $pencairan->update([
                'status_notifikasi' => 'gagal'
            ]);
            return;
        }

        $pesan = WhatsAppTemplate::pencairanDana($pencairan);

        $kirim = WhatsAppService::send($nomor, $pesan);

        if ($kirim['status']) {
            $pencairan->update([
                'status_notifikasi' => 'terkirim'
            ]);
        } else {
            $pencairan->update([
                'status_notifikasi' => 'gagal'
            ]);
        }
    }
}
