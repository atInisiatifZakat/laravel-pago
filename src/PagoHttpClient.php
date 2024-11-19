<?php

namespace LaravelPago;

use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use LaravelPago\Output\GetTransactionOutput;
use LaravelPago\Input\CreateSnapTransactionInput;
use LaravelPago\Output\CreateSnapTransactionOutput;

final class PagoHttpClient implements PagoSnapClient
{
    private static string $pagoDevUrl = 'https://pago.ondevizi.com/api/pago';

    private static string $pagoProdUrl = 'https://app.izipay.id/api/pago';

    public function __construct(
        private string $key,
        private bool $isSandbox = true,
        private ?LoggerInterface $logger = null
    )
    {
        if($this->logger === null) {
            $this->logger = new NullLogger();
        }
    }

    public function createTransaction(CreateSnapTransactionInput $input): CreateSnapTransactionOutput
    {
        $response = $this->getHttpClient()->post('v1/transaction', \array_merge($input->toArray(), [
            'redirect_url' => LaravelPago::getRedirectUrl(),
        ]));

        $this->logger->info('Pago Create Transaction Response', $response->json());

        return new CreateSnapTransactionOutput(
            (string)$response->json('transaction_id'),
            (string)$response->json('pago_url')
        );
    }

    public function detailTransaction(string $transactionId): GetTransactionOutput
    {
        $response = $this->getHttpClient()->get('v1/transaction/' . $transactionId);

        return GetTransactionOutput::fromJson($response->json());
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
