<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Merchant extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'api_key',
        'api_secret',
        'target_url',
        'fee_flat',
        'fee_percent',
        'is_active',
        'fee_merchant',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'fee_merchant' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($merchant) {
            $merchant->api_key = Uuid::uuid4()->toString();
            $merchant->api_secret = Uuid::uuid7()->toString();
        });
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}