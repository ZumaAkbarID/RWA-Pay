<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function show(string $reference)
    {
        $transaction = Transaction::where('reference', $reference)->first();

        if (! $transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'reference' => $transaction->reference,
                'amount' => $transaction->amount,
                'fee' => $transaction->fee,
                'total' => $transaction->amount + $transaction->fee + (int) $transaction->customer_reference,
                'status' => $transaction->status,
                'qris_static' => $transaction->qris_static,
                'is_manual' => $transaction->is_manual,
                'name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone,
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->updated_at,
                'expired_at' => $transaction->expired_at ? $transaction->expired_at->translatedFormat('d F Y H:i') : null,
            ]
        ]);
    }
}