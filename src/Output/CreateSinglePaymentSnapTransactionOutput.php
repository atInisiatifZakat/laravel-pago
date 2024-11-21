<?php

namespace LaravelPago\Output;

final class CreateSinglePaymentSnapTransactionOutput
{
    public function __construct(
        public string $transactionId,
        public string $status,
        public ?string $category,
        public ?array $paymentData
    ) {}
}
