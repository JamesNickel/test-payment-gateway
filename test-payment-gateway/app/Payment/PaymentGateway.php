<?php


namespace App\Payment;


abstract class PaymentGateway
{

    protected $paymentGateway;

    public function __construct($paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * This method is called when the payment process begins
     * @param $paymentObject
     * @return mixed
     */
    abstract public function getPaymentUrl($paymentObject): mixed;

    /**
     * This method is called when the payment callback is called, and we have to verify the payment
     * @param $paymentObject
     * @return mixed
     */
    abstract public function verifyPayment($paymentObject): mixed;

    /**
     * This method is called when we want to check the status of a payment anytime later
     * @param $paymentObject
     * @return mixed
     */
    abstract public function inquirePayment($paymentObject): mixed;

    /**
     * This method is called when the payment is verified from the gateway
     * @param $paymentObject
     * @return void
     */
    abstract public function onPaymentSuccess($paymentObject): void;

    /**
     * This method is called when the payment is failed with an error
     * @param $paymentObject
     * @param $message
     * @return void
     */
    abstract public function onPaymentError($paymentObject, $message): void;
}
