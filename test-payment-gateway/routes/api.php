<?php

use App\Http\Controllers\PaymentGatewayController;
use App\Http\Middleware\RestrictIpMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/payment-init', [PaymentGatewayController::class, 'getUrl']);

Route::post('/payment-gateway-callback', [PaymentGatewayController::class, 'gatewayCallback'])
    ->middleware(RestrictIpMiddleware::class);
