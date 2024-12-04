<?php

namespace LaravelPago;

use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use LaravelPago\Input\CreateSinglePaymentSnapTransactionInput;
use LaravelPago\Output\CreateSinglePaymentSnapTransactionOutput;

final class PagoSinglePaymentHttpClient implements PagoSinglePaymentSnapClient
{
  private static string $pagoDevUrl = 'https://pago.ondevizi.com/api/pago';

  private static string $pagoProdUrl = 'https://app.izipay.id/api/pago';

  public function __construct(
    private string $key,
    private bool $isSandbox = true,
    private ?LoggerInterface $logger = null
  ) {
    if ($this->logger === null) {
      $this->logger = new NullLogger();
    }
  }

  public function createTransaction(CreateSinglePaymentSnapTransactionInput $input): CreateSinglePaymentSnapTransactionOutput
  {
    $transaction = $input->toArray();
    $response = $this->getHttpClient()->post('v1/transaction/channel/' . $transaction['payment_channel_id'], \array_merge($transaction));

    $this->logger->info('Pago Create Transaction Response', $response->json());

    return new CreateSinglePaymentSnapTransactionOutput(
      (string)$response->json('transaction_id'),
      (string)$response->json('status'),
      $response->json('category'),
      $response->json('identification_number'),
      $response->json('unique_code'),
      $response->json('amount'),
      $response->json('date'),
      $response->json($response->json('category')),
    );
  }

  private function getHttpClient(): PendingRequest
  {
    $baseUrl = $this->getBaseUrl();

    return Http::withToken($this->key)->baseUrl($baseUrl)->acceptJson()->asJson();
  }

  private function getBaseUrl(): string
  {
    return $this->isSandbox ? self::$pagoDevUrl : self::$pagoProdUrl;
  }
}
