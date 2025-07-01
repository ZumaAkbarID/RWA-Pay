<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\FeeService;
use App\Services\QRISService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private function generateUniqueCode(string $merchantId): string
    {
        do {
            $code = str_pad(rand(1, 200), 3, '0', STR_PAD_LEFT);
        } while (
            Transaction::where('merchant_id', $merchantId)
            ->where('customer_reference', $code)
            ->where('status', 'pending')
            ->exists()
        );

        return $code;
    }

    public function create(Request $request)
    {
        $merchant = $request->get('merchant');

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'name' => 'nullable|string|max:100',
        ]);

        // generate customer_reference unik (3 digit)
        $customerReference = $this->generateUniqueCode($merchant->id);

        // generate reference global
        $reference = strtoupper(Str::random(12));

        $fee = FeeService::calculateFee(
            $validated['amount'],
            $merchant->fee_flat,
            $merchant->fee_percent
        );

        $generatedQris = app(QRISService::class)->generateDynamic(
            amount: $validated['amount'] + $fee + (int) $customerReference,
        );

        $transaction = Transaction::create([
            'merchant_id' => $merchant->id,
            'reference' => $reference,
            'customer_reference' => $customerReference,
            'amount' => $validated['amount'],
            'fee' => $fee,
            'qris_static' => $generatedQris,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'name' => $validated['name'] ?? null,
            'is_manual' => false,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'reference' => $transaction->reference,
            'customer_reference' => $transaction->customer_reference,
            'amount_with_code' => $transaction->amount + (int) $transaction->customer_reference,
            'fee' => $fee,
            'final_total' => $transaction->amount + $fee + (int) $transaction->customer_reference,
            'qris_static' => $generatedQris,
            'expired_at' => $transaction->expired_at->translatedFormat('d F Y H:i'),
        ]);
    }
}