<?php

namespace LaravelPago;

use LaravelPago\Output\GetTransactionOutput;
use LaravelPago\Input\CreateSnapTransactionInput;
use LaravelPago\Output\CreateSnapTransactionOutput;

interface PagoSnapClient {
    public function createTransaction(CreateSnapTransactionInput $input): CreateSnapTransactionOutput;

    public function detailTransaction(string $transactionId): GetTransactionOutput;
}
