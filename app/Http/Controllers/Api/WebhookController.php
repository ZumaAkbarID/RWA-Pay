<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendWebhookJob;
use App\Models\Transaction;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function incoming(Request $request)
    {
        $headerToken = $request->header('X-Listener-Token');

        if ($headerToken !== config('listener.secret')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $data = $request->validate([
            'title' => 'required|string',
            'text' => 'required|string',
        ]);

        preg_match('/Rp([\d.]+)(?:\D+|$)/', $data['text'], $matches);

        if (isset($matches[1])) {
            $rawAmount = str_replace('.', '', $matches[1]); // ex: "51823"

            if (strlen($rawAmount) >= 3) {
                $amount = (int) substr($rawAmount, 0, -3) * 1000; // 51 * 1000 = 51000
                $code = substr($rawAmount, -3);                  // 823
            } else {
                $amount = null;
                $code = null;
            }
        } else {
            $rawAmount = null;
            $amount = null;
            $code = null;
        }

        if (!$code) {
            return response()->json(['success' => false, 'message' => 'Kode unik tidak ditemukan.'], 400);
        }

        // Cari transaksi berdasarkan kode unik (customer_reference)
        $transaction = Transaction::where('customer_reference', $code)
            ->where('status', 'pending')
            ->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan atau sudah diproses.',
            ], 404);
        }

        $transaction->update([
            'status' => 'success',
            'payload' => [
                'title' => $data['title'],
                'text' => $data['text'],
                'matched_amount' => $amount,
                'received_amount' => $rawAmount ?? 0,
            ],
        ]);

        SendWebhookJob::dispatch($transaction);

        return response()->json([
            'success' => true,
            'message' => 'Webhook diterima & diteruskan ke merchant.',
        ]);
    }
}