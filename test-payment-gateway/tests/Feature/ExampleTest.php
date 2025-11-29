<?php

namespace Tests\Feature;

use App\Services\Payment\MellatGateway;
use App\Services\Payment\PaymentHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
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
        //dump($response['data']['url']);
        //assertNotEmpty($response['data']['url']);

        $response = $this->post('/api/payment-init', ['amount'=> 1000000]);
        //dump($response->status());
        assert($response->isSuccessful());
        $responseObj = json_decode($response->getContent());
        //dump($responseObj);
        assertNotEmpty($responseObj->url);

        $this->assertDatabaseHas('payments', ['gateway' => 'mellat']);
        $this->assertDatabaseHas('payment_logs', ['status' => 'init']);
        $this->assertDatabaseHas('payment_logs', ['status' => 'init_success']);

        $bankTrackingCode = '23458790324856';
        $response = $this->post('/api/payment-gateway-callback', [
            'request_number'=> 'PRN-78345693245',
            'tracking_code'=> $bankTrackingCode,
        ]);
        //dump($response->status());
        assert($response->isSuccessful());
        $responseObj = json_decode($response->getContent());
        //dump($responseObj);
        assertNotEmpty($response['data']['tracking_code']);
        $this->assertDatabaseHas('payment_logs', ['status' => 'verify']);
        $this->assertDatabaseHas('payment_logs', ['status' => 'verify_success']);

        $this->assertDatabaseHas('payments', ['tracking_code' => $bankTrackingCode]);


        //$response = $paymentHandler->handlePaymentCallback(null);
        //assertNotEmpty($response['data']['url']);

        //$this->assertDatabaseHas('payment_logs', ['email' => 'john@example.com']);

    }
}
