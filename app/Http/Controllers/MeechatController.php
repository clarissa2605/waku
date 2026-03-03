<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Client\Response;

class MeechatController extends Controller
{
    public function saldo(): JsonResponse
    {
        try {

            /** @var Response $response */
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('MEECHAT_API_KEY'),
                'Accept'        => 'application/json',
            ])->get('https://meechat.id/api/v1/balance');

            if ($response->successful()) {

                $data = $response->json();

                return response()->json([
                    'success'   => true,
                    'saldo'     => $data['data']['balance'] ?? 0,
                    'formatted' => $data['data']['formatted_balance'] ?? 'Rp 0'
                ]);
            }

            return response()->json([
                'success' => false,
                'saldo'   => 0
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'saldo'   => 0
            ]);
        }
    }
}