<?php

namespace LaravelPago\Tests;

use Carbon\Carbon;
use Illuminate\Support\Str;
use LaravelPago\LaravelPago;
use LaravelPago\Model\Customer;
use LaravelPago\Input\Transaction;
use Illuminate\Support\Facades\Http;
use LaravelPago\Model\TransactionItem;
use LaravelPago\Input\CreateSnapTransactionInput;

final class PagoHttpClientTest extends TestCase
{
    public function test_can_create_transaction(): void
    {
        Http::fake([
            '*.izipay.id/*' => Http::response($fakeResponse = [
                'transaction_id' => Str::uuid()->toString(),
                'pago_url' => 'https://example.com'
            ])
        ]);

        $output = LaravelPago::clientFactory(['key' => 'pago-fake-key'])->createTransaction(new CreateSnapTransactionInput(
            new Customer('Nuradiyana'),
            new Transaction(1000000, '001', [
                new TransactionItem('Testing product', 1000000)
            ],
            [1, 2])
        ));

        $this->assertSame($fakeResponse['transaction_id'], $output->transactionId);
        $this->assertSame($fakeResponse['pago_url'], $output->redirectUrl);
    }

    public function test_can_create_show_detail_transaction(): void
    {
        Http::fake([
            '*.izipay.id/*' => Http::response($fakeResponse = \json_decode(<<<JSON
{
    "transaction_id": "1ed80e33-b64f-68b4-b703-0255835e5408",
    "identification_number": "2022122165333",
    "status": "PAYMENT",
    "amount": 1509,
    "original_amount": 1000,
    "unique_code": 509,
    "created_at": "2022-12-21T03:54:56.000000Z",
    "expired_at": null,
    "cancel_at": null,
    "payment_at": "2022-12-21T03:55:01.000000Z",
    "paid_at": null,
    "confirm_at": null,
    "payment_number": null,
    "payment_name": null,
    "items": [
      {"product":  "Testing product", "amount":  "1000"}
    ],
    "customer": {
      "name": "Nuradiyana",
      "email": "me@nooradiana.com",
      "phone": null,
      "address": null
    },
    "payment_link": {
      "name": "Zakat",
      "slug": "zakat-1ed5b552-d6ce-64dc-a2a9-0255835e5408"
    }
  }
JSON, true))
        ]);

        $output = LaravelPago::clientFactory(['key' => 'pago-fake-key'])->detailTransaction(
            $fakeResponse['transaction_id']
        );

        $this->assertSame($fakeResponse['transaction_id'], $output->transaction->transactionId);
        $this->assertSame($fakeResponse['identification_number'], $output->transaction->transactionNumber);
        $this->assertSame($fakeResponse['status'], $output->transaction->status);
        $this->assertSame($fakeResponse['amount'], $output->transaction->amount);
        $this->assertSame($fakeResponse['original_amount'], $output->transaction->originalAmount);
        $this->assertSame($fakeResponse['unique_code'], $output->transaction->uniqueCode);
        $this->assertSame($fakeResponse['created_at'], Carbon::parse($output->transaction->createdAt)->toISOString());
        $this->assertSame($fakeResponse['payment_at'], Carbon::parse($output->transaction->paymentAt)->toISOString());
        $this->assertNull($output->transaction->cancelAt);
        $this->assertNull($output->transaction->expiredAt);
        $this->assertNull($output->transaction->paidAt);
        $this->assertNull($output->transaction->confirmAt);
        $this->assertNull($output->transaction->paymentNumber);
        $this->assertNull($output->transaction->paymentName);

        $this->assertCount(1, $output->transaction->items);
        $this->assertSame($fakeResponse['items'][0]['product'], $output->transaction->items[0]->product);
        $this->assertSame($fakeResponse['items'][0]['product'], $output->transaction->items[0]->product);

        $this->assertSame($fakeResponse['customer']['name'], $output->customer->name);
        $this->assertSame($fakeResponse['customer']['email'], $output->customer->email);
        $this->assertNull($output->customer->phone);
        $this->assertNull($output->customer->address);

        $this->assertNotNull($output->link);
        $this->assertSame($fakeResponse['payment_link']['name'], $output->link?->name);
        $this->assertSame($fakeResponse['payment_link']['slug'], $output->link?->slug);
    }
}
