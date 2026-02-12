<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class WhatsAppService
{
    public static function send(string $target, string $message): array
    {
        try {

            /** @var Response $response */
            $response = Http::withHeaders([
                'Authorization' => config('services.fonnte.api_key'),
            ])->asForm()->post(config('services.fonnte.base_url'), [
                'target'      => $target,
                'message'     => $message,
            ]);

            if ($response->successful()) {
                return [
                    'status'   => true,
                    'response' => $response->json(),
                ];
            }

            return [
                'status'   => false,
                'response' => $response->body(),
            ];

        } catch (\Throwable $e) {
            return [
                'status'   => false,
                'response' => $e->getMessage(),
            ];
        }
    }
}
