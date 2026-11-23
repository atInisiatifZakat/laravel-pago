<?php

namespace LaravelPago\Input;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @template-implements Arrayable<string, mixed>
 */
final class UpdateSnapTransactionStatusInput implements Arrayable
{
    public function __construct(
        public string $status
    ) {}

    public function toArray(): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
