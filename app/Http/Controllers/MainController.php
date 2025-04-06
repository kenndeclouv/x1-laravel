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

        // Caching money (5 menit) -> kalau null, tetap cache sebagai `0`
        $money = Cache::remember('user_money_' . $user->id, now()->addMinutes(5), function () use ($user) {
            $moneyAmount = $user->getMoney();
            return $moneyAmount !== null ? $moneyAmount : 0; // Cache 0 kalau null
        });

        // Caching skin (10 menit) -> kalau null, tetap cache sebagai `null`
        $skin = Cache::remember('user_skin_' . $user->id, now()->addMinutes(10), function () use ($user) {
            return $user->skin ?: null; // Cache null kalau skin gak ada
        });

        return view('app.home.index', compact('money', 'skin', 'user'));
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
