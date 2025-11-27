<?php

use App\Payment\PaymentGateway;
use Illuminate\Support\Facades\DB;

class PaymentHandler
{
    private PaymentGateway $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway){
        $this->paymentGateway = $paymentGateway;
    }

    public function initPayment($user, $amount): void{

        $paymentObject = [
            'user_id'=> $user->id,
            'amount'=> $amount,
            'request_number'=> $this->createRandomRequestNumber(),
            'tracking_code'=> '',
            'url'=> '',
            'status'=> 'started',
            'response_data'=> '{}',
            'gateway'=> $this->paymentGateway->gateway,
            'gateway_request_id'=> '',
            'created_at'=> now()->timestamp,
            'updated_at'=> now()->timestamp,
        ];
        DB::table('payments')->insert($paymentObject);

        $response = $this->paymentGateway->getPaymentUrl($paymentObject);

        if($response['success']){
            // TODO: Create redirecting response and return
            // TODO: Redirect user to the payment url

            $paymentObject = $response['result'];
        }
        else{
            // TODO: Create fail response and return
            // $response['message'] = 'error message'
        }
        DB::table('payments')
            ->where('id', $paymentObject['id'])
            ->update(['status'=> 'initiated']);
    }

    public function handlePaymentCallback($request): void{

        // TODO: parse gateway request and extract 'gateway_request_id', 'request_number'
        $requestNumber = ''; // extract from request
        $gatewayRequestId = ''; // extract from request

        DB::table('payments')
            ->where('request_number', $requestNumber)
            ->update(['status'=> 'initiated']);
        $paymentObject = DB::table('payments')
            ->where('request_number', $requestNumber)
            ->first();

        $response = $this->paymentGateway->verifyPayment($paymentObject);

        if($response['success']){

            $paymentObject = $response['result'];
            DB::table('payments')
                ->where('request_number', $requestNumber)
                ->update([
                    'status'=> 'successful',
                ]);

            $this->paymentGateway->onPaymentSuccess($paymentObject);
        }
        else{
            DB::table('payments')
                ->where('request_number', $requestNumber)
                ->update([
                    'status'=> 'failed',
                ]);

            $this->paymentGateway->onPaymentError($paymentObject, $response['message']);
        }

    }

    public function checkPaymentStatus($paymentObject): void{

        $response = $this->paymentGateway->inquirePayment($paymentObject);

        if($response['success']){

            //$response['result'] = $paymentObject
        }
        else{
            // TODO: Create fail response and return
            // $response['message'] = 'error message'
        }

    }

    private function createRandomRequestNumber(): string
    {
        return ""; // TODO: create random string
    }
}
