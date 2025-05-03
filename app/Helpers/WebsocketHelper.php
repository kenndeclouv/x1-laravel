<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use WebSocket\Client as WebSocketClient;

class WebSocketHelper
{
    public static function connectToWebSocket($command = "?", $maxAttemps = 5)
    {
        $client = new Client();

        try {
            // Fetch WebSocket token from API
            $response = $client->request('GET', env('SERVER_API_ENDPOINT') . '/api/client/servers/' . env('SERVER_UUID') . '/websocket', [
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
            $websocketResponse = self::connectToWebSocketServer($webSocketUrl, $token, $command);

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
                    'Origin' => env('SERVER_API_ENDPOINT'),
                ],
            ]);

            $ws->send(json_encode([
                "event" => "auth",
                "args" => [$token]
            ]));

            $response = $ws->receive();
            $authResponse = "Response dari WebSocket: " . $response;

            $ws->send(json_encode([
                "event" => "send command",
                "args" => [$command]
            ]));

            $responses = [];

            while (true) {
                $wsMessage = $ws->receive();
                if (!$wsMessage) break;

                $responses[] = $wsMessage;

                // auto stop kalau message udah mengandung data stats yang valid
                if (preg_match('/(cpu_absolute|disk_bytes|memory_bytes|network|uptime)/', $wsMessage)) {
                    break;
                }

                // optional: fallback tambahan
                if (strpos($wsMessage, 'end') !== false) {
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

    public static function getPlayerData($name)
    {
        $commands = [
            "money {$name}",
            "lp user {$name} info"
        ];

        $response = WebSocketHelper::connectToWebSocket(implode("\n", $commands));

        if (isset($response['error']) || !isset($response['websocketResponse']['commandResponse'])) {
            return null;
        }

        $balance = null;
        $rank = null;
        $prefix = null;
        $prefixColor = null;

        foreach ($response['websocketResponse']['commandResponse'] as $entryString) {
            $entry = json_decode(trim($entryString), true);

            if (isset($entry['event']) && $entry['event'] === 'console output' && isset($entry['args'][0])) {
                $line = $entry['args'][0];

                // cari balance
                if ($balance === null && preg_match('/\$([\d,]+)/', $line, $moneyMatch)) {
                    $balance = $moneyMatch[1];
                }

                // cari rank
                if ($rank === null && preg_match('/primarygroup=\x1b\[97m([a-zA-Z0-9_-]+)/', $line, $rankMatch)) {
                    $rank = $rankMatch[1];
                }

                // cari prefix dan warnanyaa
                // if ($prefix === null && preg_match('/\e\[(\d+)m\[\e\[(\d+)m(.*?)\e\[97m\]/', $line, $prefixMatch)) {
                //     $prefix = $prefixMatch[3];

                //     $colorCode = $prefixMatch[2];
                //     $colorMap = [
                //         '31' => '#ff5555',
                //         '32' => '#50fa7b',
                //         '33' => '#f1fa8c',
                //         '34' => '#bd93f9',
                //         '35' => '#ff79c6',
                //         '36' => '#8be9fd',
                //         '97' => '#ffffff',
                //     ];

                //     $prefixColor = $colorMap[$colorCode] ?? '#ffffff';
                // }

                // kalau semua udah ketemu
                if ($balance !== null && $rank !== null) {
                    break;
                }
            }
        }

        return [
            'balance' => $balance,
            'rank' => $rank,
            'prefix' => $prefix,
            'prefix_color' => $prefixColor,
        ];
    }
}
