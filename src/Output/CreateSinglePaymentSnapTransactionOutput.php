<?php

namespace LaravelPago\Output;

final class CreateSinglePaymentSnapTransactionOutput
{
    public function __construct(
        public string $transactionId,
        public string $status,
        public string $category,
        public string $identificationNumber,
        public string $uniqueCode,
        public int $amount,
        public string $date,
        public array $paymentData
    ) {}
}
