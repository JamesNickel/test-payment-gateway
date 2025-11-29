<?php

use App\Http\Controllers\PaymentGatewayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/payment-init', [PaymentGatewayController::class, 'init']);
Route::post('/payment-gateway-callback', [PaymentGatewayController::class, 'callback']);
//->middleware(GatewayIpLimiter::class);
