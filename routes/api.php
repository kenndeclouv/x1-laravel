<?php

use App\Helpers\WebSocketHelper;
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
Route::get('/minecraft-server', [LandingPageController::class, 'getMinecraftServerData']);
Route::post('/create-qris', [QrisController::class, 'createQris']);
Route::post('/status-qris', [QrisController::class, 'checkStatus']);
Route::get('/app-setting', function () {
    $data = AppSetting::first();
    return response()->json($data);
});

Route::group(['prefix' => 'server', 'as' => 'server.'], function () {
    Route::get('data', [LandingPageController::class, 'getServerData']);
    Route::get('websocket/{command}', function ($command) {
        $response = WebSocketHelper::connectToWebSocket($command);

        // Mengembalikan response dari WebSocket
        if (isset($response['error'])) {
            return response()->json([
                'error' => $response['error'],
            ], 500);
        }

        return response()->json([
            'authResponse' => $response['authResponse'] ?? 'No auth response',
            'commandResponse' => $response['commandResponse'] ?? 'No command response',
        ]);
    })->name('websocket');
});
