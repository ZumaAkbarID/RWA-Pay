<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('merchant_id');
            $table->string('reference')->unique();
            $table->string('customer_reference')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('amount', 18, 2)->nullable();
            $table->decimal('fee', 18, 2)->nullable();
            $table->boolean('fee_merchant')->default(false);
            $table->json('payload')->nullable();
            $table->json('headers')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->integer('response_status')->nullable();
            $table->text('response_body')->nullable();
            $table->integer('retries')->default(0);
            $table->timestamp('last_attempt_at')->nullable();
            $table->timestamps();

            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};