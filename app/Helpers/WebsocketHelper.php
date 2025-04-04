<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use WebSocket\Client as WebSocketClient;

class WebSocketHelper
{
    public static function connectToWebSocket($command)
    {
        $client = new Client();

        try {
            // Fetch WebSocket token from API
            $response = $client->request('GET', 'https://panel.nebulasrv.my.id/api/client/servers/' . env('SERVER_UUID') . '/websocket', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('SERVER_API_KEY'),
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['data']['token']) || !isset($data['data']['socket'])) {
                return [
                    'error' => 'Invalid API response: Missing token or socket URL.',
                ];
            }

            $token = $data['data']['token'];
            $webSocketUrl = $data['data']['socket'];

            // Connect to WebSocket server and get the response
            $websocketResponse = self::connectToWebSocketServer($webSocketUrl, $token, $command ?? '?');

            return [
                'message' => 'WebSocket connection initiated',
                'token' => $token,
                'webSocketUrl' => $webSocketUrl,
                'websocketResponse' => $websocketResponse,
            ];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->hasResponse() ? $e->getResponse() : null;
            $statusCode = $response ? $response->getStatusCode() : 500;
            $errorMessage = $response ? $response->getBody()->getContents() : $e->getMessage();

            return [
                'error' => 'Failed to get WebSocket token from API',
                'message' => $errorMessage,
            ];
        } catch (\Exception $e) {
            return [
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function connectToWebSocketServer($url, $token, $command)
    {
        $ws = null;
        try {
            $ws = new WebSocketClient($url, [
                'headers' => [
                    'Origin' => 'https://panel.nebulasrv.my.id',
                ],
            ]);

            // Kirim event auth setelah koneksi terbuka
            $ws->send(json_encode([
                "event" => "auth",
                "args" => [$token]
            ]));

            // Tunggu respon auth
            $response = $ws->receive();
            $authResponse = "Response dari WebSocket: " . $response;

            // Kalau sukses, baru kirim perintah
            $ws->send(json_encode([
                "event" => "send command",
                "args" => [$command]
            ]));

            // $startTime = time();
            // $timeout = 5; // timeout dalam detik

            // $responses = [];
            // while ((time() - $startTime) < $timeout) {
            //     $wsMessage = $ws->receive();
            //     if (!$wsMessage) break;
            //     $responses[] = $wsMessage;

            //     if (strpos($wsMessage, 'end') !== false) {
            //         break;
            //     }
            // }
            $maxAttempts = 5; // maksimal nerima 10 pesan biar ga loop terus
            $responses = [];

            for ($i = 0; $i < $maxAttempts; $i++) {
                $wsMessage = $ws->receive();
                if (!$wsMessage) break; // stop kalo ga ada respon
                $responses[] = $wsMessage;

                if (strpos($wsMessage, 'end') !== false) { // Sesuaikan ini kalo ada tanda akhir respon
                    break;
                }
            }

            return [
                'authResponse' => $authResponse,
                'commandResponse' => $responses,
            ];
        } catch (\Exception $e) {
            return [
                'error' => 'WebSocket Error',
                'message' => $e->getMessage(),
            ];
        } finally {
            if ($ws) {
                $ws->close();
            }
        }
    }
    public static function getPlayerBalance($name)
    {
        $response = WebSocketHelper::connectToWebSocket("money {$name}");

        if (isset($response['error'])) {
            return null; // atau kasih default balance
        }

        foreach ($response['websocketResponse']['commandResponse'] as $entryString) {
            $entry = json_decode(trim($entryString), true);

            if (isset($entry['event']) && $entry['event'] === 'console output' && isset($entry['args'][0])) {
                if (preg_match('/\\$([\d,]+)/', $entry['args'][0], $matches)) {
                    return $matches[1]; // langsung return balance tanpa loop lanjut
                }
            }
        }

        return null; // default kalau balance ga ketemu
    }
}