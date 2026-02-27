<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Models\LogNotifikasi;

class WhatsAppService
{
    public function send($recipient, string $message): array
    {
        $mode = env('WA_MODE', 'simulation');

        try {

            // ===================================
            // MODE SIMULATION (AMAN UNTUK TEST)
            // ===================================
            if ($mode === 'simulation') {

                $status = 'success';
                $responseBody = 'Simulasi terkirim ke ' . $recipient->no_whatsapp;

            } else {

                // ===================================
                // MODE REAL API (MEECHAT)
                // ===================================

                /** @var Response $response */
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('services.meechat.server_key'),
                    'Content-Type'  => 'application/json',
                ])->post(config('services.meechat.url'), [
                    'number'  => $recipient->no_whatsapp,
                    'message' => $message,
                ]);

                $status = $response->successful() ? 'success' : 'failed';
                $responseBody = $response->body();
            }

            // ===================================
            // SIMPAN LOG
            // ===================================
            LogNotifikasi::create([
                'recipient_type' => get_class($recipient),
                'recipient_id'   => $recipient->getKey(),
                'no_whatsapp'    => $recipient->no_whatsapp,
                'pesan'          => $message,
                'status'         => $status,
                'response'       => $responseBody,
            ]);

            return [
                'status'   => $status,
                'response' => $responseBody,
            ];

        } catch (\Throwable $e) {

            LogNotifikasi::create([
                'recipient_type' => get_class($recipient),
                'recipient_id'   => $recipient->getKey(),
                'no_whatsapp'    => $recipient->no_whatsapp,
                'pesan'          => $message,
                'status'         => 'error',
                'response'       => $e->getMessage(),
            ]);

            return [
                'status'   => 'error',
                'response' => $e->getMessage(),
            ];
        }
    }
}