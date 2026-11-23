<?php

declare(strict_types=1);

namespace LaravelPago\Enums;

enum TransactionStatus: string
{
    case new = 'NEW';

    case paid = 'PAID';

    case confirm = 'CONFIRM';

    case cancel = 'CANCEL';

    case expired = 'EXPIRED';

    case payment = 'PAYMENT';
}
