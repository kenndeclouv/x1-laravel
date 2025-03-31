<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('app.home.index');
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