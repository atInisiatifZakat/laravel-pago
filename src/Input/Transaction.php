<?php

namespace LaravelPago\Input;

use Webmozart\Assert\Assert;
use LaravelPago\Model\TransactionItem;

class Transaction
{
    public function __construct(
        public int|float  $amount,
        public string|int $transactionNumber,

        /**
         * @var TransactionItem[]
         */
        public array $items,
        public ?array  $paymentChannels = null,
    )
    {
        Assert::same($this->amount, $this->getTotalAmountItem());
    }

    protected function getTotalAmountItem(): int|float
    {
        return \array_reduce($this->items, static fn(int|float $carry, TransactionItem $item) => $carry + $item->amount, 0);
    }
}
