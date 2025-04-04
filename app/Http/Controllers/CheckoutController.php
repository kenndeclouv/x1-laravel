<?php

namespace App\Http\Controllers;

use App\Helpers\WebSocketHelper;
use App\Models\Item;
use App\Models\Redeem;
use App\Models\Staff;
use App\Models\Transaction;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Midtrans\Config as MidtransConfig;
use WebSocket\Client as WebSocketClient;

class CheckoutController extends Controller
{
    public function payment(Transaction $transaction)
    {
        $item = Item::find($transaction->item_id);
        return view('landing.payment', compact('transaction', 'item'));
    }

    public function storeTransaction(Item $item, Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'is_gift' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        MidtransConfig::$serverKey = config('midtrans.serverKey');
        MidtransConfig::$isProduction = config('midtrans.isProduction');
        MidtransConfig::$isSanitized = config('midtrans.isSanitized');
        MidtransConfig::$is3ds = config('midtrans.is3ds');

        $time = time();
        $orderId = "X1MC{$item->type}-{$time}";

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderId,
                'gross_amount' => $item->price,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $transaction = Transaction::create([
            'order_id' => $orderId,
            'user_id' => Auth::user()->id,
            'item_id' => $item->id,
            'is_gift' => $validated['is_gift'] ?? 0,
            'description' => $validated['description'] ?? null,
            'snap_token' => $snapToken,
        ]);

        return redirect()->route('landing.checkout.payment', $transaction->id);
    }

    public function paymentSuccess(Transaction $transaction)
    {
        $midtransStatus = $this->checkTransactionStatus($transaction->order_id);
        if ($midtransStatus !== 'settlement') {
            return redirect()->route('landing.checkout.payment', $transaction->id)->with('error', 'Pembayaran belum dikonfirmasi.');
        }
        $transaction->update([
            'status' => 'paid',
        ]);

        if ($transaction->is_gift) {
            $token = Str::random(5) . '-' . Str::random(5) . '-' . Str::random(5) . '-' . Str::random(5) . '-' . Str::random(5);
            Redeem::create([
                'token' => $token,
                'item_id' => $transaction->item_id,
                'description' => $transaction->description,
            ]);

            $message = "> 📃 *" . Str::upper($transaction->item->name) . " " . Str::upper($transaction->item->type) . " REDEEM CODE*  
> ------------------------------------------
> 👤 User        : *" . $transaction->user->name . "*  
> 📦 Item        : *" . Str::upper($transaction->item->name) . "* " . Str::upper($transaction->item->type) . "
> 🕒 Purchased at: " . $transaction->updated_at . "  
> 💳 Status      : *PAID*  
> 📃 Redeem      : " . $token . "
> ------------------------------------------
> 🚫 NOT REDEEMED YET";

            sendWhatsApp($message);
            return redirect()->route('landing.store')->with('success', 'Redeem code is: ' . $token);
        } else {
            // Initialize command variable
            switch ($transaction->item->type) {
                case 'rank':
                    $transaction->user()->update([
                        'item_id' => $transaction->item_id,
                        'item_purchased_at' => now(),
                    ]);
                    $command = "lp user {$transaction->user->name} parent addtemp {$transaction->item->code} {$transaction->item->period}d";
                    break;

                case 'money':
                    $command = "eco give {$transaction->user->name} {$transaction->item->code}";
                    break;

                default:
                    $command = null; // Handle unexpected types
                    break;
            }

            // Ensure command is not null before connecting to WebSocket
            if ($command) {
                WebSocketHelper::connectToWebSocket($command);
            }

            $transaction->update([
                'status' => 'PAID',
            ]);

            $message = "> " . ($transaction->type == 'rank' ? '🔰' : '🪙') . " *" . Str::upper($transaction->item->name) . " " . Str::upper($transaction->item->type) . " PURCHASED*  
> ------------------------------------------
> 👤 User        : *" . $transaction->user->name . "*  
> 📦 Item        : *" . Str::upper($transaction->item->name) . "* " . Str::upper($transaction->item->type) . "
> 🕒 Purchased at: " . $transaction->updated_at . "  
> 💳 Status      : *PAID*  
> ------------------------------------------
> ⚠️ PENDING TO BE ACTIVATED";

            sendWhatsApp($message);
            // $responseMessage = $response['commandResponse'] ?? 'No response from WebSocket';
            // return redirect()->route('landing.store')->with('success', "Item purchased successfully! Wait for admin to confirm it :) {$responseMessage}");
            return redirect()->route('landing.store')->with('success', "Item purchased successfully! Wait for admin to confirm it :)");
        }
    }

    // fungsi buat cek status transaksi ke Midtrans
    public function checkTransactionStatus($orderId)
    {
        $serverKey = config('midtrans.serverKey');
        $url = "https://api." . (config('midtrans.isProduction') ? '' : 'sandbox.') . "midtrans.com/v2/{$orderId}/status";

        $response = Http::withBasicAuth($serverKey, '')
            ->get($url)
            ->json();

        return $response['transaction_status'] ?? 'unknown';
        // return $response;
    }
}
