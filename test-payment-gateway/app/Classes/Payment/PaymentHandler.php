<?php

namespace App\Classes\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentHandler
{
    private PaymentGateway $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway){
        $this->paymentGateway = $paymentGateway;
    }

    public function initPayment($userId, $amount): array
    {

        $paymentId = DB::table('payments')->insertGetId([
            'user_id'=> $userId,
            'amount'=> $amount,
            'request_number'=> $this->createRandomRequestNumber(),
            'tracking_code'=> '',
            'gateway'=> $this->paymentGateway->gateway,
            'gateway_request_id'=> '',
            'created_at'=> now()->timestamp,
            'updated_at'=> now()->timestamp,
        ]);
        $paymentObject = DB::table('payments')->where('id', $paymentId)->first();

        DB::table('payment_logs')->insert([
            'payment_id'=> $paymentId,
            'status'=> 'init',
            'created_at'=> now()->timestamp,
        ]);

        $response = $this->paymentGateway->getPaymentUrl($paymentObject);
        $result = $response['result'];

        if($response['success']){

            $url = $result['url'];

            DB::table('payments')
                ->where('id', $paymentId)
                ->update([
                    'gateway_request_id' => $result['gateway_request_id'],
                ]);

            DB::table('payment_logs')->insert([
                'payment_id'=> $paymentId,
                'status'=> 'init_success',
                'bank_status'=> $result['bank_status'],
                'raw_response'=> $result['raw_response'],
                'created_at'=> now()->timestamp,
            ]);

            return [
                'success' => true,
                'message'=> 'در حال انتقال به صفحه پرداخت بانک ...',
                'data'=> [
                    'url'=> $url
                ],
            ];
        }
        else{


            DB::table('payment_logs')->insert([
                'payment_id'=> $paymentId,
                'status'=> 'init_failed',
                'bank_status'=> $result['bank_status'],
                'raw_response'=> $result['raw_response'],
                'created_at'=> now()->timestamp,
            ]);

            return [
                'success' => false,
                'message'=> $response['message'],
                'data'=> [],
            ];
        }
    }

    public function handlePaymentCallback(Request $request): array
    {

        $requestNumber = 'PRN-78345693245'; // extract from request
        $trackingCode = '23458790324856'; // extract from request

        DB::table('payments')
            ->where('request_number', $requestNumber)
            ->update([
                'tracking_code' => $trackingCode,
            ]);
        $paymentObject = DB::table('payments')
            ->where('request_number', $requestNumber)
            ->first();

        DB::table('payment_logs')->insert([
            'payment_id'=> $paymentObject->id,
            'status'=> 'verify',
            'created_at'=> now()->timestamp,
        ]);

        $response = $this->paymentGateway->verifyPayment($paymentObject);
        $result = $response['result'];

        if($response['success']){

            DB::table('payment_logs')->insert([
                'payment_id'=> $paymentObject->id,
                'status'=> 'verify_success',
                'bank_status'=> $result['bank_status'],
                'raw_response'=> $result['raw_response'],
                'created_at'=> now()->timestamp,
            ]);

            return [
                'success' => true,
                'message'=> 'پرداخت موفق',
                'data'=> $paymentObject,
            ];
        }
        else{

            DB::table('payment_logs')->insert([
                'payment_id'=> $paymentObject->id,
                'status'=> 'verify_failed',
                'bank_status'=> $result['bank_status'],
                'raw_response'=> $result['raw_response'],
                'created_at'=> now()->timestamp,
            ]);


            return [
                'success' => false,
                'message'=> $response['message'],
                'data'=> $paymentObject,
            ];
        }

    }

    public function checkPaymentStatus($paymentObject): void{

        $response = $this->paymentGateway->inquirePayment($paymentObject);

        if($response['success']){

            $paymentObject = $response['result'];

            DB::table('payments')
                ->where('request_number', $paymentObject['request_number'])
                ->update([
                    'bank_status'=> '',
                ]);
        }

    }

    private function createRandomRequestNumber(): string
    {
        do {
            $requestNumber = 'PRN-'.Str::random(8);
        } while (DB::table('payments')
            ->where('request_number', $requestNumber)
            ->exists());
        //return $requestNumber;
        return 'PRN-78345693245';
    }

    private function getPaymentObject($paymentId){
        return DB::table('payments')
            ->where('id', $paymentId)
            ->first();
    }
}
