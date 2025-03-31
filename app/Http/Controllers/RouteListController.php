<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class RouteListController extends Controller
{
    public function index()
    {
        $routes = Route::getRoutes();
        return view('app.route_list.index', compact('routes'));
    }
}
