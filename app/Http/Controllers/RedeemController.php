<?php

namespace App\Http\Controllers;

use App\Helpers\WebSocketHelper;
use App\Models\Redeem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RedeemController extends Controller
{
    public function index()
    {
        return view('landing.redeem');
    }

    public function redeem(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'token' => 'required|string|max:255',
        ]);
        $redeem = Redeem::where('token', $request->token)->first();

        if ($redeem) {
            $message = "> " . $redeem->item->type == 'rank' ? '🔰' : '🪙' . " *" . Str::upper($redeem->item->name) . " " . Str::upper($redeem->item->type) . " REDEEMED*  
> ------------------------------------------
> 👤 User        : *" . $user->name . "*  
> 📦 Item        : *" . $redeem->item->name . "* " . Str::upper($redeem->item->type) . "
> 🕒 Redeemed at: " . now() . "
> ------------------------------------------
> ⚠️ PENDING TO BE ACTIVATED  ";
            // Initialize command variable
            switch ($redeem->item->type) {
                case 'rank':
                    $redeem->user()->update([
                        'item_id' => $redeem->item_id,
                        'item_purchased_at' => now(),
                    ]);
                    $command = "lp user {$user->name} parent addtemp {$redeem->item->code} {$redeem->item->period}d";
                    break;

                case 'money':
                    $command = "eco give {$user->name} {$redeem->item->code}";
                    break;

                default:
                    $command = null; // Handle unexpected types
                    break;
            }

            // Ensure command is not null before connecting to WebSocket
            if ($command) {
                WebSocketHelper::connectToWebSocket($command);
            }
            sendWhatsApp($message);
            $redeem->delete();
            return redirect()->route('landing.redeem.index')->with('success', 'Item redeemed successfully');
        } else {
            return back()->with('error', 'Invalid redeem code :(');
        }
    }
}
