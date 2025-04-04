<?php

namespace App\View\Components\layouts\sections;

use App\Helpers\WebSocketHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class nav extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = Auth::user();
        // $money = $user->money;
        $money = WebSocketHelper::getPlayerBalance($user->name);
        // dd($money);
        return view('components.layouts.sections.nav', compact('user', 'money'));
    }
}
