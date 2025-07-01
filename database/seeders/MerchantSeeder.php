<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Merchant::create([
            'name' => 'Demo Merchant',
            'api_key' => 'demo_key_123456',
            'api_secret' => 'demo_secret_7890',
            'target_url' => 'https://webhook-test.com/1afe2a8bb9bb0869e9f5176fd106df13',
            'default_fee' => 1000,
            'fee_flat' => 100,
            'fee_percent' => 0.7,
            'fee_merchant' => true,
            'is_active' => true,
        ]);
    }
}