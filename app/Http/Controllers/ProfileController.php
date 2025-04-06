<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Cache::remember('user_' . Auth::id(), now()->addMinutes(10), function () {
            return Auth::user();
        });
        $background = Cache::remember('user_background_' . $user->id, now()->addMinutes(10), function () use ($user) {
            return $user->backgrund;
        });
        return view("app.profile.index", compact("user", "background"));
    }

    public function getMinecraftUuid()
    {
        $user = Cache::remember('user_' . Auth::id(), now()->addMinutes(10), function () {
            return Auth::user();
        });

        $url = "https://panel.nebulasrv.my.id/api/client/servers/" . env('SERVER_UUID') . "/files/contents?file=usercache.json";

        $response = Http::withToken(env("SERVER_API_KEY"))->get($url);

        if (!$response->ok()) {
            return back()->with('error', 'gagal ambil data 😭');
        }

        $players = $response->json();

        $username = $user->minecraft_device == 'bedrock' ? "." . $user->name : $user->name;
        $player = Cache::remember("mc_uuid_{$username}", now()->addMinutes(5), function () use ($players, $username) {
            return collect($players)->firstWhere('name', $username);
        });


        if (!$player) {
            return back()->with('error', 'player ngga ditemuin😭');
        }

        $user->update(['minecraft_uuid' => $player['uuid']]);

        return redirect()->route('profile')->with('success', 'Your Minecraft UUID is ' . $player['uuid']);
    }
    public function getUuidByName($playerName)
    {
        $url = "https://panel.nebulasrv.my.id/api/client/servers/" . env('SERVER_UUID') . "/files/contents?file=usercache.json";

        $response = Http::withToken(env("SERVER_API_KEY"))->get($url);

        if (!$response->ok()) {
            return response()->json(['error' => 'gagal ambil data 😭'], $response->status());
        }

        $players = $response->json();

        $player = collect($players)->firstWhere('name', $playerName);

        if (!$player) {
            return response()->json(['error' => 'player nggak ditemuin 😭']);
        }

        return response()->json([
            'name' => $player['name'],
            'uuid' => $player['uuid'],
        ]);
    }
}
