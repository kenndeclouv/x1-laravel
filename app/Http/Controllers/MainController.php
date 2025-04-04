<?php

namespace App\Http\Controllers;

use App\Helpers\WebSocketHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $money = $user->getMoney();
        return view('app.home.index', compact('money'));
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