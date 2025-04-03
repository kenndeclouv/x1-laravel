<?php

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        return Auth::user()->permissions()->where('code', $permission)->exists();
    }
}
if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd F Y')
    {
        return Carbon\Carbon::parse($date)->format($format);
    }
}
if (!function_exists('sendWhatsApp')) {
    function sendWhatsApp($message)
    {
        $apiKey = env('WHATSAPP_API_KEY'); // ganti dengan api key dari callmebot
        $number = env('WHATSAPP_NUMBER');
        $apiUrl = "https://api.callmebot.com/whatsapp.php?phone={$number}&text=".urlencode($message)."&apikey={$apiKey}";
    
        $client = new Client();
        $response = $client->get($apiUrl);
    
        return json_decode($response->getBody(), true);
    }
}
