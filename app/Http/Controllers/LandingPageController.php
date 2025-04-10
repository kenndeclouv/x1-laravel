<?php

namespace App\Http\Controllers;

use App\Helpers\WebSocketHelper;
use App\Models\Item;
use App\Models\Staff;
use WebSocket\Client as WebSocketClient;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LandingPageController extends Controller
{
    public function index()
    {
        $serverData = Cache::remember('server_data', now()->addMinutes(10), function () {
            return json_decode($this->getMinecraftServerData()->getContent(), true);
        });
        $onlineMembers = $serverData["players"]["online"] ?? 0;
        $totalMembers = $serverData["players"]["max"] ?? 0;
        $onlineMemberList = $serverData["players"]["list"] ?? null;
        return view('landing.index', compact('onlineMembers', 'totalMembers', 'onlineMemberList'));
    }
    public function rules()
    {
        return view('landing.rules');
    }
    public function store()
    {
        $ranks = Cache::remember('ranks', now()->addMinutes(10), function () {
            return Item::where('type', 'rank')->get();
        });
        $moneys = Cache::remember('moneys', now()->addMinutes(10), function () {
            return Item::where('type', 'money')->get();
        });
        return view('landing.store', compact('ranks', 'moneys'));
    }
    public function checkout(Item $item)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('url', '/checkout/' . $item->id);
        }
        return view('landing.checkout', compact('item'));
    }
    public function staff()
    {
        // $staffs = Cache::remember('staffs', now()->addMinutes(10), function () {
        //     return Staff::all();
        // });
        $staffs = [
            [
                'name' => 'Vinn',
                'photo' => 'vinn.jpg',
                'role' => 'Founder',
            ],
            [
                'name' => 'PixyPAYCRAFT',
                'photo' => 'pixypaycraft.jpg',
                'role' => 'Developer',
                'link' => 'https://instagram.com/pxclvr',
            ],
            [
                'name' => 'kenndeclouv',
                'photo' => 'kenndeclouv.png',
                'role' => 'Developer',
                'link' => 'https://kenndeclouv.my.id',
                'minecraft_device' => 'java',
            ],
            [
                'name' => 'AkangHaise',
                'photo' => 'akanghaise.png',
                'role' => 'Inspector',
                'link' => 'https://instagram.com/maktanul',
            ],
            [
                'name' => 'Ririink',
                'photo' => 'ririink.png',
                'role' => 'Helper',
                'link' => 'https://instagram.com/vnist_sir',
            ],
            [
                'name' => 'Ratma_hikaru',
                'photo' => 'ratma_hikaru.png',
                'role' => 'Helper',
                'link' => 'https://tiktok.com/@rinnechhi_1',
            ],
            [
                'name' => 'Rannkanaeru',
                'photo' => 'rannkanaeru.jpg',
                'role' => 'Helper',
                'link' => 'https://instagram.com/rannkanaeru',
            ],
            [
                'name' => 'JumHzx',
                'photo' => 'jumhzx.png',
                'role' => 'Moderator',
                'link' => 'https://instagram.com/jumhzx',
            ],
            [
                'name' => 'Little_Craft6113',
                'photo' => 'little_craft6113.png',
                'role' => 'Helper',
                'link' => 'https://instagram.com/litte_craft6113',
            ],
            [
                'name' => 'Corvusion4249',
                'photo' => 'corvusion4249.png',
                'role' => 'Moderator',
                'link' => 'https://instagram.com/corpsiyon',
            ],
            [
                'name' => 'Finnlapox',
                'photo' => 'finnlapox.png',
                'role' => 'Moderator',
                'link' => 'https://instagram.com/finnhxh',
            ],
        ];
        return view('landing.staff', compact('staffs'));
    }

    public function thanks()
    {
        return view('landing.thanks');
    }

    public function maps()
    {
        return view('landing.maps');
    }
    public function getGuildMembers()
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
    public function getMinecraftServerData()
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
    public function getServerData()
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
    public function connectToWebSocket($command)
    {
        $response = WebSocketHelper::connectToWebSocket($command);
        return response()->json($response);
    }
}
