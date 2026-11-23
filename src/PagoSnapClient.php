<?php

namespace LaravelPago;

use Illuminate\Http\Response;
use LaravelPago\Output\GetTransactionOutput;
use LaravelPago\Input\CreateSnapTransactionInput;
use LaravelPago\Input\UpdateSnapTransactionStatusInput;
use LaravelPago\Output\CreateSnapTransactionOutput;

interface PagoSnapClient {
    public function createTransaction(CreateSnapTransactionInput $input): CreateSnapTransactionOutput;

    public function detailTransaction(string $transactionId): GetTransactionOutput;

    public function updateTransactionStatus(string $transactionId, UpdateSnapTransactionStatusInput $input): Response;
}
