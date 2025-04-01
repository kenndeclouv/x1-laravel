<?php

use Illuminate\Support\Facades\Auth;

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