<?php

declare(strict_types=1);

namespace Wallet\Model;

final class Nature extends Enum
{
    public const DEBIT = 'debit';

    public const CREDIT = 'credit';
}
