<?php

use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/incoming', [WebhookController::class, 'incoming']);


Route::middleware('auth.apikey')->group(function () {
    Route::get('/transaction/{reference}', [TransactionController::class, 'show']);
    Route::post('/payment/create', [PaymentController::class, 'create']);
});