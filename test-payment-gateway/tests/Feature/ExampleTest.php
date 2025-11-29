<?php

namespace Tests\Feature;

use App\Classes\Payment\MellatGateway;
use App\Classes\Payment\PaymentHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotEmpty;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_process()
    {
        $paymentGateway = new MellatGateway();
        $paymentHandler = new PaymentHandler($paymentGateway);

        $response = $paymentHandler->initPayment(1, 1000);
        dump($response['data']['url']);
        assertNotEmpty($response['data']['url']);

        //$response = $this->post('/api/payment-init/');
        //dump($response->status());
        //assert($response->isSuccessful());
        //$responseObj = json_decode($response->getContent());
        //dump($responseObj);

        $request = new Request();
        $response = $paymentHandler->handlePaymentCallback($request);
        dump($response);
        assertNotEmpty($response['data']->tracking_code);


        //$response = $paymentHandler->handlePaymentCallback(null);
        //assertNotEmpty($response['data']['url']);

        $this->assertDatabaseHas('payments', ['gateway' => 'mellat']);
        $this->assertDatabaseHas('payment_logs', ['email' => 'john@example.com']);

    }
}
