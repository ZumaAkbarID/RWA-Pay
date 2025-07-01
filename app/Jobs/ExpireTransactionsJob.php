<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ExpireTransactionsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Transaction::where('status', 'pending')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<=', now())
            ->chunk(100, function ($transactions) {
                foreach ($transactions as $transaction) {
                    $transaction->update(['status' => 'expired']);

                    // Kirim webhook via job
                    SendWebhookJob::dispatch($transaction);
                }
            });

        Log::channel('expire-job')->info('[✓] Transaksi expired diproses dan webhook dikirim via queue');
    }
}