<?php


namespace App\Classes\Payment;


abstract class PaymentGateway
{


    public function __construct()
    {
    }

    /**
     * This method is called when the payment process begins
     * @param $paymentObject
     * @return mixed
     */
    abstract public function getPaymentUrl($paymentObject): array;

    /**
     * This method is called when the payment callback is called, and we have to verify the payment
     * @param $paymentObject
     * @return mixed
     */
    abstract public function verifyPayment($paymentObject): array;

    /**
     * This method is called when we want to check the status of a payment anytime later
     * @param $paymentObject
     * @return mixed
     */
    abstract public function inquirePayment($paymentObject): array;
}
