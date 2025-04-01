<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Staff;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }
    public function rules()
    {
        return view('landing.rules');
    }
    public function store()
    {
        $items = Item::all();
        return view('landing.store', compact('items'));
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
        $staffs = Staff::all();
        return view('landing.staff', compact('staffs'));
    }
    public function getGuildMembers()
    {
        $guildId = '1314236534484111370'; // Ganti dengan ID server Anda
        $botToken = 'MTMxNjYyMjcxMjA0MjQyMjM5Mg.Gg731W.1v81B_suK6QrSd7VXcyBrsN24x_eWsdncc62sY'; // Ganti dengan token bot Anda

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
