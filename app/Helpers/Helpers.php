<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        return Auth::user()->permissions()->where('code', $permission)->exists();
    }
}
