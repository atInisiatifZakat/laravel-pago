<?php

namespace LaravelPago\Model;

class TransactionItem
{
    public function __construct(
        public string $product,
        public float|int $amount,
        /**
         * @var null|string[]
         */
        public ?array $names = null,
    )
    {
    }
}
