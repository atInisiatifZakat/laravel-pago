<?php

namespace LaravelPago\Output;

use DateTimeInterface;
use LaravelPago\Model\TransactionItem;

class Transaction
{
    public function __construct(
        public string $transactionId,
        public string|int $transactionNumber,
        public string $status,
        public int|float $amount,
        public int|float $originalAmount,
        public DateTimeInterface  $createdAt,
        public int|float $uniqueCode = 0,
        public ?DateTimeInterface $expiredAt = null,
        public ?DateTimeInterface $cancelAt = null,
        public ?DateTimeInterface $paymentAt = null,
        public ?DateTimeInterface $paidAt = null,

        /**
         * @var TransactionItem[]
         */
        public array $items = []
    )
    {
    }
}
