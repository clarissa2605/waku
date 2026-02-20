<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\LogNotifikasi;

class WhatsAppService
{
    public function send($recipient, string $message): array
    {
        $mode = env('WA_MODE', 'simulation');

        try {

            // ==============================
            // MODE SIMULASI
            // ==============================
            if ($mode === 'simulation') {

                $status = 'success';
                $responseBody = 'Simulasi terkirim ke ' . $recipient->no_whatsapp;

            } else {

                // ==============================
                // MODE API (REAL)
                // ==============================

                /** @var \Illuminate\Http\Client\Response $response */
                $response = Http::withHeaders([
                    'Authorization' => config('services.fonnte.api_key'),
                ])->asForm()->post(config('services.fonnte.base_url'), [
                    'target'  => $recipient->no_whatsapp,
                    'message' => $message,
                ]);

                $status = $response->successful() ? 'success' : 'failed';
                $responseBody = $response->body();
            }

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