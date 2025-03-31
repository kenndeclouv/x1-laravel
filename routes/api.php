<?php

use App\Http\Controllers\LandingPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\QrisController;
use App\Models\AppSetting;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/search-data', [SearchController::class, 'getNavigation']);
Route::get('/discord-members', [LandingPageController::class, 'getGuildMembers']);
Route::post('/create-qris', [QrisController::class, 'createQris']);
Route::post('/status-qris', [QrisController::class, 'checkStatus']);
Route::get('/app-setting', function () {
    $data = AppSetting::first();
    return response()->json($data);
});