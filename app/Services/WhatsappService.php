<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Models\LogNotifikasi;

class WhatsAppService
{
    public function sendTemplate($recipient, string $templateName, array $params): array
    {
        try {

            /** @var Response $response */
            $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-KEY'    => 'Bearer ' . config('services.meechat.client_key'),
            ])->post(
                config('services.meechat.url') . '/v1/send-template',
                [
                    'name_template' => $templateName,
                    'phone_number'  => $recipient->no_whatsapp,
                    'language_code' => 'id',
                    'body_params'   => $params,
                ]
            );

            $statusCode = $response->status();
            $isSuccess  = $response->successful();

            $status = $isSuccess ? 'success' : 'failed';

            $responseBody = $response->body();

            // 🔎 DEBUG: simpan status code + response
            LogNotifikasi::create([
                'recipient_type' => get_class($recipient),
                'recipient_id'   => $recipient->getKey(),
                'no_whatsapp'    => $recipient->no_whatsapp,
                'pesan'          => json_encode($params),
                'status'         => $status,
                'response'       => 'HTTP ' . $statusCode . ' - ' . $responseBody,
            ]);

            return [
                'status'   => $status,
                'response' => $responseBody,
            ];

        } catch (\Throwable $e) {

            // 🔥 Jika benar-benar error (timeout / crash)
            LogNotifikasi::create([
                'recipient_type' => get_class($recipient),
                'recipient_id'   => $recipient->getKey(),
                'no_whatsapp'    => $recipient->no_whatsapp ?? '-',
                'pesan'          => json_encode($params ?? []),
                'status'         => 'error',
                'response'       => 'EXCEPTION: ' . $e->getMessage(),
            ]);

            return [
                'status'   => 'error',
                'response' => $e->getMessage(),
            ];
        }
    }
}