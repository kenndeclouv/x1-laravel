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
            return json_decode(getMinecraftServerData()->getContent(), true);
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
        $ranks = Cache::remember('ranks', now()->addDay(), function () {
            return Item::where('type', 'rank')->get();
        });
        $moneys = Cache::remember('moneys', now()->addDay(), function () {
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
                'photo' => 'kennrender.png',
                'role' => 'Developer',
                'link' => 'https://kenndeclouv.my.id',
                'minecraft_device' => 'java',
            ],
            [
                'name' => 'AkangHaise',
                'photo' => 'akangrender.png',
                'role' => 'Inspector',
                'link' => 'https://instagram.com/maktanul',
            ],
            [
                'name' => 'Ririink',
                'photo' => 'ririinkrender.png',
                'role' => 'Helper',
                'link' => 'https://instagram.com/vnist_sir',
            ],
            [
                'name' => 'Ratma_hikaru',
                'photo' => 'rinnerender.png',
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
                'photo' => 'jumrender.png',
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
                'photo' => 'finarender.png',
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
}
