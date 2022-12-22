<?php

namespace LaravelPago\Output;

final class Channel
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $name,
        public ?string $number = null,
    )
    {
    }
}
