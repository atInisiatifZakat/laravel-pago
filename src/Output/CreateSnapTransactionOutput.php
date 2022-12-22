<?php

namespace LaravelPago\Output;

final class CreateSnapTransactionOutput
{
    public function __construct(
        public string $transactionId,
        public string $redirectUrl
    )
    {
    }
}
