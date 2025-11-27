<?php

use App\Payment\PaymentGateway;

class MellatGateway extends PaymentGateway
{
    public string $gateway = 'mellat';

    public function getPaymentUrl($paymentObject): mixed
    {
        $terminalId		= "0000000";					// Terminal ID
        $userName		= "xxxxxxx";					// Username
        $userPassword	= "0000000";					// Password
        $orderId		= time();						// Order ID
        $amount 		= "1000";						// Price / Rial
        $localDate		= date('Ymd');			// Date
        $localTime		= date('Gis');			// Time
        $additionalData	= '';
        $callBackUrl	= "http://name.ir/verify.php";	// Callback URL
        $payerId		= 0;

        $parameters = array(
            'terminalId' 		=> $terminalId,
            'userName' 			=> $userName,
            'userPassword' 		=> $userPassword,
            'orderId' 			=> $orderId,
            'amount' 			=> $amount,
            'localDate' 		=> $localDate,
            'localTime' 		=> $localTime,
            'additionalData' 	=> $additionalData,
            'callBackUrl' 		=> $callBackUrl,
            'payerId' 			=> $payerId);

        $client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $namespace = 'http://interfaces.core.sw.bps.com/';
        $result = $client->call('bpPayRequest', $parameters, $namespace);

        return [
            'success'=> true,
            'message'=> '',
            'result'=> $paymentObject
        ];
    }

    public function verifyPayment($paymentObject): mixed
    {
        $terminalId		= "0000000";					// Terminal ID
        $userName		= "xxxxxxx";					// Username
        $userPassword	= "0000000";					// Password
        $orderId		= time();						// Order ID
        $amount 		= "1000";						// Price / Rial
        $localDate		= date('Ymd');			// Date
        $localTime		= date('Gis');			// Time
        $additionalData	= '';
        $callBackUrl	= "http://name.ir/verify.php";	// Callback URL
        $payerId		= 0;

        $parameters = array(
            'terminalId' 		=> $terminalId,
            'userName' 			=> $userName,
            'userPassword' 		=> $userPassword,
            'orderId' 			=> $orderId,
            'amount' 			=> $amount,
            'localDate' 		=> $localDate,
            'localTime' 		=> $localTime,
            'additionalData' 	=> $additionalData,
            'callBackUrl' 		=> $callBackUrl,
            'payerId' 			=> $payerId);

        $client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $namespace = 'http://interfaces.core.sw.bps.com/';
        $result = $client->call('bpPayRequest', $parameters, $namespace);

        return [
            'success'=> false,
            'message'=> '',
            'result'=> $paymentObject
        ];
    }
    public function inquirePayment($paymentObject): mixed
    {

        $terminalId		= "0000000";					// Terminal ID
        $userName		= "xxxxxxx";					// Username
        $userPassword	= "0000000";					// Password
        $orderId		= time();						// Order ID
        $amount 		= "1000";						// Price / Rial
        $localDate		= date('Ymd');			// Date
        $localTime		= date('Gis');			// Time
        $additionalData	= '';
        $callBackUrl	= "http://name.ir/verify.php";	// Callback URL
        $payerId		= 0;

        $parameters = array(
            'terminalId' 		=> $terminalId,
            'userName' 			=> $userName,
            'userPassword' 		=> $userPassword,
            'orderId' 			=> $orderId,
            'amount' 			=> $amount,
            'localDate' 		=> $localDate,
            'localTime' 		=> $localTime,
            'additionalData' 	=> $additionalData,
            'callBackUrl' 		=> $callBackUrl,
            'payerId' 			=> $payerId);

        $client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $namespace = 'http://interfaces.core.sw.bps.com/';
        $result = $client->call('bpPayRequest', $parameters, $namespace);

        return [
            'success'=> false,
            'message'=> '',
            'result'=> $paymentObject
        ];
    }

    public function onPaymentSuccess($paymentObject): void
    {
        // TODO: Display success view
    }

    public function onPaymentError($paymentObject, $message): void
    {
        // TODO: Display error view
    }
}
