<?php

namespace App\Classes\Payment;

use Illuminate\Support\Facades\Http;

class MellatGateway extends PaymentGateway
{
    public string $gateway = 'mellat';

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

    public function verifyPayment($paymentObject): array
    {

        //$response = Http::get('http://www.google.com/'.$paymentObject->gateway_request_id);

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
