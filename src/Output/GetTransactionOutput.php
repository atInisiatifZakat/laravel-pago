<?php

namespace LaravelPago\Output;

use Webmozart\Assert\Assert;
use Illuminate\Support\Carbon;
use LaravelPago\Model\Customer;
use LaravelPago\Model\TransactionItem;

final class GetTransactionOutput
{
    public function __construct(
        public Customer $customer,
        public Transaction $transaction,
        public ?PaymentLink $link = null,
    )
    {
    }

    public static function fromJson(array $data): self
    {
        Assert::keyExists($data, 'transaction_id');
        Assert::keyExists($data, 'identification_number');
        Assert::keyExists($data, 'status');
        Assert::keyExists($data, 'amount');
        Assert::keyExists($data, 'original_amount');
        Assert::keyExists($data, 'unique_code');
        Assert::keyExists($data, 'created_at');
        Assert::keyExists($data, 'expired_at');
        Assert::keyExists($data, 'cancel_at');
        Assert::keyExists($data, 'payment_at');
        Assert::keyExists($data, 'paid_at');
        Assert::keyExists($data, 'confirm_at');
        Assert::keyExists($data, 'items');
        Assert::keyExists($data, 'payment_link');
        Assert::keyExists($data, 'customer');

        return new self(
            self::createCustomerFromArray($data['customer']),
            self::createTransactionFromArray($data),
            $data['payment_link'] ? self::createPaymentLinkFromArray($data['payment_link']) : null,
        );
    }


    /**
     * @psalm-suppress PossiblyNullArgument
     */
    private static function createTransactionFromArray(array $data): Transaction
    {
        return new Transaction(
            $data['transaction_id'],
            $data['identification_number'],
            $data['status'],
            $data['amount'],
            $data['original_amount'],
            $data['created_at'] ? Carbon::parse($data['created_at']) : null,
            $data['unique_code'],
            $data['payment_number'],
            $data['payment_name'],
            $data['expired_at'] ? Carbon::parse($data['expired_at']) : null,
            $data['cancel_at'] ? Carbon::parse($data['cancel_at']) : null,
            $data['payment_at'] ? Carbon::parse($data['payment_at']) : null,
            $data['paid_at'] ? Carbon::parse($data['paid_at']) : null,
            $data['confirm_at'] ? Carbon::parse($data['confirm_at']) : null,
            $data['payment_channels'],
            \array_map(static fn(array $item) => new TransactionItem($item['product'], $item['amount'], $item['names'] ?? null), $data['items'])
        );
    }

    private static function createCustomerFromArray(array $data): Customer
    {
        Assert::keyExists($data, 'name');

        return new Customer(
            $data['name'], $data['email'], $data['phone'], $data['address'],
        );
    }

    private static function createPaymentLinkFromArray(array $data): PaymentLink
    {
        Assert::keyExists($data, 'name');
        Assert::keyExists($data, 'slug');

        return new PaymentLink(
            $data['name'], $data['slug'],
        );
    }

    private static function createChannelFromArray(?array $data = null): ?Channel
    {
        foreach (['id', 'uuid', 'name', 'default_number'] as $value) {
            Assert::nullOrKeyExists($data, $value);
        }
        return $data ? new Channel(
            $data['id'], $data['uuid'], $data['name'], $data['default_number']
        ) : null;
    }
}
