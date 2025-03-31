<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlipQrisService;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class QrisController extends Controller
{
    protected $qrisService;

    public function __construct(FlipQrisService $qrisService)
    {
        $this->qrisService = $qrisService;
    }

    public function createQris(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        $orderId = 'X1MC-' . time(); // contoh invoice id

        $qris = $this->qrisService->createQris($request->amount, $orderId);

        return response()->json($qris);
    }

    public function checkStatus(Request $request)
    {
        Log::info('Webhook Flip:', $request->all());

        $data = $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|string', // "PAID" atau "EXPIRED"
        ]);

        if ($data['status'] === 'PAID') {
            Transaction::where('order_id', $data['order_id'])
                ->update(['status' => 'paid']);
        }

        return response()->json(['message' => 'Webhook received'], 200);
    }
}
