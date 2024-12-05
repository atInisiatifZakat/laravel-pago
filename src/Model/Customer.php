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

        if (!is_null($this->phone)) {

            if (str_starts_with($this->phone, '0')) {
                $this->phone = '+62' . substr($this->phone, 1);
            }

            if (
                !(str_starts_with($this->phone, '62') || str_starts_with($this->phone, '+62')) ||
                strlen($this->phone) > 13
            ) {
                throw new \InvalidArgumentException('Nomor telepon harus diawali dengan 62, +62, atau 0, dan maksimal 13 karakter.');
            }
        }
    }
}
