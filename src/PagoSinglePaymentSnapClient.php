<?php

namespace LaravelPago;

use LaravelPago\Input\CreateSinglePaymentSnapTransactionInput;
use LaravelPago\Output\CreateSinglePaymentSnapTransactionOutput;

interface PagoSinglePaymentSnapClient {
    public function createTransaction(CreateSinglePaymentSnapTransactionInput $input): CreateSinglePaymentSnapTransactionOutput;

}
