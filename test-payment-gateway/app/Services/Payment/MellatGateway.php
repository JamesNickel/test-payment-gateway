<?php

namespace App\Services\Payment;

use App\Services\Payment\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MellatGateway extends PaymentGateway
{

    public string $name = 'mellat';

    public function getPaymentUrl($paymentObject): array
    {
        //$terminalId		= "0000000";					// Terminal ID
        //$userName		= "xxxxxxx";					// Username
        //$userPassword	= "0000000";					// Password
        //$orderId		= time();						// Order ID
        //$amount 		= "1000";						// Price / Rial
        //$localDate		= date('Ymd');			// Date
        //$localTime		= date('Gis');			// Time
        //$additionalData	= '';
        //$callBackUrl	= "http://name.ir/verify.php";	// Callback URL
        //$payerId		= 0;
        //
        //$parameters = array(
        //    'terminalId' 		=> $terminalId,
        //    'userName' 			=> $userName,
        //    'userPassword' 		=> $userPassword,
        //    'orderId' 			=> $orderId,
        //    'amount' 			=> $amount,
        //    'localDate' 		=> $localDate,
        //    'localTime' 		=> $localTime,
        //    'additionalData' 	=> $additionalData,
        //    'callBackUrl' 		=> $callBackUrl,
        //    'payerId' 			=> $payerId);
        //
        //$client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        //$namespace = 'http://interfaces.core.sw.bps.com/';
        //$result = $client->call('bpPayRequest', $parameters, $namespace);

        return [
            'success'=> true,
            'message'=> '',
            'result'=> [
                'url' => 'http://www.google.com/',
                'gateway_request_id' => '',
                'bank_status' => '0',
                'raw_response' => '[]'
            ]
        ];
    }

    public function parseGatewayRequest(Request $request): array
    {
        return [
            'success'=> true,
            'message'=> '',
            'result'=> [
                //'request_number' => 'PRN-78345693245', // extract from request
                'request_number' => $request->input('request_number'), // extract from request
                //'tracking_code' => '23458790324856', // extract from request
                'tracking_code' => $request->input('tracking_code'), // extract from request
                'bank_status' => '0',
                'raw_response' => json_encode($request->getContent())
            ]
        ];
    }

    public function verifyPayment($paymentObject): array
    {

        //$response = Http::get('http://www.google.com/'.$paymentObject->gateway_request_id);

        return [
            'success'=> true,
            'message'=> '',
            'result'=> [
                'tracking_code' => '23458790324856',
                'bank_status' => '0',
                'raw_response' => '[]'
            ]
        ];

    }
    public function inquirePayment($paymentObject): array
    {
        $response = Http::get('http://www.google.com/'.$paymentObject->gateway_request_id);

        if($response->successful()){
            return [
                'success'=> true,
                'message'=> '',
                'result'=> [
                    'tracking_code' => '',
                    'bank_status' => '0',
                    'raw_response' => '[]'
                ]
            ];
        }
        else{
            return [
                'success'=> false,
                'message'=> 'شناسه نامعتبر',
                'result'=> []
            ];
        }
    }
}
