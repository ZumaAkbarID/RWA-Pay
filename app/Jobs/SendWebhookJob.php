<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWebhookJob implements ShouldQueue
{
    use Queueable;

    public Transaction $transaction;

    /**
     * Create a new job instance.
     */

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function middleware(): array
    {
        return [
            new ThrottlesExceptions(5, 60), // max 5 error per minute
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transaction = $this->transaction->fresh(); // latest data
        $merchant = $transaction->merchant;

        if (!$merchant || !$merchant->is_active) {
            return;
        }

        $payload = array_merge(
            $transaction->payload ?? [],
            [
                'reference' => $transaction->reference,
                'customer_reference' => $transaction->customer_reference,
                'amount' => $transaction->amount,
                'fee' => $transaction->fee,
                'qris_static' => $transaction->qris_static,
                'status' => $transaction->status,
                'email' => $transaction->email,
                'name' => $transaction->name,
                'phone' => $transaction->phone,
                'is_manual' => $transaction->is_manual,
            ]
        );

        $signature = hash_hmac('sha256', json_encode($payload), $merchant->api_secret);

        try {
            $response = Http::withHeaders([
                'X-Api-Key' => $merchant->api_key,
                'X-Signature' => $signature,
                'Accept' => 'application/json',
            ])->post($merchant->target_url, $payload);

            $transaction->update([
                'status' => $response->successful() ? 'success' : 'failed',
                'response_status' => $response->status(),
                'response_body' => $response->body(),
                'last_attempt_at' => now(),
                'retries' => $transaction->retries + 1,
            ]);
        } catch (\Throwable $e) {
            $transaction->update([
                'status' => 'failed',
                'response_status' => 0,
                'response_body' => $e->getMessage(),
                'last_attempt_at' => now(),
                'retries' => $transaction->retries + 1,
            ]);

            Log::error('Webhook failed for transaction ' . $transaction->reference, [
                'merchant_id' => $merchant->id,
                'merchant_target_url' => $merchant->target_url,
                'transaction_id' => $transaction->id,
                'transaction_reference' => $transaction->reference,
                'transaction_status' => $transaction->status,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}