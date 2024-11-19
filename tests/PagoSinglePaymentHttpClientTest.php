<?php

namespace LaravelPago\Tests;

use Carbon\Carbon;
use Illuminate\Support\Str;
use LaravelPago\LaravelPago;
use LaravelPago\Model\Customer;
use Illuminate\Support\Facades\Http;
use LaravelPago\Input\CreateSinglePaymentSnapTransactionInput;
use LaravelPago\Model\TransactionItem;
use LaravelPago\Input\TransactionSinglePayment;

final class PagoSinglePaymentHttpClientTest extends TestCase
{
    public function test_can_create_single_payment_transaction(): void
    {
        Http::fake([
            '*.izipay.id/*' => Http::response($fakeResponse = [
                'transaction_id' => Str::uuid()->toString(),
                'status' => 'pending',
                'category' => 'ewallet',
                'ewallet' => [
                    'checkout_redirect' => 'https://example.com/checkout',
                    'deeplink_redirect' => null,
                    'show_qr' => true,
                    'app_notification' => false,
                ],
            ])
        ]);

        $output = LaravelPago::clientSinglePaymentFactory(['key' => 'pago-fake-key'])->createTransaction(new CreateSinglePaymentSnapTransactionInput(
            new Customer('Nuradiyana'),
            new TransactionSinglePayment(1000000, '001', [
                new TransactionItem('Testing product', 1000000)
            ],
            38)
        ));

        $this->assertSame($fakeResponse['transaction_id'], $output->transactionId);
        $this->assertSame($fakeResponse['category'], $output->category);
        $this->assertSame($fakeResponse['status'], $output->status);

    }
}
