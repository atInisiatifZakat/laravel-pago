<?php

namespace LaravelPago\Model;

use Webmozart\Assert\Assert;

class Customer
{
    public function __construct(
        public string  $name,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $address = null,
    )
    {
        Assert::nullOrEmail($this->email);
        Assert::nullOrStartsWith($this->phone, '62');
        Assert::nullOrLength($this->phone, 13);
    }
}
