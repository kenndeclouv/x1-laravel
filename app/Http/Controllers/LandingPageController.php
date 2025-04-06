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
        $onlineMembers = $serverData["players"]["online"];
        $totalMembers = $serverData["players"]["max"];
        return view('landing.index', compact('onlineMembers','totalMembers'));
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
        $staffs = Cache::remember('staffs', now()->addMinutes(10), function () {
            return Staff::all();
        });
        return view('landing.staff', compact('staffs'));
    }

    public function thanks()
    {
        return view('landing.thanks');
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
            $response = $client->get("https://panel.nebulasrv.my.id/api/client/servers/" . $server, [
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
