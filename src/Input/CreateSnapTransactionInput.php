<?php

namespace LaravelPago\Input;

use LaravelPago\Model\Customer;
use LaravelPago\Model\TransactionItem;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @template-implements Arrayable<string, mixed>
 */
final class CreateSnapTransactionInput implements Arrayable
{
    public function __construct(
        public Customer $customer,
        public Transaction $transaction
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->customer->name,
            'email' => $this->customer->email,
            'phone' => $this->customer->phone,
            'address' => $this->customer->address,
            'identification_number' => $this->transaction->transactionNumber,
            'amount' => $this->transaction->amount,
            'items' => \array_map(static function (TransactionItem $item): array {
                return ['product' => $item->amount, 'amount' => $item->amount, 'names' => $item->names];
            }, $this->transaction->items),
        ];
    }
}
