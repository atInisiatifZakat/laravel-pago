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
    ) {
        Assert::nullOrEmail($this->email);

        if (
            !is_null($phone) &&
            !(str_starts_with($phone, '62') || str_starts_with($phone, '+62') || str_starts_with($phone, '08')) ||
            strlen($phone) > 13
        ) {
            throw new \InvalidArgumentException('Nomor telepon harus diawali dengan 62, +62, atau 08, dan maksimal 13 karakter.');
        }
    }
}
