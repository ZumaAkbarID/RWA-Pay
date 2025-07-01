<?php

namespace App\Models;

use App\Services\QRISService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Transaction extends Model
{
    use HasUuids;

    protected $fillable = [
        'merchant_id',
        'reference',
        'customer_reference',
        'is_manual',
        'name',
        'email',
        'phone',
        'amount',
        'fee',
        'fee_merchant',
        'payload',
        'qris_static',
        'headers',
        'status',
        'response_status',
        'response_body',
        'retries',
        'last_attempt_at',
        'expired_at',
    ];

    protected $casts = [
        'is_manual' => 'boolean',
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'fee_merchant' => 'boolean',
        'payload' => 'array',
        'headers' => 'array',
        'last_attempt_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function generateQrisStatic(): void
    {
        $qrisService = app(QRISService::class);
        $this->qris_static = $qrisService->generateDynamic(
            amount: $this->amount + ($this->fee ?? 0) + (int) $this->customer_reference
        );
    }

    protected static function booted(): void
    {
        static::creating(function (Transaction $transaction) {
            $transaction->generateQrisStatic();
            $transaction->expired_at = now()->addMinutes(30);
        });

        static::updating(function (Transaction $transaction) {
            if ($transaction->isDirty('amount') || $transaction->isDirty('fee')) {
                $transaction->generateQrisStatic();
            }
        });
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}