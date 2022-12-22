<?php

namespace LaravelPago\Output;

class PaymentLink
{
    public function __construct(
        public string $name,
        public string $slug
    )
    {
    }
}
