<?php

namespace App\Http\Controllers;

use App\Services\Payment\PaymentHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    protected PaymentHandler $paymentHandler;

    public function __construct(PaymentHandler $paymentHandler)
    {
        $this->paymentHandler = $paymentHandler;
    }

    public function getUrl(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required',
        ]);
        //$userId = $request->getUser()->id;
        $amount = $request->input('amount');
        $userId = 1;

        $result = $this->paymentHandler->initPayment($userId, $amount);

        if($result['success']){

            // Return redirect()->away($result['data']['url']);
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
    public function gatewayCallback(Request $request)
    {
        $result = $this->paymentHandler->handlePaymentCallback($request);
        if($result['success']){
            return response()->json([
                'success' => true,
                'message' => '',
                'data'=> $result['data']
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
