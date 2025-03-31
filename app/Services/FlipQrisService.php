<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class FlipQrisService
{
    protected $apiKey;
    protected $qrisUrl;

    public function __construct()
    {
        $this->apiKey = env('FLIP_API_KEY');
        $this->qrisUrl = env('FLIP_QRIS_URL');
    }

    public function createQris($amount, $orderId)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->qrisUrl . '/transactions', [
            'amount' => $amount,
            'order_id' => $orderId,
        ]);

        return $response->json();
    }
}
