<?php

namespace Tests\Feature;

use App\Payment\MellatGateway;
use App\Payment\PaymentHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotEmpty;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_process()
    {
        //$paymentGateway = new MellatGateway();
        //$paymentHandler = new PaymentHandler($paymentGateway);
        //
        //$response = $paymentHandler->initPayment(1, 1000);
        //assertNotEmpty($response['data']['url']);

        $response = $this->post('/api/payment-init', []);
        assert($response->isSuccessful());
        $responseObj = json_decode($response->getContent());
        dump($responseObj);



        //$response = $paymentHandler->handlePaymentCallback(null);
        //assertNotEmpty($response['data']['url']);

        //$this->assertDatabaseHas('users', ['email' => 'john@example.com']);

    }
}
