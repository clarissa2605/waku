<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use App\Helpers\LogHelper;

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
            
            LogHelper::simpan(
    'Cek Saldo Meechat',
    'WhatsApp API',
    'Admin mengecek saldo API Meechat'
);
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
