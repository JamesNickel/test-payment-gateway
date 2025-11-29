<?php

namespace App\Http\Controllers;

use App\Classes\Payment\MellatGateway;
use App\Classes\Payment\PaymentHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{


    public function init(Request $request): JsonResponse
    {
        $paymentGateway = new MellatGateway();
        $paymentHandler = new PaymentHandler($paymentGateway);
        //$userId = $request->getUser()->id;
        $userId = 1;
        $amount = $request->input('amount');
        $result = $paymentHandler->initPayment($userId, $amount);
        //$result['success'] = true;
        //$result['data'] = [];

        if($result['success']){

            // Return redirect()->away('https://www.example.com');
            return response()->json([
                'success' => true,
                'url' => $result['data']['url'],
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ]);
        }
    }
    public function callback(Request $request): JsonResponse
    {
        $paymentGateway = new MellatGateway();
        $paymentHandler = new PaymentHandler($paymentGateway);
        $result = $paymentHandler->handlePaymentCallback($request);
        if($result['success']){
            return response()->json([
                'success' => true,
                'message' => '',
                'data'=> []
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ]);
        }
    }
}
