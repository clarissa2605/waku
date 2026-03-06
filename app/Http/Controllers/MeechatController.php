<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class MeechatController extends Controller
{
    public function saldo(): JsonResponse
    {
        try {

            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-API-KEY' => env('MEECHAT_CLIENT_KEY'),
            ])->get(env('MEECHAT_URL') . '/v1/balance');

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil saldo dari MeeChat',
                ]);
            }

            $data = $response->json();

            return response()->json([
                'success' => true,
                'saldo' => $data['balance'] ?? 0,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
