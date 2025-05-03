<?php

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        return Auth::user()->permissions()->where('code', $permission)->exists();
    }
}
if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd F Y')
    {
        return Carbon\Carbon::parse($date)->format($format);
    }
}
if (!function_exists('sendWhatsApp')) {
    function sendWhatsApp($message)
    {
        $apiKey = env('WHATSAPP_API_KEY'); // ganti dengan api key dari callmebot
        $number = env('WHATSAPP_NUMBER');
        $apiUrl = "https://api.callmebot.com/whatsapp.php?phone={$number}&text=" . urlencode($message) . "&apikey={$apiKey}";

        $client = new Client();
        $response = $client->get($apiUrl);

        return json_decode($response->getBody(), true);
    }
}
if (!function_exists('getDiscordData')) {
    function getGuildMembers()
    {
        $guildId = env('DISCORD_GUILD_ID'); // Ganti dengan ID server Anda
        $botToken = env('DISCORD_BOT_TOKEN'); // Ganti dengan token bot Anda

        $client = new Client();

        try {
            $response = $client->get("https://discord.com/api/v10/guilds/{$guildId}/members?limit=1000", [
                'headers' => [
                    'Authorization' => "Bot {$botToken}",
                ],
            ]);

            $members = json_decode($response->getBody(), true);

            // Hitung jumlah anggota
            $totalMembers = count($members);

            // Hitung jumlah anggota online
            $onlineMembers = 0;
            foreach ($members as $member) {
                if (isset($member['presence']) && $member['presence']['status'] === 'online') {
                    $onlineMembers++;
                }
            }

            return response()->json([
                'total_members' => $totalMembers,
                'online_members' => $onlineMembers,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
if (!function_exists('getMinecraftServerData')) {
    function getMinecraftServerData()
    {
        $server = env('MINECRAFT_SERVER');

        $client = new Client();

        try {
            $response = $client->get("https://api.mcstatus.io/v2/status/java/" . $server);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
if (!function_exists('getServerData')) {
    function getServerData()
    {
        $server = env('SERVER_UUID');

        $client = new Client();

        try {
            $response = $client->get(env('SERVER_API_ENDPOINT') . "/api/client/servers/" . $server, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('SERVER_API_KEY'),
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
