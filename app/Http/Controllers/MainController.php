<?php

namespace App\Http\Controllers;

use App\Helpers\WebSocketHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Caching money (15 menit) -> kalau null, tetap cache sebagai `0`
        $userMinecraftData = [];
        if (!$user->roles->contains('code', env('APP_HIGHEST_ROLE', 'super_admin'))) {
            $userMinecraftData = Cache::remember('user_minecraft_data_' . $user->id, now()->addMinutes(15), function () use ($user) {
                $userMinecraftData = $user->getMinecraftData();
                return $userMinecraftData !== null ? $userMinecraftData : []; // Cache 0 kalau null
            });
        }

        $skin = Cache::remember('user_skin_' . $user->id, now()->addMinutes(10), function () use ($user) {
            return $user->skin ?: null;
        });

        $minecraftData = Cache::remember('server_data', now()->addMinutes(10), function () {
            return json_decode(getMinecraftServerData()->getContent(), true);
        });
        return view('app.home.index', compact('userMinecraftData', 'minecraftData', 'skin', 'user'));
    }


    public function profile()
    {
        return view('app.profile.index');
    }

    public function settings()
    {
        return view('app.settings.index');
    }
}
