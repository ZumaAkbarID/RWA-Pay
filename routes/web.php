<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/qris', function (Request $request) {
    $qrisService = new App\Services\QRISService();

    $dynamicQris = $qrisService->generateDynamic(
        qrisStatic: config('qris.static'),
        amount: $request->amount,
        fee: $request->service_fee ? [ // gak working cik
            'type' => $request->fee_type, // 'r' or 'p'
            'value' => $request->fee_value
        ] : null
    );

    return response()->json(['qris' => $dynamicQris]);
});